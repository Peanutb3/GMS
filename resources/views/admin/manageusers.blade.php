@extends('layouts.app')

@section('title', 'Manage Staff')

@section('sidebar')
    @include('partials.sidebar-admin')
@endsection

@section('content')
  <div class="max-w-4l mx-auto px-1 overflow-x-hidden">

    <!-- Breadcrumbs -->
  <div class="px-5 mb-6">
    <nav class="text-sm text-gray-600 flex items-center pb-4">
      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" 
           viewBox="0 0 30 30" class="w-6 h-6 mr-1">
        <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z"/>
      </svg>
      <a href="/staff/dashboard" class="hover:text-red-800">Dashboard</a>
      <span class="mx-3 text-gray-500">></span>
      <a href="/staff/manage-staff" class="text-blue-600 hover">Manage Staff</a>
    </nav>

	<h2 class="text-2xl font-bold mb-4">Staff Accounts</h2>

	<div class="bg-white rounded-xl shadow p-6 max-w-5xl mx-auto">
		<div class="flex justify-between items-center mb-4">
			<div></div>
			<div class="relative w-64">
				<input type="text" class="border border-gray-300 rounded-lg py-2 px-4 w-full focus:outline-none" placeholder="Search" />
				<span class="absolute right-3 top-2.5 text-gray-400">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
				</span>
			</div>
		</div>
		<div class="overflow-x-auto">
			<table class="min-w-full text-sm text-left">
				<thead class="bg-gray-50">
					<tr>
						<th class="px-4 py-3 font-semibold text-blue-900">ID Number</th>
						<th class="px-4 py-3 font-semibold text-blue-900">Name</th>
						<th class="px-4 py-3 font-semibold text-blue-900">Position</th>
						<th class="px-4 py-3 font-semibold text-blue-900">Email</th>
						<th class="px-4 py-3 font-semibold text-blue-900">Status</th>
						<th class="px-4 py-3 font-semibold text-blue-900">Actions</th>
					</tr>
				</thead>
				<tbody>
					<!-- Example row, repeat for each staff -->
					<tr class="bg-white border-b">
						<td class="px-4 py-3"><input type="checkbox" class="form-checkbox"></td>
						<td class="px-4 py-3">Maria D. Reyes</td>
						<td class="px-4 py-3">OSAS Coordinator</td>
						<td class="px-4 py-3">m.reyes@usep.edu.ph</td>
						<td class="px-4 py-3">
							<span class="inline-flex items-center text-green-600">
								<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
								Active
							</span>
						</td>
						<td class="px-4 py-3 space-x-2">
							<button class="bg-green-100 text-green-700 rounded p-1 hover:bg-green-200" title="Edit">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0L9 13z"/></svg>
							</button>
							<button class="bg-red-100 text-red-700 rounded p-1 hover:bg-red-200" title="Delete">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
							</button>
						</td>
					</tr>
					<!-- Add more rows as needed -->
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
