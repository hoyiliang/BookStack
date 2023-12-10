<?php

namespace BookStack\Activity\Controllers;

use BookStack\Activity\Models\Notification;
use BookStack\Entities\Models\Page;
use BookStack\Http\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(15);
        
        return view('users.notification.index', [
            'notifications' => $notifications
        ]);
    }

    public function markAsRead(Request $request)
    {
        $notification = Notification::findOrFail($request->input('notification_id'));

        $notification->markAsRead();

        return redirect($notification->getUrl());
    }

    public function markAllAsRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();

        $this->showSuccessNotification(trans('notifications.mark_all_as_read_notification'));

        return redirect()->back();
    }

    public function deleteAll(Request $request) 
    {
        auth()->user()->notifications()->delete();

        $this->showSuccessNotification(trans('notifications.delete_all_notification'));

        return redirect()->back();
    }
}