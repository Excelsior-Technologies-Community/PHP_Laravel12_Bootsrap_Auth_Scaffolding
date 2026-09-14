@extends('layouts.app')

@section('content')

<div class="container">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Login Activity
            </h2>

            <p class="text-muted mb-0">
                Monitor your account login history.
            </p>

        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('login.activities.export') }}"
                class="btn btn-success"
            >
                📥 Export CSV
            </a>

            <a
                href="{{ route('home') }}"
                class="btn btn-secondary"
            >
                Dashboard
            </a>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- FILTER --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('login.activities') }}"
            >

                <div class="row g-3">

                    <div class="col-md-6">

                        <label class="form-label">
                            Search
                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Search IP address or browser..."
                        >

                    </div>


                    <div class="col-md-4">

                        <label class="form-label">
                            Login Date
                        </label>

                        <input
                            type="date"
                            name="date"
                            value="{{ request('date') }}"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-2 d-flex align-items-end">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            🔎 Search
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ACTIVITY TABLE --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm">

        <div class="card-header bg-info text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    Login Records
                </h5>

                <span class="badge bg-light text-dark">
                    {{ $activities->total() }} Records
                </span>

            </div>

        </div>


        <div class="card-body">

            @if($activities->count())

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>#</th>

                                <th>Login Date & Time</th>

                                <th>Logout Date & Time</th>

                                <th>IP Address</th>

                                <th>Browser / Device</th>

                                <th>Status</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($activities as $activity)

                                <tr>

                                    <td>
                                        {{ $activities->firstItem() + $loop->index }}
                                    </td>


                                    <td>
                                        {{ $activity->login_at?->format('d M Y, h:i A') }}
                                    </td>


                                    <td>

                                        @if($activity->logout_at)

                                            {{ $activity->logout_at->format('d M Y, h:i A') }}

                                        @else

                                            <span class="text-muted">
                                                Not recorded
                                            </span>

                                        @endif

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


                                    <td>

                                        @if($activity->logout_at)

                                            <span class="badge bg-secondary">
                                                Logged Out
                                            </span>

                                        @else

                                            <span class="badge bg-success">
                                                Active
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Numeric Pagination Only --}}

                <div class="mt-4">

                    {{ $activities->onEachSide(1)->links('pagination::bootstrap-5') }}

                </div>

            @else

                <div class="alert alert-info mb-0">

                    No login activity found.

                </div>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- CLEAR ACTIVITY --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm border-danger mt-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="text-danger mb-1">
                        Clear Login History
                    </h5>

                    <p class="text-muted mb-0">
                        Permanently delete your login activity records.
                    </p>

                </div>


                <form
                    method="POST"
                    action="{{ route('login.activities.clear') }}"
                    onsubmit="return confirm('Are you sure you want to delete all login activity?');"
                >

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        🗑️ Clear History
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection