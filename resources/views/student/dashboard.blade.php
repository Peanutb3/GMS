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
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Recent Grievances</h3>
            <a href="{{ route('student.grievances') }}" class="text-sm text-blue-600 hover:underline">View all</a>
        </div>

        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
                <thead class="bg-white text-blue-900 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-gray-700">Case ID</th>
                        <th class="px-6 py-3 font-semibold text-gray-700">Name</th>
                        <th class="px-6 py-3 font-semibold text-gray-700">Program</th>
                        <th class="px-6 py-3 font-semibold text-gray-700">Type</th>
                        <th class="px-6 py-3 font-semibold text-gray-700">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @php $items = collect($myGrievances ?? [])->take(2); @endphp

                    @if($items->isNotEmpty())
                        @foreach($items as $g)
                            <tr class="{{ $loop->odd ? 'bg-[#EDEBEB]' : 'bg-white' }} hover:bg-gray-100 transition">
                                <td class="px-5 py-3">{{ $g->case_id }}</td>
                                <td class="px-5 py-3">{{ optional($g->student)->first_name ? optional($g->student)->first_name . ' ' . optional($g->student)->last_name : ($g->name_snapshot ?? $g->name ?? '-') }}</td>
                                <td class="px-5 py-3">{{ optional($g->student)->program ?? ($g->program_snapshot ?? $g->program ?? '-') }}</td>
                                <td class="px-5 py-3">{{ Str::limit($g->grievance ?? $g->description, 80) }}</td>
                                <td class="px-5 py-3">{{ optional($g->date)->format('Y-m-d') ?? optional($g->created_at)->format('Y-m-d') }}</td>
                                <!-- <td class="px-5 py-3">
                                    <div class="text-sm text-gray-700">{{ ucfirst($g->status ?? 'pending') }}</div>
                                    @if($g->filed_by_staff_id && $g->staff)
                                        <div class="text-xs text-gray-500 mt-1">Filed by staff: {{ $g->staff->first_name }} {{ $g->staff->last_name }}</div>
                                    @elseif(!empty($g->filed_by))
                                        <div class="text-xs text-gray-500 mt-1">Filed by: {{ $g->filed_by }}</div>
                                    @endif
                                </td> -->
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-5 py-4 text-center text-gray-500">No grievances found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
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
        </div>
        @php $editRoute = \Illuminate\Support\Facades\Route::has('student.profile.edit') ? route('student.profile.edit') : '#'; @endphp
        <a href="{{ $editRoute }}" class="text-center px-6 py-3 bg-red-900 text-white rounded-lg hover:bg-red-800 font-medium">
            Edit Profile
        </a>
    </div>
</div>
@endsection
