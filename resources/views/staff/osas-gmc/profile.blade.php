@extends('layouts.app')

@section('title', 'Profile')

@section('sidebar')
    @include('partials.sidebar-osas-gmc')
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
                <a href="{{ route('staff.dashboard') }}" class="hover:text-red-800">Dashboard</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-blue-600">Profile</span>
            </nav>
        </div>

        <!-- Profile header (avatar, name, position, id/email) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 p-6">
            <div class="flex items-center gap-6">
                <div class="relative flex-shrink-0">
                    @if(!empty($staff->profile_photo_path))
                    <img src="{{ asset('storage/' . $staff->profile_photo_path) }}" alt="Profile Avatar"
                        class="h-24 w-24 md:h-28 md:w-28 rounded-full bg-white object-cover shadow-sm ring-4 ring-gray-500">
                    @else
                        <div class="h-24 w-24 md:h-28 md:w-28 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-sm ring-4 ring-gray-500">
                            <!-- Default SVG avatar (fills the circle) -->
                            <svg class="h-full w-full text-gray-500" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                                <g fill="currentColor">
                                    <!-- head -->
                                    <circle cx="12" cy="8" r="4" opacity="0.95" />
                                    <!-- body (fills remaining) -->
                                    <path d="M3 20c0-3.314 4.029-6 9-6s9 2.686 9 6v1H3v-1z" opacity="0.9"/>
                                </g>
                            </svg>
                        </div>
                    @endif

                    <a href="{{ route('staff.profile.edit') }}" title="Edit avatar" class="absolute -bottom-2 -right-2 bg-white rounded-full p-2 shadow border hover:bg-gray-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6L21 11l-6-6-6 6z" />
                        </svg>
                    </a>
                </div>

                <div class="flex-1">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                    <div class="text-sm text-gray-500 mt-1">{{ $staff->position ?? 'OSAS Officer' }}</div>

                    <div class="mt-3 text-sm text-gray-600">
                        <span class="font-semibold">Staff ID:</span>
                        <span class="text-gray-800">{{ $staff->employee_id ?? 'ST-001' }}</span>
                        <span class="mx-3 text-gray-300">|</span>
                        <span class="font-semibold">Email:</span>
                        <span class="text-gray-800">{{ $user->email }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Basic info card (with avatar to the right) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
            <div class="px-6 py-5 flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Basic info</h3>
                    <p class="text-sm text-gray-500 mt-2">Some information may be visible to other users of this system. Manage visibility in your profile settings.</p>
                </div>

                <!-- <div class="flex-shrink-0 ml-6 text-right">
                    <div class="relative inline-block">
                        <img src="{{ !empty($staff->profile_photo_path) ? asset('storage/' . $staff->profile_photo_path) : asset('/images/avatar-female.png') }}" alt="Profile Avatar"
                             class="h-20 w-20 rounded-full border bg-white object-cover shadow-sm">
                        <a href="{{ route('staff.profile.edit') }}" title="Edit avatar" class="absolute -bottom-1 -right-1 bg-white rounded-full p-2 shadow border hover:bg-gray-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6L21 11l-6-6-6 6z" />
                            </svg>
                        </a>
                    </div>
                </div> -->
            </div>

            

            <div class="divide-y divide-gray-100">
                <a href="{{ route('staff.profile.edit') }}" class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-gray-50">
                    <div class="text-sm text-gray-600">Name</div>
                    <div class="flex items-center gap-3">
                        <div class="text-sm text-gray-800">{{ $user->name }}</div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <a href="{{ route('staff.profile.edit') }}" class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-gray-50">
                    <div class="text-sm text-gray-600">Office</div>
                    <div class="flex items-center gap-3">
                        <div class="text-sm text-gray-800">{{ $staff->department ?? 'OSAS' }}</div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <a href="{{ route('staff.profile.edit') }}" class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-gray-50">
                    <div class="text-sm text-gray-600">Position</div>
                    <div class="flex items-center gap-3">
                        <div class="text-sm text-gray-800">{{ $staff->position ?? '-' }}</div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                

                <a href="{{ route('staff.profile.edit') }}" class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-gray-50">
                    <div class="text-sm text-gray-600">Phone</div>
                    <div class="flex items-center gap-3">
                        <div class="text-sm text-gray-800">{{ $staff->phone ?? '-' }}</div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <a href="{{ route('staff.profile.edit') }}" class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-gray-50">
                    <div class="text-sm text-gray-600">Email</div>
                    <div class="flex items-center gap-3">
                        <div class="text-sm text-gray-800">{{ $user->email }}</div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <a href="{{ route('staff.profile.edit') }}#password" class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-gray-50">
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
                    <div class="text-sm text-gray-900">Staff</div>
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