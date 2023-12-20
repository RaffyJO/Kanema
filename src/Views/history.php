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

<script type="text/javascript" src="src/lib/Functions/PriceUtils.js"></script>
<script type="text/javascript" src="src/lib/Functions/CookieUtils.js"></script>

<script>
  let dataContainer = []

  function actionButtonPress(element) {
    const rawId = element.getAttribute('id')
    const _id = rawId.replace('prev-', '')

    callTransaction(_id)
  }

  function callTransaction(id) {
    const modal = document.getElementById('readProductModal')
    let actionButton = document.getElementById("actionButtonModal");

    const idContainer = document.getElementById('id-bearer');
    const detailAmount = document.getElementById('detail-amount');
    const detailDate = document.getElementById('detail-date');
    const modalListItem = document.getElementById('modal-list-item');
    const detailCashier = document.getElementById('detail-cashier');

    modalListItem.innerHTML = ''

    let selectedData = dataContainer.find(value => value._id === id);

    detailAmount.innerText = formatToIDR(selectedData.total)
    detailDate.innerText = `${selectedData.time.hour} : ${selectedData.time.minute} ${selectedData.time.day}/${selectedData.time.month}/${selectedData.time.year}`
    detailCashier.innerText = selectedData.user
    idContainer.innerText = id

    let totalQTY = 0

    selectedData.details.map(value => {
      const template = `
      <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg border-gray-700 text-gray-200 bg-gray-600">
      <div class="grid grid-cols-4 w-full text-center text-white">
              <span class="col-span-1">${value.productName}</span>
              <span class="col-span-1">${value.qty}</span>
              <span class="col-span-1">${formatToIDR(value.price)}</span>
              <span class="col-span-1">${formatToIDR(value.subtotal)}</span>
            </div>
            </li>
      `
      modalListItem.innerHTML += template
      totalQTY += value.qty
    });

    const templateTotal = `
    <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-semibold border -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg bg-slate-800 border-gray-700 text-gray-200">
            <div class="grid grid-cols-4 w-full text-center">
              <span class="col-span-1">Summary Paid</span>
              <span class="col-span-1">${totalQTY}</span>
              <span class="col-span-1">-</span>
              <span class="col-span-1">${formatToIDR(selectedData.total)}</span>
            </div>
          </li>
    `
    modalListItem.innerHTML += templateTotal

    modal.classList.toggle('hidden')
  }

  function toggleModal(modalId) {
    const modal = document.getElementById(modalId)

    if (modal != null)
      modal.classList.toggle('hidden')
  }
</script>

<div class="relative overflow-x-auto sm:rounded-lg">
  <div class="p-4 bg-gray-800 flex justify-between items-center">
    <h1 class="text-xl uppercase font-bold text-left rtl:text-right text-white bg-gray-800">Invoices</h1>
    <!-- <div>
      <label for="table-search" class="sr-only">Search</label>
      <div class="relative mt-1">
        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>
        <input type="text" id="table-search" class="block pt-2 ps-10 text-sm border rounded-lg w-80 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Search for invoices">
      </div>
    </div> -->
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
          Action
        </th>
      </tr>
    </thead>
    <tbody id="transaction-list">
    </tbody>
  </table>
</div>
<div class="w-full flex justify-center h-[15rem]  align-middle" id="container-spinner">
  <div role="status" id="loading-el" class="m-auto">
    <svg aria-hidden="true" class="inline w-10 h-10text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
      <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
    </svg>
    <span class="sr-only">Loading...</span>
  </div>
</div>

<!-- Read modal -->
<div id="readProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center" style="backdrop-filter: blur(10px); height:100%;">
  <div class="relative p-4 w-full max-w-xl max-h-full bg-gray-300 rounded-lg">
    <!-- Modal header -->
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 border-gray-600">
      <h3 class="text-lg font-semibold text-black" id="title-modal">Detail Invoice</h3>
      <button type="button" class="text-gray-400 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white" onclick="toggleModal('readProductModal')">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
        <span class="sr-only">Close modal</span>
      </button>
    </div>
    <!-- Body -->
    <div class="p-4 sm:p-4 overflow-y-auto">
      <div class="text-center">
        <h3 class="text-lg font-semibold text-sky-700">
          <span>ID-</span><span id="id-bearer"></span>
        </h3>
      </div>

      <div class="mt-5 sm:mt-10 grid grid-cols-2 sm:grid-cols-3 gap-5">
        <div>
          <span class="block text-xs uppercase text-sky-700 font-bold">Amount paid:</span>
          <span class="block text-sm font-medium text-black" id="detail-amount"></span>
        </div>
        <div>
          <span class="block text-xs uppercase text-sky-700 font-bold">Date paid:</span>
          <span class="block text-sm font-medium text-black" id="detail-date"></span>
        </div>
        <div>
          <span class="block text-xs uppercase text-sky-700 font-bold">Cashier</span>
          <div class="flex items-center gap-x-2">
            <span class="block text-sm font-medium text-black" id="detail-cashier"></span>
          </div>
        </div>
      </div>

      <div class="mt-5 sm:mt-10">
        <h4 class="text-xs font-semibold uppercase text-sky-700">Summary</h4>

        <ul class="mt-3 flex flex-col" id="modal-list-item">
          <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg border-gray-700 text-gray-200">
            <div class="flex items-center justify-between w-full">
              <span>Indomie</span>
              <span>1</span>
              <span>$264.00</span>
            </div>
          </li>
          <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-semibold border -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg bg-slate-800 border-gray-700 text-gray-200">
            <div class="flex items-center justify-between w-full">
              <span>Amount Paid</span>
              <span>$316.8</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <script>
    const transactionContainer = document.getElementById('transaction-list');
    if (transactionContainer) {
      fetch('/api/orders', {
          method: 'GET'
        })
        .then(response => response.json())
        .then(result => {
          let items = '';
          result.data.forEach(content => {
            const formattedTotal = new Intl.NumberFormat('id-ID', {
              style: 'currency',
              currency: 'IDR',
              minimumFractionDigits: 0, // Minimum number of digits after the decimal point
              maximumFractionDigits: 0, // Maximum number of digits after the decimal point
            }).format(content.total);
            items += `<tr class="bg-gray-800 border-gray-700">
        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
        ${content._id}
        </th>
        <td class="px-6 py-4 text-white">
        ${formattedTotal}
        </td>
        <td class="px-6 py-4 text-white">
        ${content.details.length}
        </td>
        <td class="px-6 py-4 text-white">
        ${content.time.day}-${content.time.month}-${content.time.year}
        </td>
        <td class="px-6 py-4 text-white">
        ${content.user}
        </td>
        <td class="px-6 py-4 text-right">
          <button type="button" class="py-2 px-3 flex items-center text-sm font-medium text-center focus:outline-none rounded-lg border focus:z-10 focus:ring-4 focus:ring-gray-700 bg-gray-800 text-blue-400 border-blue-600 hover:text-white hover:bg-blue-700" onclick="actionButtonPress(this)" id="prev-${content._id}">
            <svg class="w-4 h-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="20" fill="none" viewBox="0 0 18 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M12 2h4a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4m6 0v3H6V2m6 0a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1M5 5h8m-5 5h5m-8 0h.01M5 14h.01M8 14h5" />
            </svg>
            Details
          </button>
        </td>
      </tr>`;
          });

          document.getElementById('container-spinner').remove();
          transactionContainer.innerHTML += items;

          dataContainer = result.data

        }).catch(error => console.error(error))
    } else {
      console.error('Product container not found!');
    }
  </script>