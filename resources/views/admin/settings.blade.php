@extends('layouts.app')

@section('title', 'System Settings')

@section('sidebar')
    @include('partials.sidebar-admin')
@endsection

@section('content')
<!-- Breadcrumb -->
<div class="px-3 -mt-2 mb-4">
    <nav class="text-sm text-gray-600 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
        <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z"/>
        </svg>
        <a href="{{ route('admin.dashboard') }}" class="hover:text-red-800">Dashboard</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">Settings</span>
    </nav>
</div>

<!-- Page Header -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl p-8 mb-8 shadow-lg">
    <div>
        <h1 class="text-3xl font-bold mb-2">System Settings</h1>
        <p class="text-gray-100">Configure system-wide settings and preferences</p>
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg mb-6 flex items-center justify-between">
    <span>{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf

    <!-- School Information -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                School Information
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">School Name</label>
                <input type="text" name="school_name" value="{{ $settings['school_name'] }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">OSAS Head/Director</label>
                <input type="text" name="osas_head" value="{{ $settings['osas_head'] }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Semester</label>
                <select name="current_semester" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent" required>
                    <option value="1st Semester" {{ $settings['current_semester'] === '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                    <option value="2nd Semester" {{ $settings['current_semester'] === '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                    <option value="Summer" {{ $settings['current_semester'] === 'Summer' ? 'selected' : '' }}>Summer</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Academic Year</label>
                <input type="text" name="current_year" value="{{ $settings['current_year'] }}" 
                    placeholder="2024-2025"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent"
                    required>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Contact Information
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                <input type="email" name="contact_email" value="{{ $settings['contact_email'] }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contact Phone</label>
                <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] }}" 
                    placeholder="(123) 456-7890"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
            </div>
        </div>
    </div>

    <!-- Signature Upload -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Digital Signature
            </h2>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Upload Director's Signature (for certificates)
            </label>
            <input type="file" name="signature" accept="image/*"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
            <p class="mt-2 text-sm text-gray-500">Recommended size: 300x100 pixels, PNG format with transparent background</p>
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end">
        <button type="submit" class="px-8 py-3 bg-red-800 text-white rounded-lg hover:bg-red-900 font-medium transition-colors shadow-lg flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Save Settings
        </button>
    </div>
</form>

@endsection
