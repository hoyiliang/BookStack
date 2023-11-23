<?php

namespace BookStack\Activity\Controllers;

use BookStack\Activity\ActivityType;
use BookStack\Activity\Models\Activity;
use BookStack\Http\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        $notificationDatas = auth()->user()->notifications()->pluck('data');
        $activityIds = $notificationDatas->map(function ($data) {
            return $data['activity']['id'] ?? null;
        })->filter(); 
        $activities = Activity::whereIn('id', $activityIds)->get();

        $ids = [];
        foreach($activities as $activity) {
            $ids[] = $activity->type == ActivityType::COMMENT_CREATE ? $activity->id + 1 : $activity->id; 
        }

        $notifications = Activity::whereIn('id', $ids)->get();
        
        return view('users.notification.index', [
            'notifications' => $notifications
        ]);
    }
}