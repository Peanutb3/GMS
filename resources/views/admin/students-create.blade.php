@extends('layouts.app')

@section('title', 'Add New Student')

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
        <a href="{{ route('admin.manage-students') }}" class="text-gray-600 hover:text-red-800">Students</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">Create New</span>
    </nav>
</div>

<!-- Page Header -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl p-8 mb-8 shadow-lg">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Add New Student</h1>
            <p class="text-gray-100">Create a new student account and profile</p>
        </div>
        <a href="{{ route('admin.manage-students') }}"
            class="bg-white text-red-800 px-6 py-3 rounded-lg hover:bg-gray-100 font-medium transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Students
        </a>
    </div>
</div>

<!-- Create Form -->
<div class="bg-white rounded-xl shadow-lg p-8">
    <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Basic Information -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Basic Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student ID -->
                <div>
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Student ID <span class="text-red-600">*</span></label>
                    <input type="text" id="student_id" name="student_id" value="{{ old('student_id') }}" required
                        autocomplete="off"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('student_id') border-red-500 @enderror">
                    @error('student_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-600">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name <span class="text-red-600">*</span></label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('first_name') border-red-500 @enderror">
                    @error('first_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Middle Initial -->
                <div>
                    <label for="middle_initial" class="block text-sm font-medium text-gray-700 mb-2">Middle Initial</label>
                    <input type="text" id="middle_initial" name="middle_initial" value="{{ old('middle_initial') }}" maxlength="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('middle_initial') border-red-500 @enderror">
                    @error('middle_initial')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name <span class="text-red-600">*</span></label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('last_name') border-red-500 @enderror">
                    @error('last_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Suffix -->
                <div>
                    <label for="suffix" class="block text-sm font-medium text-gray-700 mb-2">Suffix</label>
                    <select id="suffix" name="suffix"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                        <option value="">None</option>
                        <option value="Jr." {{ old('suffix') === 'Jr.' ? 'selected' : '' }}>Jr.</option>
                        <option value="Sr." {{ old('suffix') === 'Sr.' ? 'selected' : '' }}>Sr.</option>
                        <option value="II" {{ old('suffix') === 'II' ? 'selected' : '' }}>II</option>
                        <option value="III" {{ old('suffix') === 'III' ? 'selected' : '' }}>III</option>
                        <option value="IV" {{ old('suffix') === 'IV' ? 'selected' : '' }}>IV</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Academic Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- College -->
                <div>
                    <label for="college" class="block text-sm font-medium text-gray-700 mb-2">College <span class="text-red-600">*</span></label>
                    <select id="college" name="college" required onchange="filterPrograms()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('college') border-red-500 @enderror">
                        <option value="">Select College</option>
                        @foreach($colleges as $college)
                        <option value="{{ $college->id }}" {{ old('college') == $college->id ? 'selected' : '' }}>
                            {{ $college->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('college')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Program -->
                <div>
                    <label for="program" class="block text-sm font-medium text-gray-700 mb-2">Program <span class="text-red-600">*</span></label>
                    <select id="program" name="program" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('program') border-red-500 @enderror">
                        <option value="">Select College First</option>
                        @foreach($programs as $program)
                        <option value="{{ $program->id }}" data-college-id="{{ $program->college_id }}" style="display: none;" {{ old('program') == $program->id ? 'selected' : '' }}>
                            {{ $program->name }} @if($program->code) ({{ $program->code }}) @endif
                        </option>
                        @endforeach
                    </select>
                    @error('program')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Year Level -->
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Year Level <span class="text-red-600">*</span></label>
                    <select id="year" name="year" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('year') border-red-500 @enderror">
                        <option value="">Select Year</option>
                        <option value="1" {{ old('year') == '1' ? 'selected' : '' }}>1st Year</option>
                        <option value="2" {{ old('year') == '2' ? 'selected' : '' }}>2nd Year</option>
                        <option value="3" {{ old('year') == '3' ? 'selected' : '' }}>3rd Year</option>
                        <option value="4" {{ old('year') == '4' ? 'selected' : '' }}>4th Year</option>
                        <option value="5" {{ old('year') == '5' ? 'selected' : '' }}>5th Year</option>
                    </select>
                    @error('year')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Account Security -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Account Security</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-600">*</span></label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
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
                    <p class="mt-1 text-xs text-gray-600">
                        Password must contain: <span class="font-medium">minimum 8 characters, uppercase, lowercase, number, and special character (@$!%*#?&_-)</span>
                    </p>
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password <span class="text-red-600">*</span></label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required
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
                Create Student
            </button>
            <a href="{{ route('admin.manage-students') }}" class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition-colors">
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

    function filterPrograms() {
        const collegeSelect = document.getElementById('college');
        const programSelect = document.getElementById('program');
        const selectedCollegeId = collegeSelect.value;

        // Reset program dropdown
        programSelect.value = '';

        // Get all program options
        const programOptions = programSelect.querySelectorAll('option');

        // Hide all program options except the first one
        programOptions.forEach((option, index) => {
            if (index === 0) {
                option.style.display = 'block';
                option.textContent = selectedCollegeId ? 'Select Program' : 'Select College First';
            } else {
                const programCollegeId = option.getAttribute('data-college-id');
                if (programCollegeId === selectedCollegeId) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            }
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        filterPrograms();
    });
</script>
@endsection
