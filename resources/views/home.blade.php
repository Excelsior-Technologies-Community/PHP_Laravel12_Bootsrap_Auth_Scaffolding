@extends('layouts.app')

@section('content')

<div class="container">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Dashboard
            </h2>

            <p class="text-muted mb-0">
                Welcome back, {{ Auth::user()->name }}!
            </p>
        </div>

        <span class="badge bg-success fs-6">
            ● Authenticated
        </span>

    </div>


    {{-- ========================================================= --}}
    {{-- SECURITY ALERT --}}
    {{-- ========================================================= --}}

    @if($completion < 100)

        <div class="alert alert-warning shadow-sm">

            <strong>
                Complete your account
            </strong>

            <div class="mt-2">
                Your profile is {{ $completion }}% complete.
            </div>

            <a
                href="{{ route('profile.edit') }}"
                class="btn btn-sm btn-warning mt-2"
            >
                Complete Profile
            </a>

        </div>

    @else

        <div class="alert alert-success shadow-sm">

            <strong>
                ✓ Your account profile is complete.
            </strong>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- STATISTICS --}}
    {{-- ========================================================= --}}

    <div class="row g-4 mb-4">

        <div class="col-md-3">

            <div class="card shadow-sm h-100 border-primary">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Users
                    </h6>

                    <h2 class="fw-bold text-primary">
                        {{ $totalUsers }}
                    </h2>

                    <small class="text-muted">
                        Registered users
                    </small>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card shadow-sm h-100 border-success">

                <div class="card-body">

                    <h6 class="text-muted">
                        Today's Users
                    </h6>

                    <h2 class="fw-bold text-success">
                        {{ $todayUsers }}
                    </h2>

                    <small class="text-muted">
                        Registered today
                    </small>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card shadow-sm h-100 border-info">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Logins
                    </h6>

                    <h2 class="fw-bold text-info">
                        {{ $totalLogins }}
                    </h2>

                    <small class="text-muted">
                        All login records
                    </small>

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card shadow-sm h-100 border-warning">

                <div class="card-body">

                    <h6 class="text-muted">
                        Today's Logins
                    </h6>

                    <h2 class="fw-bold text-warning">
                        {{ $todayLogins }}
                    </h2>

                    <small class="text-muted">
                        Login activity today
                    </small>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MY ACCOUNT --}}
    {{-- ========================================================= --}}

    <div class="row g-4 mb-4">

        <div class="col-md-6">

            <div class="card shadow-sm h-100">

                <div class="card-header bg-dark text-white">

                    <h5 class="mb-0">
                        👤 My Account
                    </h5>

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <strong>
                            Name
                        </strong>

                        <div class="text-muted">
                            {{ Auth::user()->name }}
                        </div>

                    </div>


                    <div class="mb-3">

                        <strong>
                            Email
                        </strong>

                        <div class="text-muted">
                            {{ Auth::user()->email }}
                        </div>

                    </div>


                    <div class="mb-3">

                        <strong>
                            Account Created
                        </strong>

                        <div class="text-muted">
                            {{ Auth::user()->created_at->format('d M Y, h:i A') }}
                        </div>

                    </div>


                    <div class="mb-3">

                        <strong>
                            Profile Completion
                        </strong>

                        <div class="progress mt-2">

                            <div
                                class="progress-bar"
                                role="progressbar"
                                style="width: {{ $completion }}%;"
                            >
                                {{ $completion }}%
                            </div>

                        </div>

                    </div>


                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('profile.edit') }}"
                            class="btn btn-primary"
                        >
                            Manage Profile
                        </a>

                        <a
                            href="{{ route('password.edit') }}"
                            class="btn btn-warning"
                        >
                            Change Password
                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- LAST LOGIN --}}
        {{-- ===================================================== --}}

        <div class="col-md-6">

            <div class="card shadow-sm h-100">

                <div class="card-header bg-info text-white">

                    <h5 class="mb-0">
                        🔐 Security Information
                    </h5>

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <strong>
                            My Total Logins
                        </strong>

                        <div class="display-6 fw-bold text-info">
                            {{ $myLoginCount }}
                        </div>

                    </div>


                    @if($lastLogin)

                        <div class="mb-3">

                            <strong>
                                Last Login
                            </strong>

                            <div class="text-muted">
                                {{ $lastLogin->login_at?->format('d M Y, h:i A') }}
                            </div>

                        </div>


                        <div class="mb-3">

                            <strong>
                                IP Address
                            </strong>

                            <div>
                                <span class="badge bg-secondary">
                                    {{ $lastLogin->ip_address }}
                                </span>
                            </div>

                        </div>

                    @else

                        <div class="alert alert-info">
                            No login activity found.
                        </div>

                    @endif


                    <a
                        href="{{ route('login.activities') }}"
                        class="btn btn-info text-white"
                    >
                        View Login Activity
                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- RECENT ACTIVITY --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    Recent Login Activity
                </h5>

                <a
                    href="{{ route('login.activities') }}"
                    class="btn btn-sm btn-light"
                >
                    View All
                </a>

            </div>

        </div>


        <div class="card-body p-0">

            @if($recentActivities->count())

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead class="table-light">

                            <tr>

                                <th>#</th>

                                <th>Login Time</th>

                                <th>IP Address</th>

                                <th>Browser / Device</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($recentActivities as $activity)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $activity->login_at?->format('d M Y, h:i A') }}
                                    </td>

                                    <td>

                                        <span class="badge bg-secondary">
                                            {{ $activity->ip_address }}
                                        </span>

                                    </td>

                                    <td>

                                        <small>
                                            {{ $activity->user_agent }}
                                        </small>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="p-4">

                    <div class="alert alert-info mb-0">
                        No login activity available.
                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection