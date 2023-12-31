<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$current_page = $_SERVER['REQUEST_URI'];
?>

<script src="src/lib/Functions/CookieUtils.js"></script>
<script src="src/lib/Functions/NavUtils.js"></script>
<script>
    function signout() {
        destroyBearer()
        window.location.href = '/login'
    }
</script>

<nav class="fixed top-0 z-50 w-full border-b border-gray-200 bg-gray-800">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 text-gray-400 hover:bg-gray-700 focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <a href="#" class="flex ms-2 md:me-24">
                    <img src="src/lib/Assets/Kanema.png" class="max-h-8 w-fit" alt="">
                </a>
            </div>
            <!-- <form class="w-2/5">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-black-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="default-search" class="block w-full p-1 ps-10 text-sm rounded-lg bg-blue-100 text-black" placeholder="Search in Kanema" required>
                </div>
            </form> -->
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTOuxrvcNMfGLh73uKP1QqYpKoCB0JLXiBMvA" alt="user photo">
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none divide-y divide-gray-100 rounded shadow bg-gray-700 divide-gray-600" id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 text-white" role="none" id="nav-username">
                            </p>
                            <p class="text-sm font-bold truncate text-white" role="none" id="nav-role">
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <button class="block px-4 py-2 text-sm text-white hover:bg-gray-100 text-gray-300 hover:bg-gray-600 w-full" role="menuitem" onclick="signout()">Sign out</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- end nav -->
<!-- sidebar -->
<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full border-r border-gray-200 sm:translate-x-0 bg-gray-800" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/" class="flex items-center p-2 text-gray-900 rounded-lg text-white hover:bg-gray-100 hover:bg-gray-700 group <?= ($current_page === '/') ? 'bg-gray-700' : 'hover:bg-gray-100 hover:bg-gray-700 group'; ?>">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 text-gray-400 group-hover:text-gray-900 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/product" class="flex items-center p-2 text-gray-900 rounded-lg text-white hover:bg-gray-100 hover:bg-gray-700 group  <?= ($current_page === '/product') ? 'bg-gray-700' : 'hover:bg-gray-100 hover:bg-gray-700 group'; ?>">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 text-gray-400 group-hover:text-gray-900 group-hover:text-white w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                        <path d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Product</span>
                </a>
            </li>
            <li id="cashier">
                <a href="/cashier" class="flex items-center p-2 text-gray-900 rounded-lg text-white hover:bg-gray-100 hover:bg-gray-700 group <?= ($current_page === '/cashier') ? 'bg-gray-700' : 'hover:bg-gray-100 hover:bg-gray-700 group'; ?>">
                    <svg class="lex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 text-gray-400 group-hover:text-gray-900 group-hover:text-white w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 21">
                        <path d="M15 14H7.78l-.5-2H16a1 1 0 0 0 .962-.726l.473-1.655A2.968 2.968 0 0 1 16 10a3 3 0 0 1-3-3 3 3 0 0 1-3-3 2.97 2.97 0 0 1 .184-1H4.77L4.175.745A1 1 0 0 0 3.208 0H1a1 1 0 0 0 0 2h1.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 10 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3Zm-8 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm8 0a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                        <path d="M19 3h-2V1a1 1 0 0 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 0 0 2 0V5h2a1 1 0 1 0 0-2Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Cashier</span>
                </a>
            </li>
            <li id="request">
                <a href="/request" class="flex items-center p-2 text-gray-900 rounded-lg text-white hover:bg-gray-100 hover:bg-gray-700 group <?= ($current_page === '/request') ? 'bg-gray-700' : 'hover:bg-gray-100 hover:bg-gray-700 group'; ?>">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 text-gray-400 group-hover:text-gray-900 group-hover:text-white w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M6 1h10M6 5h10M6 9h10M1.49 1h.01m-.01 4h.01m-.01 4h.01" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Request</span>
                    <!-- <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full bg-blue-900 text-blue-300">3</span> -->
                </a>
            </li>
            <li id="inbox">
                <a href="/inbox" class="flex items-center p-2 text-gray-900 rounded-lg text-white hover:bg-gray-100 hover:bg-gray-700 group <?= ($current_page === '/inbox') ? 'bg-gray-700' : 'hover:bg-gray-100 hover:bg-gray-700 group'; ?>">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 text-gray-400 group-hover:text-gray-900 group-hover:text-white w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Inbox</span>
                    <!-- <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full bg-blue-900 text-blue-300">3</span> -->
                </a>
            </li>
            <li>
                <a href="/history" class="flex items-center p-2 text-gray-900 rounded-lg text-white hover:bg-gray-100 hover:bg-gray-700 group <?= ($current_page === '/history') ? 'bg-gray-700' : 'hover:bg-gray-100 hover:bg-gray-700 group'; ?>">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 text-gray-400 group-hover:text-gray-900 group-hover:text-white w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">History</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<!-- end sidebar -->
</div>

<script>
    getUsername().then(result => {
        // console.log(window.location.href)
        const url = document.URL
        if (url.includes('/request') && result.role.toLowerCase() !== 'owner') window.location.href = '/404'

        const navUsername = document.getElementById('nav-username');
        const navRole = document.getElementById('nav-role');

        // kalau mau menghilangkan menu komen if dibawah ini
        // if (result.role == 'admin') {
        //     document.getElementById('cashier').classList.add('hidden')
        //     document.getElementById('inbox').classList.add('hidden')
        // }
        // if (result.role == 'cashier') {
        //     document.getElementById('request').classList.add('hidden')
        // }

        navUsername.textContent = result.username
        navRole.textContent = result.role

        if (result.role.toLowerCase() !== 'owner') document.getElementById('request').remove()
    }).catch(err => console.error(err))
</script>