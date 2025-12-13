@extends('layouts.app')

@section('title', 'Manage Students')

@section('sidebar')
@include('partials.sidebar-admin')
@endsection

@section('content')
<!-- Breadcrumb -->
<div class="px-3 -mt-2 mb-4">
    <nav class="text-sm text-gray-600 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
            <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z" />
        </svg>
        <a href="{{ route('admin.dashboard') }}" class="hover:text-red-800">Dashboard</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-600">Manage Users</span>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">Students</span>
    </nav>
</div>

<!-- Page Header -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl p-8 mb-8 shadow-lg">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Student Management</h1>
            <p class="text-gray-100">Manage student accounts and information</p>
        </div>
        <a href="{{ route('admin.students.create') }}"
            class="bg-white text-red-800 px-6 py-3 rounded-lg hover:bg-gray-100 font-medium transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New Student
        </a>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-6">
    <form method="GET" action="{{ route('admin.manage-students') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Name, Student No, Email..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                <select name="program" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                    <option value="">All Programs</option>
                    @foreach($programs as $program)
                    <option value="{{ $program }}" {{ request('program') === $program ? 'selected' : '' }}>
                        {{ $program }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Year Level</label>
                <select name="year_level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                    <option value="">All Years</option>
                    <option value="1" {{ request('year_level') == '1' ? 'selected' : '' }}>1st Year</option>
                    <option value="2" {{ request('year_level') == '2' ? 'selected' : '' }}>2nd Year</option>
                    <option value="3" {{ request('year_level') == '3' ? 'selected' : '' }}>3rd Year</option>
                    <option value="4" {{ request('year_level') == '4' ? 'selected' : '' }}>4th Year</option>
                    <option value="5" {{ request('year_level') == '5' ? 'selected' : '' }}>5th Year</option>
                </select>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900 font-medium">
                Apply Filters
            </button>
            <a href="{{ route('admin.manage-students') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Students Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">All Students ({{ $students->total() }})</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Student No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">College</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Program</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Year</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($students as $student)
                <tr class="hover:bg-gray-50" id="student-row-{{ $student->id }}">
                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $student->student_id }}
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-900">
                        {{ trim($student->first_name . ' ' . ($student->middle_initial ? $student->middle_initial . '. ' : '') . $student->last_name . ($student->suffix ? ' ' . $student->suffix : '')) }}
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-600">
                        <div class="truncate max-w-xs" title="{{ optional($student->user)->email ?? '—' }}">
                            {{ optional($student->user)->email ?? '—' }}
                        </div>
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-700">
                        @php
                        $collegeAbbr = match($student->college) {
                        'College of Information and Computing' => 'CIC',
                        'College of Engineering' => 'COE',
                        'College of Education' => 'CED',
                        'College of Business Administration' => 'CBA',
                        'College of Arts and Sciences' => 'CAS',
                        'College of Applied Economics' => 'CAEC',
                        'College of Technology' => 'CT',
                        default => $student->college
                        };
                        @endphp
                        <span title="{{ $student->college }}">{{ $collegeAbbr }}</span>
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700">
                        {{ $student->program }}
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-center">
                        {{ $student->year }}
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.students.edit', $student->id) }}"
                                class="text-blue-600 hover:text-blue-900" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>

                            <form method="POST" action="{{ route('admin.students.destroy', $student->id) }}" onsubmit="return confirm('Are you sure you want to delete this student? This will also delete their user account.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>

                            {{-- Toast will be rendered at the top of the page --}}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="text-lg">No students found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($students->hasPages())
    <div class="p-6 border-t border-gray-200">
        {{ $students->links('vendor.pagination.tailwind') }}
    </div>
    @endif
</div>

@endsection


{{-- Toast notification at top of page --}}
@if(session('status'))
<div class="fixed top-5 right-5 z-50">
    <x-toast type="success" :message="session('status')" />
</div>
@endif