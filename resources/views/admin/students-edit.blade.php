@extends('layouts.app')

@section('title', 'Edit Student')

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
        <span class="text-blue-600">Edit</span>
    </nav>
</div>

<!-- Page Header -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl p-8 mb-8 shadow-lg">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Edit Student</h1>
            <p class="text-gray-100">Update student account and profile information</p>
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
    <form method="POST" action="{{ route('admin.students.update', $student->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200">Basic Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student ID -->
                <div>
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Student ID <span class="text-red-600">*</span></label>
                    <input type="text" id="student_id" name="student_id" value="{{ old('student_id', $student->student_id) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('student_id') border-red-500 @enderror">
                    @error('student_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-600">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', optional($student->user)->email) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name <span class="text-red-600">*</span></label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $student->first_name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('first_name') border-red-500 @enderror">
                    @error('first_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Middle Initial -->
                <div>
                    <label for="middle_initial" class="block text-sm font-medium text-gray-700 mb-2">Middle Initial</label>
                    <input type="text" id="middle_initial" name="middle_initial" value="{{ old('middle_initial', $student->middle_initial) }}" maxlength="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('middle_initial') border-red-500 @enderror">
                    @error('middle_initial')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name <span class="text-red-600">*</span></label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $student->last_name) }}" required
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
                        <option value="Jr." {{ old('suffix', $student->suffix) === 'Jr.' ? 'selected' : '' }}>Jr.</option>
                        <option value="Sr." {{ old('suffix', $student->suffix) === 'Sr.' ? 'selected' : '' }}>Sr.</option>
                        <option value="II" {{ old('suffix', $student->suffix) === 'II' ? 'selected' : '' }}>II</option>
                        <option value="III" {{ old('suffix', $student->suffix) === 'III' ? 'selected' : '' }}>III</option>
                        <option value="IV" {{ old('suffix', $student->suffix) === 'IV' ? 'selected' : '' }}>IV</option>
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
                    <select id="college" name="college" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('college') border-red-500 @enderror">
                        <option value="">Select College</option>
                        <option value="College of Information and Computing" {{ old('college', $student->college) === 'College of Information and Computing' ? 'selected' : '' }}>College of Information and Computing</option>
                        <option value="College of Engineering" {{ old('college', $student->college) === 'College of Engineering' ? 'selected' : '' }}>College of Engineering</option>
                        <option value="College of Education" {{ old('college', $student->college) === 'College of Education' ? 'selected' : '' }}>College of Education</option>
                        <option value="College of Business Administration" {{ old('college', $student->college) === 'College of Business Administration' ? 'selected' : '' }}>College of Business Administration</option>
                        <option value="College of Arts and Sciences" {{ old('college', $student->college) === 'College of Arts and Sciences' ? 'selected' : '' }}>College of Arts and Sciences</option>
                    </select>
                    @error('college')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Program -->
                <div>
                    <label for="program" class="block text-sm font-medium text-gray-700 mb-2">Program <span class="text-red-600">*</span></label>
                    <input type="text" id="program" name="program" value="{{ old('program', $student->program) }}" required
                        placeholder="e.g., BSIT, BSCS, BSCpE"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('program') border-red-500 @enderror">
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
                        <option value="1st year" {{ old('year', $student->year) == '1st year' ? 'selected' : '' }}>1st Year</option>
                        <option value="2nd year" {{ old('year', $student->year) == '2nd year' ? 'selected' : '' }}>2nd Year</option>
                        <option value="3rd year" {{ old('year', $student->year) == '3rd year' ? 'selected' : '' }}>3rd Year</option>
                        <option value="4th year" {{ old('year', $student->year) == '4th year' ? 'selected' : '' }}>4th Year</option>
                        <option value="5th year" {{ old('year', $student->year) == '5th year' ? 'selected' : '' }}>5th Year</option>
                    </select>
                    @error('year')
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
                    <input type="password" id="password" name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent @error('password') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                    @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pt-6 border-t border-gray-200">
            <button type="submit" class="px-8 py-3 bg-red-800 text-white rounded-lg hover:bg-red-900 font-medium transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Update Student
            </button>
            <a href="{{ route('admin.manage-students') }}" class="px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
