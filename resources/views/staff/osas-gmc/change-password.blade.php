@extends('layouts.app')

@section('title', 'Change Password')

@section('sidebar')
@include('partials.sidebar-osas-gmc')
@endsection

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 flex items-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
            <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z" />
        </svg>
        <a href="{{ route('osas-gmc.dashboard') }}" class="hover:text-red-800">Dashboard</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('osas-gmc.profile') }}" class="hover:text-red-800">Profile</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">Change Password</span>
    </nav>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Change Password</h1>
        <p class="text-gray-600 mt-2">Update your account password to keep your account secure</p>
    </div>





    <form action="{{ route('osas-gmc.password.update') }}" method="POST">
        @csrf
        @method('PATCH')

        <!-- Security Section -->
        <div class="bg-white rounded-2xl shadow-md p-8 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Password Requirements
            </h2>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-800 font-medium mb-2">Your new password must:</p>
                <ul class="text-sm text-blue-700 space-y-1 ml-5 list-disc">
                    <li>Be at least 8 characters long</li>
                    <li>Contain at least one uppercase letter</li>
                    <li>Contain at least one lowercase letter</li>
                    <li>Contain at least one number</li>
                    <li>Not match your current password</li>
                </ul>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password <span class="text-red-600">*</span></label>
                    <input type="password" name="current_password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none transition"
                        placeholder="Enter your current password"
                        required>
                    @error('current_password') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">New Password <span class="text-red-600">*</span></label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none transition"
                        placeholder="Enter new password"
                        required>
                    @error('password') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password <span class="text-red-600">*</span></label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none transition"
                        placeholder="Confirm new password"
                        required>
                </div>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-yellow-800">Security Notice</p>
                    <p class="text-sm text-yellow-700 mt-1">After changing your password, you will be logged out and need to sign in again with your new password.</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('osas-gmc.profile') }}"
                class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition duration-200">
                Cancel
            </a>
            <button type="submit"
                class="px-6 py-3 bg-red-800 text-white font-semibold rounded-lg hover:bg-red-900 shadow-md hover:shadow-lg transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Change Password
            </button>
        </div>
    </form>
</div>
@endsection
