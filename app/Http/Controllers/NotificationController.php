<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications;
        return view('notifications.index', compact('notifications'));
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'تم تعليم كل الإشعارات كمقروءة');
    }

    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();
        return redirect()->back()->with('success', 'تم حذف الإشعار');
    }

    public function clearAll()
    {
        auth()->user()->notifications()->delete();
        return redirect()->back()->with('success', 'تم حذف جميع الإشعارات');
    }
}
