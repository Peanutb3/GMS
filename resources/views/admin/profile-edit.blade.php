@extends('layouts.app')

@section('title', 'Edit Profile')

@section('sidebar')
@include('partials.sidebar-admin')
@endsection

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 flex items-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
            <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z" />
        </svg>
        <a href="{{ route('admin.dashboard') }}" class="hover:text-red-800">Dashboard</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('admin.profile') }}" class="hover:text-red-800">Profile</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">Edit Profile</span>
    </nav>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
        <p class="text-gray-600 mt-2">Update your personal information and account settings</p>
    </div>

    @if(session('success'))
    <x-toast type="success" :message="session('success')" />
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Profile Photo Section -->
        <div class="bg-white rounded-2xl shadow-md p-8 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profile Photo
            </h2>
            <div class="flex items-center space-x-6">
                <div class="relative">
                    @if(!empty($user->profile_photo_path))
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Profile Photo"
                        class="h-24 w-24 rounded-full object-cover border-4 border-gray-200 shadow-sm">
                    @else
                    <div class="h-24 w-24 rounded-full bg-gradient-to-br from-red-800 to-red-600 flex items-center justify-center border-4 border-gray-200 shadow-sm">
                        <span class="text-3xl font-bold text-white">{{ substr($user->name ?? 'A', 0, 1) }}</span>
                    </div>
                    @endif
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Photo</label>
                    <input type="file" name="profile_photo" accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-800 hover:file:bg-red-100 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2">JPG, PNG or GIF (max. 2MB)</p>
                    @error('profile_photo') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <!-- Personal Information Section -->
        <div class="bg-white rounded-2xl shadow-md p-8 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Personal Information
            </h2>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-600">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none transition" required>
                    @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="bg-white rounded-2xl shadow-md p-8 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Contact Information
            </h2>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-600">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none transition" required>
                    @error('email') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.profile') }}"
                class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition duration-200">
                Cancel
            </a>
            <button type="submit"
                class="px-6 py-3 bg-red-800 text-white font-semibold rounded-lg hover:bg-red-900 shadow-md hover:shadow-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
