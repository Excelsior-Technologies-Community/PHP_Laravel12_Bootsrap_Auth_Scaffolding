@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        User Profile
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
                        action="{{ route('profile.update') }}"
                    >

                        @csrf
                        @method('PUT')

                        <div class="mb-3">

                            <label
                                for="name"
                                class="form-label"
                            >
                                Name
                            </label>

                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label
                                for="email"
                                class="form-label"
                            >
                                Email Address
                            </label>

                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Update Profile
                            </button>

                            <a
                                href="{{ route('home') }}"
                                class="btn btn-secondary"
                            >
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