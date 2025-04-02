<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->orderByDesc('created_at')
            ->paginate(10);

        if (request()->ajax()) {
            return view('notifications.partials.notification-list', compact('notifications'));
        }

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        $this->authorize('update', $notification);
        $notification->markAsRead();

        return back()->with('success', 'Notificación marcada como leída');
    }

    public function markAllAsRead()
    {
        auth()->user()->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'Todas las notificaciones marcadas como leídas');
    }
}
