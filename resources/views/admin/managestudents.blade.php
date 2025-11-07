@extends('layouts.app')

@section('title', 'Manage Students')

@section('sidebar')
	@include('partials.sidebar-admin')
@endsection

@section('content')
<div class="flex flex-col min-h-screen">
	<!-- Breadcrumb -->
	<div class="px-3 -mt-4 mb-4">
		<nav class="text-sm text-gray-600 flex items-center space-x-1">
			<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-4 h-4 mr-1">
				<path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z"/>
			</svg>
			<a href="{{ route('admin.dashboard') }}" class="hover:text-red-800">Dashboard</a>
			<span class="mx-1 text-gray-500">></span>
			<a href="{{ route('admin.manage-staff') }}" class="text-blue-600 hover:underline">Manage Students</a>
		</nav>
	</div>

	<div class="flex-1 max-w-6xl mx-auto px-1 overflow-x-hidden w-full">
		<div class="bg-white shadow-md rounded-lg p-6">
			<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
				<h2 class="text-2xl font-bold text-gray-800 mb-2 md:mb-0">Student Accounts</h2>
				<div class="flex justify-end">
					<input type="text" placeholder="Search" class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
				</div>
			</div>
			<div class="overflow-x-auto">
				<table class="min-w-full text-sm">
					<thead class="bg-gray-50 text-gray-700">
						<tr>
							<th class="px-5 py-3 text-left font-semibold"><input type="checkbox" /></th>
							<th class="px-5 py-3 text-left font-semibold">ID Number</th>
							<th class="px-5 py-3 text-left font-semibold">Name</th>
							<th class="px-5 py-3 text-left font-semibold">Program & Year</th>
							<th class="px-5 py-3 text-left font-semibold">Email</th>
							<th class="px-5 py-3 text-left font-semibold">Status</th>
							<th class="px-5 py-3 text-left font-semibold">Actions</th>
						</tr>
					</thead>
					<tbody class="text-gray-700">
						<tr class="border-b last:border-b-0">
							<td class="px-5 py-3"><input type="checkbox" /></td>
							<td class="px-5 py-3">2022-00270</td>
							<td class="px-5 py-3">Rona Arbe B. Limbago</td>
							<td class="px-5 py-3">BSIT - 4A</td>
							<td class="px-5 py-3">rablimbago00270@usep.edu.ph</td>
							<td class="px-5 py-3">Active</td>
							<td class="px-5 py-3 flex gap-2">
								<a href="{{ route('admin.students.edit', ['student' => '2022-00270']) }}" class="text-green-600 hover:text-green-800" title="Edit">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6" />
									</svg>
								</a>
								<form action="{{ route('admin.students.destroy', ['student' => '2022-00270']) }}" method="POST" style="display:inline;">
									@csrf
									@method('DELETE')
									<button type="submit" class="text-red-600 hover:text-red-800" title="Delete" onclick="return confirm('Are you sure you want to delete this student?');">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
										</svg>
									</button>
								</form>
							</td>
						</tr>
						<tr class="border-b last:border-b-0">
							<td class="px-5 py-3"><input type="checkbox" /></td>
							<td class="px-5 py-3">2022-00002</td>
							<td class="px-5 py-3">John Michael Santos</td>
							<td class="px-5 py-3">BSIT - 4B</td>
							<td class="px-5 py-3">jsantos@usep.edu.ph</td>
                            <td class="px-5 py-3">Active</td>
							<td class="px-5 py-3 flex gap-2">
								<a href="{{ route('admin.students.edit', ['student' => '2022-00002']) }}" class="text-green-600 hover:text-green-800" title="Edit">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6" />
									</svg>
								</a>
								<form action="{{ route('admin.students.destroy', ['student' => '2022-00002']) }}" method="POST" style="display:inline;">
									@csrf
									@method('DELETE')
									<button type="submit" class="text-red-600 hover:text-red-800" title="Delete" onclick="return confirm('Are you sure you want to delete this student?');">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
										</svg>
									</button>
								</form>
							</td>
						</tr>
						<tr class="border-b last:border-b-0">
							<td class="px-5 py-3"><input type="checkbox" /></td>
							<td class="px-5 py-3">2022-00003</td>
							<td class="px-5 py-3">Camille P. Vergara</td>
							<td class="px-5 py-3">BSHM - 4A</td>
							<td class="px-5 py-3">jsantos@usep.edu.ph</td>
                            <td class="px-5 py-3">Active</td>
							<td class="px-5 py-3 flex gap-2">
								<a href="{{ route('admin.students.edit', ['id' => '2022-00003']) }}" class="text-green-600 hover:text-green-800" title="Edit">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2l-6 6m-2 2h6" />
									</svg>
								</a>
								<form action="{{ route('admin.students.destroy', ['id' => '2022-00003']) }}" method="POST" style="display:inline;">
									@csrf
									@method('DELETE')
									<button type="submit" class="text-red-600 hover:text-red-800" title="Delete" onclick="return confirm('Are you sure you want to delete this student?');">
										<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
										</svg>
									</button>
								</form>
							</td>
						</tr>
				
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection