<?php

namespace BookStack\Activity\Controllers;

use BookStack\Http\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        return view('users.notification.index');
    }
}