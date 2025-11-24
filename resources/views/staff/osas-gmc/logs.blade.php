@extends('layouts.app')

@section('title', 'Logs')

@section('sidebar')
  @include('partials.sidebar-osas-gmc')
@endsection

@section('content')
  <!-- Breadcrumb -->
  <nav class="text-sm text-gray-600 flex items-center mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
      <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z"/>
    </svg>
    <a href="/staff/dashboard" class="hover:text-red-800">Dashboard</a>
    <span class="mx-2 text-gray-500">></span>
    <a href="{{ route('staff.audit.index') }}" class="text-blue-600 hover">Logs</a>
  </nav>

  <div class="mb-6">
    <h2 class="text-2xl font-semibold">Audit Logs</h2>
    <p class="text-sm text-gray-600">Review all actions across requests and grievances.</p>
  </div>

  <!-- Tabs -->
  <div class="border-b border-gray-200">
    <nav class="-mb-px flex gap-4" aria-label="Tabs">
      <a href="{{ route('staff.audit.index') }}"
         class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ ($type ?? '') === '' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
        All
      </a>
      <a href="{{ route('staff.audit.index', ['type' => 'requests']) }}"
         class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ ($type ?? '') === 'requests' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
        Requests
      </a>
      <a href="{{ route('staff.audit.index', ['type' => 'grievances']) }}"
         class="whitespace-nowrap py-3 px-4 border-b-2 text-sm font-medium {{ ($type ?? '') === 'grievances' ? 'border-red-700 text-red-800' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
        Grievances
      </a>
    </nav>
  </div>

  <!-- Filters block (top, after tabs) -->
  <div class="mt-3 mb-4">
    <form method="GET" action="{{ route('staff.audit.index') }}" class="flex flex-wrap items-center gap-2">
      <input type="hidden" name="type" value="{{ $type ?? '' }}" />
      <select name="action" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
        <option value="">All actions</option>
        @php
          $isAdmin = auth()->user() && (auth()->user()->role ?? null) === 'admin';
          $actions = $isAdmin
            ? ['created','checked','paid','processed','printed','released','canceled','status_changed','updated','deleted','login','logout','login_failed','login_rate_limited']
            : ['checked','paid','processed','printed','released','canceled','status_changed','updated','deleted','login','logout','login_failed','login_rate_limited'];
        @endphp
        @foreach ($actions as $a)
          <option value="{{ $a }}" @selected(request('action')===$a)>{{ $a }}</option>
        @endforeach
      </select>
      <input type="text" name="user_id" value="{{ request('user_id') }}" placeholder="User ID" class="px-3 py-2 border border-gray-300 rounded-lg text-sm w-28" />
      <input type="text" name="staff_id" value="{{ request('staff_id') }}" placeholder="Staff ID" class="px-3 py-2 border border-gray-300 rounded-lg text-sm w-28" />
      <input type="date" name="from" value="{{ request('from') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm" />
      <input type="date" name="to" value="{{ request('to') }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm" />
      <button class="px-4 py-2 bg-red-800 text-white rounded-lg text-sm hover:bg-red-700">Filter</button>
    </form>
  </div>

  <div class="bg-white rounded-2xl shadow-md overflow-hidden">
    <table class="w-full text-sm text-left text-gray-700 border border-gray-200">
      <thead class="bg-gray-50 text-gray-700 text-xs uppercase">
        <tr>
          <th class="px-6 py-3">When</th>
          <th class="px-6 py-3">Type</th>
          <th class="px-6 py-3">Action</th>
          <th class="px-6 py-3">User</th>
          <th class="px-6 py-3">Staff</th>
          <th class="px-6 py-3">IP</th>
          <th class="px-6 py-3">Details</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($logs as $log)
          <tr class="{{ $loop->odd ? 'bg-[#F9FAFB]' : 'bg-white' }}">
            <td class="px-6 py-3 whitespace-nowrap">{{ $log->created_at }}</td>
            <td class="px-6 py-3">{{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</td>
            <td class="px-6 py-3">{{ $log->action }}</td>
            <td class="px-6 py-3">{{ $log->user_id ?? '—' }}</td>
            <td class="px-6 py-3">{{ $log->staff_id ?? '—' }}</td>
            <td class="px-6 py-3">{{ $log->ip_address ?? '—' }}</td>
            <td class="px-6 py-3 text-xs">
              @if($log->old_values || $log->new_values)
                <details>
                  <summary class="cursor-pointer text-blue-700">view</summary>
                  <div class="grid grid-cols-2 gap-4 mt-2">
                    <pre class="bg-gray-50 p-2 rounded border whitespace-pre-wrap">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                    <pre class="bg-gray-50 p-2 rounded border whitespace-pre-wrap">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                  </div>
                </details>
              @else
                —
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="px-6 py-6 text-center text-gray-500">No audit logs found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <!-- Pagination -->
    {{ $logs->links('vendor.pagination.tailwind') }}
  </div>
@endsection
