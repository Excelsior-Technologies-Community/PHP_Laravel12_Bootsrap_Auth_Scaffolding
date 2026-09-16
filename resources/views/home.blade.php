@extends('layouts.app')

@section('content')

<div class="container">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div class="d-flex align-items-center gap-3">
            @if (Auth::user()->avatar_url)
                <img
                    src="{{ Auth::user()->avatar_url }}"
                    alt="{{ Auth::user()->name }}"
                    class="rounded-circle shadow-sm border"
                    width="54"
                    height="54"
                    style="object-fit: cover;"
                >
            @else
                <span
                    class="avatar-initials shadow-sm"
                    style="width: 54px; height: 54px; font-size: 20px; background-color: {{ Auth::user()->avatar_bg_color }};"
                >
                    {{ Auth::user()->initials }}
                </span>
            @endif

            <div>
                <h2 class="fw-bold mb-0">
                    Dashboard
                </h2>
                <p class="text-muted mb-0">
                    Welcome back, <span class="fw-semibold text-body">{{ Auth::user()->name }}</span>!
                </p>
            </div>
        </div>

        <div>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6">
                ● Authenticated Active
            </span>
        </div>
    </div>


    {{-- ========================================================= --}}
    {{-- SECURITY ALERT --}}
    {{-- ========================================================= --}}

    @if($completion < 100)
        <div class="alert alert-warning shadow-sm border-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <strong>⚠️ Complete your account</strong>
                <div class="mt-1">
                    Your profile is {{ $completion }}% complete. Add your profile details and photo.
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-warning fw-semibold">
                Complete Profile
            </a>
        </div>
    @else
        <div class="alert alert-success shadow-sm border-0">
            <strong>✓ Your account profile is complete and up to date.</strong>
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
    {{-- MY ACCOUNT & SECURITY --}}
    {{-- ========================================================= --}}

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        👤 My Account Profile
                    </h5>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3 p-3 rounded bg-body-tertiary border">
                        @if (Auth::user()->avatar_url)
                            <img
                                src="{{ Auth::user()->avatar_url }}"
                                alt="{{ Auth::user()->name }}"
                                class="rounded-circle shadow-sm border"
                                width="60"
                                height="60"
                                style="object-fit: cover;"
                            >
                        @else
                            <span
                                class="avatar-initials shadow-sm"
                                style="width: 60px; height: 60px; font-size: 22px; background-color: {{ Auth::user()->avatar_bg_color }};"
                            >
                                {{ Auth::user()->initials }}
                            </span>
                        @endif

                        <div>
                            <h6 class="fw-bold mb-0">{{ Auth::user()->name }}</h6>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Account Created</strong>
                        <div class="text-muted">
                            {{ Auth::user()->created_at->format('d M Y, h:i A') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Profile Completion</strong>
                        <div class="progress mt-2" style="height: 10px;">
                            <div
                                class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                role="progressbar"
                                style="width: {{ $completion }}%;"
                                aria-valuenow="{{ $completion }}"
                                aria-valuemin="0"
                                aria-valuemax="100"
                            >
                            </div>
                        </div>
                        <small class="text-muted mt-1 d-block">{{ $completion }}% complete</small>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            Manage Profile & Photo
                        </a>
                        <a href="{{ route('password.edit') }}" class="btn btn-outline-warning">
                            Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- LAST LOGIN --}}
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="mb-0 fw-bold">
                        🔐 Security & Login Details
                    </h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <strong>My Total Logins</strong>
                        <div class="display-6 fw-bold text-info">
                            {{ $myLoginCount }}
                        </div>
                    </div>

                    @if($lastLogin)
                        <div class="mb-3">
                            <strong>Last Login Time</strong>
                            <div class="text-muted">
                                {{ $lastLogin->login_at?->format('d M Y, h:i A') }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>IP Address</strong>
                            <div>
                                <span class="badge bg-secondary-subtle text-secondary border">
                                    {{ $lastLogin->ip_address }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No prior login activity recorded.
                        </div>
                    @endif

                    <a href="{{ route('login.activities') }}" class="btn btn-info text-white">
                        View Login Activity Logs
                    </a>
                </div>
            </div>
        </div>
    </div>


    {{-- ========================================================= --}}
    {{-- RECENT ACTIVITY TABLE --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm">
        <div class="card-header bg-body-tertiary py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    Recent Login Activity
                </h5>
                <a href="{{ route('login.activities') }}" class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            @if($recentActivities->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
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
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $activity->login_at?->format('d M Y, h:i A') }}</td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary border">
                                            {{ $activity->ip_address }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $activity->user_agent }}</small>
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
