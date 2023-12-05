<?php

require_once('src/Views/templates/source.php');
if (!isset($TPL)) {
    $TPL = new source();
    $TPL->title = "Inbox Page";
    $TPL->bodycontent = __FILE__;
    include "src/Views/layout/layout.php";
    exit;
}
?>
<!-- Header -->
<div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 white:border-gray-700 fixed-header">
  <!-- Input -->
  <div class="sm:col-span-1">
    <label for="hs-as-table-product-review-search" class="sr-only">Search</label>
    <div class="relative">
      <input type="text" id="hs-as-table-product-review-search" name="hs-as-table-product-review-search" class="py-2 px-3 ps-11 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none white:bg-slate-900 white:border-gray-700 white:text-gray-400 white:focus:ring-gray-700" placeholder="Search">
      <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
        <svg class="h-4 w-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg>
      </div>
    </div>
  </div>
  <!-- End Input -->

  <div class="sm:col-span-2 md:grow">
    <div class="flex justify-end gap-x-2">

      <div class="hs-dropdown relative inline-block [--placement:bottom-right]" data-hs-dropdown-auto-close="inside">
        <button id="hs-as-table-table-filter-dropdown" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none white:bg-slate-900 white:border-gray-700 white:text-white white:hover:bg-gray-800 white:focus:outline-none white:focus:ring-1 white:focus:ring-gray-600">
          <svg class="flex-shrink-0 w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M7 12h10"/><path d="M10 18h4"/></svg>
          Filter
          <span class="ps-2 text-xs font-semibold text-blue-600 border-s border-gray-200 white:border-gray-700 white:text-blue-500">
            1
          </span>
        </button>
        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden mt-2 divide-y divide-gray-200 min-w-[12rem] z-10 bg-white shadow-md rounded-lg mt-2 white:divide-gray-700 white:bg-gray-800 white:border white:border-gray-700" aria-labelledby="hs-as-table-table-filter-dropdown">
          <div class="divide-y divide-gray-200 white:divide-gray-700">
            <label for="hs-as-filters-dropdown-all" class="flex py-2.5 px-3">
              <input type="checkbox" class="shrink-0 mt-0.5 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none white:bg-slate-900 white:border-gray-600 white:checked:bg-blue-500 white:checked:border-blue-500 white:focus:ring-offset-gray-800" id="hs-as-filters-dropdown-all" checked>
              <span class="ms-3 text-sm text-gray-800 white:text-gray-200">All</span>
            </label>
            <label for="hs-as-filters-dropdown-published" class="flex py-2.5 px-3">
              <input type="checkbox" class="shrink-0 mt-0.5 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none white:bg-slate-900 white:border-gray-600 white:checked:bg-blue-500 white:checked:border-blue-500 white:focus:ring-offset-gray-800" id="hs-as-filters-dropdown-published">
              <span class="ms-3 text-sm text-gray-800 white:text-gray-200">Published</span>
            </label>  
            <label for="hs-as-filters-dropdown-pending" class="flex py-2.5 px-3">
              <input type="checkbox" class="shrink-0 mt-0.5 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none white:bg-slate-900 white:border-gray-600 white:checked:bg-blue-500 white:checked:border-blue-500 white:focus:ring-offset-gray-800" id="hs-as-filters-dropdown-pending">
              <span class="ms-3 text-sm text-gray-800 white:text-gray-200">Pending</span>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Header -->
          
<!-- Table Section -->
<div class="max-w-screen px-4 py-10 sm:px-1 lg:px-1 lg:py-2">
  <!-- Card -->
  <div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
      <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden white:bg-slate-900 white:border-gray-700">
          <!-- Table -->
          <table class="table-auto overflow-scroll w-full">
            <thead class="bg-gray-50 white:bg-slate-800 sticky top-0">
              <tr>
                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-bold uppercase tracking-wide text-gray-800 white:text-gray-200">
                      Product
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-bold uppercase tracking-wide text-gray-800 white:text-gray-200">
                      Cashier
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-bold uppercase tracking-wide text-gray-800 white:text-gray-200">
                      Description
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-bold uppercase tracking-wide text-gray-800 white:text-gray-200">
                      Date
                    </span>
                  </div>
                </th>

                <th scope="col" class="px-6 py-3 text-start">
                  <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 white:text-gray-200">
                      Status
                    </span>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 white:divide-gray-700">
              <tr class="bg-white hover:bg-gray-50 white:bg-slate-900 white:hover:bg-slate-800">
                <td class="h-px w-px whitespace-nowrap align-top">
                  <a class="block p-6" href="#">
                    <div class="flex items-center gap-x-4">
                      <img class="flex-shrink-0 h-[2.375rem] w-[2.375rem] rounded-lg" src="https://www.indomie.com/uploads/product/indomie-mi-goreng-special_detail_094906814.png" alt="Image Description">
                      <div>
                        <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Mie Goreng</span>
                      </div>
                    </div>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-top">
                  <a class="block p-6" href="#">
                    <div class="flex items-center gap-x-3">
                      <img class="inline-block h-[2.375rem] w-[2.375rem] rounded-full" src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" alt="Image Description">
                      <div class="grow">
                        <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Stevanus Ageng</span>
                      </div>
                    </div>
                  </a>
                </td>
                <td class="h-px w-72 min-w-[18rem] align-center">
                  <a class="block p-6" href="#">   
                    <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Rp5000 -> Rp7000</span>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-center">
                  <a class="block p-6" href="#">
                    <span class="text-sm font-semibold text-gray-600 white:text-gray-400">04 Dec 2023</span>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-center">
                  <a class="block p-6" href="#">
                    <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full white:bg-teal-500/10 white:text-teal-500">
                      <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                      </svg>
                      Approved
                    </span>
                  </a>
                </td>
              </tr>

              <tr class="bg-white hover:bg-gray-50 white:bg-slate-900 white:hover:bg-slate-800">
                <td class="h-px w-px whitespace-nowrap align-top">
                  <a class="block p-6" href="#">
                    <div class="flex items-center gap-x-4">
                      <img class="flex-shrink-0 h-[2.375rem] w-[2.375rem] rounded-lg" src="https://www.indomie.com/uploads/product/indomie-mi-goreng-special_detail_094906814.png" alt="Image Description">
                      <div>
                        <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Mie Goreng</span>
                      </div>
                    </div>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-top">
                  <a class="block p-6" href="#">
                    <div class="flex items-center gap-x-3">
                      <img class="inline-block h-[2.375rem] w-[2.375rem] rounded-full" src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" alt="Image Description">
                      <div class="grow">
                        <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Stevanus Ageng</span>
                      </div>
                    </div>
                  </a>
                </td>
                <td class="h-px w-72 min-w-[18rem] align-center">
                  <a class="block p-6" href="#">   
                    <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Rp5000 -> Rp7000</span>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-center">
                  <a class="block p-6" href="#">
                    <span class="text-sm font-semibold text-gray-600 white:text-gray-400">04 Dec 2023</span>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-center">
                  <a class="block p-6" href="#">
                    <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full white:bg-red-500/10 white:text-red-500">
                      <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                      </svg>
                      Rejected
                    </span>
                  </a>
                </td>
              </tr>
              <tr class="bg-white hover:bg-gray-50 white:bg-slate-900 white:hover:bg-slate-800">
                <td class="h-px w-px whitespace-nowrap align-top">
                  <a class="block p-6" href="#">
                    <div class="flex items-center gap-x-4">
                      <img class="flex-shrink-0 h-[2.375rem] w-[2.375rem] rounded-lg" src="https://www.indomie.com/uploads/product/indomie-mi-goreng-special_detail_094906814.png" alt="Image Description">
                      <div>
                        <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Mie Goreng</span>
                      </div>
                    </div>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-top">
                  <a class="block p-6" href="#">
                    <div class="flex items-center gap-x-3">
                      <img class="inline-block h-[2.375rem] w-[2.375rem] rounded-full" src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" alt="Image Description">
                      <div class="grow">
                        <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Stevanus Ageng</span>
                      </div>
                    </div>
                  </a>
                </td>
                <td class="h-px w-72 min-w-[18rem] align-center">
                  <a class="block p-6" href="#">   
                    <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Rp5000 -> Rp7000</span>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-center">
                  <a class="block p-6" href="#">
                    <span class="text-sm font-semibold text-gray-600 white:text-gray-400">04 Dec 2023</span>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-center">
                  <a class="block p-6" href="#">
                    <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full white:bg-teal-500/10 white:text-yellow-500">
                    <svg class=" text-yellow-700"  width="12" height="12" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="9" />  <polyline points="12 7 12 12 15 15" /></svg>
                      Pending
                    </span>
                  </a>
                </td>
              </tr>
              <tr class="bg-white hover:bg-gray-50 white:bg-slate-900 white:hover:bg-slate-800">
                <td class="h-px w-px whitespace-nowrap align-top">
                  <a class="block p-6" href="#">
                    <div class="flex items-center gap-x-4">
                      <img class="flex-shrink-0 h-[2.375rem] w-[2.375rem] rounded-lg" src="https://www.indomie.com/uploads/product/indomie-mi-goreng-special_detail_094906814.png" alt="Image Description">
                      <div>
                        <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Mie Goreng</span>
                      </div>
                    </div>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-top">
                  <a class="block p-6" href="#">
                    <div class="flex items-center gap-x-3">
                      <img class="inline-block h-[2.375rem] w-[2.375rem] rounded-full" src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" alt="Image Description">
                      <div class="grow">
                        <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Stevanus Ageng</span>
                      </div>
                    </div>
                  </a>
                </td>
                <td class="h-px w-72 min-w-[18rem] align-center">
                  <a class="block p-6" href="#">   
                    <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Rp5000 -> Rp7000</span>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-center">
                  <a class="block p-6" href="#">
                    <span class="text-sm font-semibold text-gray-600 white:text-gray-400">04 Dec 2023</span>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-center">
                  <a class="block p-6" href="#">
                    <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full white:bg-red-500/10 white:text-red-500">
                      <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                      </svg>
                      Rejected
                    </span>
                  </a>
                </td>
              </tr>
              <tr class="bg-white hover:bg-gray-50 white:bg-slate-900 white:hover:bg-slate-800">
                <td class="h-px w-px whitespace-nowrap align-top">
                  <a class="block p-6" href="#">
                    <div class="flex items-center gap-x-4">
                      <img class="flex-shrink-0 h-[2.375rem] w-[2.375rem] rounded-lg" src="https://www.indomie.com/uploads/product/indomie-mi-goreng-special_detail_094906814.png" alt="Image Description">
                      <div>
                        <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Mie Goreng</span>
                      </div>
                    </div>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-top">
                  <a class="block p-6" href="#">
                    <div class="flex items-center gap-x-3">
                      <img class="inline-block h-[2.375rem] w-[2.375rem] rounded-full" src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" alt="Image Description">
                      <div class="grow">
                        <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Stevanus Ageng</span>
                      </div>
                    </div>
                  </a>
                </td>
                <td class="h-px w-72 min-w-[18rem] align-center">
                  <a class="block p-6" href="#">   
                    <span class="block text-sm font-semibold text-gray-800 white:text-gray-200">Rp5000 -> Rp7000</span>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-center">
                  <a class="block p-6" href="#">
                    <span class="text-sm font-semibold text-gray-600 white:text-gray-400">04 Dec 2023</span>
                  </a>
                </td>
                <td class="h-px w-px whitespace-nowrap align-center">
                  <a class="block p-6" href="#">
                    <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full white:bg-red-500/10 white:text-red-500">
                      <svg class="w-2.5 h-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                      </svg>
                      Rejected
                    </span>
                  </a>
                </td>
              </tr>
              
            </tbody>
          </table>
          <!-- End Table -->

          <!-- Footer -->
          <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 white:border-gray-700">
            <div class="max-w-sm space-y-3">
            <div>
              <div class="inline-flex gap-x-2">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none white:bg-slate-900 white:border-gray-700 white:text-white white:hover:bg-gray-800 white:focus:outline-none white:focus:ring-1 white:focus:ring-gray-600">
                  <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                  Prev
                </button>

                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none white:bg-slate-900 white:border-gray-700 white:text-white white:hover:bg-gray-800 white:focus:outline-none white:focus:ring-1 white:focus:ring-gray-600">
                  Next
                  <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </button>
              </div>
            </div>
          </div>
          <!-- End Footer -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Card -->
</div>
<!-- End Table Section -->