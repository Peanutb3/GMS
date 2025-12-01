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
  <h2 class="text-2xl font-semibold">Good Moral & Safe Loan Requests</h2>
  <p class="text-sm text-gray-600">View and manage incoming requests.</p>
</div>

<!-- Tabs -->
<div class="border-b border-gray-200 mb-4">
  <div class="flex items-end justify-between gap-4">
    <nav class="-mb-px flex gap-4" aria-label="Tabs">
      <a href="{{ route('osas-gmc.requests', ['tab' => 'goodmoral']) }}"
        class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ ($tab ?? 'goodmoral') === 'goodmoral' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
        Good Moral
      </a>
      <a href="{{ route('osas-gmc.requests', ['tab' => 'safeloan']) }}"
        class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ ($tab ?? 'goodmoral') === 'safeloan' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
        Safe Loan
      </a>
      <a href="{{ route('osas-gmc.requests', ['tab' => 'history']) }}"
        class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ ($tab ?? 'goodmoral') === 'history' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
        History
      </a>
    </nav>
    <form method="GET" action="{{ route('osas-gmc.requests') }}" class="flex items-center space-x-2 pb-2">
      <input type="hidden" name="tab" value="{{ $tab }}" />
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
$gm = ($goodMorals ?? collect());
$sl = ($safeLoans ?? collect());
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

@if(($tab ?? 'goodmoral') === 'history')
{{-- History Tab - Completed Requests --}}
<div class="relative overflow-x-auto bg-white shadow-sm rounded-lg border border-gray-200 pb-40">
  <table class="w-full text-sm text-left text-gray-700">
    <thead class="bg-gray-50 border-b border-gray-200">
      <tr>
        <th scope="col" class="px-6 py-3 font-medium">Ref No</th>
        <th scope="col" class="px-6 py-3 font-medium">Name</th>
        <th scope="col" class="px-6 py-3 font-medium">Type</th>
        <th scope="col" class="px-6 py-3 font-medium">OR Number</th>
        <th scope="col" class="px-6 py-3 font-medium">Completed Date</th>
        <th scope="col" class="px-6 py-3 font-medium text-right">Action</th>
      </tr>
    </thead>
    <tbody>
      @php
      $completedGM = $goodMorals->filter(fn($r) => $r->status === 'completed');
      $completedSL = $safeLoans->filter(fn($r) => $r->status === 'completed');
      $allCompleted = $completedGM->merge($completedSL)->sortByDesc('completed_at');
      @endphp
      @forelse($allCompleted as $r)
      <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $r->reference_no ?? '—' }}</th>
        <td class="px-6 py-4">{{ ($r->last_name ?? '') }}, {{ ($r->first_name ?? '') }}</td>
        <td class="px-6 py-4">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ isset($r->loan_amount) ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
            {{ isset($r->loan_amount) ? 'Safe Loan' : 'Good Moral' }}
          </span>
        </td>
        <td class="px-6 py-4">{{ $r->or_number ?? '—' }}</td>
        <td class="px-6 py-4">{{ $r->completed_at ? \Carbon\Carbon::parse($r->completed_at)->format('M d, Y h:i A') : '—' }}</td>
        <td class="px-6 py-4 text-right">
          @if(!isset($r->loan_amount))
          <a href="{{ route('good-moral.certificate', $r->id) }}" target="_blank" class="font-medium text-red-700 hover:underline">View Certificate</a>
          @else
          <a href="{{ route('safe-loan.print', $r->id) }}" target="_blank" class="font-medium text-red-700 hover:underline">View Document</a>
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No completed requests found.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@elseif(($tab ?? 'goodmoral') === 'goodmoral')
<div class="relative overflow-x-auto bg-white shadow-sm rounded-lg border border-gray-200 pb-40">
  <table class="w-full text-sm text-left text-gray-700">
    <thead class="bg-gray-50 border-b border-gray-200">
      <tr>
        <th scope="col" class="px-6 py-3 font-medium">Ref No</th>
        <th scope="col" class="px-6 py-3 font-medium">Name</th>
        <th scope="col" class="px-6 py-3 font-medium">Program/Year</th>
        <th scope="col" class="px-6 py-3 font-medium">Copies</th>
        <th scope="col" class="px-6 py-3 font-medium">Purpose</th>
        <th scope="col" class="px-6 py-3 font-medium">Status</th>
        <th scope="col" class="px-6 py-3 font-medium text-right">Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($gm as $r)
      <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 hover:bg-gray-100 cursor-pointer" data-href="{{ route('good-moral.print', $r->id) }}">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $r->reference_no ?? '—' }}</th>
        <td class="px-6 py-4">{{ ($r->last_name ?? '') }}, {{ ($r->first_name ?? '') }} {{ $r->middle_name ? substr($r->middle_name,0,1).'.' : '' }}</td>
        <td class="px-6 py-4">{{ $r->program_year ?? '—' }}</td>
        <td class="px-6 py-4">{{ $r->copies ?? 1 }}</td>
        <td class="px-6 py-4 max-w-xs truncate" title="{{ $r->purpose }}">{{ $r->purpose }}</td>
        <td class="px-6 py-4">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $r->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
            {{ ucfirst($r->status ?? 'pending') }}
          </span>
        </td>
        <td class="px-6 py-4 text-right">
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
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" class="px-6 py-8 text-center text-gray-500">No good moral requests found.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@else
<div class="relative overflow-x-auto bg-white shadow-sm rounded-lg border border-gray-200 pb-40">
  <table class="w-full text-sm text-left text-gray-700">
    <thead class="bg-gray-50 border-b border-gray-200">
      <tr>
        <th scope="col" class="px-6 py-3 font-medium">Ref No</th>
        <th scope="col" class="px-6 py-3 font-medium">Name</th>
        <th scope="col" class="px-6 py-3 font-medium">Loan Amount</th>
        <th scope="col" class="px-6 py-3 font-medium">Purpose</th>
        <th scope="col" class="px-6 py-3 font-medium">Status</th>
        <th scope="col" class="px-6 py-3 font-medium text-right">Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($sl as $r)
      <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 hover:bg-gray-100 cursor-pointer" data-href="{{ route('safe-loan.print', $r->id) }}">
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $r->reference_no ?? '—' }}</th>
        <td class="px-6 py-4">{{ ($r->last_name ?? '') }}, {{ ($r->first_name ?? '') }} {{ $r->middle_name ? substr($r->middle_name,0,1).'.' : '' }}</td>
        <td class="px-6 py-4">{{ $r->loan_amount ? '₱'.number_format($r->loan_amount,2) : '—' }}</td>
        <td class="px-6 py-4 max-w-xs truncate" title="{{ $r->purpose }}">{{ $r->purpose }}</td>
        <td class="px-6 py-4">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $r->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
            {{ ucfirst($r->status ?? 'pending') }}
          </span>
        </td>
        <td class="px-6 py-4 text-right">
          <div class="flex items-center gap-3 justify-end">
            <form method="POST" action="{{ route('staff.requests.check', ['type'=>'safeloan', 'id' => $r->id]) }}" onsubmit="event.stopPropagation();" class="inline">
              @csrf
              @method('PATCH')
              <button type="submit" title="Check" class="text-green-700 hover:text-green-900">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                  <path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z" />
                </svg>
              </button>
            </form>
            <a href="{{ route('safe-loan.print', $r->id) }}" class="open-print font-medium text-red-700 hover:underline" onclick="event.preventDefault(); event.stopPropagation();" title="View">
              View
            </a>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No safe loan requests found.</td>
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

    // Row click opens modal
    document.querySelectorAll('tr[data-href]').forEach(function(row) {
      row.addEventListener('click', function(e) {
        const tag = e.target.tagName.toLowerCase();
        if (['a', 'button', 'input', 'svg', 'path'].includes(tag)) return;
        const url = this.getAttribute('data-href');
        if (url) openModal(url);
      });
    });

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
      }
    });
    printBtn && printBtn.addEventListener('click', function() {
      if (iframe && iframe.contentWindow) {
        iframe.contentWindow.focus();
        iframe.contentWindow.print();
      }
    });
  });
</script>
@endsection