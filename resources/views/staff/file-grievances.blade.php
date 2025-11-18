@extends('layouts.app')

@section('title', 'Dashboard')

@section('sidebar')
    @include('partials.sidebar-staff')
@endsection


@section('content')
  <!-- <div class="max-w-4l mx-auto px-1 overflow-x-hidden"> -->

    <!-- <div class="px-5 mb-6"> -->
      <nav class="text-sm text-gray-600 flex items-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 30 30" class="w-5 h-5 mr-2 text-gray-500">
        <path d="M3 9.75L12 3l9 6.75V21a1 1 0 0 1-1 1h-5.5a.5.5 0 0 1-.5-.5V15h-4v6.5a.5.5 0 0 1-.5.5H4a1 1 0 0 1-1-1V9.75z"/>
        </svg>
        <a href="{{ route('staff.dashboard') }}" class="hover:text-red-800">Dashboard</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-blue-600">File Grievance</span>
      </nav>
    <!-- </div> -->
    
  <!-- Form Card -->
  <div class="flex-1 max-w-[1400px] mx-auto w-full">
    <div class="bg-white rounded-2xl shadow-lg p-10 w-full">
      <div class="h-3 bg-[#6f0909] rounded-t-2xl -mx-10 -mt-10 mb-8"></div>
      <h1 class="text-3xl text-gray-800">Student Grievance Report Form</h1>
      <div class="border-t border-gray-200 mt-4 mb-8"></div>

      <form class="space-y-5 text-sm" method="POST" action="{{ route('staff.grievances.store') }}">
        @csrf
        <!-- Row 1 -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div>
            <input type="text" id="student_id" name="student_id" placeholder="Student ID"
                   class="w-full px-4 py-3 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none" />
            
            <!-- <div class="mt-2 flex items-center gap-3">
              <button type="button" id="testLookupBtn" class="px-3 py-1 bg-gray-100 border rounded text-sm">Test lookup</button>
              <span id="studentLookupStatus" class="text-sm text-gray-500">&nbsp;</span>
            </div> -->
          </div>

          <input type="text" id="name" name="name" placeholder="Name"
                 class="w-full px-4 py-3 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none" />
        </div>

        <!-- Row 2 -->
  <input type="text" id="program" name="program" placeholder="College and Program"
               class="w-full px-4 py-3 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none" />

        <!-- Row 3 -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="relative">
            <input type="date" id="date" name="date"
                   class="w-full px-4 py-3 pr-10 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none" />
          </div>
          <div class="relative">
            <select id="grievance" name="grievance"
                    class="w-full px-4 py-3 pr-10 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none appearance-none bg-white">
              <option value="Grievance">Grievance</option>
              <option value="Spot Report">Spot Report</option>
              <option value="Pending Arf">Pending ARF</option>
              <option value="Other">Other</option>
            </select>
          </div>
        </div>

        <!-- Row 4 -->
  <textarea id="description" name="description" rows="6" placeholder="Description of Incident"
                  class="w-full px-4 py-3 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none resize-none"></textarea>

        <!-- Buttons -->
        <div class="flex justify-end space-x-4 pt-3">
          <button type="button"
                  class="px-5 py-3 border border-gray-300 text-gray-700 rounded hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 focus:border-gray-500 outline-none">
            Clear
          </button>
          <button type="submit"
                  class="px-5 py-3 bg-red-900 text-white rounded hover:bg-red-800 focus:ring-2 focus:ring-red-800 outline-none">
            Add
          </button>
        </div>
      </form>
    </div>
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
  const programInput = document.getElementById('program');
  const findUrlBase = '/staff/students/find';
  const statusEl = document.getElementById('studentLookupStatus');
  // const testBtn = document.getElementById('testLookupBtn');

    if (studentIdInput) {
      const lookup = debounce(function() {
        const val = studentIdInput.value.trim();
        if (!val) return;
  const url = `${findUrlBase}/${encodeURIComponent(val)}`;
  if (statusEl) statusEl.textContent = 'Looking up...';
        fetch(url)
          .then(res => {
            if (!res.ok) throw new Error('not found');
            return res.json();
          })
          .then(data => {
            if (data.found) {
              nameInput.value = data.student.name || '';
              programInput.value = data.student.program || '';
              if (statusEl) statusEl.textContent = 'Found';
            } else {
              if (statusEl) statusEl.textContent = 'Not found';
            }
          })
          .catch((err) => {
            console.log('student lookup error', err);
            if (statusEl) statusEl.textContent = 'Not found';
          });
      }, 400);

      studentIdInput.addEventListener('input', lookup);

    }
    
    //   if (testBtn) {
    //     testBtn.addEventListener('click', function() {
    //       lookup();
    //     });
    //   }
    // }
  </script>
  @endpush
