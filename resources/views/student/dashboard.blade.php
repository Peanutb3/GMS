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
        <div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Grievances</h3>
                    <a href="{{ route('student.grievances') }}" class="text-sm text-red-800 hover:text-red-900 font-medium">View All →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Case ID</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Type</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php $items = collect($myGrievances ?? [])->take(3); @endphp

                            @if($items->isNotEmpty())
                            @foreach($items as $g)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-900">{{ $g->case_id }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ Str::limit($g->grievance ?? $g->description, 50) }}</td>
                                <td class="px-4 py-3">
                                    @if($g->status === 'pending')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Pending</span>
                                    @elseif($g->status === 'resolved')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Resolved</span>
                                    @elseif($g->status === 'in_progress')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                    @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($g->status ?? 'pending') }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ optional($g->date)->format('M d, Y') ?? optional($g->created_at)->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400">No recent grievances found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Right side: Profile card -->
    <div>
        <h3 class="text-xl font-semibold mb-4 text-gray-800">Profile</h3>
        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col">
            <div class="relative">
                @if($student && !empty($student->profile_photo_path))
                <img src="{{ asset('storage/' . $student->profile_photo_path) }}"
                    alt="Profile Avatar"
                    class="h-20 w-20 rounded-full border-4 border-pink-300 mx-auto mb-4 object-cover">
                @else
                <div class="h-20 w-20 rounded-full border-4 border-pink-300 bg-gradient-to-br from-blue-800 to-blue-600 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">{{ substr($user->name ?? 'S', 0, 1) }}</span>
                </div>
                @endif
            </div>

            <h4 class="font-semibold text-center text-lg mb-1">{{ $user->name ?? ($student->first_name . ' ' . $student->last_name) ?? 'Student' }}</h4>
            <p class="text-sm text-gray-600 text-center mb-4">Student</p>
            <div class="mb-4 px-2 text-sm text-gray-700 space-y-2">
                <p class="break-words"><span class="font-semibold">Student ID:</span> {{ $student->student_id ?? '—' }}</p>
                <p class="break-words"><span class="font-semibold">Email:</span> {{ Str::limit(Auth::user()->email, 30) }}</p>
                <p class="break-words"><span class="font-semibold">Program:</span> {{ $student->program_name ?? '—' }}@if(!empty($student->year)) | Year {{ $student->year }}@endif</p>
            </div>
            <a href="{{ route('student.profile') }}" class="text-center px-6 py-3 bg-red-900 text-white rounded-lg hover:bg-red-800 font-medium">
                Edit Profile
            </a>
        </div>
    </div>
</div>
@endsection
