<?php

require_once __DIR__ . '/templates/source.php';
if (!isset($TPL)) {
    $TPL = new source();
    $TPL->title = "Cashier Page";
    $TPL->bodycontent = __FILE__;
    include "src/Views/layout/layout.php";
    exit;
}
?>

<script type="text/javascript" src="src/lib/Functions/CookieUtils.js"></script>
<script>
    let orderItemPlan = [];

    function getItem(element) {
        let content = {
            id: null,
            name: null,
            price: null,
            imgUrl: null,
            amount: 0
        }

        const itemName = element.querySelector('#item-name');
        const itemPrice = element.querySelector('#item-price');
        const itemPicture = element.querySelector('#item-picture');


        content.id = element.getAttribute('id');
        content.name = itemName.innerText
        content.price = itemPrice.innerText;
        content.imgUrl = itemPicture.getAttribute('src');
        content.amount++;

        if (orderItemPlan.some(value => value.id.toString() == content.id.toString())) {
            const index = orderItemPlan.findIndex(value => value.id == content.id)

            // console.log(index)

            orderItemPlan[index].amount++
            content = orderItemPlan[index]
        }

        if (!orderItemPlan.some(value => value.id.toString() == content.id.toString()))
            orderItemPlan.push(content);

        addOrder(content)
        content = null
    }

    function addOrder(content) {
        let orderContainer = document.querySelector('#order-container')
        const id = content.id.toString();


        const template = orderTemplate(content.id, content.name, content.price, content.amount, content.imgUrl);
        let hasValue;

        hasValue = orderContainer.querySelectorAll('#order')

        let isExist;

        if (hasValue.length != 0) {
            const value = hasValue.values()
            const nodesArray = [...value]

            isExist = nodesArray.some(el => isExist = el.getAttribute('value') == id)
        }

        if (hasValue.length == 0) isExist = false

        if (!isExist) {
            orderContainer.innerHTML += template
        } else {
            hasValue.forEach(el => {
                if (el.getAttribute('value') == id) {
                    el.querySelector('#counter-input').setAttribute('value', content.amount)
                }
            })
        }

        calcPrices()
    }

    function orderTemplate(id, name, price, amount, imgUrl) {
        return `
        <div class="flex flex-row justify-between items-center mb-4" id="order" value="${id}">
                    <div class="flex flex-row items-center w-2/5">
                        <img src="${imgUrl}" class="w-10 h-10 object-cover rounded-md" alt="">
                        <span class="ml-4 font-semibold text-sm">${name}</span>
                    </div>
                    <div class="w-32 flex justify-center">
                        <div class="relative flex items-center">
                            <button type="button" id="decrement-button" data-input-counter-decrement="counter-input" class="flex-shrink-0 bg-red-500 hover:bg-red-700 inline-flex items-center justify-center rounded-md h-5 w-5 focus:ring-gray-100" onclick="reduce('${id}')">
                                <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                </svg>
                            </button>
                            <input type="text" id="counter-input" data-input-counter class="flex-shrink-0  border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center" placeholder="" value="${amount}" required>
                            <button type="button" id="increment-button" data-input-counter-increment="counter-input" class="flex-shrink-0 bg-green-500 hover:bg-green-700 inline-flex items-center justify-center rounded-md h-5 w-5 focus:ring-gray-100" onclick="increase('${id}')">
                                <svg class="w-2.5 h-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
        `
    }

    function calcPrices() {
        let subTotal = document.getElementById('subtotal')
        let total = document.getElementById('total')

        let sub = 0;

        let content = {
            id: null,
            name: null,
            price: null,
            imgUrl: null,
            amount: 0
        }

        if (orderItemPlan !== null && orderItemPlan.length > 0) {
            orderItemPlan.forEach(value => {
                sub += parseIDRToNumber(value.price) * Number.parseInt(value.amount)
            });

            validateSubmit()
        }

        subTotal.innerText = formatToIDR(sub);
        total.innerText = formatToIDR(sub)

        validateSubmit()
    }

    function reduce(id) {
        let orderContainer = document.querySelector('#order-container')
        let idx;
        const INVALID_IDX = -1
        let isExist = false

        let currentData = {
            id: null,
            name: null,
            price: null,
            imgUrl: null,
            amount: 0
        }


        if (orderItemPlan.some(value => value.id.toString() == id.toString())) {
            idx = orderItemPlan.findIndex(value => value.id == id)

            orderItemPlan[idx].amount--;
            currentData = orderItemPlan[idx];

            if (orderItemPlan[idx].amount < 1)
                orderItemPlan.splice(idx, 1);
        }

        if (idx == INVALID_IDX) return;

        let hasValue = orderContainer.querySelectorAll('#order');

        if (hasValue.length != 0) {
            const value = hasValue.values()
            const nodesArray = [...value]

            isExist = nodesArray.some(el => isExist = el.getAttribute('value') == id)
        }

        if (hasValue.length == 0) isExist = false;

        if (isExist) {
            hasValue.forEach(el => {
                if (el.getAttribute('value') == id) {
                    if (0 == currentData.amount) {
                        orderContainer.removeChild(el)
                    }

                    if (0 != currentData.amount)
                        el.querySelector('#counter-input').setAttribute('value', currentData.amount)
                }
            })
        }

        calcPrices()
    }

    function increase(id) {
        let orderContainer = document.querySelector('#order-container')
        let idx;
        const INVALID_IDX = -1
        let isExist = false

        let currentData = {
            id: null,
            name: null,
            price: null,
            imgUrl: null,
            amount: 0
        }


        if (orderItemPlan.some(value => value.id.toString() == id.toString())) {
            idx = orderItemPlan.findIndex(value => value.id == id)

            orderItemPlan[idx].amount++;
            currentData = orderItemPlan[idx];
        }

        if (idx == INVALID_IDX) return;

        let hasValue = orderContainer.querySelectorAll('#order');

        if (hasValue.length != 0) {
            const value = hasValue.values()
            const nodesArray = [...value]

            isExist = nodesArray.some(el => isExist = el.getAttribute('value') == id)
        }

        if (hasValue.length == 0) isExist = false;

        if (isExist) {
            hasValue.forEach(el => {
                if (el.getAttribute('value') == id) {
                    // if (0 == currentData.amount) {
                    //     orderContainer.appendChild(el)
                    // }

                    if (0 != currentData.amount)
                        el.querySelector('#counter-input').setAttribute('value', currentData.amount)
                }
            })
        }

        calcPrices()
    }

    function clearOrder() {
        let orderContainer = document.querySelector('#order-container');
        let hasValue = orderContainer.querySelectorAll('#order');

        hasValue.forEach(el => {
            orderContainer.removeChild(el)
        })

        orderItemPlan = []
        calcPrices()
    }

    function validateSubmit() {
        const submitButton = document.getElementById('submit-btn')

        if (orderItemPlan.length > 0) {
            submitButton.disabled = false
        } else {
            submitButton.disabled = true
        }
    }

    function formatToIDR(number) {
        // Format the number to IDR currency
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(number).replaceAll(',00', '');
    }

    function parseIDRToNumber(idrString) {
        // Remove non-numeric characters (including currency symbol 'IDR', 'Rp', and commas)
        let numericString = idrString.replaceAll(',00', '');

        numericString = numericString.replace('Rp', '');
        // numericString = idrString.replace(/[^\d.,]/g, '');

        // Replace comma (,) with empty string for proper parsing
        numericString = numericString.replace(/,/g, '');
        numericString = numericString.replaceAll('.', '');
        console.log(numericString)

        // Parse the string to a number
        let numberValue = Number.parseInt(numericString);

        return isNaN(numberValue) ? 0 : numberValue; // Return 0 if parsing fails
    }
</script>

<div class="flex lg:flex-row flex-col-reverse h-fit pb-5" id="main-container">
    <!-- left section -->
    <div class="w-full lg:w-3/5 h-fit">
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
            <div class="p-4 rounded-lg grid grid-cols-2 max-sm:grid-cols-1 md:grid-cols-3 gap-4 w-full" id="allItems" role="tabpanel" aria-labelledby="allItems-tab">
            </div>
            <div class="hidden p-4 rounded-lg grid grid-cols-2 max-sm:grid-cols-1 md:grid-cols-3 gap-4 w-full" id="food" role="tabpanel" aria-labelledby="food-tab">
            </div>
            <div class="hidden p-4 rounded-lg grid grid-cols-2 max-sm:grid-cols-1 md:grid-cols-3 gap-4 w-full" id="drink" role="tabpanel" aria-labelledby="drink-tab">
            </div>
        </div>
        <!-- end products -->
    </div>
    <!-- end left section -->
    <!-- right section -->
    <div class="flex flex-col lg:w-2/5">
        <div class="w-full md:w-3/5 mt-3 mb-5">
            <form class="flex items-center">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="simple-search" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2  border-gray-600 placeholder-gray-400 text-white text-black" placeholder="Search" required="">
                </div>
            </form>
        </div>
        <div class="w-full shadow-xl h-fit pb-5 rounded-lg">
            <!-- header -->
            <div class="flex flex-row items-center justify-between px-5 mt-5">
                <div class="font-bold text-xl">Current Order</div>
                <div class="font-semibold">
                    <button class="px-4 py-2 rounded-md bg-red-100 text-red-500" onclick="clearOrder()">Clear All</button>
                </div>
            </div>
            <!-- end header -->
            <!-- order list -->
            <div class="px-5 py-4 mt-5 overflow-y-auto h-64" id="order-container">
                <!-- 
                
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
            <div class="font-semibold text-sm w-16 text-center">
                Rp. 3000
            </div>
        </div> -->
            </div>
            <!-- end order list -->
            <!-- totalItems -->
            <div class="px-5 mt-5">
                <div class="py-4 rounded-md shadow-lg">
                    <div class=" px-4 flex justify-between ">
                        <span class="font-semibold text-sm">Subtotal</span>
                        <span class="font-bold" id="subtotal">Rp 0</span>
                    </div>
                    <div class=" px-4 flex justify-between ">
                        <span class="font-semibold text-sm">Discount</span>
                        <span class="font-bold" id="discount">Rp 0</span>
                    </div>
                    <div class="border-t-2 mt-3 py-2 px-4 flex items-center justify-between">
                        <span class="font-semibold text-2xl">Total</span>
                        <span class="font-bold text-2xl" id="total">Rp 0</span>
                    </div>
                </div>
            </div>
            <!-- end total -->
            <!-- button pay-->
            <div class="px-5 mt-5">
                <button href="#" class="block px-4 py-4 rounded-md shadow-lg text-center bg-blue-500 disabled:bg-blue-300 disabled:cursor-not-allowed text-white font-semibold w-full transition-all duration-200 ease-in" disabled onclick="submitOrder()" id="submit-btn">
                    Process
                </button>
            </div>
            <!-- end button pay -->
        </div>
    </div>
    <!-- end right section -->
</div>

<script>
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
                // let other = `<div class="p-4 rounded-lg" id="allItems" role="tabpanel" aria-labelledby="allItems-tab"> </div>`

                let allItem = ''
                let foodItems = ''
                let drinkItems = ''

                result.data.forEach(content => {
                    // console.table(content)
                    allItem += `
                            <button class="bg-white border border-gray-200 rounded-lg shadow-2xl drop-shadow-lg col-span-1 w-full h-fit transition-all duration-200 ease-in" onclick="getItem(this)" id="${content._id}">
                                <div class="h-3/5 w-full">
                                    <img class="rounded-t-lg w-full h-full object-contain object-center" src="${content.imgUrl}" alt="item-pict" id="item-picture" />
                                </div>
                                <div class="p-3 bg-gray-800 text-white rounded-b-lg flex flex-col items-center justify-center">
                                    <h5 class="mb-2 text-lg font-normal tracking-tight" id="item-name">${content.name}</h5>
                                    <p class="mb-3 text-xl font-bold" id="item-price">${formatToIDR(content.price)}</p>
                                </div>
                            </button>`

                    if (content.category == 'food') {
                        foodItems += `
                            <button class="bg-white border border-gray-200 rounded-lg shadow-2xl drop-shadow-lg col-span-1 w-full h-fit transition-all duration-200 ease-in" onclick="getItem(this)" id="${content._id}">
                                <div class="h-3/5 w-full">
                                    <img class="rounded-t-lg w-full h-full object-contain object-center" src="${content.imgUrl}" alt="item-pict" id="item-picture" />
                                </div>
                                <div class="p-3 bg-gray-800 text-white rounded-b-lg flex flex-col items-center justify-center">
                                    <h5 class="mb-2 text-lg font-normal tracking-tight" id="item-name">${content.name}</h5>
                                    <p class="mb-3 text-xl font-bold" id="item-price">${formatToIDR(content.price)}</p>
                                </div>
                            </button>`
                    }

                    if (content.category == 'drink') {
                        drinkItems += `
                        <button class="bg-white border border-gray-200 rounded-lg shadow-2xl drop-shadow-lg col-span-1 w-full h-fit transition-all duration-200 ease-in" onclick="getItem(this)" id="${content._id}">
                                <div class="h-3/5 w-full">
                                    <img class="rounded-t-lg w-full h-full object-contain object-center" src="${content.imgUrl}" alt="item-pict" id="item-picture" />
                                </div>
                                <div class="p-3 bg-gray-800 text-white rounded-b-lg flex flex-col items-center justify-center">
                                    <h5 class="mb-2 text-lg font-normal tracking-tight" id="item-name">${content.name}</h5>
                                    <p class="mb-3 text-xl font-bold" id="item-price">${formatToIDR(content.price)}</p>
                                </div>
                            </button>`
                    }

                });

                let allitem = `${allItem}`
                let foods = `${foodItems}`
                let drinks = `${drinkItems}`

                document.getElementById('container-spinner').remove()
                // productContainer.innerHTML += elements;
                allitemsContainer.innerHTML += allitem
                foodsContainer.innerHTML += foods
                drinksContainer.innerHTML += drinks

            }).catch(error => console.error(error))
    } else {
        console.error('Product container not found!');
    }
</script>

<script>
    function submitOrder() {
        let alertBox = document.getElementById('box-alert');

        let preparedData = []

        orderItemPlan.map(value => {
            let dataTemplate = {
                Product_id: null,
                price: null,
                qty: 0
            }

            dataTemplate.Product_id = value.id
            dataTemplate.price = parseIDRToNumber(value.price)
            dataTemplate.qty = value.amount

            preparedData.push(dataTemplate)
        })

        let headersList = {
            "Accept": "*/*",
            "Authorization": `Bearer ${getCookie('Bearer')}`
        }

        fetch('/api/order', {
                method: 'POST',
                body: JSON.stringify({
                    details: preparedData
                }),
                headers: headersList
            })
            .then(response => response.json())
            .then(result => {
                if (new Object(result).hasOwnProperty('error')) {
                    alertBox.classList.toggle('hidden')

                    const template = `
<div id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 w-fit mt-2 mr-2" role="alert" id="instance-alert">
    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>
    <span class="sr-only">Error</span>
    <div class="ms-3 text-sm font-medium">
        ${result.error}
    </div>
</div>
                    `

                    alertBox.innerHTML = template

                    setTimeout(() => {
                        alertBox.classList.toggle('hidden')
                        document.getElementById('instance-alert').classList.toggle('hidden')
                    }, 5000);

                    return;
                }

                const succeedTemplate = `
                <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400  w-fit mt-2 mr-2" role="alert" id="instance-success">
  <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
  </svg>
  <span class="sr-only">Info</span>
  <div>
  ${result.message}
  </div>
  </div>
  `

                alertBox.innerHTML = succeedTemplate
                alertBox.classList.toggle('hidden')

                setTimeout(() => {
                    alertBox.classList.toggle('hidden')
                    document.getElementById('instance-success').classList.toggle('hidden')
                }, 5000);

                clearOrder()
            }).catch(err => console.error(err))
    }
</script>