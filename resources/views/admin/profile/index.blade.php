@extends('admin.dashboard.layout')

@section('title', 'Admin Profile - ABS')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold">Admin Profile</h6>
    </div>
    <div>
      @if(session('status'))
        <div class="neo-alert-success mb-4">
          {{ session('status') }}
        </div>
      @endif
      <div class="mb-6">
        <h5 class="text-lg font-bold mb-4">Profile Information</h5>
        <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          @method('PATCH')
          <div class="mb-4">
            <label for="name" class="neo-label">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
              class="neo-input"
              required>
            @error('name')
              <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="email" class="neo-label">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
              class="neo-input"
              required>
            @error('email')
              <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex justify-end">
            <button type="submit" class="neo-btn-primary">
              Save
            </button>
          </div>
        </form>
      </div>

<hr class="h-px my-6 border-t-3 border-black">

      <div class="mb-6">
        <h5 class="text-lg font-bold mb-4">Update Password</h5>
        <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          @method('PATCH')
          <div class="mb-4">
            <label for="current_password" class="neo-label">Current Password</label>
            <input type="password" id="current_password" name="current_password"
              class="neo-input"
              placeholder="Enter current password">
            @error('current_password')
              <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="password" class="neo-label">New Password</label>
            <input type="password" id="password" name="password"
              class="neo-input"
              placeholder="Enter new password">
            @error('password')
              <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="password_confirmation" class="neo-label">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
              class="neo-input"
              placeholder="Confirm new password">
            @error('password_confirmation')
              <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex justify-end">
            <button type="submit" class="neo-btn-primary">
              Update Password
            </button>
          </div>
        </form>
      </div>

<hr class="h-px my-6 border-t-3 border-black">

      <div>
        <h5 class="text-lg font-bold mb-4 text-neo-red">Delete Account</h5>
        <p class="text-sm mb-4">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account?')">
          @csrf
          @method('DELETE')
          <div class="mb-4">
            <label for="password" class="neo-label">Password</label>
            <input type="password" id="password" name="password"
              class="neo-input"
              placeholder="Enter password to confirm" required>
            @error('password', 'userDeletion')
              <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex justify-end">
            <button type="submit" class="neo-btn-danger">
              Delete Account
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
