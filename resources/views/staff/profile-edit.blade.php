@extends('layouts.app')

@section('title', 'Edit Profile')

@section('sidebar')
    @include('partials.sidebar-staff')
@endsection

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Edit Profile</h2>

    @if(session('success'))
        <div class="p-3 bg-green-50 border border-green-200 text-green-800 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('staff.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">First name</label>
                <input name="first_name" value="{{ old('first_name', $staff->first_name ?? $user->name) }}" class="w-full border px-3 py-2 rounded" required>
                @error('first_name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Last name</label>
                <input name="last_name" value="{{ old('last_name', $staff->last_name ?? '') }}" class="w-full border px-3 py-2 rounded" required>
                @error('last_name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Middle initial</label>
                <input name="middle_initial" value="{{ old('middle_initial', $staff->middle_initial ?? '') }}" class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Suffix</label>
                <input name="suffix" value="{{ old('suffix', $staff->suffix ?? '') }}" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Department</label>
            <input name="department" value="{{ old('department', $staff->department ?? '') }}" class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Position</label>
            <input name="position" value="{{ old('position', $staff->position ?? '') }}" class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Phone</label>
            <input name="phone" value="{{ old('phone', $staff->phone ?? '') }}" class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input name="email" value="{{ old('email', $user->email) }}" class="w-full border px-3 py-2 rounded" required>
            @error('email') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Avatar</label>
            @if(!empty($staff->profile_photo_path))
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $staff->profile_photo_path) }}" alt="avatar" class="h-20 w-20 rounded-full object-cover">
                </div>
            @endif
            <input type="file" name="profile_photo" accept="image/*" class="w-full">
            @error('avatar') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">New password</label>
                <input type="password" name="password" class="w-full border px-3 py-2 rounded">
                @error('password') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Confirm password</label>
                <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('staff.profile') }}" class="px-4 py-2 mr-2 border rounded">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-red-800 text-white rounded">Save</button>
        </div>
    </form>
</div>
@endsection
