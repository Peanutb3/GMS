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
        <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z" />
    </svg>
    <a href="{{ route('osas-gmc.dashboard') }}" class="hover:text-red-800">Dashboard</a>
    <span class="mx-2 text-gray-500">></span>
    <span class="text-blue-600">Grievances</span>
</nav>

<!-- Search Bar (no tabs - history removed) -->
<div class="border-b border-gray-200 mb-4">
    <div class="flex items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold mb-1">Grievances Management</h2>
            <p class="text-sm text-gray-600 mb-3">Track and manage student grievance cases</p>
        </div>
        <form method="GET" action="{{ route('osas-gmc.grievances') }}" class="flex items-center space-x-2 pb-2">
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
            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200 hover:bg-gray-100">
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
<div id="toast-stack" class="fixed top-4 right-4 space-y-2 z-50"></div>
@push('scripts')
<script>
    // Kebab menu toggle
    function toggleKebab(event, menuId) {
        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        const menu = document.getElementById(menuId);
        if (!menu) return false;

        const allMenus = document.querySelectorAll('[id^="grv-"]');
        allMenus.forEach(m => {
            if (m.id !== menuId) m.classList.add('hidden');
        });

        menu.classList.toggle('hidden');
        return false;
    }

    // Close kebab menus on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('[id^="grv-"]') && !e.target.closest('button[onclick*="toggleKebab"]')) {
            document.querySelectorAll('[id^="grv-"]').forEach(menu => menu.classList.add('hidden'));
        }
    });

    const token = '{{ csrf_token() }}';
    const stack = document.getElementById('toast-stack');

    function toast(msg, type = 'info') {
        const el = document.createElement('div');
        el.className = 'px-4 py-2 rounded shadow text-sm text-white flex items-center gap-2 ' + (type === 'success' ? 'bg-green-600' : 'bg-red-600');
        el.textContent = msg;
        stack.appendChild(el);
        setTimeout(() => {
            el.classList.add('opacity-0', 'transition');
            setTimeout(() => el.remove(), 400);
        }, 2500);
    }

    function markAsDone(id) {
        if (!confirm('Mark this grievance as done?')) return;

        fetch(`{{ url('staff/grievances') }}/${id}/resolve`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (!data.ok) throw new Error('Failed');
                toast('Grievance marked as done', 'success');
                setTimeout(() => location.reload(), 1000);
            })
            .catch(() => toast('Action failed', 'error'));
    }

    function deleteGrievance(id) {
        if (!confirm('Delete this grievance?')) return;

        fetch(`{{ url('staff/grievances') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (!data.ok) throw new Error('Failed');
                toast('Grievance deleted', 'success');
                setTimeout(() => location.reload(), 1000);
            })
            .catch(() => toast('Action failed', 'error'));
    }
</script>
@endpush
@endsection