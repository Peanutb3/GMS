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
                <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z"/>
                </svg>
                <a href="{{ route('student.dashboard') }}" class="hover:text-red-800">Dashboard</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-blue-600">Profile</span>
            </nav>
        </div>

        <!-- Profile header (avatar, name, role, id/email) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 p-6">
            <div class="flex items-center gap-6">
                <div class="relative flex-shrink-0">
                   @if (!empty($student->profile_photo_path))
            <img src="{{ asset('storage/' . $student->profile_photo_path) }}" 
                        alt="Profile Avatar"
                        class="h-20 w-20 md:h-24 md:w-24 rounded-full border bg-white object-cover shadow-sm">
                @else
                    <div class="relative h-20 w-20 flex items-center justify-center overflow-hidden bg-gray-100 rounded-full border">
                        <svg class="absolute w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                @endif
                </div>

                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-900">{{ $user->name ?? 'Anna Alleah Jane B. Lindo' }}</h2>
                            <div class="text-sm text-gray-500 mt-1">Student</div>

                            <div class="mt-3 text-sm text-gray-600">
                                <span class="font-semibold">Student ID:</span>
                                <span class="text-gray-800">{{ $student->student_id ?? 'ST-001' }}</span>
                                <span class="mx-3 text-gray-300">|</span>
                                <span class="font-semibold">Email:</span>
                                <span class="text-gray-800">{{ $user->email ?? 'aajlindo@usep.edu.ph' }}</span>
                            </div>
                        </div>
                        <a href="{{ route('student.profile.edit') }}" 
                           class="px-4 py-2 bg-red-800 text-white text-sm font-medium rounded-lg hover:bg-red-900 transition duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Profile
                        </a>
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
                    <div class="text-sm text-gray-800">{{ $user->name ?? 'Anna Alleah Jane B. Lindo' }}</div>
                </div>

                <div class="flex items-center justify-between px-6 py-4">
                    <div class="text-sm text-gray-600">College</div>
                    <div class="text-sm text-gray-800">{{ $student->college ?? 'College of Information Computing' }}</div>
                </div>

                <div class="flex items-center justify-between px-6 py-4">
                    <div class="text-sm text-gray-600">Program & Year</div>
                    <div class="text-sm text-gray-800">{{ $student->program_and_year ?? 'BSIT - 4th Year' }}</div>
                </div>

                <!-- <div class="flex items-center justify-between px-6 py-4">
                    <div class="text-sm text-gray-600">Phone</div>
                    <div class="text-sm text-gray-800">{{ $student->phone ?? '0991 234 5678' }}</div>
                </div> -->

                <div class="flex items-center justify-between px-6 py-4">
                    <div class="text-sm text-gray-600">Email</div>
                    <div class="text-sm text-gray-800">{{ $user->email ?? 'aajlindo@usep.edu.ph' }}</div>
                </div>

                <a href="{{ route('student.profile.edit') }}#password" class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-gray-50">
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
                    <div class="text-sm text-gray-900">{{ optional($user->last_login_at)->format('M d, Y – h:i A') ?? '—' }}</div>
                </div>
            </div>
        </div>

    </div>
@endsection