<?php

namespace App\Traits;

trait CreatesNotifications
{
    protected function createNotification($user, $title, $message, $type = 'info', $data = [])
    {
        return $user->notifications()->create([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data
        ]);
    }

    protected function notifyProjectMembers($project, $title, $message, $type = 'info', $data = [])
    {
        // Notificar al dueño del proyecto y otros miembros del equipo
        $users = collect([$project->company->owner])
            ->merge($project->company->users)
            ->unique('id');

        foreach ($users as $user) {
            $this->createNotification($user, $title, $message, $type, $data);
        }
    }
}
