@extends('front.layouts.app')

@section('main')

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="card border-0 shadow mb-4">

                    {{-- @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif --}}
                    @include('front.message')

                    <form method="POST" action="{{ route('account.updateProfile') }}">
                        @csrf
                        @method('PUT')

                        <div class="card-body  p-4">
                            <h3 class="fs-4 mb-1">My Profile</h3>
                            <div class="mb-4">
                                <label for="" class="mb-2">Name*</label>
                                <input type="text" name="name" id="name" value="{{ $user->name }}" placeholder="Enter Name" class="form-control" value="">
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" name="email" id="email" value="{{ $user->email }}" placeholder="Enter Email" class="form-control" disabled>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Designation*</label>
                                <input type="text" name="designation" id="designation" value="{{ $user->designation }}" placeholder="Designation" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Phone*</label>
                                <input type="text" name="phone" id="phone" value="{{ $user->phone }}" placeholder="Phone" class="form-control">
                            </div>                        
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

                <div class="card border-0 shadow mb-4">
                    <form action="{{ route('account.changePassword') }}" method="POST" id="changePasswordForm" name="changePasswordForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-1">Change Password</h3>
                            <div class="mb-4">
                                <label for="" class="mb-2">Old Password*</label>
                                <input type="password" id="old_password" name="old_password" placeholder="Old Password" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">New Password*</label>
                                <input type="password" id="new_password" name="new_password" placeholder="New Password" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Confirm Password*</label>
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" class="form-control">
                            </div>                        
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')
<script>
    document.getElementById("changePasswordForm").addEventListener("submit", function(event) {
        let oldPassword = document.getElementById("old_password").value.trim();
        let newPassword = document.getElementById("new_password").value.trim();
        let confirmPassword = document.getElementById("confirm_password").value.trim();

        if (!oldPassword || !newPassword || !confirmPassword) {
            alert("Please fill in all the fields.");
            event.preventDefault();
            return;
        }

        if (newPassword.length < 5) {
            alert("New password must be at least 5 characters long.");
            event.preventDefault();
            return;
        }

        if (newPassword !== confirmPassword) {
            alert("New password and confirm password do not match.");
            event.preventDefault();
            return;
        }
    });
</script>

@endsection