@extends('layouts.app')

@section('title', 'Edit Staff')

@section('sidebar')
@include('partials.sidebar-admin')
@endsection

@section('content')
<!-- Breadcrumb -->
<div class="px-3 -mt-2 mb-4">
    <nav class="text-sm text-gray-600 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
            <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z" />
        </svg>
        <a href="{{ route('admin.dashboard') }}" class="hover:text-red-800">Dashboard</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-600">Manage Users</span>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('admin.manage-staff') }}" class="text-gray-600 hover:text-red-800">Staff</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">Edit</span>
    </nav>
</div>

<!-- Page Header -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl p-8 mb-8 shadow-lg">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Edit Staff Member</h1>
            <p class="text-gray-100">Update staff account and profile information</p>
        </div>
        <a href="{{ route('admin.manage-staff') }}"
            class="bg-white text-red-800 px-6 py-3 rounded-lg hover:bg-gray-100 font-medium transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Staff
        </a>
    </div>
</div>

<!-- Validation Errors -->
@if ($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6">
    <div class="flex items-start">
        <svg class="h-5 w-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
        </svg>
        <div>
            <p class="font-semibold mb-2">Please correct the following errors:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<!-- Edit Form -->
<div class="bg-white rounded-xl shadow-lg p-8">
    <form method="POST" action="{{ route('admin.staff.update', $staff->id) }}">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Basic Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name <span class="text-red-600">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $staff->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-600">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $staff->email) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Staff Type -->
                <div>
                    <label for="staff_type" class="block text-sm font-medium text-gray-700 mb-2">Staff Type</label>
                    <select id="staff_type" name="staff_type"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                        <option value="">Select Type</option>
                        <option value="Academic" {{ old('staff_type', optional($staff->staff)->staff_type) === 'Academic' ? 'selected' : '' }}>Academic</option>
                        <option value="Non-Academic" {{ old('staff_type', optional($staff->staff)->staff_type) === 'Non-Academic' ? 'selected' : '' }}>Non-Academic</option>
                        <option value="Administrative" {{ old('staff_type', optional($staff->staff)->staff_type) === 'Administrative' ? 'selected' : '' }}>Administrative</option>
                    </select>
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role/Access Level <span class="text-red-600">*</span></label>
                    <select id="role" name="role" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('role') border-red-500 @enderror">
                        <option value="">Select Role</option>
                        <option value="osas_gmc" {{ old('role', $staff->role) === 'osas_gmc' ? 'selected' : '' }}>OSAS GMC (Good Moral & Safe Loan)</option>
                        <option value="osas_du" {{ old('role', $staff->role) === 'osas_du' ? 'selected' : '' }}>OSAS DU (Discipline Unit - Grievances)</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">
                        OSAS GMC: Manage requests, view grievances | OSAS DU: Manage grievances, view requests
                    </p>
                    @error('role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Password Update (Optional) -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Update Password (Optional)</h2>
            <p class="text-sm text-gray-600 mb-4">Leave blank to keep current password</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('password') border-red-500 @enderror">
                        <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <svg id="password-eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="password-eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <svg id="password_confirmation-eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="password_confirmation-eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pt-6 border-t border-gray-200">
            <button type="submit" class="px-8 py-3 bg-red-800 text-white rounded-lg hover:bg-red-900 font-medium transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Update Staff
            </button>
            <a href="{{ route('admin.manage-staff') }}" class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    function togglePassword(fieldId) {
        const input = document.getElementById(fieldId);
        const eyeOpen = document.getElementById(fieldId + '-eye-open');
        const eyeClosed = document.getElementById(fieldId + '-eye-closed');

        if (input.type === 'password') {
            input.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }
</script>
@endsection