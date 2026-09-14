@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow-sm">

                <div class="card-header bg-warning">
                    <h5 class="mb-0">
                        Change Password
                    </h5>
                </div>

                <div class="card-body">

                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">
                        </button>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">

                        <strong>Please fix the following errors:</strong>

                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('password.change') }}">

                        @csrf


                        <div class="mb-3">

                            <label
                                for="current_password"
                                class="form-label">
                                Current Password
                            </label>

                            <input
                                type="password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password"
                                name="current_password"
                                required>

                            @error('current_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label
                                for="password"
                                class="form-label">
                                New Password
                            </label>

                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                required>

                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label
                                for="password_confirmation"
                                class="form-label">
                                Confirm New Password
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                required>

                        </div>

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-warning">
                                Change Password
                            </button>

                            <a
                                href="{{ route('home') }}"
                                class="btn btn-secondary">
                                Back to Dashboard
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection