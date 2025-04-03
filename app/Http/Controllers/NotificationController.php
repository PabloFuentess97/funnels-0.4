<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        try {
            $notifications = Notification::where('user_id', auth()->id())
                ->orderByDesc('created_at')
                ->paginate(10);

            Log::info('Retrieved notifications for user: ' . auth()->id() . ', count: ' . $notifications->count());

            if (request()->ajax()) {
                return view('notifications.partials.notification-list', compact('notifications'));
            }

            return view('notifications.index', compact('notifications'));
        } catch (\Exception $e) {
            Log::error('Error retrieving notifications: ' . $e->getMessage());
            return back()->with('error', 'Error al cargar las notificaciones');
        }
    }

    public function markAsRead(Notification $notification)
    {
        try {
            $this->authorize('update', $notification);
            
            $notification->update(['read_at' => now()]);
            Log::info('Notification marked as read: ' . $notification->id);

            return back()->with('success', 'Notificación marcada como leída');
        } catch (\Exception $e) {
            Log::error('Error marking notification as read: ' . $e->getMessage());
            return back()->with('error', 'Error al marcar la notificación como leída');
        }
    }

    public function markAllAsRead()
    {
        try {
            Notification::where('user_id', auth()->id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            Log::info('All notifications marked as read for user: ' . auth()->id());

            return back()->with('success', 'Todas las notificaciones han sido marcadas como leídas');
        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read: ' . $e->getMessage());
            return back()->with('error', 'Error al marcar las notificaciones como leídas');
        }
    }
}
