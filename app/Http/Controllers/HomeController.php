<?php

namespace App\Http\Controllers;

use App\Models\LoginActivity;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $todayUsers = User::whereDate(
            'created_at',
            today()
        )->count();

        $totalLogins = LoginActivity::count();

        $todayLogins = LoginActivity::whereDate(
            'login_at',
            today()
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Current User Login Statistics
        |--------------------------------------------------------------------------
        */

        $myLoginCount = $user
            ->loginActivities()
            ->count();

        $lastLogin = $user
            ->loginActivities()
            ->latest('login_at')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Account Completion
        |--------------------------------------------------------------------------
        */

        $completion = 0;

        if (!empty($user->name)) {
            $completion += 50;
        }

        if (!empty($user->email)) {
            $completion += 50;
        }

        /*
        |--------------------------------------------------------------------------
        | Recent Login Activities
        |--------------------------------------------------------------------------
        */

        $recentActivities = $user
            ->loginActivities()
            ->oldest('login_at')
            ->take(5)
            ->get();

        return view('home', compact(
            'totalUsers',
            'todayUsers',
            'totalLogins',
            'todayLogins',
            'myLoginCount',
            'lastLogin',
            'completion',
            'recentActivities'
        ));
    }
}