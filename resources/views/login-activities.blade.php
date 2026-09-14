@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card shadow-sm">

        <div class="card-header bg-info text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    Login Activity
                </h5>

                <span class="badge bg-light text-dark">
                    {{ $activities->total() }} Records
                </span>

            </div>

        </div>

        <div class="card-body">

            @if ($activities->count() > 0)

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>#</th>
                                <th>Login Date & Time</th>
                                <th>IP Address</th>
                                <th>Browser / Device</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($activities as $activity)

                                <tr>

                                    <td>
                                        {{ $activities->firstItem() + $loop->index }}
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

                <div class="mt-3">

                    {{ $activities->links() }}

                </div>

            @else

                <div class="alert alert-info mb-0">
                    No login activity found.
                </div>

            @endif

        </div>

    </div>

</div>
@endsection