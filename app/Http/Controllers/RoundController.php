<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Round;
use App\Models\Project;
use App\Traits\CreatesNotifications;

class RoundController extends Controller
{
    use CreatesNotifications;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rounds = Round::whereHas('project', function($query) {
            $query->where('company_id', auth()->user()->company_id);
        })->with('project')->paginate(10);
        
        return view('rounds.index', compact('rounds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::where('company_id', auth()->user()->company_id)
            ->where('is_active', true)
            ->get();
        return view('rounds.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
        $this->authorize('update', $project);

        // Desactivar la ronda actual si existe
        if ($project->currentRound) {
            $project->currentRound->update(['is_active' => false]);
        }

        // Crear nueva ronda
        $roundNumber = $project->rounds()->max('round_number') + 1;
        $round = $project->rounds()->create([
            'round_number' => $roundNumber,
            'is_active' => true
        ]);

        // Reiniciar clicks de los links
        $project->links()->update(['current_clicks' => 0]);

        // Notificar a los miembros del proyecto
        $this->notifyProjectMembers(
            $project,
            'Nueva ronda iniciada',
            "Se ha iniciado la ronda #{$roundNumber} en el proyecto '{$project->name}'.",
            'info',
            ['action_url' => route('projects.show', $project)]
        );

        return back()->with('success', 'Nueva ronda creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Round $round)
    {
        $this->authorize('view', $round);
        $round->load('project.links');
        return view('rounds.show', compact('round'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Round $round)
    {
        $this->authorize('update', $round);
        return view('rounds.edit', compact('round'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Round $round)
    {
        $this->authorize('update', $round->project);

        if ($request->is_active) {
            // Desactivar la ronda actual si existe
            $round->project->rounds()->where('id', '!=', $round->id)
                ->update(['is_active' => false]);
            
            // Activar esta ronda
            $round->update(['is_active' => true]);

            // Notificar el cambio de ronda
            $this->notifyProjectMembers(
                $round->project,
                'Cambio de ronda activa',
                "Se ha activado la ronda #{$round->round_number} en el proyecto '{$round->project->name}'.",
                'info',
                ['action_url' => route('projects.show', $round->project)]
            );
        }

        return back()->with('success', 'Ronda actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Round $round)
    {
        $this->authorize('delete', $round->project);
        $round->delete();

        return back()->with('success', 'Ronda eliminada correctamente.');
    }
}
