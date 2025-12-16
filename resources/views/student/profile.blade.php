@extends('layouts.app')

@section('title', 'Student Profile')

@section('sidebar')
@include('partials.sidebar-student')
@endsection

@section('content')
<!-- <div class="flex flex-col min-h-screen"> -->

<div class="max-w-4xl mx-auto py-6">

    <!-- Breadcrumb -->
    <div class="px-3 -mt-2 mb-4">
        <nav class="text-sm text-gray-600 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
                <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z" />
            </svg>
            <a href="{{ route('student.dashboard') }}" class="hover:text-red-800">Dashboard</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-blue-600">Profile</span>
        </nav>
    </div>

    <!-- Email Verification Notice -->
    @if (!$user->hasVerifiedEmail())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-lg">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm text-yellow-700">
                    Your email address is not verified.
                <form method="POST" action="{{ route('verification.send') }}" class="inline">
                    @csrf
                    <button type="submit" class="font-medium underline hover:text-yellow-600">
                        Click here to resend verification email
                    </button>
                </form>
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Profile header (avatar, name, role, id/email) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 p-8">
        <div class="flex items-start gap-6">
            <div class="relative flex-shrink-0">
                @if (!empty($student->profile_photo_path))
                <img src="{{ asset('storage/' . $student->profile_photo_path) }}"
                    alt="Profile Avatar"
                    class="h-24 w-24 md:h-28 md:w-28 rounded-full bg-white object-cover shadow-sm ring-4 ring-gray-200">
                @else
                <div class="h-24 w-24 md:h-28 md:w-28 rounded-full bg-gradient-to-br from-[#760000] to-[#D62F26] flex items-center justify-center ring-4 ring-gray-200">
                    <span class="text-4xl font-bold text-white">{{ substr($user->name ?? 'S', 0, 1) }}</span>
                </div>
                @endif

                <!-- Online Status Indicator -->
                <div class="absolute bottom-1 right-1 w-5 h-5 bg-green-500 rounded-full border-4 border-white"></div>

                <a href="{{ route('student.profile.edit') }}" title="Edit avatar" class="absolute -bottom-1 -right-1 bg-white rounded-full p-2.5 shadow-md border-2 border-gray-200 hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </a>
            </div>

            <div class="flex-1 pt-2">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="flex items-center gap-3">
                            <h2 class="text-xl md:text-2xl font-bold text-gray-900">
                                {{ $student->first_name }}
                                @if(!empty($student->middle_initial))
                                {{ $student->middle_initial }}.
                                @endif
                                {{ $student->last_name }}
                                @if(!empty($student->suffix))
                                {{ ' ' . $student->suffix }}
                                @endif
                            </h2>
                            <span class="px-3 py-1 bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 text-xs font-semibold rounded-full border border-blue-200">
                                Student
                            </span>
                        </div>
                        <div class="text-sm text-gray-500 mt-1 mb-3">{{ $student->program_and_year ?? 'BSIT - 4th Year' }}</div>
                    </div>
                    <button onclick="window.location.href='{{ route('student.profile.edit') }}'" class="px-4 py-2 bg-gradient-to-r from-[#760000] to-[#D62F26] text-white text-sm font-medium rounded-lg hover:from-[#8B0000] hover:to-[#B22222] transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profile
                    </button>
                </div>

                <div class="flex flex-col gap-2 mt-4">
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        <span class="font-semibold text-gray-900">Student ID:</span>
                        <span class="text-gray-700">{{ $student->student_id ?? 'ST-001' }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="font-semibold text-gray-900">Email:</span>
                        <span class="text-gray-700">{{ $user->email ?? 'aajlindo@usep.edu.ph' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Basic info card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
        <div class="px-6 py-5">
            <h3 class="text-lg font-semibold text-gray-800">Basic info</h3>
        </div>

        <div class="divide-y divide-gray-100">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="text-sm text-gray-600">Name</div>
                <div class="text-sm text-gray-800">
                    {{ $student->first_name }}
                    @if(!empty($student->middle_initial))
                    {{ $student->middle_initial }}.
                    @endif
                    {{ $student->last_name }}
                    @if(!empty($student->suffix))
                    {{ ' ' . $student->suffix }}
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-between px-6 py-4">
                <div class="text-sm text-gray-600">College</div>
                <div class="text-sm text-gray-800">{{ $collegeName ?? ($student->college ?? 'Not Set') }}</div>
            </div>

            <div class="flex items-center justify-between px-6 py-4">
                <div class="text-sm text-gray-600">Program</div>
                <div class="text-sm text-gray-800">{{ $programName ?? ($student->program ?? 'Not Set') }}</div>
            </div>

            <div class="flex items-center justify-between px-6 py-4">
                <div class="text-sm text-gray-600">Year Level</div>
                <div class="text-sm text-gray-800">{{ $student->year ? ($student->year . ' Year') : '—' }}</div>
            </div>

            <div class="flex items-center justify-between px-6 py-4">
                <div class="text-sm text-gray-600">Phone</div>
                <div class="text-sm text-gray-800">{{ $student->phone ?? '—' }}</div>
            </div>

            <div class="flex items-center justify-between px-6 py-4">
                <div class="text-sm text-gray-600">Email</div>
                <div class="text-sm text-gray-800">{{ $user->email ?? 'aajlindo@usep.edu.ph' }}</div>
            </div>

            <a href="{{ route('student.change-password') }}" class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-gray-50">
                <div class="text-sm text-gray-600">Change password</div>
                <div class="flex items-center gap-3">
                    <div class="text-sm text-gray-800">********</div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </a>
        </div>
    </div>

    <!-- System Info card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
        <div class="px-6 py-5">
            <h3 class="text-lg font-semibold text-gray-800">System Info</h3>
        </div>
        <div class="divide-y divide-gray-100">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="text-sm text-gray-600">Role</div>
                <div class="text-sm text-gray-900">Student</div>
            </div>
            <div class="flex items-center justify-between px-6 py-4">
                <div class="text-sm text-gray-600">Date Joined</div>
                <div class="text-sm text-gray-900">{{ optional($user->created_at)->format('M d, Y – h:i A') ?? '—' }}</div>
            </div>
            <div class="flex items-center justify-between px-6 py-4">
                <div class="text-sm text-gray-600">Last Login</div>
                <div class="text-sm text-gray-900">{{ optional($user->updated_at)->format('M d, Y – h:i A') ?? '—' }}</div>
            </div>
        </div>
    </div>

</div>
@endsection