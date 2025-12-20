@extends('layouts.app')

@section('title', 'File Grievance')

@section('sidebar')
@include('partials.sidebar-osas-du')
@endsection

@section('content')
<!-- <div class="max-w-4l mx-auto px-1 overflow-x-hidden"> -->

<!-- <div class="px-5 mb-6"> -->
<nav class="text-sm text-gray-600 flex items-center mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
        <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z" />
    </svg>
    <a href="{{ route('osas-du.dashboard') }}" class="hover:text-red-800">Dashboard</a>
    <span class="mx-2 text-gray-400">/</span>
    <span class="text-blue-600">File Grievance</span>
</nav>
<!-- </div> -->

<!-- Form Card -->
<div class="flex-1 max-w-[1400px] mx-auto w-full">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 w-full">
        <div class="h-2 bg-gradient-to-r from-red-900 to-red-700 rounded-t-2xl -mx-10 -mt-10 mb-8"></div>

        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-3">
                <!-- <div class="p-3 bg-gradient-to-br from-red-100 to-red-50 rounded-xl">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
        </div> -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Student Grievance Report</h1>
                    <!-- <p class="text-sm text-gray-500 mt-1">Document and track student incidents and grievances</p> -->
                </div>
            </div>
            <div class="border-t border-gray-200 mt-6"></div>
        </div>

        <form class="space-y-6 text-sm" method="POST" action="{{ route('osas-du.grievances.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Student Information Section -->
            <div class="space-y-5">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-800" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                    </svg>
                    Student Information
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative">
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">Student ID <span class="text-red-600">*</span></label>
                        <input type="text" id="student_id" name="student_id" placeholder="Enter student ID" required value="{{ old('student_id') }}"
                            class="w-full px-4 py-3 border @error('student_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none transition-all hover:border-gray-400" />
                        <div id="studentLookupStatus" class="mt-1 text-sm text-gray-500"></div>
                        @error('student_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name <span class="text-red-600">*</span></label>
                        <input type="text" id="name" name="name" placeholder="Enter student name" required value="{{ old('name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none transition-all hover:border-gray-400" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative">
                        <label for="college" class="block text-sm font-medium text-gray-700 mb-2">College <span class="text-red-600">*</span></label>
                        <select id="college" name="college" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none appearance-none bg-white transition-all hover:border-gray-400">
                            <option value=""></option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-7 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative">
                        <label for="program" class="block text-sm font-medium text-gray-700 mb-2">Program <span class="text-red-600">*</span></label>
                        <select id="program" name="program" disabled required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none appearance-none bg-white transition-all hover:border-gray-400 disabled:bg-gray-100 disabled:cursor-not-allowed">
                            <option value=""></option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-7 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grievance Details Section -->
            <div class="space-y-5 pt-4">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-800" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    Grievance Details
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative">
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date <span class="text-red-600">*</span></label>
                        <input type="date" id="date" name="date" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none transition-all hover:border-gray-400" />
                    </div>

                    <div class="relative">
                        <label for="grievance" class="block text-sm font-medium text-gray-700 mb-2">Type <span class="text-red-600">*</span></label>
                        <select id="grievance" name="grievance" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none appearance-none bg-white transition-all hover:border-gray-400">
                            <option value="Grievance">Grievance</option>
                            <option value="Spot Report">Spot Report</option>
                            <option value="Pending Arf">Pending ARF</option>
                            <option value="Other">Other</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 pt-7 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="6" placeholder="Provide a detailed description of the incident..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none resize-none transition-all hover:border-gray-400"></textarea>
                </div>
            </div>

            <!-- File Upload Section -->
            <div class="space-y-3 pt-4">
                <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                    Attachments
                </h2>

                <div class="relative">
                    <label for="attachment" class="block text-sm font-medium text-gray-700 mb-2">
                        Supporting Documents
                        <span class="text-gray-500 text-xs font-normal ml-1">(Optional - PDF, JPG, PNG • Max: 5MB)</span>
                    </label>
                    <div id="fileDropZone" class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-red-300 transition-colors bg-gray-50 hover:bg-red-50/30">
                        <input type="file" id="attachment" name="attachment" accept=".pdf,.jpg,.jpeg,.png"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                        <div id="fileUploadPrompt" class="text-center pointer-events-none">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">
                                <span class="font-semibold text-red-800">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-500 mt-1">Evidence, documents, or images related to this incident</p>
                        </div>
                        <div id="fileSelected" class="hidden text-center pointer-events-none">
                            <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-2 text-sm font-semibold text-gray-900" id="fileName">File attached</p>
                            <p class="text-xs text-gray-500 mt-1" id="fileSize"></p>
                            <p class="text-xs text-red-600 mt-2 font-medium">Click to change file</p>
                        </div>
                    </div>
                    <p id="fileError" class="hidden text-xs text-red-600 mt-2 font-medium"></p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <button type="button"
                    class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-400 focus:border-gray-400 outline-none transition-all font-medium">
                    Clear Form
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-red-900 to-red-800 text-white rounded-lg hover:from-red-800 hover:to-red-700 focus:ring-2 focus:ring-red-800 outline-none transition-all font-medium shadow-lg hover:shadow-xl">
                    Submit Report
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
<script>
    // debounce helper
    function debounce(fn, wait) {
        let t;
        return function(...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    const studentIdInput = document.getElementById('student_id');
    const nameInput = document.getElementById('name');
    const collegeSelect = document.getElementById('college');
    const programSelect = document.getElementById('program');
    const findUrlBase = '{{ url("osas-du/students/find") }}';
    const statusEl = document.getElementById('studentLookupStatus');
    const submitBtn = document.querySelector('button[type="submit"]');

    let studentFound = false; // Track if student ID is valid

    // File upload feedback
    const fileInput = document.getElementById('attachment');
    const fileDropZone = document.getElementById('fileDropZone');
    const fileUploadPrompt = document.getElementById('fileUploadPrompt');
    const fileSelected = document.getElementById('fileSelected');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const fileError = document.getElementById('fileError');
    const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB in bytes

    // Load colleges on page load
    async function loadColleges() {
        try {
            const response = await fetch('/api/colleges');
            const colleges = await response.json();
            collegeSelect.innerHTML = '<option value=""></option>';
            colleges.forEach(college => {
                const option = document.createElement('option');
                option.value = college.name;
                option.dataset.collegeId = college.id;
                option.textContent = college.name;
                collegeSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading colleges:', error);
        }
    }

    // Load programs when college is selected
    collegeSelect.addEventListener('change', async function() {
        const selectedOption = this.options[this.selectedIndex];
        const collegeId = selectedOption.dataset.collegeId;

        if (!collegeId) {
            programSelect.innerHTML = '<option value=""></option>';
            programSelect.disabled = true;
            return;
        }

        try {
            const response = await fetch(`/api/programs/${collegeId}`);
            const programs = await response.json();
            programSelect.innerHTML = '<option value=""></option>';
            programs.forEach(program => {
                const option = document.createElement('option');
                option.value = program.name;
                option.textContent = program.name;
                programSelect.appendChild(option);
            });
            programSelect.disabled = false;
        } catch (error) {
            console.error('Error loading programs:', error);
        }
    });

    loadColleges();

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const sizeMB = (file.size / 1024 / 1024).toFixed(2);

                // Check file size
                if (file.size > MAX_FILE_SIZE) {
                    fileError.textContent = `File is too large! Maximum file size is 5MB. Your file is ${sizeMB}MB. Please choose a smaller file.`;
                    fileError.classList.remove('hidden');
                    this.value = ''; // Clear the input
                    // Reset to default state
                    fileUploadPrompt.classList.remove('hidden');
                    fileSelected.classList.add('hidden');
                    fileDropZone.classList.remove('border-green-500', 'bg-green-50');
                    fileDropZone.classList.add('border-gray-300', 'hover:border-red-300');
                    return;
                }

                // Clear error and update UI to show file is attached
                fileError.classList.add('hidden');
                fileUploadPrompt.classList.add('hidden');
                fileSelected.classList.remove('hidden');
                fileName.textContent = file.name;
                fileSize.textContent = `${sizeMB} MB`;

                // Change border color to green
                fileDropZone.classList.remove('border-gray-300', 'hover:border-red-300');
                fileDropZone.classList.add('border-green-500', 'bg-green-50');
            } else {
                // Reset to default state if no file
                fileError.classList.add('hidden');
                fileUploadPrompt.classList.remove('hidden');
                fileSelected.classList.add('hidden');
                fileDropZone.classList.remove('border-green-500', 'bg-green-50');
                fileDropZone.classList.add('border-gray-300', 'hover:border-red-300');
            }
        });
    }

    if (studentIdInput) {
        const lookup = debounce(function() {
            const val = studentIdInput.value.trim();
            if (!val) {
                studentFound = false;
                return;
            }
            const url = `${findUrlBase}/${encodeURIComponent(val)}`;
            if (statusEl) {
                statusEl.textContent = 'Looking up...';
                statusEl.className = 'mt-1 text-sm text-blue-600';
            }
            fetch(url)
                .then(res => {
                    if (!res.ok) throw new Error('not found');
                    return res.json();
                })
                .then(data => {
                    if (data.found) {
                        studentFound = true;
                        nameInput.value = data.student.name || '';

                        // Parse college and program from the combined string
                        const collegeProgramStr = data.student.program || '';
                        const parts = collegeProgramStr.split(' | ');

                        if (parts.length === 2) {
                            const collegeName = parts[0].trim();
                            const programName = parts[1].trim();

                            // Select college first
                            for (let i = 0; i < collegeSelect.options.length; i++) {
                                if (collegeSelect.options[i].value === collegeName) {
                                    collegeSelect.selectedIndex = i;

                                    // Load programs for this college, then select the program
                                    const selectedOption = collegeSelect.options[i];
                                    const collegeId = selectedOption.dataset.collegeId;

                                    if (collegeId) {
                                        fetch(`/api/programs/${collegeId}`)
                                            .then(response => response.json())
                                            .then(programs => {
                                                programSelect.innerHTML = '<option value=""></option>';
                                                programs.forEach(program => {
                                                    const option = document.createElement('option');
                                                    option.value = program.name;
                                                    option.textContent = program.name;
                                                    programSelect.appendChild(option);
                                                });
                                                programSelect.disabled = false;

                                                // Now select the program
                                                for (let j = 0; j < programSelect.options.length; j++) {
                                                    if (programSelect.options[j].value === programName) {
                                                        programSelect.selectedIndex = j;
                                                        break;
                                                    }
                                                }
                                            })
                                            .catch(error => console.error('Error loading programs:', error));
                                    }
                                    break;
                                }
                            }
                        }

                        if (statusEl) {
                            statusEl.textContent = '✓ Student found';
                            statusEl.className = 'mt-1 text-sm text-green-600 font-medium';
                        }
                    } else {
                        studentFound = false;
                        // Clear fields
                        nameInput.value = '';
                        collegeSelect.selectedIndex = 0;
                        programSelect.innerHTML = '<option value=""></option>';
                        programSelect.disabled = true;

                        if (statusEl) {
                            statusEl.textContent = '✗ Student ID not found in the system';
                            statusEl.className = 'mt-1 text-sm text-red-600 font-medium';
                        }
                    }
                })
                .catch((err) => {
                    console.log('student lookup error', err);
                    studentFound = false;
                    // Clear fields
                    nameInput.value = '';
                    collegeSelect.selectedIndex = 0;
                    programSelect.innerHTML = '<option value=""></option>';
                    programSelect.disabled = true;

                    if (statusEl) {
                        statusEl.textContent = '✗ Student ID not found in the system';
                        statusEl.className = 'mt-1 text-sm text-red-600 font-medium';
                    }
                });
        }, 300);

        studentIdInput.addEventListener('input', lookup);

        // Prevent form submission if student not found
        const form = studentIdInput.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (studentIdInput.value.trim() && !studentFound) {
                    e.preventDefault();
                    alert('Please enter a valid Student ID. The Student ID you entered was not found in the system.');
                    studentIdInput.focus();
                    return false;
                }
            });
        }
    }

    //   if (testBtn) {
    //     testBtn.addEventListener('click', function() {
    //       lookup();
    //     });
    //   }
    // }
</script>
@endpush