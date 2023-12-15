<?php

require_once('src/Views/templates/source.php');
if (!isset($TPL)) {
    $TPL = new source();
    $TPL->title = "Request Page";
    $TPL->bodycontent = __FILE__;
    include "src/Views/layout/layout.php";
    exit;
}
?>
<script type="text/javascript" src="src/lib/Functions/CookieUtils.js"></script>
<script type="text/javascript" src="src/lib/Functions/PriceUtils.js"></script>
<style>
    .scrollbar-none::-webkit-scrollbar {
        display: none;
    }
</style>

<script>
    function detailButtonPress(element) {
        const rawId = element.getAttribute('id')
        const _id = rawId.replace('details-', '')

        callDetails(_id)
    }

    function callDetails(id) {
        const modal = document.getElementById('detailRequest')

        let headersList = {
            "Accept": "*/*",
            "Authorization": `Bearer ${getCookie('Bearer')}`
        }

        fetch(`/api/product?search=${id}`, {
                method: 'GET',
                headers: headersList
            })
            .then(response => response.json())
            .then(result => {
                if (new Object(result).hasOwnProperty('error')) {
                    alertBox.classList.toggle('hidden')
                }

                result.data.forEach(value => {});


                modal.classList.toggle('hidden')
            }).catch(err => console.error(err))
    }

    function toggleModal(modalId) {
        const modal = document.getElementById(modalId)

        if (modal != null)
            modal.classList.toggle('hidden')
    }
</script>

<div class="w-full bg-gray-800 relative shadow-md rounded-lg overflow-hidden">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full md:w-1/2">
            <form class="flex items-center">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-3/5">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="simple-search" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 bg-gray-700 border-gray-600 placeholder-gray-400 text-white" placeholder="Search" required="">
                </div>
            </form>
        </div>
        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
            <div class="flex items-center space-x-3 w-full md:w-auto">
                <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-white focus:outline-none rounded-lg border border-gray-200 focus:z-10 focus:ring-gray-200 focus:ring-gray-700 bg-gray-800 border-gray-600 hover:text-white hover:bg-gray-700" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    Filter
                    <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                </button>
                <div id="filterDropdown" class="z-10 hidden w-56 p-3 rounded-lg shadow bg-gray-700">
                    <h6 class="mb-3 text-sm font-medium text-white">Category</h6>
                    <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                        <li class="flex items-center">
                            <input id="apple" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-600 ring-offset-gray-700 focus:ring-2 bg-gray-600 border-gray-500">
                            <label for="apple" class="ml-2 text-sm font-medium text-gray-100">Food</label>
                        </li>
                        <li class="flex items-center">
                            <input id="fitbit" type="checkbox" value="" class="w-4 h-4 rounded text-blue-600 focus:ring-blue-600 ring-offset-gray-700 ring-2 bg-gray-600 border-gray-500">
                            <label for="fitbit" class="ml-2 text-sm font-medium text-gray-100">Drink</label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-4">Product name</th>
                    <th scope="col" class="px-4 py-3">Cashier</th>
                    <th scope="col" class="px-4 py-3">Description</th>
                    <th scope="col" class="px-4 py-3">Date</th>
                    <th scope="col" class="p-4">Action</th>
                </tr>
            </thead>
            <tbody id="products-list">
                <tr class="border-b border-gray-700">
                    <th scope="row" class="px-4 py-3 font-medium whitespace-nowrap text-white">Indomie</th>
                    <td class="px-4 py-3 text-white">
                        Ricky
                    </td>
                    <td class="px-4 py-3 text-white">Rp. 3000 -> Rp. 5000</td>
                    <td class="px-4 py-3 text-white">10 Dec 2023</td>
                    <td class="px-4 py-3 text-white">
                        <div class="flex items-center space-x-4">
                            <button type="button" class="py-2 px-3 flex items-center text-white text-sm font-medium text-center focus:outline-none rounded-lg border focus:ring-green-700 text-green-400 border-green-600 hover:text-white hover:bg-green-700">
                                <svg class="h-4 w-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                </svg>
                                Accept
                            </button>
                            <button type="button" class="flex items-center hover:text-white border font-medium rounded-lg text-sm px-3 py-2 text-center border-red-500 text-red-500 hover:text-white hover:bg-red-600 focus:ring-red-900" onclick="deleteButtonPress(this)" id="del-${content._id}">
                                <svg class="h-4 w-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                                </svg>
                                Decline
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div id="detailRequest" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full" style="backdrop-filter: blur(10px);height: 100%">
    <div class="relative p-4 w-full h-full mx-auto flex justify-center items-center overflow-hidden">
        <!-- Modal content -->
        <div class="relative rounded-lg shadow bg-gray-800 w-4/5 overflow-y-auto h-full scrollbar-none">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                <h3 class="text-lg font-semibold text-white">
                    Detail Request - <span class="font-bold" id="id_details"></span>
                </h3>
                <button type="button" class="text-gray-400 bg-transparent rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white" onclick="toggleModal('detailRequest')">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <div class="mb-4 border-b border-gray-700 flex justify-between">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="update-tab" data-tabs-target="#update" type="button" role="tab" aria-controls="update" aria-selected="false">Update</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="create-tab" data-tabs-target="#create" type="button" role="tab" aria-controls="create" aria-selected="false">Create</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="delete-tab" data-tabs-target="#delete" type="button" role="tab" aria-controls="delete" aria-selected="false">Delete</button>
                        </li>
                    </ul>
                    <div class="flex p-3">
                        <button type="button" class="py-2 px-3 flex items-center text-white text-sm font-medium text-center focus:outline-none rounded-lg border focus:ring-green-700 text-green-400 border-green-600 hover:text-white hover:bg-green-700 mr-3" onclick="" id="">
                            <svg class="h-4 w-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            Approved choice
                        </button>
                        <button type="button" class="flex items-center hover:text-white border font-medium rounded-lg text-sm px-3 py-2 text-center border-red-500 text-red-500 hover:text-white hover:bg-red-600 focus:ring-red-900" onclick="" id="">
                            <svg class="h-4 w-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                            </svg>
                            Reject choice
                        </button>
                    </div>
                </div>
                <div id="default-tab-content">
                    <div class="hidden relative overflow-x-auto bg-gray-800" id="update" role="tabpanel" aria-labelledby="update-tab">
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                                <!-- start template update -->
                                <tr>
                                    <th scope="col" class="p-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-primary-600 rounded focus:ring-primary-600 ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600">
                                            <label for="checkbox-all" class="sr-only">checkbox</label>
                                        </div>
                                    </th>
                                    <th scope="col" class="p-4">Product</th>
                                    <th scope="col" class="p-4">Status</th>
                                </tr>
                            </thead>
                            <tbody id="accordion-collapse-update" data-accordion="open">
                                <tr class="border-b border-gray-600 hover:bg-gray-700" id="upd-proc-1" data-accordion-target="#accor-upd-proc-1" aria-expanded="false" aria-controls="accor-upd-proc-1">
                                    <td class="p-4 w-4">
                                        <div class="flex items-center">
                                            <input id="checkbox-table-search-1" type="checkbox" onclick="event.stopPropagation()" class="w-4 h-4 text-primary-600 rounded focus:ring-primary-600 ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap text-white">
                                        <div class="flex items-center mr-3">
                                            <img src="https://cdn.discordapp.com/avatars/460429122431221771/799decc5388b211d9e827c8f45208537.webp?size=48" alt="iMac Front Image" class="h-8 h-8 mr-3 rounded-full">
                                            Apple Pie
                                        </div>
                                    </th>
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-medium px-2 py-0.5 rounded bg-primary-900 text-primary-300">
                                            <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded bg-red-900 text-red-300" id="status">pending</span>
                                        </span>
                                    </td>
                                </tr>
                                <tr id="accor-upd-proc-1" class="hidden" aria-labelledby="accor-upd-proc-1">
                                    <td class="p-5 bg-gray-900 relative overflow-x-auto" colspan="3">
                                        <table class="w-full text-sm text-left rtl:text-right text-gray-400">
                                            <thead class="text-xs uppercase text-gray-400">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3">

                                                    </th>
                                                    <th scope="col" class="px-6 py-3">
                                                        Old Data
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 bg-gray-800">
                                                        New Data
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="border-b border-gray-700">
                                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white bg-gray-800 uppercase">
                                                        Product name
                                                    </th>
                                                    <td class="px-6 py-4"> mie goreng
                                                    </td>
                                                    <td class="px-6 py-4 bg-gray-800"> mie ayam
                                                    </td>
                                                </tr>
                                                <tr class="border-b border-gray-700">
                                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white bg-gray-800 uppercase">
                                                        Price
                                                    </th>
                                                    <td class="px-6 py-4">10000
                                                    </td>
                                                    <td class="px-6 py-4 bg-gray-800">12000
                                                    </td>
                                                </tr>
                                                <tr class="border-b border-gray-700">
                                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white bg-gray-800 uppercase">
                                                        Stock
                                                    </th>
                                                    <td class="px-6 py-4">10
                                                    </td>
                                                    <td class="px-6 py-4 bg-gray-800">12
                                                    </td>
                                                </tr>
                                                <tr class="border-b border-gray-700">
                                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white bg-gray-800 uppercase">
                                                        Category
                                                    </th>
                                                    <td class="px-6 py-4">Food
                                                    </td>
                                                    <td class="px-6 py-4 bg-gray-800">Food
                                                    </td>
                                                </tr>
                                                <tr class="border-b border-gray-700">
                                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white bg-gray-800 uppercase">
                                                        Available
                                                    </th>
                                                    <td class="px-6 py-4">true
                                                    </td>
                                                    <td class="px-6 py-4 bg-gray-800">true
                                                    </td>
                                                </tr>
                                                <tr class="border-b border-gray-700">
                                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white bg-gray-800 uppercase">
                                                        Img
                                                    </th>
                                                    <td class="px-6 py-4">
                                                        <img src="https://www.kkisitb1.com/wp-content/uploads/2022/11/indomieaceh1.jpg" class="w-full rounded-lg" alt="">
                                                    </td>
                                                    <td class="px-6 py-4 bg-gray-800">
                                                        <img src="https://www.kkisitb1.com/wp-content/uploads/2022/11/indomieaceh1.jpg" class="w-full rounded-lg" alt="">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="block flex justify-end mt-3 gap-3">
                                            <button type="button" class="py-2 px-3 flex items-center text-white text-sm font-medium text-center focus:outline-none rounded-lg border focus:ring-green-700 text-green-400 border-green-600 hover:text-white hover:bg-green-700 mr-3" onclick="" id="">
                                                <svg class="h-4 w-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                </svg>
                                                Approved
                                            </button>
                                            <button type="button" class="flex items-center hover:text-white border font-medium rounded-lg text-sm px-3 py-2 text-center border-red-500 text-red-500 hover:text-white hover:bg-red-600 focus:ring-red-900" onclick="" id="">
                                                <svg class="h-4 w-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                                                </svg>
                                                Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- end template update -->
                            </tbody>
                        </table>
                    </div>
                    <div class="hidden rounded-lg bg-gray-800" id="create" role="tabpanel" aria-labelledby="create-tab">
                        <table class="w-full text-sm text-left text-gray-400 rounded-t-lg">
                            <thead class="text-xs rounded-t-lg uppercase bg-gray-900 text-gray-400">
                                <!-- start template create -->
                                <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-400">
                                        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                                            <tr>
                                                <th scope="col" class="p-4">
                                                    <div class="flex items-center">
                                                        <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-primary-600 rounded focus:ring-primary-600 ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600">
                                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Product name
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Price
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Stock
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Category
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Available
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Img
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Status
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-b bg-gray-800 border-gray-700">
                                                <td class="p-4 w-4">
                                                    <div class="flex items-center">
                                                        <input id="checkbox-table-search-1" type="checkbox" onclick="event.stopPropagation()" class="w-4 h-4 text-primary-600 rounded focus:ring-primary-600 ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600">
                                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                                    </div>
                                                </td>
                                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-white">
                                                    Mie kuah
                                                </th>
                                                <td class="px-6 py-4">
                                                    3000
                                                </td>
                                                <td class="px-6 py-4">
                                                    10
                                                </td>
                                                <td class="px-6 py-4">
                                                    Food
                                                </td>
                                                <td class="px-6 py-4">
                                                    True
                                                </td>
                                                <td class="text-center">
                                                    <img src="https://lzd-img-global.slatic.net/g/p/66d6ba51a0d95fd32a291b65723fc326.png_720x720q80.png" class="h-12 w-auto rounded-full ms-3" alt="">
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded bg-red-900 text-red-300">Pending</span>
                                                </td>
                                                <td class="px-6 py-4 flex items-center">
                                                    <button type="button" class="py-2 px-3 flex items-center text-white text-sm font-medium text-center focus:outline-none rounded-lg border focus:ring-green-700 text-green-400 border-green-600 hover:text-white hover:bg-green-700 mr-3" onclick="" id="">
                                                        <svg class="h-4 w-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                        </svg>
                                                        Approved
                                                    </button>
                                                    <button type="button" class="flex items-center hover:text-white border font-medium rounded-lg text-sm px-3 py-2 text-center border-red-500 text-red-500 hover:text-white hover:bg-red-600 focus:ring-red-900" onclick="" id="">
                                                        <svg class="h-4 w-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                                                        </svg>
                                                        Reject
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end template create -->
                                </tbody>
                        </table>
                    </div>
                    <div class="hidden rounded-lg bg-gray-800" id="delete" role="tabpanel" aria-labelledby="delete-tab">
                        <table class="w-full text-sm text-left text-gray-400 rounded-t-lg">
                            <thead class="text-xs rounded-t-lg uppercase bg-gray-900 text-gray-400">
                                <!-- start template delete -->
                                <div class="relative overflow-x-auto">
                                    <table class="w-full text-sm text-left rtl:text-right text-gray-400">
                                        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                                            <tr>
                                                <th scope="col" class="p-4 w-4">
                                                    <div class="flex items-center">
                                                        <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-primary-600 rounded focus:ring-primary-600 ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600">
                                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Product name
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Status
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-b bg-gray-800 border-gray-700">
                                                <td class="p-4">
                                                    <div class="flex items-center">
                                                        <input id="checkbox-table-search-1" type="checkbox" onclick="event.stopPropagation()" class="w-4 h-4 text-primary-600 rounded  focus:ring-primary-600 ring-offset-gray-800 focus:ring-2 bg-gray-700 border-gray-600">
                                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                                    </div>
                                                </td>
                                                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white flex items-center">
                                                    Mie kuah
                                                </th>
                                                <td class="px-6 py-4">
                                                    <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded bg-red-900 text-red-300">Pending</span>
                                                </td>
                                                <td class="px-6 py-4 flex items-center">
                                                    <button type="button" class="py-2 px-3 flex items-center text-white text-sm font-medium text-center focus:outline-none rounded-lg border focus:ring-green-700 text-green-400 border-green-600 hover:text-white hover:bg-green-700 mr-3" onclick="" id="">
                                                        <svg class="h-4 w-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                        </svg>
                                                        Approved
                                                    </button>
                                                    <button type="button" class="flex items-center hover:text-white border font-medium rounded-lg text-sm px-3 py-2 text-center border-red-500 text-red-500 hover:text-white hover:bg-red-600 focus:ring-red-900" onclick="" id="">
                                                        <svg class="h-4 w-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                                                        </svg>
                                                        Reject
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end template delete -->
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function initPageData() {
        const reqContainer = document.getElementById('req-list');

        let headersList = {
            "Accept": "*/*",
            "Authorization": `Bearer ${getCookie('Bearer')}`
        }

        fetch('/api/requests', {
                method: 'GET',
                headers: headersList
            })
            .then(response => response.json())
            .then(result => {
                console.log(result.data)

                result.data.map(value => {

                    // <th scope="row" class="px-4 py-3 font-medium whitespace-nowrap text-white">${value.name}</th>
                    // <td class="px-4 py-3 text-white">Rp. 3000 -> Rp. 5000</td>
                    const template = `
                    <tr class="border-b border-gray-700">
                    <td class="px-4 py-3 text-white text-center">
                        ${value.creatorName}
                    </td>
                    <td class="px-4 py-3 text-white text-center">${new Date(value.created_at * 1000).toLocaleString()}</td>
                    <td class="px-4 py-3 text-white flex justify-center">
                        <button type="button" class="flex items-center hover:text-white border font-medium rounded-lg text-sm px-3 py-2 text-center border-sky-500 text-sky-500 hover:text-white hover:bg-sky-600 focus:ring-sky-900 transition-all ease-in duration-200" onclick="detailButtonPress(this)" id="${value._id.toString()}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5 mr-2 -ml-0.5" fill="currentColor">
                                <path d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z"></path>
                            </svg>
                            Detail
                        </button>
                    </td>
                </tr>
                    `
                    reqContainer.innerHTML += template
                })

            })
    }

    initPageData()
</script>