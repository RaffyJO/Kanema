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


<div class="w-full bg-gray-800 relative shadow-md rounded-lg overflow-hidden col-span-2">
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
                    <!-- <th scope="col" class="px-4 py-4">Product name</th> -->
                    <th scope="col" class="px-4 py-3 text-center">Creator</th>
                    <!-- <th scope="col" class="px-4 py-3">Description</th> -->
                    <th scope="col" class="px-4 py-3 text-center">Date</th>
                    <th scope="col" class="p-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody id="req-list">

            </tbody>
        </table>
    </div>
</div>
<div id="select-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Open positions
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="select-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <p class="text-gray-500 dark:text-gray-400 mb-4">Select your desired position:</p>
                <ul class="space-y-4 mb-4">
                    <li>
                        <input type="radio" id="job-1" name="job" value="job-1" class="hidden peer" required>
                        <label for="job-1" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                            <div class="block">
                                <div class="w-full text-lg font-semibold">UI/UX Engineer</div>
                                <div class="w-full text-gray-500 dark:text-gray-400">Flowbite</div>
                            </div>
                            <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="job-2" name="job" value="job-2" class="hidden peer">
                        <label for="job-2" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                            <div class="block">
                                <div class="w-full text-lg font-semibold">React Developer</div>
                                <div class="w-full text-gray-500 dark:text-gray-400">Alphabet</div>
                            </div>
                            <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </label>
                    </li>
                    <li>
                        <input type="radio" id="job-3" name="job" value="job-3" class="hidden peer">
                        <label for="job-3" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                            <div class="block">
                                <div class="w-full text-lg font-semibold">Full Stack Engineer</div>
                                <div class="w-full text-gray-500 dark:text-gray-400">Apple</div>
                            </div>
                            <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </label>
                    </li>
                </ul>
                <button class="text-white inline-flex w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Next step
                </button>
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