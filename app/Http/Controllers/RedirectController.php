<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Link;
use App\Models\Click;
use App\Models\Round;
use App\Traits\CreatesNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedirectController extends Controller
{
    use CreatesNotifications;

    public function handle($slug)
    {
        DB::beginTransaction();
        try {
            $project = Project::where('slug', $slug)->firstOrFail();
            
            if (!$project->is_active) {
                abort(404);
            }

            $currentRound = $project->currentRound;
            if (!$currentRound) {
                // Si no hay ronda activa y no es un proyecto de rondas infinitas,
                // significa que el proyecto está pausado
                if (!$project->infinite_rounds) {
                    DB::commit();
                    return $project->fallback_url 
                        ? redirect($project->fallback_url)
                        : view('funnel.paused');
                }
                abort(404, 'No hay una ronda activa en este momento.');
            }

            // Obtener el siguiente link disponible
            $link = Link::where('project_id', $project->id)
                ->where('is_active', true)
                ->orderBy('position')
                ->get()
                ->filter(function ($link) use ($currentRound) {
                    $clickCount = $link->clicks()
                        ->where('round_id', $currentRound->id)
                        ->count();
                    return $clickCount < $link->click_limit;
                })
                ->first();

            if (!$link) {
                if ($project->infinite_rounds) {
                    // Desactivar la ronda actual
                    $currentRound->update(['is_active' => false, 'is_completed' => true]);
                    
                    // Notificar que la ronda ha terminado
                    $this->notifyProjectMembers(
                        $project,
                        'Ronda completada',
                        "La ronda #{$currentRound->round_number} del proyecto '{$project->name}' ha sido completada.",
                        'success',
                        ['action_url' => route('projects.show', $project)]
                    );

                    // Crear nueva ronda automáticamente
                    $newRound = $project->rounds()->create([
                        'round_number' => $currentRound->round_number + 1,
                        'is_active' => true,
                        'is_completed' => false
                    ]);

                    // Notificar que una nueva ronda ha comenzado
                    $this->notifyProjectMembers(
                        $project,
                        'Nueva ronda iniciada',
                        "La ronda #{$newRound->round_number} del proyecto '{$project->name}' ha comenzado.",
                        'info',
                        ['action_url' => route('projects.show', $project)]
                    );

                    // Obtener el primer link nuevamente
                    $link = Link::where('project_id', $project->id)
                        ->where('is_active', true)
                        ->orderBy('position')
                        ->first();

                    // Refrescar la ronda actual
                    $currentRound = $newRound;
                } else {
                    // Si no hay más links disponibles y no es un proyecto de rondas infinitas,
                    // marcar la ronda como completada y redirigir según la configuración
                    $currentRound->update(['is_active' => false, 'is_completed' => true]);

                    // Notificar que la ronda ha terminado
                    $this->notifyProjectMembers(
                        $project,
                        'Ronda completada',
                        "La ronda #{$currentRound->round_number} del proyecto '{$project->name}' ha sido completada.",
                        'success',
                        ['action_url' => route('projects.show', $project)]
                    );

                    DB::commit();
                    return $project->fallback_url 
                        ? redirect($project->fallback_url)
                        : view('funnel.paused');
                }
            }

            // Registrar el click
            Click::create([
                'link_id' => $link->id,
                'round_id' => $currentRound->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);

            // Calcular el progreso de la ronda
            $totalClicksInRound = Click::where('round_id', $currentRound->id)->count();
            $totalClickLimit = $project->links()->where('is_active', true)->sum('click_limit');
            $roundProgress = ($totalClicksInRound / $totalClickLimit) * 100;

            // Notificar cuando la ronda alcanza ciertos porcentajes
            $notificationThresholds = [80, 90];
            foreach ($notificationThresholds as $threshold) {
                if ($roundProgress >= $threshold && $roundProgress < ($threshold + 10)) {
                    $this->notifyProjectMembers(
                        $project,
                        "Ronda al {$threshold}%",
                        "La ronda #{$currentRound->round_number} del proyecto '{$project->name}' ha alcanzado el {$threshold}% de su capacidad.",
                        'warning',
                        ['action_url' => route('projects.show', $project)]
                    );
                }
            }

            // Actualizar el contador de clicks del link
            $link->increment('current_clicks');

            // Notificar cuando se alcanza el límite de clicks
            if ($link->current_clicks >= $link->click_limit) {
                $this->notifyProjectMembers(
                    $project,
                    'Límite de clicks alcanzado',
                    "El link '{$link->url}' ha alcanzado su límite de {$link->click_limit} clicks.",
                    'warning',
                    ['action_url' => route('projects.show', $project)]
                );
            }

            // Notificar cuando se alcanza el 80% del límite
            $percentageUsed = ($link->current_clicks / $link->click_limit) * 100;
            if ($percentageUsed >= 80 && $percentageUsed < 100) {
                $this->notifyProjectMembers(
                    $project,
                    'Link cerca del límite',
                    "El link '{$link->url}' está al {$percentageUsed}% de su límite de clicks.",
                    'info',
                    ['action_url' => route('projects.show', $project)]
                );
            }

            DB::commit();
            return redirect($link->url);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
