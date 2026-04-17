@extends('admin-backend.main.panel')
@section('title', 'Profile')
@section('panel-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Profile</h1>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="row g-3">
            @csrf

            <div class="col-12">
                <label class="form-label">Current Profile Image</label>
                <div class="d-flex align-items-center gap-3">
                    <img
                        src="{{ !empty($user->profile_image) ? asset('storage/' . $user->profile_image) : asset('frontend/images/doc.jpg') }}"
                        alt="Profile"
                        class="rounded-circle border"
                        style="width:72px; height:72px; object-fit:cover;"
                    >
                    <div class="text-muted small">
                        Upload a square image for best results.
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Profile Image</label>
                <input class="form-control" type="file" name="profile_image" accept="image/*">
            </div>

            <div class="col-md-6">
                <label class="form-label">New Password</label>
                <input class="form-control" type="password" name="password" placeholder="Leave blank to keep current password">
            </div>

            <div class="col-md-6">
                <label class="form-label">Confirm New Password</label>
                <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm new password">
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
