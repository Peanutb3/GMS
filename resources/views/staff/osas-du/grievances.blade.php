@extends('layouts.app')

@section('title', 'Grievances')

@section('sidebar')
@include('partials.sidebar-osas-du')
@endsection

@section('content')
<!-- <div class="max-w-6xl mx-auto px-5 py-6"> -->

<!-- Breadcrumb -->
<nav class="text-sm text-gray-600 flex items-center mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
        <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z" />
    </svg>
    <a href="{{ route('osas-du.dashboard') }}" class="hover:text-red-800">Dashboard</a>
    <span class="mx-2 text-gray-500">></span>
    <a href="{{ route('osas-du.file-grievances') }}" class="text-blue-600 hover">Grievances</a>
</nav>

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-semibold">Grievances Management</h2>
    <p class="text-sm text-gray-600">Track and manage student grievance cases</p>
</div>

<!-- Tabs + Search (match Requests styling) -->
<div class="border-b border-gray-200 mb-4">
    <div class="flex items-end justify-between gap-4">
        <nav class="-mb-px flex gap-4" aria-label="Tabs">
            <a href="{{ route('osas-du.grievances', array_merge(request()->except('page'), ['tab'=>'active'])) }}"
                class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ ($tab ?? 'active')==='active' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">Active</a>
            <a href="{{ route('osas-du.grievances', array_merge(request()->except('page'), ['tab'=>'history'])) }}"
                class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ ($tab ?? 'active')==='history' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">History</a>
        </nav>
        <form method="GET" action="{{ route('osas-du.grievances') }}" class="flex items-center space-x-2 pb-2">
            <input type="hidden" name="tab" value="{{ $tab ?? 'active' }}" />
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                    class="pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none text-sm w-64" />
                <span class="absolute left-3 top-2.5 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                </span>
            </div>
            @if(($tab ?? 'active')==='active')
            <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-800">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            </select>
            @endif
            <button type="submit" class="px-4 py-2 bg-red-800 text-white rounded-lg text-sm hover:bg-red-700">Search</button>
        </form>
    </div>
</div>

@if(session('success'))
<x-toast type="success" :message="session('success')" />
@endif

<!-- Table -->
<div class="relative overflow-x-auto bg-white shadow-sm rounded-lg border border-gray-200 pb-40">
    @if(($tab ?? 'active')==='history')
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="bg-gray-50 border-b text-sm border-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">Case ID</th>
                <th scope="col" class="px-6 py-3 font-medium">Name</th>
                <th scope="col" class="px-6 py-3 font-medium">Program</th>
                <th scope="col" class="px-6 py-3 font-medium">Type</th>
                <th scope="col" class="px-6 py-3 font-medium">Action</th>
                <th scope="col" class="px-6 py-3 font-medium">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse(($historyItems ?? collect()) as $h)
            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $h['case_id'] }}</th>
                <td class="px-6 py-4">{{ $h['name'] }}</td>
                <td class="px-6 py-4">
                    @php
                    $prog = $h['program'];

                    // Look up program code from database
                    $programModel = \App\Models\Program::where('name', $prog)->first();
                    $progAbbr = $programModel && $programModel->code ? $programModel->code : $prog;
                    @endphp
                    <span title="{{ $prog }}">{{ $progAbbr }}</span>
                </td>
                <td class="px-6 py-4">
                    {{ $h['grievance_type'] ?? 'Grievance' }}
                </td>
                <td class="px-6 py-4">
                    @php
                    $actionClass = match($h['action']) {
                    'resolved' => 'bg-green-100 text-green-800',
                    'deleted' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800'
                    };
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $actionClass }}">
                        {{ ucfirst($h['action']) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($h['date'])->format('M d, Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">No history found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @else
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">Case ID</th>
                <th scope="col" class="px-6 py-3 font-medium">Name</th>
                <th scope="col" class="px-6 py-3 font-medium">Program</th>
                <th scope="col" class="px-6 py-3 font-medium">Type</th>
                <th scope="col" class="px-6 py-3 font-medium">Date</th>
                <th scope="col" class="px-6 py-3 font-medium">Status</th>
                <th scope="col" class="px-6 py-3 font-medium">Attachment</th>
                <!-- <th scope="col" class="px-6 py-3 font-medium">Filed By</th> -->
                <th scope="col" class="px-6 py-3 font-medium text-right">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($grievances as $g)
            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 hover:bg-gray-100 cursor-pointer" onclick="openGrievanceModal({{ $g->id }}, '{{ addslashes($g->case_id) }}', '{{ addslashes(optional($g->student)->first_name ? optional($g->student)->first_name . ' ' . optional($g->student)->last_name : ($g->name_snapshot ?? $g->name ?? '-')) }}', '{{ addslashes(optional($g->student)->program ?? ($g->program_snapshot ?? $g->program ?? '-')) }}', '{{ addslashes(str_replace('_', ' ', $g->grievance)) }}', '{{ $g->created_at->format('Y-m-d') }}', '{{ $g->status }}', '{{ addslashes($g->description ?? '') }}', '{{ addslashes($g->remarks ?? '') }}', '{{ addslashes($g->filed_by_display) }}')">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $g->case_id }}</th>
                <td class="px-6 py-4">{{ optional($g->student)->first_name ? optional($g->student)->first_name . ' ' . optional($g->student)->last_name : ($g->name_snapshot ?? $g->name ?? '-') }}</td>
                <td class="px-6 py-4">
                    @php
                    $prog = optional($g->student)->program_name ?? ($g->program_snapshot ?? '-');

                    // Look up program code from database
                    if ($prog !== '-') {
                    $programModel = \App\Models\Program::where('name', $prog)->first();
                    $progAbbr = $programModel && $programModel->code ? $programModel->code : $prog;
                    } else {
                    $progAbbr = '-';
                    }
                    @endphp
                    <span title="{{ $prog }}">{{ $progAbbr }}</span>
                </td>
                <td class="px-6 py-4">
                    {{ str_replace('_', ' ', $g->grievance) }}
                </td>
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
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium whitespace-nowrap {{ $statusClass }}">
                        {{ ucfirst(str_replace('_',' ',$g->status)) }}
                    </span>
                </td>
                <td class="px-6 py-4" onclick="event.stopPropagation();">
                    @if($g->attachment_path)
                    <a href="{{ asset('storage/' . $g->attachment_path) }}" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        View
                    </a>
                    @else
                    <span class="text-gray-400 text-sm">—</span>
                    @endif
                </td>
                <!-- <td class="px-6 py-4">{{ $g->filed_by_display }}</td> -->
                <td class="px-6 py-4 text-right">
                    <div class="relative inline-block" onclick="event.stopPropagation();">
                        <button onclick="toggleKebab(event, 'grv-{{ $g->id }}')" type="button" class="p-1.5 hover:bg-gray-100 rounded-lg transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-red-200">
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                        </button>
                        <div id="grv-{{ $g->id }}" class="hidden absolute right-0 mt-1 w-40 bg-white rounded-lg shadow-lg border border-gray-200 z-[9999] overflow-hidden opacity-0 scale-95 transition-all duration-200">
                            <a href="{{ route('osas-du.grievances.edit', $g->id) }}" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors" onclick="event.stopPropagation();">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span>Edit</span>
                            </a>
                            <button onclick="event.stopPropagation(); openRemarksModal({{ $g->id }}, '{{ addslashes($g->case_id) }}')" , type="button" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                <span>Add Remarks</span>
                            </button>
                            <button onclick="event.stopPropagation(); openStatusModal({{ $g->id }}, '{{ addslashes($g->case_id) }}', '{{ $g->status }}')" , type="button" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <span>Change Status</span>
                            </button>
                            @if($g->status !== 'resolved')
                            <div class="border-t border-gray-100 my-1"></div>
                            <button onclick="event.stopPropagation(); markAsDone({{ $g->id }})" type="button" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Mark as Done</span>
                            </button>
                            @endif
                            <div class="border-t border-gray-100 my-1"></div>
                            <button onclick="event.stopPropagation(); deleteGrievance({{ $g->id }})" type="button" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="px-6 py-8 text-center text-gray-500">No grievances found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    @if(($tab ?? 'active')==='active' && method_exists($grievances, 'links'))
    {{ $grievances->links('vendor.pagination.tailwind') }}
    @endif

    @endif
</div>

<!-- Grievance Details Modal -->
<div id="grievanceModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full p-8 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Grievance Details</h3>
                <p class="text-sm text-gray-500 mt-1">Case ID: <span id="detailCaseId" class="font-semibold text-gray-700"></span></p>
            </div>
            <button onclick="closeGrievanceModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Student Name</label>
                    <p id="detailName" class="text-gray-900"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                    <p id="detailProgram" class="text-gray-900"></p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Grievance Type</label>
                    <p id="detailType" class="text-gray-900 capitalize"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <p id="detailDate" class="text-gray-900"></p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <span id="detailStatus" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"></span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filed By</label>
                    <p id="detailFiledBy" class="text-gray-900"></p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <div id="detailDescription" class="text-gray-900 p-3 bg-gray-50 rounded-lg whitespace-pre-wrap"></div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Remarks / Comments</label>
                <div id="detailRemarks" class="text-gray-900 p-3 bg-gray-50 rounded-lg whitespace-pre-wrap min-h-[100px]"></div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <button onclick="closeGrievanceModal()" class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-400 outline-none transition font-medium">
                Close
            </button>
        </div>
    </div>
</div>

<!-- Remarks Modal -->
<div id="remarksModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Add Remarks</h3>
                <p class="text-sm text-gray-500 mt-1">Case ID: <span id="modalCaseId" class="font-semibold text-gray-700"></span></p>
            </div>
            <button onclick="closeRemarksModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="remarksForm" onsubmit="submitRemarks(event)">
            <input type="hidden" id="remarksGrievanceId" />
            <div class="mb-6">
                <label for="remarksText" class="block text-sm font-medium text-gray-700 mb-2">Remarks/Comments</label>
                <textarea id="remarksText" name="remarks" rows="5" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none resize-none"
                    placeholder="Enter your remarks or comments about this grievance..."></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeRemarksModal()"
                    class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-400 outline-none transition font-medium">
                    Cancel
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-gradient-to-r from-red-900 to-red-800 text-white rounded-lg hover:from-red-800 hover:to-red-700 focus:ring-2 focus:ring-red-800 outline-none transition font-medium shadow-lg">
                    Save Remarks
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Status Change Modal -->
<div id="statusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Change Status</h3>
                <p class="text-sm text-gray-500 mt-1">Case ID: <span id="statusModalCaseId" class="font-semibold text-gray-700"></span></p>
            </div>
            <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="statusForm" onsubmit="submitStatusChange(event)">
            <input type="hidden" id="statusGrievanceId" />
            <div class="mb-6">
                <label for="newStatus" class="block text-sm font-medium text-gray-700 mb-2">Select New Status</label>
                <select id="newStatus" name="status" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeStatusModal()"
                    class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-400 outline-none transition font-medium">
                    Cancel
                </button>
                <button type="submit" id="statusUpdateBtn"
                    class="px-5 py-2.5 bg-gradient-to-r from-red-900 to-red-800 text-white rounded-lg hover:from-red-800 hover:to-red-700 focus:ring-2 focus:ring-red-800 outline-none transition font-medium shadow-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white hidden" id="statusLoadingSpinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="statusBtnText">Update Status</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="toast-stack" class="fixed top-4 right-4 space-y-2 z-50"></div>

<!-- Grievance Details Modal -->
<div id="grievanceModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full p-8 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Grievance Details</h3>
                <p class="text-sm text-gray-500 mt-1">Case ID: <span id="detailCaseId" class="font-semibold text-gray-700"></span></p>
            </div>
            <button onclick="closeGrievanceModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Student Name</label>
                    <p id="detailName" class="text-gray-900"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                    <p id="detailProgram" class="text-gray-900"></p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Grievance Type</label>
                    <p id="detailType" class="text-gray-900 capitalize"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <p id="detailDate" class="text-gray-900"></p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <span id="detailStatus" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"></span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filed By</label>
                    <p id="detailFiledBy" class="text-gray-900"></p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <div id="detailDescription" class="text-gray-900 p-3 bg-gray-50 rounded-lg whitespace-pre-wrap"></div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Remarks / Comments</label>
                <div id="detailRemarks" class="text-gray-900 p-3 bg-gray-50 rounded-lg whitespace-pre-wrap min-h-[100px]"></div>
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <button onclick="closeGrievanceModal()" class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-400 outline-none transition font-medium">
                Close
            </button>
        </div>
    </div>
</div>

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
</style>
<script>
    // Helper function to create toast notifications (mimics toast component)
    function createToast(msg, type = 'info') {
        const colors = {
            success: {
                bg: 'bg-green-100',
                text: 'text-green-600',
                bar: 'bg-green-500',
                icon: '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />'
            },
            error: {
                bg: 'bg-red-100',
                text: 'text-red-600',
                bar: 'bg-red-500',
                icon: '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />'
            },
            warning: {
                bg: 'bg-orange-100',
                text: 'text-orange-600',
                bar: 'bg-orange-500',
                icon: '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z" />'
            },
            info: {
                bg: 'bg-blue-100',
                text: 'text-blue-600',
                bar: 'bg-blue-500',
                icon: '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />'
            }
        };
        const color = colors[type] || colors.info;

        const toastContainer = document.createElement('div');
        toastContainer.className = '!fixed !top-20 !right-4 !z-50 animate-fade-in';
        toastContainer.style.cssText = 'position: fixed !important; top: 5rem !important; right: 1rem !important; z-index: 9999 !important; width: calc(100% - 2rem); max-width: 24rem;';

        toastContainer.innerHTML = `
            <div class="relative flex items-center w-full max-w-sm p-4 rounded-lg shadow border border-gray-200 bg-white text-gray-800 overflow-hidden" role="alert">
                <div class="absolute bottom-0 left-0 h-1 ${color.bar} toast-timer-bar"></div>
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 mr-3 rounded-lg ${color.bg} ${color.text}">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        ${color.icon}
                    </svg>
                </div>
                <div class="ms-3 text-sm font-normal flex-1">${msg}</div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" onclick="this.closest('[role=alert]').parentElement.remove()">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        `;

        document.body.appendChild(toastContainer);

        setTimeout(() => {
            toastContainer.style.transition = 'opacity 0.3s, transform 0.3s';
            toastContainer.style.opacity = '0';
            toastContainer.style.transform = 'translateX(20px)';
            setTimeout(() => toastContainer.remove(), 300);
        }, 5000);
    }

    // Check for status update success
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status_updated') === '1') {
        createToast('Status updated successfully', 'success');
        // Clean URL
        const newParams = new URLSearchParams(urlParams);
        newParams.delete('status_updated');
        const newUrl = window.location.pathname + (newParams.toString() ? '?' + newParams.toString() : '');
        window.history.replaceState({}, '', newUrl);
    }

    // Grievance Details Modal Functions
    function openGrievanceModal(id, caseId, name, program, type, date, status, description, remarks, filedBy) {
        document.getElementById('detailCaseId').textContent = caseId;
        document.getElementById('detailName').textContent = name;
        document.getElementById('detailProgram').textContent = program;
        document.getElementById('detailType').textContent = type;
        document.getElementById('detailDate').textContent = date;
        document.getElementById('detailFiledBy').textContent = filedBy;
        document.getElementById('detailDescription').textContent = description || 'No description provided';
        document.getElementById('detailRemarks').textContent = remarks || 'No remarks yet';

        // Set status badge
        const statusEl = document.getElementById('detailStatus');
        const statusClass = {
            'pending': 'bg-yellow-100 text-yellow-800',
            'in_progress': 'bg-blue-100 text-blue-800',
            'resolved': 'bg-green-100 text-green-800'
        } [status] || 'bg-gray-100 text-gray-800';
        statusEl.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium whitespace-nowrap ' + statusClass;
        statusEl.textContent = status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());

        document.getElementById('grievanceModal').classList.remove('hidden');
    }

    function closeGrievanceModal() {
        document.getElementById('grievanceModal').classList.add('hidden');
    }

    // Kebab menu toggle with smooth animations
    function toggleKebab(event, menuId) {
        event.preventDefault();
        event.stopPropagation();

        const menu = document.getElementById(menuId);
        if (!menu) return false;

        const allMenus = document.querySelectorAll('[id^="grv-"]');

        // Close all other menus with animation
        allMenus.forEach(m => {
            if (m.id !== menuId && !m.classList.contains('hidden')) {
                m.classList.remove('opacity-100', 'scale-100');
                m.classList.add('opacity-0', 'scale-95');
                setTimeout(() => m.classList.add('hidden'), 200);
            }
        });

        // Toggle current menu with animation
        const isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            menu.classList.remove('hidden');
            // Trigger reflow
            menu.offsetHeight;
            menu.classList.remove('opacity-0', 'scale-95');
            menu.classList.add('opacity-100', 'scale-100');
        } else {
            menu.classList.remove('opacity-100', 'scale-100');
            menu.classList.add('opacity-0', 'scale-95');
            setTimeout(() => menu.classList.add('hidden'), 200);
        }

        return false;
    }

    // Close kebab menus on outside click with animation
    document.addEventListener('click', function(e) {
        if (!e.target.closest('[id^="grv-"]') && !e.target.closest('button[onclick*="toggleKebab"]')) {
            document.querySelectorAll('[id^="grv-"]').forEach(menu => {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.remove('opacity-100', 'scale-100');
                    menu.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => menu.classList.add('hidden'), 200);
                }
            });
        }
    });

    const token = '{{ csrf_token() }}';

    function markAsDone(id) {
        if (!confirm('Mark this grievance as done?')) return;

        fetch(`/osas-du/grievances/${id}/resolve`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(async r => {
                if (!r.ok) {
                    const text = await r.text();
                    console.error('Server response:', text);
                    throw new Error('HTTP error ' + r.status);
                }
                return r.json();
            })
            .then(data => {
                console.log('Mark as done response:', data);
                if (data.ok) {
                    location.reload();
                } else {
                    createToast('Failed to mark as done', 'error');
                }
            })
            .catch(err => {
                console.error('Mark as done error:', err);
                createToast('Failed to mark as done: ' + err.message, 'error');
            });
    }

    function deleteGrievance(id) {
        if (!confirm('Delete this grievance? This action cannot be undone.')) return;

        fetch(`/osas-du/grievances/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(async r => {
                if (!r.ok) {
                    const text = await r.text();
                    console.error('Server response:', text);
                    throw new Error('HTTP error ' + r.status);
                }
                return r.json();
            })
            .then(data => {
                console.log('Delete response:', data);
                if (data.ok) {
                    location.reload();
                } else {
                    createToast('Failed to delete', 'error');
                }
            })
            .catch(err => {
                console.error('Delete error:', err);
                createToast('Failed to delete: ' + err.message, 'error');
            });
    }

    // Remarks Modal Functions
    function openRemarksModal(id, caseId) {
        document.getElementById('remarksGrievanceId').value = id;
        document.getElementById('modalCaseId').textContent = caseId;
        document.getElementById('remarksText').value = '';
        document.getElementById('remarksModal').classList.remove('hidden');
    }

    function closeRemarksModal() {
        document.getElementById('remarksModal').classList.add('hidden');
    }

    function submitRemarks(event) {
        event.preventDefault();
        const id = document.getElementById('remarksGrievanceId').value;
        const remarks = document.getElementById('remarksText').value;

        fetch(`/osas-du/grievances/${id}/remarks`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    remarks
                })
            })
            .then(r => r.json())
            .then(data => {
                if (!data.ok) throw new Error('Failed');
                closeRemarksModal();
                location.reload();
            })
            .catch(() => createToast('Failed to add remarks', 'error'));
    }

    // Status Modal Functions
    function openStatusModal(id, caseId, currentStatus) {
        document.getElementById('statusGrievanceId').value = id;
        document.getElementById('statusModalCaseId').textContent = caseId;
        document.getElementById('newStatus').value = currentStatus;
        document.getElementById('statusModal').classList.remove('hidden');
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
    }

    function submitStatusChange(event) {
        event.preventDefault();
        const id = document.getElementById('statusGrievanceId').value;
        const status = document.getElementById('newStatus').value;
        const btn = document.getElementById('statusUpdateBtn');
        const spinner = document.getElementById('statusLoadingSpinner');
        const btnText = document.getElementById('statusBtnText');

        // Show loading on button only
        btn.disabled = true;
        spinner.classList.remove('hidden');
        btnText.textContent = 'Updating...';

        fetch(`/osas-du/grievances/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    status
                })
            })
            .then(async r => {
                if (!r.ok) {
                    const text = await r.text();
                    console.error('Server response:', text);
                    throw new Error('HTTP error ' + r.status);
                }
                return r.json();
            })
            .then(data => {
                if (data.ok) {
                    // Reload page to show toast notification
                    window.location.href = '{{ route("osas-du.grievances") }}?status_updated=1';
                } else {
                    throw new Error('Update failed');
                }
            })
            .catch(err => {
                console.error('Status change error:', err);

                createToast('Failed to update status: ' + err.message, 'error');
                btn.disabled = false;
                spinner.classList.add('hidden');
                btnText.textContent = 'Update Status';
            });
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeGrievanceModal();
            closeRemarksModal();
            closeStatusModal();
        }
    });
</script>
@endpush
@endsection