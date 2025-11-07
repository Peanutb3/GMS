<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>OSAS Request System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

<header class="px-4 sm:px-6 bg-gray-50 border-b border-gray-300 flex flex-col sm:flex-row items-center justify-center sm:justify-between cursor-default gap-2 sm:gap-4 py-4">
  <img src="{{ asset('images/osas_logo.png') }}" alt="OSAS Logo" class="h-12 sm:h-16">
  <span class="text-gray-700 font-semibold text-base sm:text-lg text-center sm:text-left">
    Office of Student Affairs and Services
  </span>
</header>

<main class="flex-1 mt-8 mb-48 px-6">
  <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-xl p-8">
    <div class="mb-6 text-center">
      <h2 class="text-xl font-semibold text-gray-600">Select What to Request</h2>
    </div>

<div class="flex gap-6 justify-center overflow-x-auto pb-4 sm:justify-center sm:flex-wrap">
  <!-- Good Moral -->
  <div class="option-card min-w-[16rem] w-72 p-6 rounded-xl text-center cursor-pointer transition transform bg-red-50 shadow hover:-translate-y-1 hover:shadow-lg hover:bg-red-100"
       style="border:2px solid #8B0000;" data-option="good-moral" tabindex="0" role="button" aria-pressed="false">
    <i class="fas fa-award text-5xl mb-3" style="color:#8B0000;"></i>
    <h3 class="text-lg font-bold mb-2" style="color:#8B0000;">Good Moral Certificate</h3>
    <p class="text-sm text-gray-600">Request certification of good conduct</p>
  </div>

  <!-- Safe Loan -->
  <div class="option-card min-w-[16rem] w-72 p-6 rounded-xl text-center cursor-pointer transition transform bg-red-50 shadow hover:-translate-y-1 hover:shadow-lg hover:bg-red-100"
       style="border:2px solid #8B0000;" data-option="safe-loan-form" tabindex="0" role="button" aria-pressed="false">
    <i class="fas fa-hand-holding-usd text-5xl mb-3" style="color:#8B0000;"></i>
    <h3 class="text-lg font-bold mb-2" style="color:#8B0000;">Safe Loan Application</h3>
    <p class="text-sm text-gray-600">Apply for a student loan</p>
  </div>
</div>

<footer class="fixed bottom-0 left-0 w-full bg-gray-100 text-center py-3 border-t border-gray-300 text-sm text-gray-600 z-50">
  <p>© 2025 Office of the Student Affairs and Services. All rights reserved.</p>
  <p>For inquiries, contact: <span style="color:#8B0000;">osas@usep.edu.ph</span></p>
</footer>

<!-- Form Modal (Step 1) -->
<div id="good-moral-modal" class="modal fixed inset-0 hidden bg-black/50 z-50 items-center justify-center p-4">
  <div class="modal-content bg-gray-50 rounded-xl p-6 shadow-xl max-w-2xl w-2/3 relative overflow-y-auto max-h-[80vh]">
    <button class="close-btn absolute top-3 right-3 text-xl text-gray-400 hover:text-red-600">&times;</button>
    <h2 class="text-lg font-bold mb-4 text-center" style="color:#8B0000;">Please Fill Out</h2>

    <form id="moral-form" class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-5 text-sm">
      <div>
        <label for="date" class="block mb-1 font-semibold text-gray-700">Date</label>
        <input type="date" id="date" name="date" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" required>
      </div>

      <div>
        <label for="email" class="block mb-1 font-semibold text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" required>
      </div>

      <div>
        <label for="contact" class="block mb-1 font-semibold text-gray-700">Contact</label>
        <input type="text" id="contact" name="contact" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" required>
      </div>

      <div>
        <label for="program" class="block mb-1 font-semibold text-gray-700">Program & Year</label>
        <input type="text" id="program" name="program" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" required>
      </div>

      <div>
        <label for="lastName" class="block mb-1 font-semibold text-gray-700">Last Name</label>
        <input type="text" id="lastName" name="lastName" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" required>
      </div>

      <div>
        <label for="firstName" class="block mb-1 font-semibold text-gray-700">First Name</label>
        <input type="text" id="firstName" name="firstName" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" required>
      </div>

      <div>
        <label for="middleName" class="block mb-1 font-semibold text-gray-700">Middle Name</label>
        <input type="text" id="middleName" name="middleName" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;">
      </div>

      <div>
        <label for="lastSem" class="block mb-1 font-semibold text-gray-700">Last Sem & SY</label>
        <input type="text" id="lastSem" name="lastSem" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;">
      </div>

      <div>
        <label for="yearGraduated" class="block mb-1 font-semibold text-gray-700">Year Graduated</label>
        <input type="text" id="yearGraduated" name="yearGraduated" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;">
      </div>

      <div>
        <label class="block mb-1 font-semibold text-gray-700">Gender</label>
        <div class="flex gap-3">
          <label><input type="radio" name="gender" value="female"> Female</label>
          <label><input type="radio" name="gender" value="male"> Male</label>
          <label><input type="radio" name="gender" value="prefer"> Prefer not to say</label>
        </div>
      </div>

      <div class="col-span-1 sm:col-span-2">
        <label for="purpose" class="block mb-1 font-semibold text-gray-700">Purpose</label>
        <textarea id="purpose" name="purpose" class="w-full px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" rows="3"></textarea>
      </div>

      <div class="col-span-1 sm:col-span-2 flex justify-end">
        <button id="next-btn" type="button" class="w-[95%] px-3 py-2 border font-semibold rounded-md shadow hover:bg-red-800 transition">
          Next
        </button>
      </div>
    </form>
  </div>
</div>


<!-- Payment Slip Modal (Good Moral) -->
<div id="payment-slip-modal" class="modal fixed inset-0 hidden bg-black/50 z-50 items-center justify-center p-4">
  <div class="modal-content bg-gray-50 rounded-xl p-6 shadow-xl max-w-lg w-2/3 relative overflow-y-auto max-h-[80vh]">
    <button class="close-btn absolute top-3 right-3 text-xl text-gray-400 hover:text-red-600">&times;</button>
    <h2 class="text-lg font-bold mb-4 text-center" style="color:#8B0000;">Payment Slip</h2>
    <form id="payment-form" class="text-sm space-y-4">
      <table class="w-full border border-gray-300 text-center text-sm">
        <thead class="bg-gray-200">
          <tr>
            <th class="border px-2 py-1">Description</th>
            <th class="border px-2 py-1">Quantity</th>
            <th class="border px-2 py-1">Cost</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-2 py-1">Certificate of Good Moral Character (₱70.00/copy)</td>
            <td class="border px-2 py-1">
              <input type="number" id="gm-qty" name="gm_qty" min="1" value="1" class="w-16 text-center border rounded">
            </td>
            <td class="border px-2 py-1" id="gm-cost">₱70.00</td>
          </tr>
          <tr>
            <td class="border px-2 py-1">Safe Loan</td>
            <td class="border px-2 py-1">-</td>
            <td class="border px-2 py-1">₱0.00</td>
          </tr>
          <tr>
            <td class="border px-2 py-1 font-semibold" colspan="2">Total Amount</td>
            <td class="border px-2 py-1 font-bold" id="total-amount">₱70.00</td>
          </tr>
        </tbody>
      </table>
      <div class="flex justify-between mt-6">
        <button type="button" id="back-btn" class="px-4 py-2 border font-semibold rounded-md shadow hover:bg-red-800 transition">
          Back
        </button>
        <button type="submit" class="px-4 py-2 border font-semibold rounded-md shadow hover:bg-red-800 transition">
          Submit
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Payment Slip Modal (Safe Loan) -->
<div id="payment-slip-loan-modal" class="modal fixed inset-0 hidden bg-black/50 z-50 items-center justify-center p-4">
  <div class="modal-content bg-gray-50 rounded-xl p-6 shadow-xl max-w-lg w-2/3 relative overflow-y-auto max-h-[80vh]">
    <button class="close-btn absolute top-3 right-3 text-xl text-gray-400 hover:text-red-600">&times;</button>
    <h2 class="text-lg font-bold mb-4 text-center" style="color:#8B0000;">Payment Slip</h2>
    <form id="payment-loan-form" class="text-sm space-y-4">
      <table class="w-full border border-gray-300 text-center text-sm">
        <thead class="bg-gray-200">
          <tr>
            <th class="border px-2 py-1">Description</th>
            <th class="border px-2 py-1">Quantity</th>
            <th class="border px-2 py-1">Cost</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-2 py-1">Certificate of Good Moral Character (₱70.00/copy)</td>
            <td class="border px-2 py-1">-</td>
            <td class="border px-2 py-1">₱0.00</td>
          </tr>
          <tr>
            <td class="border px-2 py-1">Safe Loan</td>
            <td class="border px-2 py-1">-</td>
            <td class="border px-2 py-1">
              <input type="number" id="loan-amount" name="loan_amount" min="0" value="0" class="w-24 text-center border rounded" step="0.01">
            </td>
          </tr>
          <tr>
            <td class="border px-2 py-1 font-semibold" colspan="2">Total Amount</td>
            <td class="border px-2 py-1 font-bold" id="loan-total-amount">₱0.00</td>
          </tr>
        </tbody>
      </table>
      <div class="flex justify-between mt-6">
        <button type="button" id="loan-back-btn" class="px-4 py-2 border font-semibold rounded-md shadow hover:bg-red-800 transition">
          Back
        </button>
        <button type="submit" class="px-4 py-2 border font-semibold rounded-md shadow hover:bg-red-800 transition">
          Submit
        </button>
      </div>
    </form>
  </div>
</div>



<!-- Safe Loan Instructions Modal -->
<div id="safe-loan-instructions-modal" class="modal fixed inset-0 hidden bg-black/50 z-50 items-center justify-center p-4">
  <div class="modal-content bg-gray-50 rounded-xl p-6 shadow-xl max-w-2xl w-2/3 relative overflow-y-auto max-h-[80vh]">
    <button class="close-btn absolute top-3 right-3 text-xl text-gray-400 hover:text-red-600">&times;</button>
    <h2 class="text-lg font-bold mb-6 text-center" style="color:#8B0000;">Loan Instructions</h2>
    <div class="text-sm text-gray-700 px-2 sm:px-6">
      <p class="text-center font-medium mb-6">
        Please be advised that the Safe Loan Application is processed through the OSAS office. Kindly follow the steps below:
      </p>
      <ol class="list-decimal list-inside space-y-4">
        <li>1. The applicant/student should apply directly to the Office of Student Services (Obrero Campus).</li>
        <li>2. The applicant must submit a formal letter to the Screening and Scholarship Committee, which will assess eligibility and grant the loan if qualified.</li>
        <li>
            3. The Screening and Scholarship Committee shall consider the following documents to be submitted by the applicant/student:
          <ul class="list-disc list-inside ml-6 mt-3 space-y-2">
            <li>• Medical Certificate</li>
            <li>• Grades of the previous semester</li>
            <li>• Income Tax return of Parents / Affidavit of No Income</li>
            <li>• Recommendation from the adviser/teacher</li>
            <li>• Recommendation from the guidance counselor</li>
            <li style="color:#8B0000;">
              Reminder: APPLICANTS WITH INCOMPLETE REQUIREMENTS CAN'T PROCEED WITH THE APPLICATION.
            </li>
          </ul>
        </li>
      </ol>
    </div>
    <div class="flex justify-end mt-8">
      <button type="button" id="open-loan-form-btn" class="px-6 py-2 border font-semibold rounded-md shadow hover:bg-red-800 transition" style="background-color:#8B0000; color:white; border-color:#8B0000;">
        Proceed to Form
      </button>
    </div>
  </div>
</div>

<!-- Safe Loan Modal (Form) -->
<div id="safe-loan-form-modal" class="modal fixed inset-0 hidden bg-black/50 z-50 items-center justify-center p-4">
  <div class="modal-content bg-gray-50 rounded-xl p-6 shadow-xl max-w-2xl w-2/3 relative overflow-y-auto max-h-[80vh]">
    <button class="close-btn absolute top-3 right-3 text-xl text-gray-400 hover:text-red-600">&times;</button>
    <h2 class="text-lg font-bold mb-4 text-center" style="color:#8B0000;">Please Fill Out</h2>
    <form id="safe-loan-form" class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-5 text-sm">
      <div>
        <label for="loan-date" class="block mb-1 font-semibold text-gray-700">Date</label>
        <input type="date" id="loan-date" name="loan-date" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" required>
      </div>
      <div>
        <label for="loan-email" class="block mb-1 font-semibold text-gray-700">Email</label>
        <input type="email" id="loan-email" name="loan-email" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" required>
      </div>
      <div>
        <label for="loan-contact" class="block mb-1 font-semibold text-gray-700">Contact</label>
        <input type="text" id="loan-contact" name="loan-contact" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" required>
      </div>
      <div>
        <label for="loan-program" class="block mb-1 font-semibold text-gray-700">Program & Year</label>
        <input type="text" id="loan-program" name="loan-program" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" required>
      </div>
      <div>
        <label for="loan-lastName" class="block mb-1 font-semibold text-gray-700">Last Name</label>
        <input type="text" id="loan-lastName" name="loan-lastName" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" required>
      </div>
      <div>
        <label for="loan-firstName" class="block mb-1 font-semibold text-gray-700">First Name</label>
        <input type="text" id="loan-firstName" name="loan-firstName" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" required>
      </div>
      <div>
        <label for="loan-middleName" class="block mb-1 font-semibold text-gray-700">Middle Name</label>
        <input type="text" id="loan-middleName" name="loan-middleName" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;">
      </div>
      <div>
        <label for="loan-lastSem" class="block mb-1 font-semibold text-gray-700">Last Sem & SY</label>
        <input type="text" id="loan-lastSem" name="loan-lastSem" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;">
      </div>
      <div>
        <label for="loan-yearGraduated" class="block mb-1 font-semibold text-gray-700">Year Graduated</label>
        <input type="text" id="loan-yearGraduated" name="loan-yearGraduated" class="w-[95%] px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;">
      </div>
      <div>
        <label class="block mb-1 font-semibold text-gray-700">Gender</label>
        <div class="flex gap-3">
          <label><input type="radio" name="loan-gender" value="female"> Female</label>
          <label><input type="radio" name="loan-gender" value="male"> Male</label>
          <label><input type="radio" name="loan-gender" value="prefer"> Prefer not to say</label>
        </div>
      </div>
      <div class="col-span-1 sm:col-span-2">
        <label for="loan-purpose" class="block mb-1 font-semibold text-gray-700">Purpose</label>
        <textarea id="loan-purpose" name="loan-purpose" class="w-full px-3 py-2 border rounded-md focus:ring" style="border-color:#8B0000;" rows="3"></textarea>
      </div>
      <div class="col-span-1 sm:col-span-2 flex justify-end">
        <button id="loan-next-btn" type="button" class="w-[95%] px-3 py-2 border font-semibold rounded-md shadow hover:bg-red-800 transition">
          Next
        </button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const optionCards = document.querySelectorAll('.option-card');
  const modals = {
    'good-moral': document.getElementById('good-moral-modal'),
    'safe-loan-instructions': document.getElementById('safe-loan-instructions-modal'),
    'safe-loan-form': document.getElementById('safe-loan-form-modal'),
    'payment-slip': document.getElementById('payment-slip-modal'),
    'payment-slip-loan': document.getElementById('payment-slip-loan-modal')
  };

  function openModal(option) {
    if (modals[option]) {
      modals[option].classList.remove('hidden');
      modals[option].classList.add('flex');
    }
  }

  function closeModal(modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  optionCards.forEach(card => {
    if (card.dataset.option === 'safe-loan-form') {
      card.addEventListener('click', () => openModal('safe-loan-instructions'));
    } else {
      card.addEventListener('click', () => openModal(card.dataset.option));
    }
  });
  // Safe Loan: Proceed to Application button
  document.getElementById('open-loan-form-btn').addEventListener('click', () => {
    closeModal(modals['safe-loan-instructions']);
    openModal('safe-loan-form');
  });

  document.querySelectorAll('.close-btn').forEach(btn => {
    btn.addEventListener('click', () => closeModal(btn.closest('.modal')));
  });

  document.querySelectorAll('.ok-btn').forEach(btn => {
    btn.addEventListener('click', () => closeModal(btn.closest('.modal')));
  });

  document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', e => {
      if (e.target === modal) closeModal(modal);
    });
  });


  document.getElementById('next-btn').addEventListener('click', () => {
    closeModal(modals['good-moral']);
    openModal('payment-slip');
  });

  // Safe Loan: Proceed to Payment Slip after form
  document.getElementById('loan-next-btn').addEventListener('click', function() {
    closeModal(modals['safe-loan-form']);
    openModal('payment-slip-loan');
  });

  // Loan Payment Slip: Back button
  document.getElementById('loan-back-btn').addEventListener('click', () => {
    closeModal(modals['payment-slip-loan']);
    openModal('safe-loan-form');
  });

  // Loan Payment Slip: Update total when amount changes
  const loanAmountInput = document.getElementById('loan-amount');
  const loanTotalAmount = document.getElementById('loan-total-amount');
  function updateLoanTotal() {
    const amt = parseFloat(loanAmountInput.value) || 0;
    loanTotalAmount.textContent = `₱${amt.toFixed(2)}`;
  }
  loanAmountInput.addEventListener('input', updateLoanTotal);
  updateLoanTotal();

 
  document.getElementById('back-btn').addEventListener('click', () => {
    closeModal(modals['payment-slip']);
    openModal('good-moral');
  });


  const gmQty = document.getElementById('gm-qty');
  const gmCost = document.getElementById('gm-cost');
  const totalAmount = document.getElementById('total-amount');

  function updateCost() {
    const qty = parseInt(gmQty.value) || 1;
    const cost = qty * 70;
    gmCost.textContent = `₱${cost.toFixed(2)}`;
    totalAmount.textContent = `₱${cost.toFixed(2)}`;
  }

  gmQty.addEventListener('input', updateCost);
  updateCost();
});
</script>
</body>
</html>