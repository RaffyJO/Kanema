<?php

require_once __DIR__ . '/templates/source.php';
if (!isset($TPL)) {
    $TPL = new source();
    $TPL->title = "Kanema";
    $TPL->bodycontent = __FILE__;
    include "src/Views/layout/no_layout.php";
    exit;
}
?>

<nav class="bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-600 p-4 text-center flex justify-center">
    <a href="#" class="">
        <img src="src/lib/Assets/Kanema.png" class="max-h-8 w-fit" alt="">
    </a>
</nav>
<div class="mt-16 p-4">
    <span class="font-bold text-2xl mb-4">List Jualan Kantin</span>
    <div class="w-full h-fit">
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
            <div class="w-full flex justify-center h-[15rem] align-middle" id="container-spinner">
                <div role="status" id="loading-el" class="m-auto">
                    <svg aria-hidden="true" class="inline w-10 h-10text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="p-4 rounded-lg grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 w-full" id="allItems" role="tabpanel" aria-labelledby="allItems-tab">
            </div>
            <div class="hidden p-4 rounded-lg grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 w-full" id="food" role="tabpanel" aria-labelledby="food-tab">
            </div>
            <div class="hidden p-4 rounded-lg grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 w-full" id="drink" role="tabpanel" aria-labelledby="drink-tab">
            </div>
        </div>
    </div>
</div>

<script>
    function formatToIDR(number) {
        // Format the number to IDR currency
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(number).replaceAll(',00', '');
    }

    function initPageData() {
        const productContainer = document.getElementById('default-tab-content');
        const allitemsContainer = document.getElementById('allItems')
        const foodsContainer = document.getElementById('food')
        const drinksContainer = document.getElementById('drink')

        if (productContainer) {
            fetch('/api/products', {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(result => {
                    let elements = '';

                    let allItem = ''
                    let foodItems = ''
                    let drinkItems = ''

                    result.data.forEach(content => {
                        if (content.available)
                            allItem += `
                            <button class="bg-white border border-gray-200 rounded-lg shadow-2xl drop-shadow-lg col-span-1 w-full h-fit transition-all duration-200 ease-in" onclick="getItem(this)" id="${content._id}">
                                <div class="h-3/5 w-full">
                                    <img class="rounded-t-lg w-full aspect-square object-cover object-center" src="${content.imgUrl}" alt="item-pict" id="item-picture" />
                                </div>
                                <div class="p-3 bg-gray-800 text-white rounded-b-lg flex flex-col items-center justify-center">
                                    <h5 class="mb-0 text-lg font-normal tracking-tight" id="item-name">${content.name}</h5>
                                    <p class="text-xl font-bold" id="item-price">${formatToIDR(content.price)}</p>
                                    <span id="item-stock">Tersisa : ${content.stock}</span>
                                </div>
                            </button>`

                        if (content.category == 'food' && content.available) {
                            foodItems += `
                            <button class="bg-white border border-gray-200 rounded-lg shadow-2xl drop-shadow-lg col-span-1 w-full h-fit transition-all duration-200 ease-in" onclick="getItem(this)" id="${content._id}">
                                <div class="h-3/5 w-full">
                                    <img class="rounded-t-lg w-full aspect-square object-cover object-center" src="${content.imgUrl}" alt="item-pict" id="item-picture" />
                                </div>
                                <div class="p-3 bg-gray-800 text-white rounded-b-lg flex flex-col items-center justify-center">
                                    <h5 class="mb-0 text-lg font-normal tracking-tight" id="item-name">${content.name}</h5>
                                    <p class="text-xl font-bold" id="item-price">${formatToIDR(content.price)}</p>
                                    <span id="item-stock">Tersisa : ${content.stock}</span>
                                </div>
                            </button>`
                        }

                        if (content.category == 'drink' && content.available) {
                            drinkItems += `
                        <button class="bg-white border border-gray-200 rounded-lg shadow-2xl drop-shadow-lg col-span-1 w-full h-fit transition-all duration-200 ease-in" onclick="getItem(this)" id="${content._id}">
                                <div class="h-3/5 w-full">
                                    <img class="rounded-t-lg w-full aspect-square object-cover object-center" src="${content.imgUrl}" alt="item-pict" id="item-picture" />
                                </div>
                                <div class="p-3 bg-gray-800 text-white rounded-b-lg flex flex-col items-center justify-center">
                                    <h5 class="mb-0 text-lg font-normal tracking-tight" id="item-name">${content.name}</h5>
                                    <p class="text-xl font-bold" id="item-price">${formatToIDR(content.price)}</p>
                                    <span id="item-stock">Tersisa : ${content.stock}</span>
                                </div>
                            </button>`
                        }

                    });

                    let allitem = `${allItem}`
                    let foods = `${foodItems}`
                    let drinks = `${drinkItems}`

                    if (document.getElementById('container-spinner') !== null)
                        document.getElementById('container-spinner').remove()
                    // productContainer.innerHTML += elements;
                    allitemsContainer.innerHTML = allitem
                    foodsContainer.innerHTML = foods
                    drinksContainer.innerHTML = drinks

                }).catch(error => console.error(error))
        } else {
            console.error('Product container not found!');
        }
    }


    initPageData()
</script>