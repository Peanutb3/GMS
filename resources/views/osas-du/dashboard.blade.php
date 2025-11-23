@extends('layouts.app')

@section('title', 'OSAS DU Dashboard')

@section('sidebar')
    @include('partials.sidebar-osas-du')
@endsection

@section('content')
<!-- TOP CARD -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl flex flex-col md:flex-row justify-between items-stretch px-8 mb-8 shadow-lg h-40">
    <!-- Text Section -->
    <div class="md:w-2/3 flex flex-col justify-center">
        <p class="text-xs text-gray-200 mb-7">{{ now()->format('F j, Y') }}</p>
        <h2 class="text-3xl font-bold mb-1">Welcome back, {{ Auth::user()->name }}!</h2>
        <p class="text-sm">OSAS Discipline Unit - Grievance Management</p>
    </div>

    <!-- Image Section -->
    <div class="md:w-1/3 flex justify-end items-end">
        <img src="/images/Sticker.png" alt="OSAS Illustration" 
             class="h-full object-bottom object-contain">
    </div>
</div>

<!-- GRID: Summary Cards -->
<div class="mb-8">
    <h3 class="text-xl font-semibold mb-4">Grievance Summary</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Grievances -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">{{ $totalGrievances }}</p>
            <p class="text-sm text-gray-600">Total Grievances</p>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">{{ $pendingGrievances }}</p>
            <p class="text-sm text-gray-600">Pending Cases</p>
        </div>

        <!-- Investigating -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-orange-100 rounded-lg">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">{{ $investigatingGrievances }}</p>
            <p class="text-sm text-gray-600">Investigating</p>
        </div>

        <!-- Resolved -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-800 mb-1">{{ $resolvedGrievances }}</p>
            <p class="text-sm text-gray-600">Resolved Cases</p>
        </div>
    </div>
</div>

<!-- Recent Grievances Table -->
<div class="bg-white rounded-xl shadow-lg p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Recent Grievances</h3>
        <a href="{{ route('osas-du.grievances') }}" class="text-sm text-blue-600 hover:underline">View all →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Case ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Student</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Program</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentGrievances as $grievance)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-800 font-medium">{{ $grievance->case_id }}</td>
                    <td class="px-4 py-3 text-gray-800">
                        @if($grievance->student)
                            {{ $grievance->student->first_name }} {{ $grievance->student->last_name }}
                        @else
                            {{ $grievance->name }}
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        @if($grievance->student)
                            {{ $grievance->student->program }}
                        @else
                            {{ $grievance->program }}
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $grievance->grievance }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($grievance->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($grievance->status === 'investigating') bg-blue-100 text-blue-800
                            @elseif($grievance->status === 'in_progress') bg-orange-100 text-orange-800
                            @elseif($grievance->status === 'resolved') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $grievance->status)) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 text-xs">{{ $grievance->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">No recent grievances</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
