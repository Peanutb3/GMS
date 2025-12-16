@extends('layouts.app')

@section('title', 'Student Grievances')

@section('sidebar')
@include('partials.sidebar-student')
@endsection

@section('content')
<!-- Breadcrumb -->
<nav class="text-sm text-gray-600 flex items-center mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
        <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z" />
    </svg>
    <a href="{{ route('student.dashboard') }}" class="hover:text-red-800">Dashboard</a>
    <span class="mx-2 text-gray-500">></span>
    <span class="text-blue-600">Grievances</span>
</nav>

<!-- Search Section with Header -->
<div class="border-b border-gray-200 mb-4">
    <div class="flex items-end justify-between gap-4">
        <!-- Header on the left -->
        <div class="pb-2">
            <h2 class="text-2xl font-semibold">My Grievances</h2>
            <p class="text-sm text-gray-600">View your grievance cases and their status</p>
        </div>
        <!-- Search form on the right -->
        <form method="GET" action="{{ route('student.grievances') }}" class="flex items-center space-x-2 pb-2">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                    class="pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none text-sm w-64" />
                <span class="absolute left-3 top-2.5 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                </span>
            </div>
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-800">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-red-800 text-white rounded-lg text-sm hover:bg-red-700">Search</button>
        </form>
    </div>
</div>

<!-- Table -->
<div class="relative overflow-x-auto bg-white shadow-sm rounded-lg border border-gray-200 pb-40">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">Case ID</th>
                <th scope="col" class="px-6 py-3 font-medium">Name</th>
                <th scope="col" class="px-6 py-3 font-medium">Program</th>
                <th scope="col" class="px-6 py-3 font-medium">Type</th>
                <th scope="col" class="px-6 py-3 font-medium">Date Filed</th>
                <th scope="col" class="px-6 py-3 font-medium">Status</th>
                <th scope="col" class="px-6 py-3 font-medium">Filed By</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($grievances as $g)
            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 hover:bg-gray-100 cursor-pointer" onclick="showGrievanceModal({{ $g->id }})">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $g->case_id }}</th>
                <td class="px-6 py-4">{{ optional($g->student)->first_name ? optional($g->student)->first_name . ' ' . optional($g->student)->last_name : ($g->name_snapshot ?? $g->name ?? '-') }}</td>
                <td class="px-6 py-4">
                    @php
                    $prog = optional($g->student)->program ?? ($g->program_snapshot ?? $g->program ?? '-');

                    // Get program code from database
                    if ($prog !== '-') {
                    $programModel = \App\Models\Program::where('name', $prog)->first();
                    $progAbbr = $programModel && $programModel->code ? $programModel->code : $prog;
                    } else {
                    $progAbbr = '-';
                    }
                    @endphp
                    <span title="{{ $prog }}">{{ $progAbbr }}</span>
                </td>
                <td class="px-6 py-4 capitalize">{{ str_replace('_', ' ', $g->grievance) }}</td>
                <td class="px-6 py-4">{{ $g->created_at->format('Y-m-d') }}</td>
                <td class="px-6 py-4">
                    @php
                    $statusClass = match($g->status) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'in_progress' => 'bg-blue-100 text-blue-800',
                    'resolved' => 'bg-green-100 text-green-800',
                    default => 'bg-gray-100 text-gray-800'
                    };
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                        {{ ucfirst(str_replace('_',' ',$g->status)) }}
                    </span>
                </td>
                <td class="px-6 py-4">{{ $g->filed_by_display }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-500">No grievances found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    @if(method_exists($grievances, 'links'))
    {{ $grievances->links('vendor.pagination.tailwind') }}
    @endif
</div>

<!-- Grievance Details Modal -->
<div id="grievanceModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-xl font-semibold text-gray-900">Grievance Details</h3>
            <button onclick="closeGrievanceModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div id="grievanceModalContent" class="mt-4 space-y-4">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>

@php
$grievancesData = $grievances->map(function($g) {
return [
'id' => $g->id,
'case_id' => $g->case_id,
'name' => optional($g->student)->first_name ? optional($g->student)->first_name . ' ' . optional($g->student)->last_name : ($g->name_snapshot ?? $g->name ?? '-'),
'program' => optional($g->student)->program ?? ($g->program_snapshot ?? $g->program ?? '-'),
'type' => str_replace('_', ' ', $g->grievance),
'date_filed' => $g->created_at->format('Y-m-d'),
'status' => ucfirst(str_replace('_', ' ', $g->status)),
'filed_by' => $g->filed_by_display,
'description' => $g->description ?? 'No description provided.',
'remarks' => $g->remarks ?? 'No remarks available.',
'attachment_path' => $g->attachment_path ?? null,
];
})->values();
@endphp

@push('scripts')
<script>
    const grievancesData = @json($grievancesData);

    function showGrievanceModal(id) {
        const grievance = grievancesData.find(g => g.id === id);
        if (!grievance) return;

        const modal = document.getElementById('grievanceModal');
        const content = document.getElementById('grievanceModalContent');

        let attachmentHtml = '';
        if (grievance.attachment_path) {
            const fileName = grievance.attachment_path.split('/').pop();
            attachmentHtml = `
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Attached File</label>
                <a href="/storage/${grievance.attachment_path}" target="_blank"
                   class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    ${fileName}
                </a>
            </div>
        `;
        }

        content.innerHTML = `
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Case ID</label>
                <p class="text-gray-900">${grievance.case_id}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <p class="text-gray-900">${grievance.status}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <p class="text-gray-900">${grievance.name}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                <p class="text-gray-900">${grievance.program}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <p class="text-gray-900 capitalize">${grievance.type}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Filed</label>
                <p class="text-gray-900">${grievance.date_filed}</p>
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filed By</label>
                <p class="text-gray-900">${grievance.filed_by}</p>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <p class="text-gray-900 p-3 bg-gray-50 rounded border border-gray-200">${grievance.description}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
            <p class="text-gray-900 p-3 bg-gray-50 rounded border border-gray-200">${grievance.remarks}</p>
        </div>
        ${attachmentHtml}
    `;

        modal.classList.remove('hidden');
    }

    function closeGrievanceModal() {
        document.getElementById('grievanceModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('grievanceModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeGrievanceModal();
        }
    });
</script>
@endpush

@endsection
