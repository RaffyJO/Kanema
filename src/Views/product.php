<?php

require_once('src/Views/templates/source.php');
if (!isset($TPL)) {
    $TPL = new source();
    $TPL->title = "Product Page";
    $TPL->bodycontent = __FILE__;
    include "src/Views/layout/layout.php";
    exit;
}
?>

            <div class="flex lg:flex-row flex-col-reverse">
                <!-- left section -->
                <div class="w-full lg:w-3/5 min-h-screen">
                    <!-- categories -->
                    <div class="mb-4 ">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="allItems-tab" data-tabs-target="#allItems" type="button" role="tab" aria-controls="allItems" aria-selected="false">All Product</button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="food-tab" data-tabs-target="#food" type="button" role="tab" aria-controls="food" aria-selected="false">Food</button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="drink-tab" data-tabs-target="#drink" type="button" role="tab" aria-controls="drink" aria-selected="false">Drink</button>
                            </li>
                        </ul>
                    </div>
                    <!-- end categories -->
                    <!-- products -->
                    <div id="default-tab-content">
                        <div class="hidden p-4 rounded-lg" id="allItems" role="tabpanel" aria-labelledby="allItems-tab">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <div>
                                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow">
                                        <a href="#">
                                            <img class="rounded-t-lg" src="https://www.indomie.com/uploads/product/indomie-mi-goreng-special_detail_094906814.png" alt="" />
                                        </a>
                                        <div class="p-3 bg-blue-300 rounded-b-lg flex flex-col items-center justify-center">
                                            <a href="#">
                                                <h5 class="mb-2 text-lg font-normal tracking-tight">Indomie Goreng</h5>
                                            </a>
                                            <p class="mb-3 text-xl font-bold">Rp. 3000</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden p-4 rounded-lg" id="food" role="tabpanel" aria-labelledby="food-tab">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <div>
                                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow">
                                        <a href="#">
                                            <img class="rounded-t-lg" src="https://www.indomie.com/uploads/product/indomie-mi-goreng-special_detail_094906814.png" alt="" />
                                        </a>
                                        <div class="p-3 bg-blue-300 rounded-b-lg flex flex-col items-center justify-center">
                                            <a href="#">
                                                <h5 class="mb-2 text-lg font-normal tracking-tight">Nasi Goreng</h5>
                                            </a>
                                            <p class="mb-3 text-xl font-bold">Rp. 3000</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden p-4 rounded-lg" id="drink" role="tabpanel" aria-labelledby="drink-tab">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <div>
                                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow">
                                        <a href="#">
                                            <img class="rounded-t-lg" src="https://www.indomie.com/uploads/product/indomie-mi-goreng-special_detail_094906814.png" alt="" />
                                        </a>
                                        <div class="p-3 bg-blue-300 rounded-b-lg flex flex-col items-center justify-center">
                                            <a href="#">
                                                <h5 class="mb-2 text-lg font-normal tracking-tight">Coca-cola</h5>
                                            </a>
                                            <p class="mb-3 text-xl font-bold">Rp. 3000</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end products -->
                </div>
            <!-- end left section -->
            <!-- right section -->
            <div class="w-full lg:w-2/5 shadow-xl">
                <!-- header -->
                <div class="flex flex-row items-center justify-between px-5 mt-5">
                <div class="font-bold text-xl">Current Order</div>
                <div class="font-semibold">
                    <span class="px-4 py-2 rounded-md bg-red-100 text-red-500">Clear All</span>
                </div>
                </div>
                <!-- end header -->
                <!-- order list -->
                <div class="px-5 py-4 mt-5 overflow-y-auto h-64">
                    <div class="flex flex-row justify-between items-center mb-4">
                        <div class="flex flex-row items-center w-2/5">
                            <img src="https://www.indomie.com/uploads/product/indomie-mi-goreng-special_detail_094906814.png" class="w-10 h-10 object-cover rounded-md" alt="">
                            <span class="ml-4 font-semibold text-sm">Indomie</span>
                        </div>
                        <div class="w-32 flex justify-center">
                            <div class="relative flex items-center">
                                <button type="button" id="decrement-button" data-input-counter-decrement="counter-input" class="flex-shrink-0 bg-red-500 hover:bg-red-700 inline-flex items-center justify-center rounded-md h-5 w-5 focus:ring-gray-100">
                                    <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                                    </svg>
                                </button>
                                <input type="text" id="counter-input" data-input-counter class="flex-shrink-0  border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center" placeholder="" value="1" required>
                                <button type="button" id="increment-button" data-input-counter-increment="counter-input" class="flex-shrink-0 bg-green-500 hover:bg-green-700 inline-flex items-center justify-center rounded-md h-5 w-5 focus:ring-gray-100">
                                    <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="font-semibold text-sm w-16 text-center">
                            Rp. 3000
                        </div>
                    </div>
                </div>
                <!-- end order list -->
                <!-- totalItems -->
                <div class="px-5 mt-5">
                <div class="py-4 rounded-md shadow-lg">
                    <div class=" px-4 flex justify-between ">
                    <span class="font-semibold text-sm">Subtotal</span>
                    <span class="font-bold">Rp. 3000</span>
                    </div>
                    <div class=" px-4 flex justify-between ">
                    <span class="font-semibold text-sm">Discount</span>
                    <span class="font-bold">Rp. 0</span>
                    </div>
                    <div class="border-t-2 mt-3 py-2 px-4 flex items-center justify-between">
                    <span class="font-semibold text-2xl">Total</span>
                    <span class="font-bold text-2xl">Rp. 3000</span>
                    </div>
                </div>
                </div>
                <!-- end total -->
                <!-- button pay-->
                <div class="px-5 mt-5">
                <a href="#" class="block px-4 py-4 rounded-md shadow-lg text-center bg-blue-300 text-white font-semibold">
                    Process
                </a>
                </div>
                <!-- end button pay -->
            </div>
            <!-- end right section -->
            </div>