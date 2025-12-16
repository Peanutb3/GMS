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
        <p class="text-sm">Monitor and manage student grievances and disciplinary cases.</p>
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
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-4xl font-bold text-red-800 mb-2">{{ $totalGrievances }}</p>
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-3"></span>
                        Total Grievances
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-4xl font-bold text-red-800 mb-2">{{ $pendingGrievances }}</p>
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <span class="w-3 h-3 bg-orange-500 rounded-full mr-3"></span>
                        Pending
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-4xl font-bold text-red-800 mb-2">{{ $investigatingGrievances }}</p>
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></span>
                        Investigating
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-4xl font-bold text-red-800 mb-2">{{ $resolvedGrievances }}</p>
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-3"></span>
                        Resolved
                    </p>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Grievances</h3>
                    <a href="{{ route('osas-du.grievances') }}" class="text-sm text-red-800 hover:text-red-900 font-medium">View All →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Case ID</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Student</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Program</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                            $items = collect($recentGrievances ?? [])->take(3);
                            @endphp

                            @if($items->isNotEmpty())
                            @foreach($items as $g)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-900">{{ $g->case_id }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ optional($g->student)->first_name ? optional($g->student)->first_name . ' ' . optional($g->student)->last_name : ($g->name_snapshot ?? $g->name ?? 'N/A') }}</div>
                                    @if($g->student && $g->student->student_id)
                                    <div class="text-xs text-gray-500">{{ $g->student->student_id }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    @php
                                    $prog = optional($g->student)->program ?? ($g->program_snapshot ?? $g->program ?? 'N/A');

                                    // Get program code from database
                                    if ($prog !== 'N/A') {
                                    $programModel = \App\Models\Program::where('name', $prog)->first();
                                    $progAbbr = $programModel && $programModel->code ? $programModel->code : $prog;
                                    } else {
                                    $progAbbr = 'N/A';
                                    }
                                    @endphp
                                    <span title="{{ $prog }}">{{ $progAbbr }}</span>
                                </td>
                                </td>
                                <td class="px-4 py-3">
                                    @if($g->status === 'pending')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Pending</span>
                                    @elseif($g->status === 'resolved')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Resolved</span>
                                    @elseif($g->status === 'in_progress')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                    @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($g->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ optional($g->date)->format('M d, Y') ?? $g->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-400">No recent grievances found.</td>
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
        <h3 class="text-xl font-semibold mb-4">Profile</h3>
        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col">
            <div class="relative">
                @if(Auth::user()->staff && !empty(Auth::user()->staff->profile_photo_path))
                <img src="{{ asset('storage/' . Auth::user()->staff->profile_photo_path) }}"
                    alt="Profile Avatar"
                    class="h-20 w-20 rounded-full border-4 border-pink-300 mx-auto mb-4 object-cover">
                @else
                <div class="h-20 w-20 rounded-full border-4 border-pink-300 bg-gradient-to-br from-red-800 to-red-600 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                @endif
            </div>

            <h4 class="font-semibold text-center text-lg mb-1">{{ Auth::user()->name }}</h4>
            <p class="text-sm text-gray-600 text-center mb-4">Staff</p>
            <div class="mb-4 pl-2 text-sm text-gray-700 space-y-2">
                <p><span class="font-semibold">Staff ID:</span> {{ Auth::user()->staff->employee_id ?? 'N/A' }}</p>
                <p class="break-all"><span class="font-semibold">Email:</span> {{ Auth::user()->email }}</p>
                <p><span class="font-semibold">Role:</span> {{ ucfirst(Auth::user()->role) }}</p>
            </div>
            <a href="{{ route('osas-du.profile') }}" class="text-center px-6 py-3 bg-red-900 text-white rounded-lg hover:bg-red-800 font-medium">
                Edit Profile
            </a>
        </div>
    </div>
</div>
@endsection