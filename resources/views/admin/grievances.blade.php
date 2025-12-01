@extends('layouts.app')

@section('title', 'Manage Grievances')

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
        <span class="text-blue-600">Grievances</span>
    </nav>
</div>

<!-- Page Header -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl p-8 mb-8 shadow-lg">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Grievance Management</h1>
            <p class="text-gray-100">View and manage all grievances in the system</p>
        </div>
        <div class="hidden md:block">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 2 0 01-2 2z" stroke="currentColor" fill="none" stroke-width="2" />
            </svg>
        </div>
    </div>
</div>

<!-- Filters Section -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <form method="GET" action="{{ route('admin.grievances') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Name, Student No, Description..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="investigating" {{ request('status') === 'investigating' ? 'selected' : '' }}>Investigating</option>
                    <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>

            <!-- Program Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                <select name="program" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                    <option value="">All Programs</option>
                    @foreach($programs as $program)
                    <option value="{{ $program }}" {{ request('program') === $program ? 'selected' : '' }}>
                        {{ $program }}
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
            <a href="{{ route('admin.grievances') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition-colors">
                Clear Filters
            </a>
        </div>
    </form>
</div>

<!-- Grievances Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">All Grievances ({{ $grievances->total() }})</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase w-16">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase">Student</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase">Program</th>
                    <!-- <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Description</th> -->
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase">Filed By</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($grievances as $grievance)
                <tr class="hover:bg-gray-50" id="grievance-row-{{ $grievance->id }}">
                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                        #{{ $grievance->id }}
                    </td>
                    <td class="px-6 py-3">
                        <div class="text-sm font-medium text-gray-900 truncate" title="{{ $grievance->name_snapshot }}">{{ $grievance->name_snapshot }}</div>
                        <div class="text-sm text-gray-500">{{ $grievance->student_no_snapshot }}</div>
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-700">
                        @php
                        // Check if program_snapshot contains a college name and abbreviate it
                        $programDisplay = $grievance->program_snapshot;
                        if (strpos($programDisplay, '|') !== false) {
                        // If format is "College | Program", split and abbreviate college
                        [$college, $program] = explode('|', $programDisplay, 2);
                        $collegeAbbr = match(trim($college)) {
                        'College of Information and Computing' => 'CIC',
                        'College of Engineering' => 'COE',
                        'College of Education' => 'CED',
                        'College of Business Administration' => 'CBA',
                        'College of Arts and Sciences' => 'CAS',
                        'College of Applied Economics' => 'CAEC',
                        'College of Technology' => 'CT',
                        default => trim($college)
                        };
                        $programDisplay = $collegeAbbr . ' | ' . trim($program);
                        }
                        @endphp
                        <div class="truncate" title="{{ $grievance->program_snapshot }}">{{ $programDisplay }}</div>
                    </td>
                    <!-- <td class="px-3 py-3">
                        <div class="text-xs text-gray-900 truncate" style="max-width: 200px;" title="{{ $grievance->description }}">{{ Str::limit($grievance->description, 35) }}</div>
                    </td> -->
                    <td class="px-6 py-3 text-sm text-gray-700">
                        <div class="truncate" title="{{ $grievance->filed_by_display }}">{{ $grievance->filed_by_display }}</div>
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            @if($grievance->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($grievance->status === 'resolved') bg-green-100 text-green-800
                            @else bg-indigo-100 text-indigo-800
                            @endif">
                            {{ ucfirst($grievance->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-600">
                        {{ $grievance->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium">
                        <div class="flex gap-1">
                            <a href="{{ route('admin.grievances.show', $grievance->id) }}"
                                class="text-blue-600 hover:text-blue-900" title="View Details">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <button type="button" onclick="deleteGrievance('{{ $grievance->id }}')"
                                class="text-red-600 hover:text-red-900" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-lg">No grievances found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($grievances->hasPages())
    <div class="p-6 border-t border-gray-200">
        {{ $grievances->links('vendor.pagination.tailwind') }}
    </div>
    @endif
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden transition-all transform translate-y-0">
    <p id="toast-message"></p>
</div>

@endsection

@push('scripts')
<script>
    // Delete grievance
    function deleteGrievance(id) {
        if (!confirm('Are you sure you want to delete this grievance? This action cannot be undone.')) {
            return;
        }

        fetch(`/admin/grievances/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Grievance deleted successfully!', 'success');
                    document.getElementById(`grievance-row-${id}`).remove();
                } else {
                    showToast('Failed to delete grievance', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred', 'error');
            });
    }

    // Toast notification
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');

        toastMessage.textContent = message;
        toast.classList.remove('hidden', 'bg-green-500', 'bg-red-500');
        toast.classList.add(type === 'success' ? 'bg-green-500' : 'bg-red-500');

        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }
</script>
@endpush