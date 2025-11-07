@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Dashboard')

@section('sidebar')
    @include('partials.sidebar-student')
@endsection

@section('content')
  <!-- <div class="max-w-4l mx-auto px-1 overflow-x-hidden"> -->

<!-- TOP CARD -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl flex flex-col md:flex-row justify-between items-stretch px-8 mb-8 shadow-lg h-40">
    <!-- Text Section -->
    <div class="md:w-2/3 flex flex-col justify-center">
        <p class="text-xs text-gray-200 mb-7">{{ now()->format('F j, Y') }}</p>
        <h2 class="text-3xl font-bold mb-1">Welcome back, {{ $student->first_name ?? Auth::user()->name ?? 'Student' }}!</h2>
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
                    <p class="text-4xl font-bold text-red-800 mb-2">{{ $myGrievances->count() }}</p>
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-3"></span>
                        Total Grievances
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-4xl font-bold text-black mb-2">{{ $myGrievances->where('status', 'pending')->count() }}</p>
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <span class="w-3 h-3 bg-orange-500 rounded-full mr-3"></span>
                        Pending Cases
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-4xl font-bold text-red-800 mb-2">{{ $myGrievances->where('status', 'resolved')->count() }}</p>
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
                        @forelse($myGrievances as $g)
                        <tr class="border-b last:border-b-0 hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $g->case_id }}</td>
                            <td class="px-6 py-4">{{ $g->name }}</td>
                            <td class="px-6 py-4">{{ $g->program }}</td>
                            <td class="px-6 py-4">{{ optional($g->created_at)->format('M d, Y') }}</td>
                            <td class="px-6 py-4">{{ Str::limit($g->grievance ?? $g->description, 80) }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700">{{ ucfirst($g->status ?? 'pending') }}</div>
                                @if($g->filed_by_staff_id && $g->staff)
                                    <div class="text-xs text-gray-500 mt-1">Filed by staff: {{ $g->staff->first_name }} {{ $g->staff->last_name }}</div>
                                @elseif(!empty($g->filed_by))
                                    <div class="text-xs text-gray-500 mt-1">Filed by: {{ $g->filed_by }}</div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-400">No grievances found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right side: Profile card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col">
        <div class="relative">
            <img src="{{ isset($student->profile_photo_path) ? asset('storage/' . $student->profile_photo_path) : asset('/images/default-avatar.png') }}"
                 alt="Profile Avatar" class="h-20 w-20 rounded-full border-4 border-pink-300 mx-auto mb-4 object-cover">
        </div>

        <h4 class="font-semibold text-center text-lg mb-1">{{ $user->name ?? ($student->first_name . ' ' . $student->last_name) ?? 'Student' }}</h4>
        <p class="text-sm text-gray-600 text-center mb-4">Student</p>
        <div class="mb-4 text-sm text-gray-700 space-y-2">
            <p><span class="font-semibold">Student ID:</span> {{ $student->student_id ?? '—' }}</p>
            <p><span class="font-semibold">Email:</span> {{ Auth::user()->email }}</p>
            <p><span class="font-semibold">Program:</span> {{ $student->program ?? '—' }}@if(!empty($student->year)) | {{ $student->year }}@endif</p>
            @php
                $pendingStatuses = ['pending', 'in_progress', 'open'];
                $hasPending = isset($myGrievances) ? $myGrievances->whereIn('status', $pendingStatuses)->count() > 0 : false;
                $goodStatus = $hasPending ? 'Not Eligible' : 'Eligible';
            @endphp
            <p><span class="font-semibold">Good Moral Status:</span> <span class="ml-1 text-sm text-gray-700">{{ $goodStatus }}</span></p>
        </div>
        @if($hasPending)
            <button type="button" disabled
                class="mt-4 inline-block text-center px-4 py-2 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed text-sm">
                Request for Good Moral
            </button>
        @else
            @php $gmRoute = \Illuminate\Support\Facades\Route::has('student.request-good-moral') ? route('student.request-good-moral') : '#'; @endphp
            <a href="{{ $gmRoute }}" class="mt-auto inline-block text-center px-4 py-2 bg-red-900 text-white rounded-lg hover:bg-red-800 font-medium">
                Request for Good Moral
            </a>
        @endif
    </div>
</div>
@endsection
