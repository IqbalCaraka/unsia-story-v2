<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\CallbackRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $blogCount = BlogPost::count();
        $callbackCount = CallbackRequest::count();
        $eventCount = Event::count();

        return view('admin.dashboard', compact('blogCount', 'callbackCount', 'eventCount'));
    }
}
