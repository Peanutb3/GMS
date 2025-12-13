@extends('layouts.app')

@section('title', 'Manage Colleges & Programs')

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
        <span class="text-gray-600">System Configuration</span>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">Colleges & Programs</span>
    </nav>
</div>

<!-- Page Header -->
<div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white rounded-xl p-8 mb-8 shadow-lg">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Colleges & Programs Management</h1>
            <p class="text-gray-100">Manage your institution's colleges and programs</p>
        </div>
        <div class="flex gap-3">
            <button onclick="openCollegeModal()" class="bg-white text-red-800 px-6 py-3 rounded-lg hover:bg-gray-100 font-medium transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add College
            </button>
            <button onclick="openProgramModal()" class="bg-white text-red-800 px-6 py-3 rounded-lg hover:bg-gray-100 font-medium transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Program
            </button>
        </div>
    </div>
</div>

<!-- Colleges List -->
<div class="space-y-6">
    @forelse($colleges as $college)
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- College Header -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-red-800 text-white p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $college->name }}</h2>
                        @if($college->code)
                        <p class="text-sm text-gray-600">Code: {{ $college->code }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $college->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $college->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <button onclick="editCollege({{ $college->id }}, '{{ addslashes($college->name) }}', '{{ addslashes($college->code) }}', {{ $college->is_active ? 'true' : 'false' }})" class="text-blue-600 hover:text-blue-800 p-2 rounded hover:bg-blue-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    <form action="{{ route('admin.colleges.destroy', $college) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this college? This will fail if there are programs associated with it.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded hover:bg-red-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Programs Table -->
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Programs ({{ $college->programs->count() }})</h3>
            </div>

            @if($college->programs->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Program Name</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Code</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($college->programs as $program)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">{{ $program->name }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ $program->code ?? 'N/A' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $program->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $program->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="editProgram({{ $program->id }}, {{ $program->college_id }}, '{{ addslashes($program->name) }}', '{{ addslashes($program->code) }}', {{ $program->is_active ? 'true' : 'false' }})" class="text-blue-600 hover:text-blue-800 p-2 rounded hover:bg-blue-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this program?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 p-2 rounded hover:bg-red-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-8 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p>No programs in this college yet.</p>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        <p class="text-gray-500 text-lg">No colleges found. Click "Add College" to get started.</p>
    </div>
    @endforelse
</div>

<!-- Add/Edit College Modal -->
<div id="collegeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white px-6 py-4 rounded-t-xl">
            <h3 id="collegeModalTitle" class="text-xl font-bold">Add College</h3>
        </div>
        <form id="collegeForm" method="POST">
            @csrf
            <input type="hidden" id="collegeMethod" name="_method" value="POST">
            <div class="p-6 space-y-4">
                <div>
                    <label for="collegeName" class="block text-sm font-medium text-gray-700 mb-2">College Name <span class="text-red-600">*</span></label>
                    <input type="text" id="collegeName" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                </div>
                <div>
                    <label for="collegeCode" class="block text-sm font-medium text-gray-700 mb-2">College Code</label>
                    <input type="text" id="collegeCode" name="code" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent" placeholder="e.g., COE, CAS">
                </div>
                <div id="collegeActiveDiv" class="hidden">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" id="collegeActive" name="is_active" value="1" class="rounded border-gray-300 text-red-800 focus:ring-red-800">
                        <span class="text-sm font-medium text-gray-700">Active</span>
                    </label>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-end gap-3">
                <button type="button" onclick="closeCollegeModal()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900 font-medium transition-colors">
                    Save College
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add/Edit Program Modal -->
<div id="programModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="bg-gradient-to-r from-[#760000] to-[#D62F26] text-white px-6 py-4 rounded-t-xl">
            <h3 id="programModalTitle" class="text-xl font-bold">Add Program</h3>
        </div>
        <form id="programForm" method="POST">
            @csrf
            <input type="hidden" id="programMethod" name="_method" value="POST">
            <div class="p-6 space-y-4">
                <div>
                    <label for="programCollege" class="block text-sm font-medium text-gray-700 mb-2">College <span class="text-red-600">*</span></label>
                    <select id="programCollege" name="college_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                        <option value="">Select College</option>
                        @foreach($colleges as $college)
                        <option value="{{ $college->id }}">{{ $college->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="programName" class="block text-sm font-medium text-gray-700 mb-2">Program Name <span class="text-red-600">*</span></label>
                    <input type="text" id="programName" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent">
                </div>
                <div>
                    <label for="programCode" class="block text-sm font-medium text-gray-700 mb-2">Program Code</label>
                    <input type="text" id="programCode" name="code" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-transparent" placeholder="e.g., BSCS, MSIT">
                </div>
                <div id="programActiveDiv" class="hidden">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" id="programActive" name="is_active" value="1" class="rounded border-gray-300 text-red-800 focus:ring-red-800">
                        <span class="text-sm font-medium text-gray-700">Active</span>
                    </label>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-end gap-3">
                <button type="button" onclick="closeProgramModal()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900 font-medium transition-colors">
                    Save Program
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // College Modal Functions
    function openCollegeModal() {
        document.getElementById('collegeModal').classList.remove('hidden');
        document.getElementById('collegeModalTitle').textContent = 'Add College';
        document.getElementById('collegeForm').action = '{{ route("admin.colleges.store") }}';
        document.getElementById('collegeMethod').value = 'POST';
        document.getElementById('collegeForm').reset();
        document.getElementById('collegeActiveDiv').classList.add('hidden');
    }

    function closeCollegeModal() {
        document.getElementById('collegeModal').classList.add('hidden');
    }

    function editCollege(id, name, code, isActive) {
        document.getElementById('collegeModal').classList.remove('hidden');
        document.getElementById('collegeModalTitle').textContent = 'Edit College';
        document.getElementById('collegeForm').action = `/admin/colleges/${id}`;
        document.getElementById('collegeMethod').value = 'PUT';
        document.getElementById('collegeName').value = name;
        document.getElementById('collegeCode').value = code || '';
        document.getElementById('collegeActive').checked = isActive;
        document.getElementById('collegeActiveDiv').classList.remove('hidden');
    }

    // Program Modal Functions
    function openProgramModal() {
        document.getElementById('programModal').classList.remove('hidden');
        document.getElementById('programModalTitle').textContent = 'Add Program';
        document.getElementById('programForm').action = '{{ route("admin.programs.store") }}';
        document.getElementById('programMethod').value = 'POST';
        document.getElementById('programForm').reset();
        document.getElementById('programActiveDiv').classList.add('hidden');
    }

    function closeProgramModal() {
        document.getElementById('programModal').classList.add('hidden');
    }

    function editProgram(id, collegeId, name, code, isActive) {
        document.getElementById('programModal').classList.remove('hidden');
        document.getElementById('programModalTitle').textContent = 'Edit Program';
        document.getElementById('programForm').action = `/admin/programs/${id}`;
        document.getElementById('programMethod').value = 'PUT';
        document.getElementById('programCollege').value = collegeId;
        document.getElementById('programName').value = name;
        document.getElementById('programCode').value = code || '';
        document.getElementById('programActive').checked = isActive;
        document.getElementById('programActiveDiv').classList.remove('hidden');
    }

    // Close modals on outside click
    document.getElementById('collegeModal').addEventListener('click', function(e) {
        if (e.target === this) closeCollegeModal();
    });

    document.getElementById('programModal').addEventListener('click', function(e) {
        if (e.target === this) closeProgramModal();
    });
</script>
@endsection
