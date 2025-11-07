@extends('layouts.app')

@section('title', 'Admin Profile')

@section('sidebar')
	@include('partials.sidebar-admin')
@endsection

@section('content')
<div class="flex flex-col min-h-screen">

	<!-- Breadcrumb -->
	<div class="px-3 -mt-4 mb-4">
		<nav class="text-sm text-gray-600 flex items-center space-x-1">
			<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" 
				 viewBox="0 0 24 24" class="w-4 h-4 mr-1">
				<path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z"/>
			</svg>
			<a href="{{ route('admin.dashboard') }}" class="hover:text-red-800">Dashboard</a>
			<span class="mx-1 text-gray-500">></span>
			<a href="{{ route('admin.profile') }}" class="text-blue-600 hover:underline">Profile</a>
		</nav>
	</div>

	<div class="p-6">
	<!-- Top Section -->
	<div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 mb-8">
		<!-- Avatar -->
		<div class="flex-shrink-0">
			<img src="/images/avatar-female.png" alt="Profile Avatar" 
				 class="h-28 w-28 rounded-full border-4 border-red-200 object-cover bg-white shadow-md">
		</div>
		<!-- Info -->
		<div class="flex flex-col justify-center">
			<h2 class="text-2xl font-bold text-gray-800 mb-1">Ivan Rhay Jeferson C. Sapar</h2>
			<p class="text-gray-600 mb-1">OSAS Officer</p>
			<p class="text-sm text-gray-500">
				<span class="font-semibold">Admin ID:</span> <span class="text-black">ADM-001</span> &nbsp;|&nbsp;
				<span class="font-semibold">Email:</span> <span class="text-black">admin@example.com</span>
			</p>
		</div>
	</div>

	<!-- Basic Info Card -->
	<div class="bg-white rounded-xl shadow border border-gray-200 mb-8">
		<div class="p-4 border-b border-gray-200">
			<h3 class="text-lg font-semibold text-gray-800">Basic info</h3>
		</div>
		<div class="p-0">
			<table class="w-full text-sm text-gray-700">
				<tbody>
					<tr class="border-b last:border-b-0">
						<td class="py-3 px-6 font-medium w-1/3">Name</td>
						<td class="py-3 px-6">Ivan Rhay Jeferson C. Sapar</td>
					</tr>
					<tr class="border-b last:border-b-0">
						<td class="py-3 px-6 font-medium">Office</td>
						<td class="py-3 px-6">OSAS</td>
					</tr>
					<tr class="border-b last:border-b-0">
						<td class="py-3 px-6 font-medium">Position</td>
						<td class="py-3 px-6">Administrative Aide VI</td>
					</tr>
					<tr class="border-b last:border-b-0">
						<td class="py-3 px-6 font-medium">Phone</td>
						<td class="py-3 px-6">0991 234 5678</td>
					</tr>
					<tr class="border-b last:border-b-0">
						<td class="py-3 px-6 font-medium">Email</td>
						<td class="py-3 px-6">admin@example.com</td>
					</tr>
					<tr>
						<td class="py-3 px-6 font-medium">Change password</td>
						<td class="py-3 px-6">********</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<!-- System Info Card -->
	<div class="bg-white rounded-xl shadow border border-gray-200">
		<div class="p-4 border-b border-gray-200">
			<h3 class="text-lg font-semibold text-gray-800">System Info</h3>
		</div>
		<div class="p-0">
			<table class="w-full text-sm text-gray-700">
				<tbody>
					<tr class="border-b last:border-b-0">
						<td class="py-3 px-6 font-medium w-1/3">Role</td>
						<td class="py-3 px-6">Admin</td>
					</tr>
					<tr class="border-b last:border-b-0">
						<td class="py-3 px-6 font-medium">Date Joined</td>
						<td class="py-3 px-6">July 10, 2025 – 02:15 PM</td>
					</tr>
					<tr>
						<td class="py-3 px-6 font-medium">Last Login</td>
						<td class="py-3 px-6">Aug 26, 2025 – 08:20 AM</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
