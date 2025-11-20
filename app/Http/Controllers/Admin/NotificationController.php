<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Ambil notifikasi yang belum dibaca.
     */
    public function getUnread()
    {
        $user = Auth::user();
        // Ambil notifikasi unread
        $notifications = $user->unreadNotifications;
        
        // Tandai sebagai sudah dibaca (agar tidak muncul terus menerus)
        $user->unreadNotifications->markAsRead();

        return response()->json($notifications);
    }
}