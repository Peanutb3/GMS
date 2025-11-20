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
        <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z"/>
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
                    <path d="M16 8c0 2.21-1.79 4-4 4s-4-1.79-4-4l.11-.94L5 5.5L12 2l7 3.5v5h-1V6l-2.11 1.06zm-4 6c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4"/>
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
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update Status
                    </button>
                </form>

                <button onclick="deleteGrievance()" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Delete Grievance
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

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden">
    <p id="toast-message"></p>
</div>

@endsection

@push('scripts')
<script>
// Update status
document.querySelector('.update-status-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

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
            showToast('Status updated successfully!', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('Failed to update status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred', 'error');
    });
});

// Delete grievance
function deleteGrievance() {
    if (!confirm('Are you sure you want to delete this grievance? This action cannot be undone.')) {
        return;
    }

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
            showToast('Grievance deleted successfully!', 'success');
            setTimeout(() => window.location.href = '{{ route("admin.grievances") }}', 1500);
        } else {
            showToast('Failed to delete grievance', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred', 'error');
    });
}

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    
    toastMessage.textContent = message;
    toast.classList.remove('hidden', 'bg-green-500', 'bg-red-500');
    toast.classList.add(type === 'success' ? 'bg-green-500' : 'bg-red-500');
    
    setTimeout(() => toast.classList.add('hidden'), 3000);
}
</script>
@endpush
