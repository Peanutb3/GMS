@extends('layouts.app')

@section('title', 'Student Grievances')

@section('sidebar')
        @include('partials.sidebar-student')
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-5 py-6">

    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 flex items-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
            <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z"/>
        </svg>
        <a href="{{ route('student.dashboard') }}" class="hover:text-red-800">Dashboard</a>
        <span class="mx-2 text-gray-500">></span>
        <a href="{{ route('student.grievances') }}" class="text-blue-600 hover">Grievances</a>
    </nav>

    <!-- Header: Title + Search -->
        <div class="flex justify-between items-center mb-4 mt-8">
        <h1 class="text-xl font-semibold text-gray-800">My Grievances</h1>

    <form method="GET" action="{{ route('student.grievances') }}" class="flex items-center space-x-2">
    <!-- Search Box -->
    <div class="relative">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
            class="pl-10 pr-3 py-2 border border-gray-300 rounded-lg 
                     focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none text-sm" />
        <span class="absolute left-3 top-2.5 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </span>
    </div>

    <!-- Filter by Status -->
    <select name="status" onchange="this.form.submit()"
        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-800">
        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
    </select>

    <button type="submit" class="bg-red-800 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-700">
        Search
    </button>
    </form>
        </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
        <thead class="bg-white text-blue-900 text-xs uppercase">
            <tr>
                <th class="px-6 py-3 font-semibold">Case ID</th>
                <th class="px-6 py-3 font-semibold">Name</th>
                <th class="px-6 py-3 font-semibold">Program</th>
                <th class="px-6 py-3 font-semibold">Type</th>
                <th class="px-6 py-3 font-semibold">Date Filed</th>
                <th class="px-6 py-3 font-semibold">Status</th>
                <th class="px-6 py-3 font-semibold text-center">Remarks</th>
            </tr>
        </thead>

    <tbody>
    @forelse ($grievances as $g)
        <tr class="{{ $loop->odd ? 'bg-[#EDEBEB]' : 'bg-white' }} hover:bg-gray-100 transition">
        <td class="px-5 py-3">{{ $g->case_id }}</td>
        <td class="px-5 py-3">{{ optional($g->student)->first_name ? optional($g->student)->first_name . ' ' . optional($g->student)->last_name : $g->name }}</td>
        <td class="px-5 py-3">{{ optional($g->student)->program ?? $g->program }}</td>
        <td class="px-5 py-3">{{ str_replace('_', ' ', $g->grievance) }}</td>
        <td class="px-5 py-3">{{ optional($g->created_at)->format('Y-m-d') }}</td>
        <td class="px-5 py-3">
            <x-status-badge :status="$g->status" />
        </td>
        @php $hasRemark = !empty($g->description); @endphp
        <td class="px-5 py-3 text-center">
            @if($hasRemark)
                <button type="button" onclick="showRemark({!! json_encode($g->description) !!}, {!! json_encode($g->case_id) !!})" title="View remark" aria-label="View remark" class="p-1 rounded hover:bg-gray-100">
                    <!-- three dots icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <circle cx="5" cy="12" r="2" />
                        <circle cx="12" cy="12" r="2" />
                        <circle cx="19" cy="12" r="2" />
                    </svg>
                </button>
            @else
                <button type="button" disabled title="No remark" aria-label="No remark" class="p-1 rounded text-gray-300 cursor-not-allowed opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <circle cx="5" cy="12" r="2" />
                        <circle cx="12" cy="12" r="2" />
                        <circle cx="19" cy="12" r="2" />
                    </svg>
                </button>
            @endif
        </td>
        </tr>
    @empty
        <tr>
        <td colspan="7" class="px-5 py-4 text-center text-gray-500">No grievances found.</td>
        </tr>
    @endforelse
    </tbody>
    </table>

    <!-- Pagination -->
    @if(method_exists($grievances, 'links'))
        {{ $grievances->links('vendor.pagination.tailwind') }}
    @endif
</div>

</div>
@endsection