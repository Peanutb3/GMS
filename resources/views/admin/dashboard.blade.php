@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('sidebar')
    @include('partials.sidebar-admin')
@endsection

@section('content')
<!-- TOP CARD -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl flex flex-col md:flex-row justify-between items-stretch px-8 mb-8 shadow-lg h-40">
    <!-- Text Section -->
    <div class="md:w-2/3 flex flex-col justify-center">
        <p class="text-xs text-gray-200 mb-7">September 5, 2025</p>
        <h2 class="text-3xl font-bold mb-1">Welcome back, Anna!</h2>
        <p class="text-sm">Keep track of your grievance history and make sure your record stays clean.</p>
    </div>

    <!-- Image Section -->
    <div class="md:w-1/3 flex justify-end items-end">
        <img src="/images/Sticker.png" alt="Staff Illustration" 
             class="h-full object-bottom object-contain">
    </div>
</div>


<!-- GRID: Left content (cards + table) + Right content (profile) -->
<div class="grid grid-cols-1 sm:grid-cols-4 gap-8 mb-8">

    <!-- Left side: Summary cards + Table -->
    <div class="sm:col-span-3 space-y-8">
        <!-- Summary -->
        <div>
            <h3 class="text-xl font-semibold mb-4">Summary</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-4xl font-bold text-red-800 mb-2">15</p>
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-3"></span>
                        Total Grievances
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-4xl font-bold text-black mb-2">5</p>
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <span class="w-3 h-3 bg-orange-500 rounded-full mr-3"></span>
                        Pending Cases
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-4xl font-bold text-red-800 mb-2">10</p>
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>
                        Resolved Cases
                    </p>
                </div>
            </div>
        </div>

        <!-- Table -->
        <h3 class="text-lg font-semibold mb-4">Recent Grievances</h3>
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-gray-700">Case ID</th>
                            <th class="px-6 py-3 font-semibold text-gray-700">Name</th>
                            <th class="px-6 py-3 font-semibold text-gray-700">Program</th>
                            <th class="px-6 py-3 font-semibold text-gray-700">Date</th>
                            <th class="px-6 py-3 font-semibold text-gray-700">Grievance</th>
                            <th class="px-6 py-3 font-semibold text-gray-700">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                No grievances found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right side: Profile card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col">
        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 fill="currentColor" viewBox="0 0 24 24" 
                 class="h-20 w-20 rounded-full border-4 border-pink-300 text-gray-600 mx-auto mb-4">
                <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 
                         2.3-5 5 2.3 5 5 5zm0 2c-3.3 
                         0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>
            </svg>
        </div>

        <h4 class="font-semibold text-center text-lg mb-1">Anna Alleah Jane B. Lindo</h4>
        <p class="text-sm text-gray-600 text-center mb-4">Staff</p>
        <div class="mb-4 pl-2 text-sm text-gray-700 space-y-2">
            <p><span class="font-semibold">Staff ID:</span> ST-001</p>
            <p><span class="font-semibold">Email:</span> staff@example.com</p>
            <p><span class="font-semibold">Role:</span> Guidance Staff</p>
            <p><span class="font-semibold">Status:</span> Active</p>
        </div>
        <button class="px-6 py-3 bg-red-900 text-white rounded-lg hover:bg-red-800 font-medium">Edit Profile</button>
    </div>
</div>

@endsection