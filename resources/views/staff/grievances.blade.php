@extends('layouts.app')

@section('title', 'Grievances')

@section('sidebar')
    @include('partials.sidebar-staff')
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-5 py-6">

  <!-- Breadcrumb -->
  <nav class="text-sm text-gray-600 flex items-center mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
      <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z"/>
    </svg>
    <a href="/staff/dashboard" class="hover:text-red-800">Dashboard</a>
    <span class="mx-2 text-gray-500">></span>
    <a href="/staff/file-grievances" class="text-blue-600 hover">Grievances</a>
  </nav>

  <!-- Header: Title + Search -->
    <div class="flex justify-between items-center mb-4 mt-8">
    <h1 class="text-xl font-semibold text-gray-800">All Grievances</h1>

  <form method="GET" action="{{ route('staff.grievances') }}" class="flex items-center space-x-2">
  <!-- Search Box -->
  <div class="relative">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
      class="pl-10 pr-3 py-2 border border-gray-300 rounded-lg 
           focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none text-sm" />
    <span class="absolute left-3 top-2.5 text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
        viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
          d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
      </svg>
    </span>
  </div>

  <!-- Filter by Status -->
  <select name="status" onchange="this.form.submit()"
    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-800">
    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
  </select>

  <button type="submit" class="bg-red-800 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-700">
    Search
  </button>
  </form>
    </div>

  <!-- Table -->
  <div class="bg-white rounded-2xl shadow-md overflow-hidden">
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
        <td class="px-5 py-3">{{ $g->name }}</td>
        <td class="px-5 py-3">{{ $g->program }}</td>
        <td class="px-5 py-3 capitalize">{{ str_replace('_', ' ', $g->grievance) }}</td>
        <td class="px-5 py-3">{{ $g->created_at->format('Y-m-d') }}</td>
        <td class="px-5 py-3">
            <x-status-badge :status="$g->status" />
        </td>
        <td class="px-5 py-3">{{ $g->filed_by }}</td>
        <td class="px-5 py-3">
            <div class="flex space-x-2">
            <a href="#" class="text-blue-600 hover:text-blue-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414
                        a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </a>
            <form method="POST" action="#" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800"
                        onclick="return confirm('Are you sure you want to delete this grievance?')">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7
                        m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                </button>
            </form>
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
</div>

  <!-- Pagination -->
  <div class="mt-4 px-4">
    @if(method_exists($grievances, 'links'))
      <div class="bg-white p-4 rounded-lg">
        {{ $grievances->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
