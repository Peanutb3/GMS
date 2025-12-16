@extends('layouts.app')

@section('title', 'Requests')

@section('sidebar')
@include('partials.sidebar-osas-gmc')
@endsection

@section('content')
<!-- Breadcrumb -->
<nav class="text-sm text-gray-600 flex items-center mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
        <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z" />
    </svg>
    <a href="{{ route('osas-gmc.dashboard') }}" class="hover:text-red-800">Dashboard</a>
    <span class="mx-2 text-gray-500">/</span>
    <span class="text-blue-600">Requests</span>
</nav>

<div class="mb-6">
    <h2 class="text-2xl font-semibold">{{ ($tab ?? 'goodmoral') === 'safeloan' ? 'Safe Loan Requests' : 'Good Moral Requests' }}</h2>
    <p class="text-sm text-gray-600">{{ ($tab ?? 'goodmoral') === 'safeloan' ? 'Manage safe loan requests' : 'Manage good moral requests' }}</p>
</div>

<!-- Tabs + Search -->
<div class="border-b border-gray-200 mb-4">
    <div class="flex items-end justify-between gap-4">
        <nav class="-mb-px flex gap-4" aria-label="Tabs">
            @if(($tab ?? 'goodmoral') === 'safeloan')
            <a href="{{ route('osas-gmc.requests', ['tab' => 'safeloan', 'view' => 'active']) }}"
                class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ (request('view') ?? 'active') === 'active' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">Active</a>
            <a href="{{ route('osas-gmc.requests', ['tab' => 'safeloan', 'view' => 'history']) }}"
                class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ (request('view') ?? 'active') === 'history' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">History</a>
            @else
            <a href="{{ route('osas-gmc.requests', ['tab' => 'goodmoral', 'view' => 'active']) }}"
                class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ (request('view') ?? 'active') === 'active' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">Active</a>
            <a href="{{ route('osas-gmc.requests', ['tab' => 'goodmoral', 'view' => 'history']) }}"
                class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ (request('view') ?? 'active') === 'history' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">History</a>
            @endif
        </nav>
        <form method="GET" action="{{ route('osas-gmc.requests') }}" class="flex items-center space-x-2 pb-2">
            <input type="hidden" name="tab" value="{{ $tab }}" />
            <input type="hidden" name="view" value="{{ request('view') ?? 'active' }}" />
            <div class="relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name or ref no."
                    class="pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none text-sm w-64" />
                <span class="absolute left-3 top-2.5 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                </span>
            </div>
            <button class="px-4 py-2 bg-red-800 text-white rounded-lg text-sm hover:bg-red-700">Search</button>
        </form>
    </div>
</div>

@if (session('status'))
<div class="mb-4 px-4 py-3 rounded-md bg-green-50 text-green-800 border border-green-200">
    {{ session('status') }}
</div>
@endif



@php
$q = trim((string) request('q'));
$view = request('view') ?? 'active';
$gm = ($goodMorals ?? collect());
$sl = ($safeLoans ?? collect());

// Filter by status (active = not completed, history = completed)
if ($view === 'history') {
$gm = $gm->filter(fn($r) => $r->status === 'completed');
$sl = $sl->filter(fn($r) => $r->status === 'completed');
} else {
$gm = $gm->filter(fn($r) => $r->status !== 'completed');
$sl = $sl->filter(fn($r) => $r->status !== 'completed');
}

// Filter by search query
if ($q !== '') {
$gm = $gm->filter(function($r) use ($q) {
$hay = strtoupper(($r->reference_no ?? '').' '.($r->first_name ?? '').' '.($r->last_name ?? ''));
return str_contains($hay, strtoupper($q));
});
$sl = $sl->filter(function($r) use ($q) {
$hay = strtoupper(($r->reference_no ?? '').' '.($r->first_name ?? '').' '.($r->last_name ?? ''));
return str_contains($hay, strtoupper($q));
});
}
@endphp

@if(($tab ?? 'goodmoral') === 'safeloan')
<!-- Safe Loan Requests Table -->
<div class="relative overflow-x-auto bg-white shadow-sm rounded-lg border border-gray-200 pb-40">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">Ref No</th>
                <th scope="col" class="px-6 py-3 font-medium">Name</th>
                <th scope="col" class="px-6 py-3 font-medium">Loan Amount</th>
                <th scope="col" class="px-6 py-3 font-medium">Purpose</th>
                @if((request('view') ?? 'active') === 'history')
                <th scope="col" class="px-6 py-3 font-medium">Completed Date</th>
                @else
                <th scope="col" class="px-6 py-3 font-medium">Status</th>
                @endif
                <th scope="col" class="px-6 py-3 font-medium text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sl as $r)
            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $r->reference_no ?? '—' }}</th>
                <td class="px-6 py-4">{{ ($r->last_name ?? '') }}, {{ ($r->first_name ?? '') }} {{ $r->middle_name ? substr($r->middle_name,0,1).'.' : '' }}</td>
                <td class="px-6 py-4">{{ $r->loan_amount ? '₱'.number_format($r->loan_amount,2) : '—' }}</td>
                <td class="px-6 py-4 max-w-xs truncate" title="{{ $r->purpose }}">{{ $r->purpose }}</td>
                @if((request('view') ?? 'active') === 'history')
                <td class="px-6 py-4">{{ $r->completed_at ? \Carbon\Carbon::parse($r->completed_at)->format('M d, Y h:i A') : '—' }}</td>
                @else
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $r->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status === 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($r->status ?? 'pending') }}
                    </span>
                </td>
                @endif
                <td class="px-6 py-4 text-right">
                    @if((request('view') ?? 'active') === 'history')
                    <a href="{{ route('safe-loan.print', $r->id) }}" target="_blank" class="font-medium text-red-700 hover:underline">View Document</a>
                    @else
                    <div class="relative inline-block" onclick="event.stopPropagation();">
                        <button onclick="toggleKebab(event, 'sl-{{ $r->id }}')" type="button" class="p-1.5 hover:bg-gray-100 rounded-lg transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-red-200">
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                        </button>
                        <div id="sl-{{ $r->id }}" class="hidden absolute right-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-[9999] overflow-hidden opacity-0 scale-95 transition-all duration-200">
                            <a href="{{ route('safe-loan.print', $r->id) }}" target="_blank" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors" onclick="event.stopPropagation();">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>View Document</span>
                            </a>
                            <button onclick="event.stopPropagation(); openSLStatusModal({{ $r->id }}, '{{ $r->reference_no }}', '{{ $r->status }}')" type="button" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <span>Change Status</span>
                            </button>
                            @if($r->status !== 'completed')
                            <div class="border-t border-gray-100 my-1"></div>
                            <button onclick="event.stopPropagation(); markSLAsDone({{ $r->id }})" type="button" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Mark as Done</span>
                            </button>
                            @endif
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('safe-loan.delete', $r->id) }}" onsubmit="event.stopPropagation(); return confirm('Delete this request?')" class="block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Delete Request</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ (request('view') ?? 'active') === 'history' ? '5' : '6' }}" class="px-6 py-8 text-center text-gray-500">No safe loan requests found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@else
<!-- Good Moral Requests Table -->
<div class="relative overflow-x-auto bg-white shadow-sm rounded-lg border border-gray-200 pb-40">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">Ref No</th>
                <th scope="col" class="px-6 py-3 font-medium">Name</th>
                <th scope="col" class="px-6 py-3 font-medium">Program & Year</th>
                <th scope="col" class="px-6 py-3 font-medium">Copies</th>
                <th scope="col" class="px-6 py-3 font-medium">Purpose</th>
                @if((request('view') ?? 'active') === 'history')
                <th scope="col" class="px-6 py-3 font-medium">OR Number</th>
                <th scope="col" class="px-6 py-3 font-medium">Completed Date</th>
                @else
                <th scope="col" class="px-6 py-3 font-medium">Status</th>
                @endif
                <th scope="col" class="px-6 py-3 font-medium text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gm as $r)
            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $r->reference_no ?? '—' }}</th>
                <td class="px-6 py-4">{{ ($r->last_name ?? '') }}, {{ ($r->first_name ?? '') }} {{ $r->middle_name ? substr($r->middle_name,0,1).'.' : '' }}</td>
                <td class="px-6 py-4">
                    @php
                    // Extract program abbreviation from program_year field
                    $programYear = $r->program_year ?? '';
                    $displayText = '—';

                    if (!empty($programYear) && $programYear !== '—') {
                    // Try to extract from format: "Program Name (ABBR) - Year"
                    if (preg_match('/\(([A-Z]+)\)\s*[-\/]\s*(.+)/', $programYear, $matches)) {
                    $displayText = $matches[1] . ' - ' . $matches[2];
                    }
                    // Try format: "Full Program Name - Year"
                    elseif (preg_match('/^(.+?)\s*[-\/]\s*(.+)$/', $programYear, $matches)) {
                    $fullProgram = trim($matches[1]);
                    $year = trim($matches[2]);

                    // Get program code from database
                    $programModel = \App\Models\Program::where('name', $fullProgram)->first();
                    if ($programModel && $programModel->code) {
                    $displayText = $programModel->code . ' - ' . $year;
                    } else {
                    $displayText = $programYear; // Keep original if no code found
                    }
                    } else {
                    $displayText = $programYear;
                    }
                    } else {
                    // Fallback: construct from separate program and year fields
                    $program = $r->program ?? '';
                    $year = $r->year ?? '';

                    if (!empty($program) && !empty($year)) {
                    // Get program code from database
                    $programModel = \App\Models\Program::where('name', $program)->first();
                    if ($programModel && $programModel->code) {
                    $displayText = $programModel->code . ' - ' . $year;
                    } else {
                    $displayText = $program . ' - ' . $year;
                    }
                    }
                    }
                    @endphp
                    {{ $displayText }}
                </td>
                <td class="px-6 py-4">{{ $r->copies ?? 1 }}</td>
                <td class="px-6 py-4 max-w-xs truncate" title="{{ $r->purpose }}">{{ $r->purpose }}</td>
                @if((request('view') ?? 'active') === 'history')
                <td class="px-6 py-4">{{ $r->or_number ?? '—' }}</td>
                <td class="px-6 py-4">{{ $r->completed_at ? \Carbon\Carbon::parse($r->completed_at)->format('M d, Y h:i A') : '—' }}</td>
                @else
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $r->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status === 'processing' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($r->status ?? 'pending') }}
                    </span>
                </td>
                @endif
                <td class="px-6 py-4 text-right">
                    @if((request('view') ?? 'active') === 'history')
                    <a href="{{ route('good-moral.certificate', $r->id) }}" target="_blank" class="font-medium text-red-700 hover:underline">View Certificate</a>
                    @else
                    <div class="relative inline-block" onclick="event.stopPropagation();">
                        <button onclick="toggleKebab(event, 'gm-{{ $r->id }}')" type="button" class="p-1.5 hover:bg-gray-100 rounded-lg transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-red-200">
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                        </button>
                        <div id="gm-{{ $r->id }}" class="hidden absolute right-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-[9999] overflow-hidden opacity-0 scale-95 transition-all duration-200">
                            <a href="{{ route('good-moral.print', $r->id) }}" target="_blank" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors" onclick="event.stopPropagation();">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>View & Print Slip</span>
                            </a>
                            <button onclick="event.stopPropagation(); openORModal({{ $r->id }}, '{{ $r->reference_no }}')" type="button" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Enter OR Number</span>
                            </button>
                            <button onclick="event.stopPropagation(); openGMStatusModal({{ $r->id }}, '{{ $r->reference_no }}', '{{ $r->status }}')" type="button" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <span>Change Status</span>
                            </button>
                            @if($r->status !== 'completed')
                            <div class="border-t border-gray-100 my-1"></div>
                            <button onclick="event.stopPropagation(); markGMAsDone({{ $r->id }})" type="button" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors text-left">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Mark as Done</span>
                            </button>
                            @endif
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('good-moral.delete', $r->id) }}" onsubmit="event.stopPropagation(); return confirm('Delete this request?')" class="block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Delete Request</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ (request('view') ?? 'active') === 'history' ? '8' : '7' }}" class="px-6 py-8 text-center text-gray-500">No good moral requests found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endif
<!-- Modal for printable view -->
<div id="printModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-[90vw] h-[90vh] rounded-lg shadow-xl overflow-hidden flex flex-col">
        <div class="flex items-center justify-between px-4 py-2 border-b">
            <h3 class="font-semibold">Printable Request</h3>
            <div class="flex items-center gap-2">
                <button id="printModalPrint" class="px-3 py-1.5 bg-red-800 text-white rounded-md text-sm">Print</button>
                <button id="printModalClose" class="px-3 py-1.5 bg-gray-200 rounded-md text-sm">Close</button>
            </div>
        </div>
        <iframe id="printFrame" src="about:blank" class="flex-1 w-full"></iframe>
    </div>
</div>

<!-- OR Number Entry Modal -->
<div id="orModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-lg shadow-xl p-6">
        <h3 class="text-lg font-semibold mb-4">Enter OR Number</h3>
        <form id="orForm" method="POST" action="">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Reference No: <span id="orRefNo" class="font-bold"></span></label>
                <input type="text" name="or_number" id="or_number" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none"
                    placeholder="Enter OR number">
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeORModal()" class="px-4 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-800 text-white rounded-lg text-sm hover:bg-red-700">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- Good Moral Status Change Modal -->
<div id="gmStatusModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-lg shadow-xl p-6">
        <h3 class="text-lg font-semibold mb-4">Change Status</h3>
        <form id="gmStatusForm" method="POST" action="">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Reference No: <span id="gmStatusRefNo" class="font-bold"></span></label>
                <select name="status" id="gm_status" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none">
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeGMStatusModal()" class="px-4 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300">Cancel</button>
                <button type="submit" id="gmStatusUpdateBtn" class="px-4 py-2 bg-red-800 text-white rounded-lg text-sm hover:bg-red-700 inline-flex items-center">
                    <svg class="animate-spin h-4 w-4 text-white hidden mr-2" id="gmStatusLoadingSpinner" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="gmStatusBtnText">Update</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Safe Loan Status Change Modal -->
<div id="slStatusModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-lg shadow-xl p-6">
        <h3 class="text-lg font-semibold mb-4">Change Status</h3>
        <form id="slStatusForm" method="POST" action="">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Reference No: <span id="slStatusRefNo" class="font-bold"></span></label>
                <select name="status" id="sl_status" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none">
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeSLStatusModal()" class="px-4 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300">Cancel</button>
                <button type="submit" id="slStatusUpdateBtn" class="px-4 py-2 bg-red-800 text-white rounded-lg text-sm hover:bg-red-700 inline-flex items-center">
                    <svg class="animate-spin h-4 w-4 text-white hidden mr-2" id="slStatusLoadingSpinner" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="slStatusBtnText">Update</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Kebab menu toggle with smooth animations
    function toggleKebab(event, menuId) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        const menu = document.getElementById(menuId);
        if (!menu) return false;

        const allMenus = document.querySelectorAll('[id^="gm-"], [id^="sl-"]');

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
        if (!e.target.closest('[id^="gm-"]') && !e.target.closest('[id^="sl-"]') && !e.target.closest('button[onclick*="toggleKebab"]')) {
            document.querySelectorAll('[id^="gm-"], [id^="sl-"]').forEach(menu => {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.remove('opacity-100', 'scale-100');
                    menu.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => menu.classList.add('hidden'), 200);
                }
            });
        }
    });

    // OR Modal functions
    function openORModal(requestId, refNo) {
        const modal = document.getElementById('orModal');
        const form = document.getElementById('orForm');
        const refDisplay = document.getElementById('orRefNo');

        form.action = `/good-moral/${requestId}/enter-or`;
        form.dataset.requestId = requestId; // Store request ID for later use
        refDisplay.textContent = refNo || '—';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.getElementById('or_number').focus();
    }

    function closeORModal() {
        const modal = document.getElementById('orModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.getElementById('or_number').value = '';
    }

    // Handle OR form submission to open certificate in new tab
    document.addEventListener('DOMContentLoaded', function() {
        const orForm = document.getElementById('orForm');
        if (orForm) {
            orForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(orForm);
                const requestId = orForm.dataset.requestId;

                try {
                    const response = await fetch(orForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (response.ok) {
                        // Open certificate in new tab
                        window.open(`/good-moral/${requestId}/certificate`, '_blank');

                        // Close modal and reload page
                        closeORModal();
                        window.location.reload();
                    } else {
                        alert('Failed to submit OR number');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred');
                }
            });
        }
    });

    // Good Moral Status Modal
    function openGMStatusModal(requestId, refNo, currentStatus) {
        const modal = document.getElementById('gmStatusModal');
        const form = document.getElementById('gmStatusForm');
        const refDisplay = document.getElementById('gmStatusRefNo');
        const select = document.getElementById('gm_status');

        form.action = `/good-moral/${requestId}/change-status`;
        refDisplay.textContent = refNo || '—';
        select.value = currentStatus || 'pending';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeGMStatusModal() {
        const modal = document.getElementById('gmStatusModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Safe Loan Status Modal
    function openSLStatusModal(requestId, refNo, currentStatus) {
        const modal = document.getElementById('slStatusModal');
        const form = document.getElementById('slStatusForm');
        const refDisplay = document.getElementById('slStatusRefNo');
        const select = document.getElementById('sl_status');

        form.action = `/safe-loan/${requestId}/change-status`;
        refDisplay.textContent = refNo || '—';
        select.value = currentStatus || 'pending';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeSLStatusModal() {
        const modal = document.getElementById('slStatusModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Mark as Done functions
    function markGMAsDone(requestId) {
        if (confirm('Mark this Good Moral request as completed?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/good-moral/${requestId}/mark-done`;
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PATCH';
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    }

    function markSLAsDone(requestId) {
        if (confirm('Mark this Safe Loan request as completed?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/safe-loan/${requestId}/mark-done`;
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PATCH';
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Print modal functionality
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('printModal');
        const iframe = document.getElementById('printFrame');
        const closeBtn = document.getElementById('printModalClose');
        const printBtn = document.getElementById('printModalPrint');

        function openModal(url) {
            if (!modal || !iframe) return;
            iframe.src = url;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            if (!modal || !iframe) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            iframe.src = 'about:blank';
        }

        // View buttons
        document.querySelectorAll('a.open-print').forEach(function(a) {
            a.addEventListener('click', function(e) {
                e.preventDefault();
                const url = a.getAttribute('href');
                if (url) openModal(url);
            });
        });

        closeBtn && closeBtn.addEventListener('click', closeModal);
        modal && modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (modal && !modal.classList.contains('hidden')) closeModal();
                const orModal = document.getElementById('orModal');
                if (orModal && !orModal.classList.contains('hidden')) closeORModal();
                const gmStatusModal = document.getElementById('gmStatusModal');
                if (gmStatusModal && !gmStatusModal.classList.contains('hidden')) closeGMStatusModal();
                const slStatusModal = document.getElementById('slStatusModal');
                if (slStatusModal && !slStatusModal.classList.contains('hidden')) closeSLStatusModal();
            }
        });
        printBtn && printBtn.addEventListener('click', function() {
            if (iframe && iframe.contentWindow) {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            }
        });

        // Good Moral status form loading state
        const gmStatusForm = document.getElementById('gmStatusForm');
        if (gmStatusForm) {
            gmStatusForm.addEventListener('submit', function() {
                const btn = document.getElementById('gmStatusUpdateBtn');
                const spinner = document.getElementById('gmStatusLoadingSpinner');
                const btnText = document.getElementById('gmStatusBtnText');

                if (btn && spinner && btnText) {
                    btn.disabled = true;
                    spinner.classList.remove('hidden');
                    btnText.textContent = 'Updating...';
                }
            });
        }

        // Safe Loan status form loading state
        const slStatusForm = document.getElementById('slStatusForm');
        if (slStatusForm) {
            slStatusForm.addEventListener('submit', function() {
                const btn = document.getElementById('slStatusUpdateBtn');
                const spinner = document.getElementById('slStatusLoadingSpinner');
                const btnText = document.getElementById('slStatusBtnText');

                if (btn && spinner && btnText) {
                    btn.disabled = true;
                    spinner.classList.remove('hidden');
                    btnText.textContent = 'Updating...';
                }
            });
        }
    });
</script>
@endsection