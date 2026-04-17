<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::query()
            ->latest()
            ->paginate(20);

        return view('admin-backend.notifications-index', compact('notifications'));
    }

    public function markRead(AdminNotification $notification): JsonResponse
    {
        if (! $notification->is_read) {
            $notification->update([
                'is_read' => true,
                'read_at' => Carbon::now(),
            ]);
        }

        $unread = AdminNotification::query()->where('is_read', false)->count();

        return response()->json(['unread' => $unread]);
    }

    public function markAllRead(): JsonResponse
    {
        AdminNotification::query()
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => Carbon::now(),
            ]);

        return response()->json(['unread' => 0]);
    }
}
