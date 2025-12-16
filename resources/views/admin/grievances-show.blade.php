@extends('layouts.app')

@section('title', 'Grievance Details')

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
        <a href="{{ route('admin.grievances') }}" class="text-gray-600 hover:text-red-800">Grievances</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">View Details</span>
    </nav>
</div>

<!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('admin.grievances') }}" class="inline-flex items-center gap-2 text-red-800 hover:text-red-900 font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Grievances
    </a>
</div>

<!-- Grievance Header -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl p-8 mb-8 shadow-lg">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Grievance #{{ $grievance->id }}</h1>
            <p class="text-gray-100">Filed on {{ $grievance->created_at->format('F d, Y') }}</p>
        </div>
        <div>
            <span class="px-4 py-2 rounded-lg text-sm font-semibold
                @if($grievance->status === 'pending') bg-orange-500
                @elseif($grievance->status === 'resolved') bg-green-500
                @else bg-blue-500
                @endif">
                {{ ucfirst($grievance->status) }}
            </span>
        </div>
    </div>
</div>

<!-- Grievance Details -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Main Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Student Information -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-800" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16 8c0 2.21-1.79 4-4 4s-4-1.79-4-4l.11-.94L5 5.5L12 2l7 3.5v5h-1V6l-2.11 1.06zm-4 6c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                </svg>
                Student Information
            </h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Name</p>
                    <p class="font-medium text-gray-900">{{ $grievance->name_snapshot }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Student Number</p>
                    <p class="font-medium text-gray-900">{{ $grievance->student_no_snapshot }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Program</p>
                    <p class="font-medium text-gray-900">{{ $grievance->program_snapshot }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Gender</p>
                    <p class="font-medium text-gray-900">{{ $grievance->gender_snapshot }}</p>
                </div>
            </div>
        </div>

        <!-- Grievance Description -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Description</h2>
            <p class="text-gray-700 whitespace-pre-wrap">{{ $grievance->description }}</p>
        </div>

        <!-- Action History -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Action History</h2>
            <div class="space-y-4">
                @forelse($history as $record)
                <div class="border-l-4 border-blue-500 pl-4 py-2">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-medium text-gray-900">{{ ucfirst($record->action) }}</span>
                        <span class="text-sm text-gray-500">{{ $record->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <p class="text-sm text-gray-600">{{ $record->details }}</p>
                    @if($record->user)
                    <p class="text-xs text-gray-500 mt-1">By: {{ $record->user->name }}</p>
                    @endif
                </div>
                @empty
                <p class="text-gray-400 text-center py-4">No history available</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Filed By -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Filed By</h3>
            <p class="text-gray-900 font-medium">{{ $grievance->filed_by_display }}</p>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <form method="POST" action="{{ route('admin.grievances.update-status', $grievance->id) }}" class="update-status-form">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-3">
                        <option value="pending" {{ $grievance->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="investigating" {{ $grievance->status === 'investigating' ? 'selected' : '' }}>Investigating</option>
                        <option value="resolved" {{ $grievance->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                    <button type="submit" class="status-update-btn w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white hidden loading-spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="button-text">Update Status</span>
                    </button>
                </form>

                <button onclick="deleteGrievance()" class="delete-grievance-btn w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white hidden loading-spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="button-text">Delete Grievance</span>
                </button>
            </div>
        </div>

        <!-- Timestamps -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Timestamps</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-gray-600">Created</p>
                    <p class="font-medium text-gray-900">{{ $grievance->created_at->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Last Updated</p>
                    <p class="font-medium text-gray-900">{{ $grievance->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Update status
        const statusForm = document.querySelector('.update-status-form');
        if (statusForm) {
            statusForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const btn = this.querySelector('.status-update-btn');
                const spinner = btn.querySelector('.loading-spinner');
                const btnText = btn.querySelector('.button-text');

                // Show loading
                btn.disabled = true;
                spinner.classList.remove('hidden');
                btnText.textContent = 'Updating...';

                fetch('{{ route("admin.grievances.update-status", $grievance->id) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload immediately - toast will show via session flash
                            location.reload();
                        } else {
                            showToast('Failed to update status', 'error');
                            btn.disabled = false;
                            spinner.classList.add('hidden');
                            btnText.textContent = 'Update Status';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('An error occurred', 'error');
                        btn.disabled = false;
                        spinner.classList.add('hidden');
                        btnText.textContent = 'Update Status';
                    });
            });
        }
    });

    // Delete grievance (outside DOMContentLoaded so onclick can access it)
    function deleteGrievance() {
        if (!confirm('Are you sure you want to delete this grievance? This action cannot be undone.')) {
            return;
        }

        const btn = document.querySelector('.delete-grievance-btn');
        const spinner = btn.querySelector('.loading-spinner');
        const btnText = btn.querySelector('.button-text');

        // Show loading
        btn.disabled = true;
        spinner.classList.remove('hidden');
        btnText.textContent = 'Deleting...';

        fetch('{{ route("admin.grievances.destroy", $grievance->id) }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect immediately - toast will show via session flash
                    window.location.href = '{{ route("admin.grievances") }}';
                } else {
                    showToast('Failed to delete grievance', 'error');
                    btn.disabled = false;
                    spinner.classList.add('hidden');
                    btnText.textContent = 'Delete Grievance';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred', 'error');
                btn.disabled = false;
                spinner.classList.add('hidden');
                btnText.textContent = 'Delete Grievance';
            });
    }

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