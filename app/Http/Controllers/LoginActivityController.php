<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginActivityController extends Controller
{
    /**
     * Display the user's login activities.
     */
    public function index(Request $request): View
    {
        $activities = $request->user()
            ->loginActivities()
            ->latest('login_at')
            ->paginate(10);

        return view('login-activities', [
            'activities' => $activities,
        ]);
    }
}