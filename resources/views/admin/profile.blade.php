@extends('layouts.app')

@section('title', 'Admin Profile')

@section('sidebar')
	@include('partials.sidebar-admin')
@endsection

@section('content')

    <div class="max-w-4xl mx-auto py-6">

        <!-- Breadcrumb -->
        <div class="px-3 -mt-2 mb-4">
            <nav class="text-sm text-gray-600 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
                <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z"/>
                </svg>
                <a href="{{ route('admin.dashboard') }}" class="hover:text-red-800">Dashboard</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-blue-600">Profile</span>
            </nav>
        </div>

        <!-- Profile header (avatar, name, position, id/email) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 p-6">
            <div class="flex items-center gap-6">
                <div class="relative flex-shrink-0">
                    <img src="/images/avatar-female.png" alt="Profile Avatar"
                        class="h-24 w-24 md:h-28 md:w-28 rounded-full bg-white object-cover shadow-sm ring-4 ring-gray-500">

                    <a href="#" title="Edit avatar" class="absolute -bottom-2 -right-2 bg-white rounded-full p-2 shadow border hover:bg-gray-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6 6L21 11l-6-6-6 6z" />
                        </svg>
                    </a>
                </div>

                <div class="flex-1">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-900">{{ Auth::user()->name }}</h2>
                    <div class="text-sm text-gray-500 mt-1">System Administrator</div>

                    <div class="mt-3 text-sm text-gray-600">
                        <span class="font-semibold">Email:</span>
                        <span class="text-gray-800">{{ Auth::user()->email }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Basic info card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
            <div class="px-6 py-5">
                <h3 class="text-lg font-semibold text-gray-800">Basic info</h3>
                <p class="text-sm text-gray-500 mt-2">Manage your account information and security settings.</p>
            </div>

            <div class="divide-y divide-gray-100">
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-gray-50">
                    <div class="text-sm text-gray-600">Name</div>
                    <div class="flex items-center gap-3">
                        <div class="text-sm text-gray-800">{{ Auth::user()->name }}</div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <a href="{{ route('admin.profile.edit') }}" class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-gray-50">
                    <div class="text-sm text-gray-600">Email</div>
                    <div class="flex items-center gap-3">
                        <div class="text-sm text-gray-800">{{ Auth::user()->email }}</div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>

                <a href="{{ route('admin.change-password') }}" class="flex items-center justify-between gap-4 px-6 py-4 hover:bg-gray-50">
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
                    <div class="text-sm text-gray-900">Admin</div>
                </div>
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="text-sm text-gray-600">Date Joined</div>
                    <div class="text-sm text-gray-900">July 10, 2025 – 02:15 PM</div>
                </div>
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="text-sm text-gray-600">Last Login</div>
                    <div class="text-sm text-gray-900">Aug 26, 2025 – 08:20 AM</div>
                </div>
            </div>
        </div>

    </div>
@endsection
