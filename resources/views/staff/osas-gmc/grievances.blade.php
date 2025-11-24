@extends('layouts.app')

@section('title', 'Grievances')

@section('sidebar')
    @include('partials.sidebar-osas-gmc')
@endsection

@section('content')
<!-- <div class="max-w-6xl mx-auto px-5 py-6"> -->

  <!-- Breadcrumb -->
  <nav class="text-sm text-gray-600 flex items-center mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
      <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z"/>
    </svg>
    <a href="/staff/dashboard" class="hover:text-red-800">Dashboard</a>
    <span class="mx-2 text-gray-500">></span>
    <a href="/staff/file-grievances" class="text-blue-600 hover">Grievances</a>
  </nav>

  <!-- Header -->
  <div class="mb-6">
    <h2 class="text-2xl font-semibold">Grievances Management</h2>
      <p class="text-sm text-gray-600">Track and manage student grievance cases</p>
        </div>

      <!-- @if(($tab ?? 'active')==='active')
      <div class="flex items-center gap-4">
        <div class="text-right">
          <div class="text-2xl font-bold text-gray-900">{{ $grievances->total() ?? 0 }}</div>
          <div class="text-sm text-gray-500">Active Cases</div>
        </div>
      </div>
      @endif
    </div> -->

  <!-- Tabs + Search (match Requests styling) -->
  <div class="border-b border-gray-200 mb-4">
    <div class="flex items-end justify-between gap-4">
      <nav class="-mb-px flex gap-4" aria-label="Tabs">
        <a href="{{ route('staff.grievances', array_merge(request()->except('page'), ['tab'=>'active'])) }}"
           class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ ($tab ?? 'active')==='active' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">Active</a>
        <a href="{{ route('staff.grievances', array_merge(request()->except('page'), ['tab'=>'history'])) }}"
           class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ ($tab ?? 'active')==='history' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">History</a>
      </nav>
      <form method="GET" action="{{ route('staff.grievances') }}" class="flex items-center space-x-2 pb-2">
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

  <!-- Table -->
  <div class="bg-white rounded-2xl shadow-md overflow-hidden">
  @if(($tab ?? 'active')==='history')
  <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
    <thead class="bg-white text-blue-900 text-xs uppercase">
      <tr>
        <th class="px-6 py-3 font-semibold">Case ID</th>
        <th class="px-6 py-3 font-semibold">Name</th>
        <th class="px-6 py-3 font-semibold">Program</th>
        <th class="px-6 py-3 font-semibold">Type</th>
        <th class="px-6 py-3 font-semibold">Action</th>
        <th class="px-6 py-3 font-semibold">Date</th>
      </tr>
    </thead>
    <tbody>
    @forelse(($historyItems ?? collect()) as $h)
      <tr class="{{ $loop->odd ? 'bg-[#EDEBEB]' : 'bg-white' }}">
        <td class="px-5 py-3">{{ $h['case_id'] }}</td>
        <td class="px-5 py-3">{{ $h['name'] }}</td>
        <td class="px-5 py-3">{{ $h['program'] }}</td>
        <td class="px-5 py-3 capitalize">{{ str_replace('_',' ',$h['type']) }}</td>
        <td class="px-5 py-3 capitalize">{{ $h['action'] }}</td>
        <td class="px-5 py-3">{{ $h['date'] }}</td>
      </tr>
    @empty
      <tr>
        <td colspan="6" class="px-5 py-4 text-center text-gray-500">No history found.</td>
      </tr>
    @endforelse
    </tbody>
  </table>
  @else
  <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
    <thead class="bg-white text-blue-900 text-xs uppercase">
      <tr>
        <th class="px-6 py-3 font-semibold">Case ID</th>
        <th class="px-6 py-3 font-semibold">Name</th>
        <th class="px-6 py-3 font-semibold">Program</th>
        <th class="px-6 py-3 font-semibold">Type</th>
        <th class="px-6 py-3 font-semibold">Date Filed</th>
        <th class="px-6 py-3 font-semibold">Status</th>
        <th class="px-6 py-3 font-semibold">Filed By</th>
        <th class="px-6 py-3 font-semibold text-center">Actions</th>
      </tr>
    </thead>

    <tbody>
    @forelse ($grievances as $g)
      <tr class="{{ $loop->odd ? 'bg-[#EDEBEB]' : 'bg-white' }} hover:bg-gray-100 transition">
        <td class="px-5 py-3">{{ $g->case_id }}</td>
        <td class="px-5 py-3">{{ optional($g->student)->first_name ? optional($g->student)->first_name . ' ' . optional($g->student)->last_name : ($g->name_snapshot ?? $g->name ?? '-') }}</td>
        <td class="px-5 py-3">{{ optional($g->student)->program ?? ($g->program_snapshot ?? $g->program ?? '-') }}</td>
        <td class="px-5 py-3 capitalize">{{ str_replace('_', ' ', $g->grievance) }}</td>
        <td class="px-5 py-3">{{ $g->created_at->format('Y-m-d') }}</td>
        <td class="px-5 py-3">
          <form method="POST" action="{{ route('staff.grievances.status', $g) }}" class="relative inline-flex items-center gap-1 align-middle">
            @csrf
            @method('PATCH')
            <div class="flex items-center">
              @php
                $statusClass = match($g->status) {
                  'pending' => 'bg-red-50 text-red-700 inset-ring inset-ring-red-600/10',
                  'in_progress' => 'bg-yellow-50 text-yellow-800 inset-ring inset-ring-yellow-600/20',
                  'resolved' => 'bg-green-50 text-green-700 inset-ring inset-ring-green-600/20',
                  default => 'bg-gray-50 text-gray-600 inset-ring inset-ring-gray-500/10'
                };
              @endphp
              <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium select-none {{ $statusClass }}">
                {{ ucfirst(str_replace('_',' ',$g->status)) }}
                <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8l4 4 4-4" />
                </svg>
              </span>
            </div>
            <select name="status" title="Change status" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="this.form.submit()">
              <option value="pending" @selected($g->status==='pending')>Pending</option>
              <option value="in_progress" @selected($g->status==='in_progress')>In Progress</option>
              <option value="resolved" @selected($g->status==='resolved')>Resolved</option>
            </select>
          </form>
        </td>
  <td class="px-5 py-3">{{ $g->filed_by_display }}</td>
        <td class="px-5 py-3">
          <div class="flex items-center gap-3 justify-center" data-row="{{ $g->id }}">
            @if($g->status !== 'resolved')
            <button type="button" data-action="resolve" data-id="{{ $g->id }}" title="Mark Resolved" class="text-green-600 hover:text-green-800">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </button>
            @endif
            <button type="button" data-action="delete" data-id="{{ $g->id }}" title="Delete" class="text-red-600 hover:text-red-800">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </button>
          </div>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="8" class="px-5 py-4 text-center text-gray-500">No grievances found.</td>
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
<div id="toast-stack" class="fixed top-4 right-4 space-y-2 z-50"></div>
@push('scripts')
<script>
(function(){
  const token = '{{ csrf_token() }}';
  const stack = document.getElementById('toast-stack');
  function toast(msg,type='info'){ const el=document.createElement('div'); el.className='px-4 py-2 rounded shadow text-sm text-white flex items-center gap-2 ' + (type==='success'?'bg-green-600':'bg-red-600'); el.textContent=msg; stack.appendChild(el); setTimeout(()=>{el.classList.add('opacity-0','transition'); setTimeout(()=>el.remove(),400);},2500);} 
  function handle(action,id){
    let url, method='PATCH';
  if(action==='resolve') url = "{{ url('staff/grievances') }}"+'/'+id+'/resolve';
  if(action==='delete'){ url="{{ url('staff/grievances') }}"+'/'+id; method='DELETE'; }
    fetch(url,{method:method, headers:{'X-CSRF-TOKEN':token,'Accept':'application/json'}})
      .then(r=>r.json())
      .then(data=>{
        if(!data.ok) throw new Error('Failed');
        const rowBtn = document.querySelector('[data-row="'+id+'"]');
        if(rowBtn){ const tr = rowBtn.closest('tr'); if(tr) tr.remove(); }
        toast(action==='delete'?'Grievance deleted':'Grievance resolved','success');
      })
      .catch(()=> toast('Action failed','error'));
  }
  document.addEventListener('click',e=>{
    const btn = e.target.closest('button[data-action]');
    if(!btn) return;
    const action = btn.getAttribute('data-action');
    const id = btn.getAttribute('data-id');
    if(action==='delete' && !confirm('Delete this grievance?')) return;
    handle(action,id);
  });
})();
</script>
@endpush
@endsection
