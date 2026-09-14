@extends('layouts.app')

@section('content')

<div class="container">

    <!-- Dashboard Header -->

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
            Authenticated
        </span>

    </div>


    <!-- Statistics -->

    <div class="row g-4 mb-4">

        <!-- Profile -->

        <div class="col-md-4">

            <div class="card shadow-sm h-100 border-primary">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="text-muted">
                                Profile
                            </h6>

                            <h4 class="fw-bold">
                                {{ Auth::user()->name }}
                            </h4>

                        </div>

                        <div class="fs-1 text-primary">
                            👤
                        </div>

                    </div>

                    <p class="text-muted small">
                        Manage your account information.
                    </p>

                    <a
                        href="{{ route('profile.edit') }}"
                        class="btn btn-primary btn-sm"
                    >
                        Manage Profile
                    </a>

                </div>

            </div>

        </div>


        <!-- Password -->

        <div class="col-md-4">

            <div class="card shadow-sm h-100 border-warning">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="text-muted">
                                Security
                            </h6>

                            <h4 class="fw-bold">
                                Password
                            </h4>

                        </div>

                        <div class="fs-1 text-warning">
                            🔐
                        </div>

                    </div>

                    <p class="text-muted small">
                        Keep your account password secure.
                    </p>

                    <a
                        href="{{ route('password.edit') }}"
                        class="btn btn-warning btn-sm"
                    >
                        Change Password
                    </a>

                </div>

            </div>

        </div>


        <!-- Login Activity -->

        <div class="col-md-4">

            <div class="card shadow-sm h-100 border-info">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="text-muted">
                                Security
                            </h6>

                            <h4 class="fw-bold">
                                Login Activity
                            </h4>

                        </div>

                        <div class="fs-1 text-info">
                            🔐
                        </div>

                    </div>

                    <p class="text-muted small">
                        Review your recent login activity.
                    </p>

                    <a
                        href="{{ route('login.activities') }}"
                        class="btn btn-info text-white btn-sm"
                    >
                        View Activity
                    </a>

                </div>

            </div>

        </div>

    </div>


    <!-- Account Information -->

    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">

            <h5 class="mb-0">
                Account Information
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>
                        Name
                    </strong>

                    <div class="text-muted">
                        {{ Auth::user()->name }}
                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>
                        Email
                    </strong>

                    <div class="text-muted">
                        {{ Auth::user()->email }}
                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>
                        Account Created
                    </strong>

                    <div class="text-muted">
                        {{ Auth::user()->created_at->format('d M Y, h:i A') }}
                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>
                        Account Status
                    </strong>

                    <div>

                        <span class="badge bg-success">
                            Active
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection