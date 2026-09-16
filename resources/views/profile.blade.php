@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-11">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <span class="me-2">✓</span> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <span>👤</span>
                        <span>Manage Account Profile & Photo</span>
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form
                        method="POST"
                        action="{{ route('profile.update') }}"
                        enctype="multipart/form-data"
                        id="profileForm"
                    >
                        @csrf
                        @method('PUT')

                        {{-- AVATAR UPLOAD SECTION --}}
                        <div class="card bg-body-tertiary border mb-4">
                            <div class="card-body p-3 p-md-4">
                                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                                    <span>🖼️</span>
                                    <span>Profile Photo (Avatar)</span>
                                </h6>

                                <div class="d-flex flex-column flex-sm-row align-items-center gap-4">
                                    {{-- Avatar Preview Container --}}
                                    <div class="position-relative">
                                        <div
                                            id="avatarPreviewContainer"
                                            class="rounded-circle shadow-sm border d-flex align-items-center justify-content-center overflow-hidden bg-body"
                                            style="width: 100px; height: 100px; min-width: 100px;"
                                        >
                                            @if ($user->avatar_url)
                                                <img
                                                    id="avatarImagePreview"
                                                    src="{{ $user->avatar_url }}"
                                                    alt="{{ $user->name }}"
                                                    class="w-100 h-100"
                                                    style="object-fit: cover;"
                                                >
                                                <span
                                                    id="avatarInitialsFallback"
                                                    class="avatar-initials d-none w-100 h-100"
                                                    style="font-size: 32px; background-color: {{ $user->avatar_bg_color }};"
                                                >
                                                    {{ $user->initials }}
                                                </span>
                                            @else
                                                <img
                                                    id="avatarImagePreview"
                                                    src=""
                                                    alt="Preview"
                                                    class="w-100 h-100 d-none"
                                                    style="object-fit: cover;"
                                                >
                                                <span
                                                    id="avatarInitialsFallback"
                                                    class="avatar-initials w-100 h-100"
                                                    style="font-size: 32px; background-color: {{ $user->avatar_bg_color }};"
                                                >
                                                    {{ $user->initials }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Upload Input & Info --}}
                                    <div class="flex-grow-1 w-100">
                                        <label for="avatarInput" class="form-label fw-semibold mb-1">
                                            Choose New Photo
                                        </label>
                                        <input
                                            type="file"
                                            class="form-control @error('avatar') is-invalid @enderror"
                                            id="avatarInput"
                                            name="avatar"
                                            accept="image/png, image/jpeg, image/jpg, image/webp, image/gif"
                                        >
                                        <div class="form-text small text-muted mt-1">
                                            Allowed formats: JPG, PNG, WEBP, GIF. Maximum file size: 2MB.
                                        </div>
                                        @error('avatar')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror

                                        {{-- Live preview hint --}}
                                        <div id="previewStatus" class="small text-success mt-1 d-none fw-semibold">
                                            ✓ Image selected. Click "Save Profile & Photo" below to apply.
                                        </div>
                                    </div>

                                    {{-- Remove Avatar Button if exists --}}
                                    @if ($user->avatar)
                                        <div class="align-self-sm-center">
                                            <button
                                                type="button"
                                                class="btn btn-outline-danger btn-sm text-nowrap"
                                                onclick="document.getElementById('removeAvatarForm').submit();"
                                                title="Remove custom profile picture"
                                            >
                                                🗑️ Remove Photo
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- USER PROFILE DETAILS --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 pt-2 border-top">
                            <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                💾 Save Profile & Photo
                            </button>

                            <a href="{{ route('home') }}" class="btn btn-outline-secondary px-3">
                                Back to Dashboard
                            </a>
                        </div>
                    </form>

                    {{-- Hidden Form for Removing Avatar --}}
                    @if ($user->avatar)
                        <form id="removeAvatarForm" method="POST" action="{{ route('profile.avatar.destroy') }}" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

{{-- CLIENT-SIDE LIVE IMAGE PREVIEW SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const avatarInput = document.getElementById('avatarInput');
    const avatarImagePreview = document.getElementById('avatarImagePreview');
    const avatarInitialsFallback = document.getElementById('avatarInitialsFallback');
    const previewStatus = document.getElementById('previewStatus');

    if (!avatarInput) return;

    avatarInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            // Check file type
            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image file (PNG, JPG, WEBP, GIF).');
                avatarInput.value = '';
                return;
            }

            // Check size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size exceeds 2MB limit. Please choose a smaller photo.');
                avatarInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (event) {
                avatarImagePreview.src = event.target.result;
                avatarImagePreview.classList.remove('d-none');
                if (avatarInitialsFallback) {
                    avatarInitialsFallback.classList.add('d-none');
                }
                if (previewStatus) {
                    previewStatus.classList.remove('d-none');
                }
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
