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
                        // Get program from snapshot
                        $programDisplay = $grievance->program_snapshot;

                        if (strpos($programDisplay, '|') !== false) {
                        // If format is "College | Program", get program only
                        [, $program] = explode('|', $programDisplay, 2);
                        $program = trim($program);
                        } else {
                        $program = $programDisplay;
                        }

                        // Get program code from database
                        if (!empty($program)) {
                        $programModel = \App\Models\Program::where('name', $program)->first();
                        $progAbbr = $programModel && $programModel->code ? $programModel->code : $program;
                        } else {
                        $progAbbr = $programDisplay;
                        }
                        @endphp
                        <div class="truncate" title="{{ $grievance->program_snapshot }}">{{ $progAbbr }}</div>
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

@endsection

@push('scripts')
<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }

    @keyframes timer-progress {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }

    .toast-timer-bar {
        animation: timer-progress 5s linear forwards;
    }
</style>
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
                    showToast(data.message || 'Grievance deleted successfully!', 'success');
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

    // Unified toast notification function
    function showToast(message, type = 'success') {
        // Create toast container
        const toastContainer = document.createElement('div');
        toastContainer.className = '!fixed !top-20 !right-4 !z-50 animate-fade-in';
        toastContainer.style.cssText = 'position: fixed !important; top: 5rem !important; right: 1rem !important; z-index: 9999 !important; width: calc(100% - 2rem); max-width: 24rem;';

        const colors = {
            success: {
                bg: 'bg-green-100',
                text: 'text-green-600',
                bar: 'bg-green-500'
            },
            error: {
                bg: 'bg-red-100',
                text: 'text-red-600',
                bar: 'bg-red-500'
            },
            warning: {
                bg: 'bg-orange-100',
                text: 'text-orange-600',
                bar: 'bg-orange-500'
            },
            info: {
                bg: 'bg-blue-100',
                text: 'text-blue-600',
                bar: 'bg-blue-500'
            }
        };
        const color = colors[type] || colors.info;

        toastContainer.innerHTML = `
            <div class="relative flex items-center w-full max-w-sm p-4 rounded-lg shadow border border-gray-200 bg-white text-gray-800 overflow-hidden" role="alert">
                <div class="absolute bottom-0 left-0 h-1 ${color.bar} toast-timer-bar"></div>
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 mr-3 rounded-lg ${color.bg} ${color.text}">
                    ${type === 'success' ? '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>' : '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/></svg>'}
                </div>
                <div class="ms-3 text-sm font-normal flex-1">${message}</div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" onclick="this.closest('[role=alert]').parentElement.remove()">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                </button>
            </div>
        `;

        document.body.appendChild(toastContainer);

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            toastContainer.style.transition = 'opacity 0.3s, transform 0.3s';
            toastContainer.style.opacity = '0';
            toastContainer.style.transform = 'translateX(20px)';
            setTimeout(() => toastContainer.remove(), 300);
        }, 5000);
    }
</script>
@endpush