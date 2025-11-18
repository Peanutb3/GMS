@extends('layouts.app')

@section('title', 'Safe Loan Requests')

@section('sidebar')
    @include('partials.sidebar-admin')
@endsection

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl p-8 mb-8 shadow-lg">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Safe Loan Requests</h1>
            <p class="text-gray-100">View and manage all safe loan requests</p>
        </div>
        <div class="hidden md:block">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 opacity-50" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
            </svg>
        </div>
    </div>
</div>

<!-- Coming Soon / Under Development -->
<div class="bg-white rounded-xl shadow-lg p-12">
    <div class="text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto mb-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
        </svg>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Safe Loan Requests Module</h2>
        <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
            This feature is currently under development. Safe loan request management functionality will be available soon.
        </p>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 max-w-2xl mx-auto">
            <p class="text-sm text-blue-800">
                <strong>Note:</strong> To enable this feature, you'll need to:
            </p>
            <ul class="text-left text-sm text-blue-700 mt-3 space-y-2 list-disc list-inside">
                <li>Create the SafeLoanRequest model and migration</li>
                <li>Define the database schema for safe loan requests</li>
                <li>Implement the request submission and approval workflow</li>
                <li>Add student-facing forms for submitting requests</li>
            </ul>
        </div>
    </div>
</div>

@endsection
