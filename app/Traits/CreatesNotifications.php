<?php

namespace App\Traits;

use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

trait CreatesNotifications
{
    protected function createNotification($user, $title, $message, $type = 'info', $data = [])
    {
        try {
            if (!$user) {
                Log::warning('Attempted to create notification for null user');
                return null;
            }

            $notification = Notification::create([
                'user_id' => $user->id,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'data' => $data
            ]);

            Log::info("Notification created: {$notification->id} for user: {$user->id}");
            return $notification;

        } catch (\Exception $e) {
            Log::error('Error creating notification: ' . $e->getMessage());
            return null;
        }
    }

    protected function notifyProjectMembers($project, $title, $message, $type = 'info', $data = [])
    {
        try {
            // Verificar si el proyecto existe
            if (!$project) {
                Log::warning('Project not found for notification');
                return;
            }

            // Obtener el usuario actual
            $currentUser = Auth::user();
            if (!$currentUser) {
                Log::warning('No authenticated user found');
                return;
            }

            // Intentar obtener usuarios para notificar
            $usersToNotify = collect();

            // Si hay una compañía y un propietario, incluirlos
            if ($project->company) {
                if ($project->company->owner) {
                    $usersToNotify->push($project->company->owner);
                }
                // Agregar otros usuarios de la compañía
                $usersToNotify = $usersToNotify->merge($project->company->users);
            }

            // Si no hay usuarios de la compañía, al menos notificar al usuario actual
            if ($usersToNotify->isEmpty()) {
                $usersToNotify->push($currentUser);
            }

            // Eliminar duplicados y filtrar nulos
            $usersToNotify = $usersToNotify->unique('id')->filter();

            Log::info('Sending notification to ' . $usersToNotify->count() . ' users');

            foreach ($usersToNotify as $user) {
                $this->createNotification($user, $title, $message, $type, $data);
            }

        } catch (\Exception $e) {
            Log::error('Error in notifyProjectMembers: ' . $e->getMessage());
            // Intentar notificar solo al usuario actual en caso de error
            if ($currentUser = Auth::user()) {
                $this->createNotification($currentUser, $title, $message, $type, $data);
            }
        }
    }
}
