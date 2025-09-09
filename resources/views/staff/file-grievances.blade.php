@extends('layouts.app')

@section('title', 'Dashboard')

@section('sidebar')
<!-- File Grievances -->
<a href="/staff/file-grievances" 
   class="flex items-center gap-3 px-6 py-4 font-semibold cursor-pointer
          {{ request()->is('staff/file-grievances') ? 'bg-red-900 text-white' : 'text-red-900 hover:bg-red-800 hover:text-white' }}
          transition-colors rounded-r-lg w-full">
  
  <!-- Inline SVG icon -->
  <svg xmlns="http://www.w3.org/2000/svg" 
       class="w-6 h-6 flex-shrink-0" viewBox="0 0 16 16" fill="currentColor">
    <path fill-rule="evenodd" d="M2.5 1.045a.5.5 0 0 0-.5.5v10.91a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V5.364a.5.5 0 0 0-.152-.36L7.911 1.188a.5.5 0 0 0-.348-.142zm7.766 3.819L8.063 2.727v2.137zM6 5.5H4v-1h2zM10 8H4V7h6zm-6 2.5h6v-1H4z" clip-rule="evenodd"/>
    <path d="M13 7.5V14H4.5v1h9a.5.5 0 0 0 .5-.5v-7z"/>
  </svg>

  <span class="text-base">File Grievances</span>
</a>
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
      <a href="/staff/file-grievances" class="text-blue-600 hover">File Grievances</a>
    </nav>

  <!-- Form Card -->
  <div class="flex-1 max-w-[1400px] mx-auto w-full">
    <div class="bg-white rounded-2xl shadow-lg p-10 w-full">
      <div class="h-3 bg-[#6f0909] rounded-t-2xl -mx-10 -mt-10 mb-8"></div>
      <h1 class="text-3xl text-gray-800">Student Grievance Report Form</h1>
      <div class="border-t border-gray-200 mt-4 mb-8"></div>

      <form class="space-y-5 text-sm">
        <!-- Row 1 -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <input type="text" id="school_id" name="school_id" placeholder="School ID"
                 class="w-full px-4 py-3 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none" />
          <input type="text" id="name" name="name" placeholder="Name"
                 class="w-full px-4 py-3 border border-gray-300 rounded focus:ring-2 focus:ring-red-800 focus:border-red-800 outline-none" />
        </div>

        <!-- Row 2 -->
        <input type="text" id="program" name="program" placeholder="Program"
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
              <option value="">Grievance</option>
              <option value="spot_report">Spot Report</option>
              <option value="arf">ARF (Academic Review Form)</option>
              <option value="disciplinary">Disciplinary Action</option>
              <option value="other">Other</option>
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
