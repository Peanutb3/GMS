@extends('layouts.app')

@section('title', 'OSAS Requests')

@section('sidebar')
    @include('partials.sidebar-staff')
@endsection

@section('content')
  <!-- Breadcrumb -->
  <nav class="text-sm text-gray-600 flex items-center mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
      <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z"/>
    </svg>
    <a href="/staff/dashboard" class="hover:text-red-800">Dashboard</a>
    <span class="mx-2 text-gray-500">></span>
    <a href="{{ route('staff.requests') }}" class="text-blue-600 hover">Requests</a>
  </nav>

  <div class="mb-6">
    <h2 class="text-2xl font-semibold">Good Moral & Safe Loan Requests</h2>
    <p class="text-sm text-gray-600">View and manage incoming requests.</p>
  </div>

  <!-- Tabs -->
  <div class="border-b border-gray-200 mb-4">
    <div class="flex items-end justify-between gap-4">
      <nav class="-mb-px flex gap-4" aria-label="Tabs">
        <a href="{{ route('staff.requests', ['tab' => 'goodmoral']) }}"
           class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ ($tab ?? 'goodmoral') === 'goodmoral' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
          Good Moral
        </a>
        <a href="{{ route('staff.requests', ['tab' => 'safeloan']) }}"
           class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ ($tab ?? 'goodmoral') === 'safeloan' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
          Safe Loan
        </a>
      </nav>
      <form method="GET" action="{{ route('staff.requests') }}" class="flex items-center space-x-2 pb-2">
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

  @if(($tab ?? 'goodmoral') === 'goodmoral')
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
      <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
        <thead class="bg-gray-50 text-gray-700 text-xs uppercase">
          <tr>
            <th class="px-6 py-3">Ref No</th>
            <th class="px-6 py-3">Name</th>
            <th class="px-6 py-3">Program/Year</th>
            <th class="px-6 py-3">Copies</th>
            <th class="px-6 py-3">Purpose</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3 text-right">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($gm as $r)
            <tr class="{{ $loop->odd ? 'bg-[#F9FAFB]' : 'bg-white' }} hover:bg-gray-100 cursor-pointer" data-href="{{ route('good-moral.print', $r->id) }}">
              <td class="px-6 py-3">{{ $r->reference_no ?? '—' }}</td>
              <td class="px-6 py-3">{{ ($r->last_name ?? '') }}, {{ ($r->first_name ?? '') }} {{ $r->middle_name ? substr($r->middle_name,0,1).'.' : '' }}</td>
              <td class="px-6 py-3">{{ $r->program_year ?? '—' }}</td>
              <td class="px-6 py-3">{{ $r->copies ?? 1 }}</td>
              <td class="px-6 py-3 truncate max-w-[240px]" title="{{ $r->purpose }}">{{ $r->purpose }}</td>
              <td class="px-6 py-3">{{ ucfirst($r->status ?? 'pending') }}</td>
              <td class="px-6 py-3 text-right">
                <div class="flex items-center gap-3 justify-end">
                  <form method="POST" action="{{ route('staff.requests.check', ['type'=>'goodmoral', 'id' => $r->id]) }}" onsubmit="event.stopPropagation();" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" title="Check" class="text-green-700 hover:text-green-900">
                      <!-- check icon -->
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/></svg>
                    </button>
                  </form>
                  <a href="{{ route('good-moral.print', $r->id) }}" class="open-print" onclick="event.preventDefault(); event.stopPropagation();" title="View">
                    <!-- view icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-blue-700 hover:text-blue-900"><path d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/></svg>
                  </a>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-6 py-6 text-center text-gray-500">No good moral requests found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  @else
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
      <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
        <thead class="bg-gray-50 text-gray-700 text-xs uppercase">
          <tr>
            <th class="px-6 py-3">Ref No</th>
            <th class="px-6 py-3">Name</th>
            <th class="px-6 py-3">Loan Amount</th>
            <th class="px-6 py-3">Purpose</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3 text-right">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sl as $r)
            <tr class="{{ $loop->odd ? 'bg-[#F9FAFB]' : 'bg-white' }} hover:bg-gray-100 cursor-pointer" data-href="{{ route('safe-loan.print', $r->id) }}">
              <td class="px-6 py-3">{{ $r->reference_no ?? '—' }}</td>
              <td class="px-6 py-3">{{ ($r->last_name ?? '') }}, {{ ($r->first_name ?? '') }} {{ $r->middle_name ? substr($r->middle_name,0,1).'.' : '' }}</td>
              <td class="px-6 py-3">{{ $r->loan_amount ? '₱'.number_format($r->loan_amount,2) : '—' }}</td>
              <td class="px-6 py-3 truncate max-w-[240px]" title="{{ $r->purpose }}">{{ $r->purpose }}</td>
              <td class="px-6 py-3">{{ ucfirst($r->status ?? 'pending') }}</td>
              <td class="px-6 py-3 text-right">
                <div class="flex items-center gap-3 justify-end">
                  <form method="POST" action="{{ route('staff.requests.check', ['type'=>'safeloan', 'id' => $r->id]) }}" onsubmit="event.stopPropagation();" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" title="Check" class="text-green-700 hover:text-green-900">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/></svg>
                    </button>
                  </form>
                  <a href="{{ route('safe-loan.print', $r->id) }}" class="open-print" onclick="event.preventDefault(); event.stopPropagation();" title="View">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-blue-700 hover:text-blue-900"><path d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/></svg>
                  </a>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-6 text-center text-gray-500">No safe loan requests found.</td>
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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const modal = document.getElementById('printModal');
      const iframe = document.getElementById('printFrame');
      const closeBtn = document.getElementById('printModalClose');
      const printBtn = document.getElementById('printModalPrint');

      function openModal(url){
        if (!modal || !iframe) return;
        iframe.src = url;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
      }
      function closeModal(){
        if (!modal || !iframe) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        iframe.src = 'about:blank';
      }

      // Row click opens modal
      document.querySelectorAll('tr[data-href]').forEach(function(row) {
        row.addEventListener('click', function(e) {
          const tag = e.target.tagName.toLowerCase();
          if (['a','button','input','svg','path'].includes(tag)) return;
          const url = this.getAttribute('data-href');
          if (url) openModal(url);
        });
      });

      // View buttons
      document.querySelectorAll('a.open-print').forEach(function(a){
        a.addEventListener('click', function(e){
          e.preventDefault();
          const url = a.getAttribute('href');
          if (url) openModal(url);
        });
      });

      closeBtn && closeBtn.addEventListener('click', closeModal);
      modal && modal.addEventListener('click', function(e){ if (e.target === modal) closeModal(); });
      document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) closeModal(); });
      printBtn && printBtn.addEventListener('click', function(){ if (iframe && iframe.contentWindow) { iframe.contentWindow.focus(); iframe.contentWindow.print(); } });
    });
  </script>
  @endsection
