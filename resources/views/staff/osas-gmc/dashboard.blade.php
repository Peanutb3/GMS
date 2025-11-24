@extends('layouts.app')

@section('title', 'OSAS GMC Dashboard')

@section('sidebar')
    @include('partials.sidebar-osas-gmc')
@endsection

@section('content')
<!-- TOP CARD -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl flex flex-col md:flex-row justify-between items-stretch px-8 mb-8 shadow-lg h-40">
    <!-- Text Section -->
    <div class="md:w-2/3 flex flex-col justify-center">
        <p class="text-xs text-gray-200 mb-7">{{ now()->format('F j, Y') }}</p>
        <h2 class="text-3xl font-bold mb-1">Welcome back, {{ Auth::user()->name }}!</h2>
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
                    <p class="text-4xl font-bold text-red-800 mb-2">{{ $totalGrievances }}</p>
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-3"></span>
                        Total Grievances
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-4xl font-bold text-red-800 mb-2">{{ $pendingCases }}</p>
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <span class="w-3 h-3 bg-orange-500 rounded-full mr-3"></span>
                        Pending Cases
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-4xl font-bold text-red-800 mb-2">{{ $resolvedCases }}</p>
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>
                        Resolved Cases
                    </p>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Recent Grievances</h3>
                <a href="{{ route('staff.grievances') }}" class="text-sm text-blue-600 hover:underline">View all</a>
            </div>

            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
                    <thead class="bg-white text-blue-900 text-xs uppercase">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Case ID</th>
                            <th class="px-6 py-3 font-semibold">Name</th>
                            <th class="px-6 py-3 font-semibold">Program</th>
                            <th class="px-6 py-3 font-semibold">Type</th>
                            <th class="px-6 py-3 font-semibold">Date</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <!-- <th class="px-6 py-3 font-semibold">Filed By</th> -->
                            <!-- <th class="px-6 py-3 font-semibold text-center">Actions</th> -->
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $items = collect($recentGrievances ?? [])->take(2);
                        @endphp

                        @if($items->isNotEmpty())
                            @foreach($items as $g)
                                <tr class="{{ $loop->odd ? 'bg-[#EDEBEB]' : 'bg-white' }} hover:bg-gray-100 transition">
                                    <td class="px-5 py-3">{{ $g->case_id }}</td>
                                    <td class="px-5 py-3">{{ optional($g->student)->first_name ? optional($g->student)->first_name . ' ' . optional($g->student)->last_name : $g->name }}</td>
                                    <td class="px-5 py-3">{{ optional($g->student)->program ?? $g->program }}</td>
                                    <td class="px-5 py-3">{{ str_replace('_', ' ', $g->grievance) }}</td>
                                    <td class="px-5 py-3">{{ optional($g->date)->format('Y-m-d') ?? $g->created_at->format('Y-m-d') }}</td>
                                    <td class="px-5 py-3">
                                        <x-status-badge :status="$g->status" />
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="px-5 py-4 text-center text-gray-500">No grievances found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Right side: Profile card -->
    <div>
        <h3 class="text-xl font-semibold mb-4">Profile</h3>
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

            <h4 class="font-semibold text-center text-lg mb-1">{{ Auth::user()->name }}</h4>
            <p class="text-sm text-gray-600 text-center mb-4">Staff</p>
            <div class="mb-4 pl-2 text-sm text-gray-700 space-y-2">
                <p><span class="font-semibold">Staff ID:</span> {{ Auth::user()->staff->employee_id ?? 'N/A' }}</p>
                <p><span class="font-semibold">Email:</span> {{ Auth::user()->email }}</p>
                <p><span class="font-semibold">Role:</span> {{ ucfirst(Auth::user()->role) }}</p>
            </div>
            <button class="px-6 py-3 bg-red-900 text-white rounded-lg hover:bg-red-800 font-medium">
                Edit Profile
            </button>
        </div>
    </div>
</div>
@endsection