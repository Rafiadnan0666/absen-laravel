@extends('admin.dashboard.layout')

@section('title', 'Admin Profile - ABS')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="text-xl font-bold">Admin Profile</h6>
      </div>
      <div class="flex-auto p-6">
        @if(session('status'))
          <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ session('status') }}
          </div>
        @endif
        <div class="mb-6">
          <h5 class="text-lg font-bold mb-4">Profile Information</h5>
          <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            <div class="mb-4">
              <label for="name" class="inline-block mb-2 text-sm font-bold text-slate-700">Name</label>
              <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                required>
              @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
            <div class="mb-4">
              <label for="email" class="inline-block mb-2 text-sm font-bold text-slate-700">Email</label>
              <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                required>
              @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
            <div class="flex justify-end">
              <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white">
                Save
              </button>
            </div>
          </form>
        </div>

        <hr class="h-px my-6 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent">

        <div class="mb-6">
          <h5 class="text-lg font-bold mb-4">Update Password</h5>
          <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            <div class="mb-4">
              <label for="current_password" class="inline-block mb-2 text-sm font-bold text-slate-700">Current Password</label>
              <input type="password" id="current_password" name="current_password"
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Enter current password">
              @error('current_password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
            <div class="mb-4">
              <label for="password" class="inline-block mb-2 text-sm font-bold text-slate-700">New Password</label>
              <input type="password" id="password" name="password"
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Enter new password">
              @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
            <div class="mb-4">
              <label for="password_confirmation" class="inline-block mb-2 text-sm font-bold text-slate-700">Confirm Password</label>
              <input type="password" id="password_confirmation" name="password_confirmation"
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Confirm new password">
              @error('password_confirmation')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
            <div class="flex justify-end">
              <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white">
                Update Password
              </button>
            </div>
          </form>
        </div>

        <hr class="h-px my-6 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent">

        <div>
          <h5 class="text-lg font-bold mb-4 text-red-600">Delete Account</h5>
          <p class="text-sm text-slate-500 mb-4">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
          <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account?')">
            @csrf
            @method('DELETE')
            <div class="mb-4">
              <label for="password" class="inline-block mb-2 text-sm font-bold text-slate-700">Password</label>
              <input type="password" id="password" name="password"
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Enter password to confirm" required>
              @error('password', 'userDeletion')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
            <div class="flex justify-end">
              <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-red-600 to-rose-400 text-white">
                Delete Account
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
