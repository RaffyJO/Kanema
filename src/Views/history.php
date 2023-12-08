<?php

require_once('src/Views/templates/source.php');
if (!isset($TPL)) {
  $TPL = new source();
  $TPL->title = "History Page";
  $TPL->bodycontent = __FILE__;
  include "src/Views/layout/layout.php";
  exit;
}
?>

<div class="relative overflow-x-auto sm:rounded-lg">
  <div class="p-4 bg-white dark:bg-gray-800 flex justify-between items-center">
    <h1 class="text-xl uppercase font-semibold text-left rtl:text-right text-white bg-gray-800">Invoices</h1>
    <div>
      <label for="table-search" class="sr-only">Search</label>
      <div class="relative mt-1">
        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>
        <input type="text" id="table-search" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
      </div>
    </div>
  </div>
  <table class="w-full text-sm text-left rtl:text-right text-gray-400">
    <thead class="text-xs uppercase bg-gray-700 text-gray-400">
      <tr>
        <th scope="col" class="px-6 py-3">
          invoice Number
        </th>
        <th scope="col" class="px-6 py-3">
          Amount
        </th>
        <th scope="col" class="px-6 py-3">
          Items
        </th>
        <th scope="col" class="px-6 py-3">
          Date
        </th>
        <th scope="col" class="px-6 py-3">
          Cashier
        </th>
        <th scope="col" class="px-6 py-3">
          <span class="sr-only">Edit</span>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr class="bg-gray-800 border-gray-700">
        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
          #213123
        </th>
        <td class="px-6 py-4">
          Rp. 3000
        </td>
        <td class="px-6 py-4">
          1
        </td>
        <td class="px-6 py-4">
          07/12/2023
        </td>
        <td class="px-6 py-4">
          Ricky
        </td>
        <td class="px-6 py-4 text-right">
          <button type="button" data-modal-target="readProductModal" data-modal-toggle="readProductModal" class="py-2 px-3 flex items-center text-sm font-medium text-center focus:outline-none rounded-lg border focus:z-10 focus:ring-4 focus:ring-gray-700 bg-gray-800 text-gray-400 border-gray-600 hover:text-white hover:bg-gray-700">
            <svg class="w-4 h-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="20" fill="none" viewBox="0 0 18 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M12 2h4a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4m6 0v3H6V2m6 0a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1M5 5h8m-5 5h5m-8 0h.01M5 14h.01M8 14h5" />
            </svg>
            Details
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<!-- Read modal -->
<div id="readProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
  <div class="relative p-4 w-full max-w-xl max-h-full bg-gray-800 rounded-lg">
    <!-- Body -->
    <div class="p-4 sm:p-7 overflow-y-auto">
      <div class="text-center">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
          Invoice
        </h3>
        <p class="text-sm text-gray-500">
          Invoice #213123
        </p>
      </div>

      <div class="mt-5 sm:mt-10 grid grid-cols-2 sm:grid-cols-3 gap-5">
        <div>
          <span class="block text-xs uppercase text-gray-500">Amount paid:</span>
          <span class="block text-sm font-medium text-gray-800 dark:text-gray-200">$316.8</span>
        </div>
        <div>
          <span class="block text-xs uppercase text-gray-500">Date paid:</span>
          <span class="block text-sm font-medium text-gray-800 dark:text-gray-200">April 22, 2020</span>
        </div>
        <div>
          <span class="block text-xs uppercase text-gray-500">Cashier</span>
          <div class="flex items-center gap-x-2">
            <span class="block text-sm font-medium text-gray-800 dark:text-gray-200">Ricky</span>
          </div>
        </div>
      </div>

      <div class="mt-5 sm:mt-10">
        <h4 class="text-xs font-semibold uppercase text-gray-800 dark:text-gray-200">Summary</h4>

        <ul class="mt-3 flex flex-col">
          <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:border-gray-700 dark:text-gray-200">
            <div class="flex items-center justify-between w-full">
              <span>Indomie</span>
              <span>1</span>
              <span>$264.00</span>
            </div>
          </li>
          <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-semibold bg-gray-50 border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-slate-800 dark:border-gray-700 dark:text-gray-200">
            <div class="flex items-center justify-between w-full">
              <span>Amount paid</span>
              <span>$316.8</span>
            </div>
          </li>
        </ul>
      </div>

      <!-- Button -->
      <div class="mt-5 flex justify-end gap-x-2">
        <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 6 2 18 2 18 9" />
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
            <rect width="12" height="8" x="6" y="14" />
          </svg>
          Print
        </a>
      </div>
      <!-- End Buttons -->
    </div>
  </div>