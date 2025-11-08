@extends('layouts.master')

@section('page')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h4 class="mb-0 fw-normal">Profile Management</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Profile Information -->
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-header bg-white border-bottom">
                                        <h5 class="mb-0 fw-normal">Profile Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('profile.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="text-center mb-4">
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ $user->photo_url }}" alt="{{ $user->name }}"
                                                        class="rounded-circle"
                                                        style="width: 120px; height: 120px; object-fit: cover; border: 2px solid #dee2e6;">
                                                    <div class="position-absolute bottom-0 end-0">
                                                        <label for="photo"
                                                            class="btn btn-sm btn-dark rounded-circle cursor-pointer"
                                                            style="width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-camera" style="font-size: 12px;"></i>
                                                        </label>
                                                        <input type="file" id="photo" name="photo" class="d-none"
                                                            accept="image/*">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="name" class="form-label">Full Name *</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    name="name" value="{{ old('name', $user->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email *</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone Number</label>
                                                <input type="text"
                                                    class="form-control @error('phone') is-invalid @enderror" id="phone"
                                                    name="phone" value="{{ old('phone', $user->phone) }}">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="address" class="form-label">Address</label>
                                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-dark w-100">
                                                Update Profile
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Update -->
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-header bg-white border-bottom">
                                        <h5 class="mb-0 fw-normal">Change Password</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('profile.password.update') }}" method="POST">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="current_password" class="form-label">Current Password *</label>
                                                <input type="password"
                                                    class="form-control @error('current_password') is-invalid @enderror"
                                                    id="current_password" name="current_password" required>
                                                @error('current_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="password" class="form-label">New Password *</label>
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password" required>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation" required>
                                            </div>

                                            <button type="submit" class="btn btn-dark w-100">
                                                Change Password
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- User Information -->
                                <div class="card border mt-4">
                                    <div class="card-header bg-white border-bottom">
                                        <h5 class="mb-0 fw-normal">Account Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="mb-2"><strong>Account Created:</strong>
                                                    {{ $user->created_at->format('d M, Y') }}</p>
                                                <p class="mb-2"><strong>Last Updated:</strong>
                                                    {{ $user->updated_at->format('d M, Y') }}</p>
                                                <p class="mb-0"><strong>Email Verified:</strong>
                                                    @if ($user->email_verified_at)
                                                        <span class="badge bg-success">Verified</span>
                                                    @else
                                                        <span class="badge bg-secondary">Pending</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Preview image before upload
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.querySelector('.rounded-circle');
                    img.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection