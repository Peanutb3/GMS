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
        <p class="text-xs text-gray-200 mb-2">{{ now()->format('F j, Y') }}</p>
        <h2 class="text-3xl font-bold mb-1">Welcome back, {{ Auth::user()->name }}!</h2>
        <p class="text-sm">Manage your institution's grievance system and monitor all activities.</p>
    </div>

    <!-- Image Section -->
    <div class="md:w-1/3 flex justify-end items-end">
        <img src="/images/Sticker.png" alt="Admin Illustration"
            class="h-full object-bottom object-contain">
    </div>
</div>

<!-- STATISTICS GRID -->
<div class="mb-8">
    <h3 class="text-xl font-semibold mb-4 text-gray-800">Overview Statistics</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Students -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Student(s)</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_students'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 8c0 2.21-1.79 4-4 4s-4-1.79-4-4l.11-.94L5 5.5L12 2l7 3.5v5h-1V6l-2.11 1.06zm-4 6c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Staff -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Staff(s)</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_staff'] }}</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="6" r="4" />
                        <path d="M20 17.5c0 2.485 0 4.5-8 4.5s-8-2.015-8-4.5S7.582 13 12 13s8 2.015 8 4.5" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Grievances -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Grievance(s)</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_grievances'] }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke="currentColor" fill="none" stroke-width="2" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Grievances -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Pending Grievance(s)</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['pending_grievances'] }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Resolved Grievances -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Resolved Grievance(s)</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['resolved_grievances'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Admins -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Admin(s)</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_admins'] }}</p>
                </div>
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Good Moral Requests -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-teal-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Good Moral Request(s)</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_good_moral'] }}</p>
                </div>
                <div class="bg-teal-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-teal-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Good Moral -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Pending Request(s)</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['pending_good_moral'] }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- GRID: Charts + Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

    <!-- Recent Grievances -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Grievances</h3>
                <a href="{{ route('admin.grievances') }}" class="text-sm text-red-800 hover:text-red-900 font-medium">View All →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Student</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Program</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentGrievances as $grievance)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">{{ $grievance->name_snapshot }}</div>
                                <div class="text-xs text-gray-500">{{ $grievance->student_no_snapshot }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                @php
                                $prog = $grievance->program_snapshot ?? 'N/A';

                                // Remove college prefix if present (e.g., "CIC | BSIT" -> "BSIT")
                                if (strpos($prog, '|') !== false) {
                                [, $prog] = explode('|', $prog, 2);
                                $prog = trim($prog);
                                }

                                // Get program code from database
                                if ($prog !== 'N/A' && !empty($prog)) {
                                $programModel = \App\Models\Program::where('name', $prog)->first();
                                $progAbbr = $programModel && $programModel->code ? $programModel->code : $prog;
                                } else {
                                $progAbbr = 'N/A';
                                }
                                @endphp
                                <span title="{{ $grievance->program_snapshot }}">{{ $progAbbr }}</span>
                            </td>
                            <td class="px-4 py-3">
                                @if($grievance->status === 'pending')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Pending</span>
                                @elseif($grievance->status === 'resolved')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Resolved</span>
                                @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ ucfirst($grievance->status) }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $grievance->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                No recent grievances found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Good Moral Requests -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Requests</h3>
                <a href="{{ route('admin.requests.good-moral') }}" class="text-sm text-red-800 hover:text-red-900 font-medium">View All →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentGoodMoral as $request)
                <div class="border-l-4 border-teal-500 bg-gray-50 p-3 rounded">
                    <div class="font-medium text-sm text-gray-900">
                        {{ $request->first_name }} {{ $request->middle_name ? $request->middle_name . ' ' : '' }}{{ $request->last_name }}
                    </div>
                    @if($request->student)
                    <div class="text-xs text-gray-500 mt-1">
                        {{ $request->student->student_id }}
                    </div>
                    @endif
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-xs px-2 py-1 rounded-full
                            @if($request->status === 'pending') bg-orange-100 text-orange-800
                            @elseif($request->status === 'approved') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($request->status) }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $request->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400 text-sm">
                    No recent requests.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection