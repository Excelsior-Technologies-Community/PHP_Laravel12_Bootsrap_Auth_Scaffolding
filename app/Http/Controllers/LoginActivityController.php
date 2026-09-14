<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class LoginActivityController extends Controller
{
    /**
     * Display login activities.
     */
    public function index(Request $request): View
    {
        $query = $request->user()
            ->loginActivities()
            ->oldest('login_at');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                    ->orWhere('user_agent', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {
            $query->whereDate('login_at', $request->date);
        }

        $activities = $query
            ->paginate(5)
            ->withQueryString();

        return view('login-activities', [
            'activities' => $activities,
        ]);
    }

    /**
     * Export login activities to CSV.
     */
    public function export(Request $request): Response
    {
        $activities = $request->user()
            ->loginActivities()
            ->oldest('login_at')
            ->get();

        $filename = 'login-activities-' . now()->format('Y-m-d-H-i-s') . '.csv';

        $handle = fopen('php://temp', 'w+');

        fputcsv($handle, [
            'ID',
            'Login Date',
            'Logout Date',
            'IP Address',
            'Browser / Device',
        ]);

        foreach ($activities as $activity) {
            fputcsv($handle, [
                $activity->id,
                $activity->login_at?->format('Y-m-d H:i:s'),
                $activity->logout_at?->format('Y-m-d H:i:s'),
                $activity->ip_address,
                $activity->user_agent,
            ]);
        }

        rewind($handle);

        $csv = stream_get_contents($handle);

        fclose($handle);

        return response(
            $csv,
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }

    /**
     * Delete all login activities for current user.
     */
    public function clear(Request $request)
    {
        $request->user()
            ->loginActivities()
            ->delete();

        return redirect()
            ->route('login.activities')
            ->with('success', 'Login activity cleared successfully.');
    }
}