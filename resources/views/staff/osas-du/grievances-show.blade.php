@extends('layouts.app')

@section('title', 'Edit Grievance')

@section('sidebar')
@include('partials.sidebar-osas-du')
@endsection

@section('content')
<!-- Breadcrumb -->
<div class="px-3 -mt-2 mb-4">
    <nav class="text-sm text-gray-600 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
            <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z" />
        </svg>
        <a href="{{ route('osas-du.dashboard') }}" class="hover:text-red-800">Dashboard</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('osas-du.grievances') }}" class="text-gray-600 hover:text-red-800">Grievances</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">Edit</span>
    </nav>
</div>

<!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('osas-du.grievances') }}" class="inline-flex items-center gap-2 text-red-800 hover:text-red-900 font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Grievances
    </a>
</div>

<!-- Page Header -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl p-6 mb-6 shadow-lg">
    <h1 class="text-2xl font-bold">Edit Grievance</h1>
    <p class="text-gray-100 mt-1">Case ID: {{ $grievance->case_id }} • Filed on {{ $grievance->created_at->format('F d, Y') }}</p>
</div>

<!-- Edit Form -->
<form method="POST" action="{{ route('osas-du.grievances.update', $grievance->id) }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PATCH')

    <div class="bg-white rounded-xl shadow-lg p-6">
        <!-- Student Information (Read-only) -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-800" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16 8c0 2.21-1.79 4-4 4s-4-1.79-4-4l.11-.94L5 5.5L12 2l7 3.5v5h-1V6l-2.11 1.06zm-4 6c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4" />
                </svg>
                Student Information
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                <div>
                    <p class="text-sm text-gray-600">Name</p>
                    <p class="font-medium text-gray-900">{{ $grievance->name_snapshot }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Student Number</p>
                    <p class="font-medium text-gray-900">{{ $grievance->student_no_snapshot }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Program</p>
                    <p class="font-medium text-gray-900">{{ $grievance->program_snapshot }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Gender</p>
                    <p class="font-medium text-gray-900">{{ $grievance->gender_snapshot }}</p>
                </div>
            </div>
        </div>

        <!-- Grievance Type -->
        <div class="mb-6">
            <label for="grievance" class="block text-sm font-medium text-gray-700 mb-2">
                <span class="text-red-600">*</span> Grievance Type
            </label>
            <select name="grievance" id="grievance" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none">
                <option value="">Select grievance type</option>
                <option value="academic_issue" {{ $grievance->grievance === 'academic_issue' ? 'selected' : '' }}>Academic Issue</option>
                <option value="behavioral_issue" {{ $grievance->grievance === 'behavioral_issue' ? 'selected' : '' }}>Behavioral Issue</option>
                <option value="harassment" {{ $grievance->grievance === 'harassment' ? 'selected' : '' }}>Harassment</option>
                <option value="discrimination" {{ $grievance->grievance === 'discrimination' ? 'selected' : '' }}>Discrimination</option>
                <option value="facility_concern" {{ $grievance->grievance === 'facility_concern' ? 'selected' : '' }}>Facility Concern</option>
                <option value="policy_violation" {{ $grievance->grievance === 'policy_violation' ? 'selected' : '' }}>Policy Violation</option>
                <option value="other" {{ $grievance->grievance === 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('grievance')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Date -->
        <div class="mb-6">
            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
                <span class="text-red-600">*</span> Date of Incident
            </label>
            <input type="date" name="date" id="date" value="{{ $grievance->date }}" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none">
            @error('date')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                <span class="text-red-600">*</span> Description
            </label>
            <textarea name="description" id="description" rows="6" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none resize-none"
                placeholder="Provide detailed information about the grievance...">{{ $grievance->description }}</textarea>
            @error('description')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Current Attachment -->
        @if($grievance->attachment_path)
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Current Attachment</label>
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
                <a href="{{ asset('storage/' . $grievance->attachment_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">
                    View Current File
                </a>
            </div>
        </div>
        @endif

        <!-- New Attachment Upload -->
        <div class="mb-6">
            <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">
                {{ $grievance->attachment_path ? 'Replace Attachment (Optional)' : 'Add Attachment (Optional)' }}
            </label>
            <div class="relative">
                <input type="file" name="attachment" id="attachment" accept=".pdf,.jpg,.jpeg,.png"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none">
            </div>
            <p class="text-xs text-gray-500 mt-1">Allowed: PDF, JPG, JPEG, PNG • Max size: 5MB</p>
            @error('attachment')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
            <a href="{{ route('osas-du.grievances') }}"
                class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-400 outline-none transition font-medium">
                Cancel
            </a>
            <button type="submit"
                class="px-6 py-2.5 bg-gradient-to-r from-red-900 to-red-800 text-white rounded-lg hover:from-red-800 hover:to-red-700 focus:ring-2 focus:ring-red-800 outline-none transition font-medium shadow-lg">
                Save Changes
            </button>
        </div>
    </div>
</form>

<!-- Remarks Section (if exists) -->
@if($grievance->remarks)
<div class="bg-white rounded-xl shadow-lg p-6 mt-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
        </svg>
        Remarks History
    </h2>
    <div class="bg-gray-50 p-4 rounded-lg">
        <p class="text-gray-700 whitespace-pre-wrap text-sm">{{ $grievance->remarks }}</p>
    </div>
</div>
@endif

<!-- Toast Notification -->
<div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg hidden">
    <p id="toast-message"></p>
</div>

@endsection