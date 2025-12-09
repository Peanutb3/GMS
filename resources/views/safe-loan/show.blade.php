<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Request Submitted - OSAS</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

  <header class="px-4 sm:px-6 bg-gray-50 border-b border-gray-300 flex flex-col sm:flex-row items-center justify-center sm:justify-between cursor-default gap-2 sm:gap-4 py-2">
    <img src="{{ asset('images/osas_logo.png') }}" alt="OSAS Logo" class="h-10 sm:h-14">
    <span class="text-gray-700 font-semibold text-base sm:text-lg text-center sm:text-left">
      Office of Student Affairs and Services
    </span>
  </header>

  <main class="flex-1 flex items-center justify-center px-6 py-12">
    <div class="bg-white rounded-2xl p-8 shadow-2xl max-w-md w-full text-center">

      <!-- Success Icon -->
      <div class="mb-6">
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100">
          <i class="fas fa-check text-4xl text-green-600"></i>
        </div>
      </div>

      <!-- Success Message -->
      <h1 class="text-3xl font-bold mb-3 text-gray-800">Request Submitted!</h1>
      <p class="text-gray-600 mb-2">
        Thank you for your Safe Loan request. Your reference number is:
      </p>
      <p class="text-2xl font-bold mb-6" style="color:#8B0000;">{{ $requestModel->reference_no }}</p>
      <p class="text-gray-600 mb-8">
        Our staff will review and process it shortly. Please wait for confirmation from the Office of Student Affairs and Services.
      </p>

      <!-- Action Buttons -->
      <div class="flex flex-col gap-3">
        <a href="{{ route('safe-loan.print', $requestModel) }}" target="_blank" class="px-6 py-3 font-semibold rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 inline-flex items-center justify-center" style="background-color:#8B0000; color:white;">
          <i class="fas fa-file-pdf mr-2"></i>View / Download Receipt
        </a>
        <a href="{{ route('requests.good-moral') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg shadow-md hover:bg-gray-300 transition inline-flex items-center justify-center">
          <i class="fas fa-home mr-2"></i>Back to Home
        </a>
      </div>
    </div>
  </main>

  <footer class="bg-gray-100 text-center py-3 border-t border-gray-300 text-sm text-gray-600">
    <p>© 2025 Office of the Student Affairs and Services. All rights reserved.</p>
    <p>For inquiries, contact: <span style="color:#8B0000;">osas@usep.edu.ph</span></p>
  </footer>

</body>

</html>
