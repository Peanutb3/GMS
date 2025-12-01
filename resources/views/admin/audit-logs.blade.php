@extends('layouts.app')

@section('title', 'Audit Logs')

@section('sidebar')
@include('partials.sidebar-admin')
@endsection

@section('content')
<!-- Breadcrumb -->
<div class="px-3 -mt-2 mb-4">
    <nav class="text-sm text-gray-600 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
            <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z" />
        </svg>
        <a href="{{ route('admin.dashboard') }}" class="hover:text-red-800">Dashboard</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">Audit Logs</span>
    </nav>
</div>

<!-- Page Header -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl p-8 mb-8 shadow-lg">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Audit Logs</h1>
            <p class="text-gray-100">Track all system activities and user actions</p>
        </div>
        <div class="hidden md:block">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                <path d="M21 11.11V5a2 2 0 0 0-2-2h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14a2 2 0 0 0 2 2h6.11c1.26 1.24 2.98 2 4.89 2c3.87 0 7-3.13 7-7c0-1.91-.76-3.63-2-4.89M12 3c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1M6 7h12v2H6zm3.08 10H6v-2h3.08c-.05.33-.08.66-.08 1s.03.67.08 1M6 13v-2h5.11c-.61.57-1.07 1.25-1.43 2zm10 8c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5m.5-4.75l2.86 1.69l-.75 1.22L15 17v-5h1.5z" />
            </svg>
        </div>
    </div>
</div>

<!-- Filters Section -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <form method="GET" action="{{ route('admin.audit-logs') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Action, details, user..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
            </div>

            <!-- Action Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                <select name="action" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                        {{ ucfirst($action) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Date From -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
            </div>

            <!-- Date To -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900 font-medium transition-colors">
                Apply Filters
            </button>
            <a href="{{ route('admin.audit-logs') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition-colors">
                Clear Filters
            </a>
        </div>
    </form>
</div>

<!-- Logs Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Activity Logs ({{ $logs->total() }})</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Details</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">IP Address</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Timestamp</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        #{{ $log->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $log->user->name ?? 'System' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $log->user->email ?? 'N/A' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                            @if(str_contains($log->action, 'created')) bg-green-100 text-green-800
                            @elseif(str_contains($log->action, 'deleted')) bg-red-100 text-red-800
                            @elseif(str_contains($log->action, 'updated') || str_contains($log->action, 'changed')) bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($log->action) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 max-w-md truncate">
                            {{ $log->details ?? 'No details' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $log->ip_address ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $log->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $log->created_at->format('h:i A') }}</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-lg">No audit logs found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($logs->hasPages())
    <div class="p-6 border-t border-gray-200">
        {{ $logs->links('vendor.pagination.tailwind') }}
    </div>
    @endif
</div>

@endsection