@extends('layouts.app')

@section('title', 'Pending User Approvals')

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
        <span class="text-gray-600">Manage Users</span>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">Pending Approvals</span>
    </nav>
</div>

<!-- Page Header -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl p-8 mb-8 shadow-lg">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Pending User Approvals</h1>
            <p class="text-gray-100">Review and approve student account registrations</p>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
    {{ session('success') }}
</div>
@endif

@if(session('info'))
<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
    {{ session('info') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
    {{ session('error') }}
</div>
@endif

<!-- Pending Users Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Pending Approvals ({{ $pendingUsers->total() }})</h2>
    </div>

    @if($pendingUsers->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Student Info</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">College/Program</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Year</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Registered</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($pendingUsers as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-[#DC5656] to-[#800000] flex items-center justify-center text-white font-semibold flex-shrink-0">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-gray-500">{{ $user->student->student_id ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3 text-sm">
                        <div class="text-gray-900">{{ $user->email }}</div>
                        @if($user->email_verified_at)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            ✓ Verified
                        </span>
                        @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                            ⚠ Not Verified
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-700">
                        @php
                        $collegeId = $user->student->college ?? null;
                        if ($collegeId) {
                        $college = \App\Models\College::find($collegeId);
                        $collegeName = $college ? $college->name : 'N/A';
                        } else {
                        $collegeName = 'N/A';
                        }
                        @endphp
                        <div>{{ $collegeName }}</div>
                        <div class="text-gray-500">{{ $user->student->program ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-center">
                        {{ $user->student->year ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->created_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium">
                        <div class="flex gap-2">
                            <!-- Approve Button -->
                            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('POST')
                                <button type="submit"
                                    onclick="return confirm('Are you sure you want to approve this user?')"
                                    class="text-green-600 hover:text-green-900" title="Approve">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </form>

                            <!-- Reject Button -->
                            <button
                                onclick="showRejectModal({{ $user->id }}, '{{ $user->name }}')"
                                class="text-red-600 hover:text-red-900" title="Reject">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($pendingUsers->hasPages())
    <div class="p-6 border-t border-gray-200">
        {{ $pendingUsers->links('vendor.pagination.tailwind') }}
    </div>
    @endif
    @else
    <div class="px-6 py-12 text-center text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-lg">No pending approvals.</p>
    </div>
    @endif
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <form id="rejectForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Reject User Account</h3>
            </div>

            <div class="px-6 py-4">
                <p class="text-sm text-gray-600 mb-4">
                    Are you sure you want to reject <strong id="rejectUserName"></strong>'s account? This action cannot be undone.
                </p>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Rejection Reason <span class="text-red-500">*</span>
                </label>
                <textarea
                    name="rejection_reason"
                    rows="4"
                    required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                    placeholder="Please provide a reason for rejection..."></textarea>
            </div>

            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3 rounded-b-lg">
                <button
                    type="button"
                    onclick="closeRejectModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Reject Account
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showRejectModal(userId, userName) {
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectUserName').textContent = userName;
        document.getElementById('rejectForm').action = `/admin/users/${userId}/reject`;
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectForm').reset();
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRejectModal();
        }
    });
</script>
@endsection