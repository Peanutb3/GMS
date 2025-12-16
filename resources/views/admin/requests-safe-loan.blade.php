@extends('layouts.app')

@section('title', 'Safe Loan Requests')

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
        <span class="text-gray-600">Requests</span>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">Safe Loan</span>
    </nav>
</div>

<!-- Page Header -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl p-8 mb-8 shadow-lg">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Safe Loan Requests</h1>
            <p class="text-gray-100">Manage safe loan payment slips and OR numbers</p>
        </div>
        <div class="hidden md:block">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
            </svg>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <form method="GET" action="{{ route('admin.requests.safe-loan') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Student name, reference number..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-6 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900 font-medium transition-colors w-full">
                    Apply Filters
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Requests Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">All Requests ({{ $requests->total() }})</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Ref No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Loan Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Purpose</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">OR Number</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($requests as $request)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $request->reference_no ?? '#' . $request->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $request->first_name }}
                            {{ $request->middle_name ? $request->middle_name . ' ' : '' }}
                            {{ $request->last_name }}
                        </div>
                        @if($request->student)
                        <div class="text-xs text-gray-500">{{ $request->student->student_id }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        ₱{{ number_format($request->loan_amount, 2) }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <div class="max-w-xs truncate" title="{{ $request->purpose }}">
                            {{ Str::limit($request->purpose, 50) }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            {{ $request->status === 'approved' ? 'bg-green-100 text-green-800' :
                               ($request->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($request->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($request->or_number)
                        <span class="text-green-600 font-medium">{{ $request->or_number }}</span>
                        @else
                        <span class="text-gray-400">Not entered</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $request->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center gap-3">
                            <!-- View Receipt -->
                            <a href="{{ route('safe-loan.print', $request) }}" target="_blank"
                                class="text-blue-600 hover:text-blue-900" title="View Receipt">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>

                            <!-- Enter OR Number (if not entered) -->
                            @if(!$request->or_number)
                            <button onclick="openOrModal({{ $request->id }}, '{{ $request->reference_no ?? '#' . $request->id }}')"
                                class="text-green-600 hover:text-green-900" title="Enter OR Number">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </button>
                            @endif

                            <!-- Delete -->
                            <form action="{{ route('safe-loan.delete', $request) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this request?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-lg font-medium">No safe loan requests found</p>
                        <p class="text-sm mt-1">Requests will appear here once students submit them</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($requests->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $requests->links() }}
    </div>
    @endif
</div>

<!-- OR Number Modal -->
<div id="orModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Enter OR Number</h3>
        <form id="orForm" method="POST">
            @csrf
            <input type="hidden" name="request_id" id="orRequestId">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Reference Number</label>
                <input type="text" id="orRefNumber" readonly class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
            </div>
            <div class="mb-6">
                <label for="or_number" class="block text-sm font-medium text-gray-700 mb-2">OR Number <span class="text-red-600">*</span></label>
                <input type="text" name="or_number" id="or_number" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent"
                    placeholder="Enter Official Receipt number">
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeOrModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900">
                    Save OR Number
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openOrModal(requestId, refNumber) {
        document.getElementById('orRequestId').value = requestId;
        document.getElementById('orRefNumber').value = refNumber;
        document.getElementById('or_number').value = '';
        document.getElementById('orForm').action = `/safe-loan/${requestId}/enter-or`;
        document.getElementById('orModal').classList.remove('hidden');
    }

    function closeOrModal() {
        document.getElementById('orModal').classList.add('hidden');
    }

    // Close modal on outside click
    document.getElementById('orModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeOrModal();
        }
    });
</script>

@endsection
