<?php

require_once __DIR__ . '/templates/source.php';
if (!isset($TPL)) {
    $TPL = new source();
    $TPL->title = "Product Page";
    $TPL->bodycontent = __FILE__;
    include "src/Views/layout/layout.php";
    exit;
}
?>

<script type="text/javascript" src="src/lib/Functions/PriceUtils.js"></script>
<script type="text/javascript" src="src/lib/Functions/CookieUtils.js"></script>
<script>
    let formMode = null;
    let currentID = null;

    function previewButtonPress(element) {
        const rawId = element.getAttribute('id')
        const _id = rawId.replace('prev-', '')

        callProudct(_id)
    }

    function actionButtonPress(element, indicator) {
        const rawId = element.getAttribute('id');
        let _id = '';
        switch (indicator) {
            case 'upd':
                _id = rawId.replace('upd-', '')
                break;
            case 'prev':
                _id = rawId.replace('prev-', '')
                break;
            case 'crea':
                _id = rawId.replace('crea-', '')
                break;

            default:
                break;
        }

        actioncallProudct(_id, indicator)
        // actioncallProudct('656e6ebc0a04f3555c2e4815', indicator)
    }

    function actioncallProudct(id, indicator) {
        formMode = indicator;

        let modal = document.getElementById('universalProductModal');
        let icon = '';
        let headersList = '';
        let titleModal = document.getElementById("title-modal");
        let actionButton = document.getElementById("actionButtonModal");
        switch (indicator) {
            case 'upd':
                currentID = id

                titleModal.innerText = 'Edit Product'
                icon = `<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 -ml-0.5" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>`
                actionButton.innerHTML = 'Edit Product'
                // console.log("masuk indikator");
                headersList = {
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

                        result.data.forEach(value => {
                            const itemName = document.getElementById('product-name')
                            const itemPrice = document.getElementById('product-price')
                            const itemCategory = document.getElementById('product-category')
                            const itemStock = document.getElementById('product-stock')
                            const itemImage = document.getElementById('preview-image')
                            const prevImage = document.getElementById('image-preview')
                            const prevtext = document.getElementById('text-preview')
                            const actionModal = document.getElementById('action-modal').classList.remove("hidden")

                            removeDisbled()
                            itemName.value = value.name
                            itemPrice.value = value.price
                            itemCategory.value = value.category
                            itemStock.value = value.stock
                            prevtext.classList.add("hidden")
                            itemImage.src = value.imgUrl

                            if (value.imgUrl.includes('http')) {
                                document.getElementById('link-image').value = value.imgUrl
                            } else {
                                document.getElementById('dropzone-file').value = value.imgUrl
                            }

                            prevImage.classList.remove("hidden")
                        });

                        document.getElementById("icon-action-modal").innerHTML = icon
                        modal.classList.toggle('hidden')
                    }).catch(err => console.error(err))
                break;
            case 'prev':
                titleModal.innerText = 'Preview Product'
                icon = ''
                actionButton.innerHTML = 'Update Product'
                headersList = {
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

                        result.data.forEach(value => {
                            const itemName = document.getElementById('product-name')
                            const itemPrice = document.getElementById('product-price')
                            const itemCategory = document.getElementById('product-category')
                            const itemStock = document.getElementById('product-stock')
                            const itemImage = document.getElementById('preview-image')
                            const prevImage = document.getElementById('image-preview')
                            const prevtext = document.getElementById('text-preview')
                            document.getElementById('dropzone-input').setAttribute("style", "pointer-events:none")
                            document.getElementById('radio-image').classList.add("hidden")
                            document.getElementById('action-modal').classList.add("hidden")

                            itemName.value = value.name
                            itemName.setAttribute("disabled", "")
                            itemPrice.value = value.price
                            itemPrice.setAttribute("disabled", "")
                            itemCategory.value = value.category
                            itemCategory.setAttribute("disabled", "")
                            itemStock.value = value.stock
                            itemStock.setAttribute("disabled", "")
                            prevtext.classList.add("hidden")
                            itemImage.src = value.imgUrl
                            prevImage.classList.remove("hidden")
                        });
                        modal.classList.toggle('hidden')
                    }).catch(err => console.error(err))
                break;
            case 'crea':
                titleModal.innerText = 'Add Product'
                icon = `<svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>`
                actionButton.innerHTML = 'Add new Product'
                removeDisbled()
                document.getElementById('image-preview').classList.add("hidden")
                document.getElementById('text-preview').classList.remove("hidden")
                document.getElementById('dropzone-input').setAttribute("style", "")
                document.getElementById('radio-image').classList.remove("hidden")
                document.getElementById('action-modal').classList.remove("hidden")
                document.getElementById("form-modal").reset();
                document.getElementById("icon-action-modal").innerHTML = icon
                modal.classList.toggle('hidden')
                break;

            default:
                break;
        }
    }

    function removeDisbled() {
        const checkInput = document.getElementById('product-name')
        if (checkInput.disabled) {
            document.getElementById('product-name').disabled = false
            document.getElementById('product-price').disabled = false
            document.getElementById('product-category').disabled = false
            document.getElementById('product-stock').disabled = false
        }
    }

    function callProudct(id) {
        const modal = document.getElementById('readProductModal')
        currentID = id

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

                result.data.forEach(value => {
                    const itemName = document.getElementById('prev-product-name');
                    const itemPrice = document.getElementById('prev-product-price');
                    const itemCategory = document.getElementById('prev-product-category');
                    const itemStock = document.getElementById('prev-product-stock');
                    const itemImage = document.getElementById('prev-product-image');

                    itemName.innerText = value.name
                    itemPrice.innerText = formatToIDR(value.price)
                    itemCategory.innerText = value.category
                    itemStock.innerText = value.stock
                    itemImage.setAttribute('src', value.imgUrl)
                });


                modal.classList.toggle('hidden')
            }).catch(err => console.error(err))
    }

    function toggleModal(modalId) {
        const modal = document.getElementById(modalId)

        if (modal != null)
            modal.classList.toggle('hidden')

        if (modal.classList.contains('hidden')) currentID = null;
    }

    function deleteButtonPress(element) {
        const rawId = element.getAttribute('id')
        const _id = rawId.replace('del-', '')

        callProudctDelete(_id)
    }

    function callProudctDelete(id) {
        const modal = document.getElementById('deleteModal')

        currentID = id;

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

                result.data.forEach(value => {
                    const itemName = document.getElementById('confirm-del');

                    itemName.innerText = value.name
                });


                modal.classList.toggle('hidden')
            }).catch(err => console.error(err))
    }

    function stockButtonPress(element) {
        const rawId = element.getAttribute('id')
        const _id = rawId.replace('stoc-', '')

        formMode = 'stoc'

        callProudctstock(_id)
    }

    function callProudctstock(id) {
        const modal = document.getElementById('stockProductModal')
        currentID = id

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

                result.data.forEach(value => {
                    const titleModal = document.getElementById('title-modal-edit')
                    const itemName = document.getElementById('product-name-stock')
                    const valueInput = document.getElementById('edit-product-stock')
                    const iconButton = document.getElementById('icon-action-modal-stock')
                    const textButton = document.getElementById('actionButtonModal-stock')

                    titleModal.innerText = 'Edit Stock'
                    itemName.innerText = value.name
                    valueInput.value = value.stock
                    iconButton.innerHTML = `<svg class="h-4 w-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                            </svg>`
                    textButton.innerText = 'Update Stock'
                    // console.log(textButton.innerText);
                    // console.log(iconButton);
                    // console.log(textButton);
                });

                modal.classList.toggle('hidden')
            }).catch(err => console.error(err))
    }
</script>
<!-- <form id="form-modal" onsubmit="submitUniversal()">
                <div class="mb-3">
                    <label for="product-name" class="block mb-2 text-sm font-medium text-white">Name</label>
                    <input type="text" name="product-name" id="product-name" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Type product name" required="">
                </div>
                <div class="flex flex-col-reverse lg:flex-row flex-1 gap-3">
                    <div class="flex justify-center items-center w-full mb-4 lg:w-1/2 flex-col">

                        <label for="dropzone-file" class="flex flex-col justify-center items-center w-full h-64 rounded-lg border-2 border-dashed cursor-pointer hover:bg-bray-800 bg-gray-700 border-gray-600 hover:border-gray-500 bg-gray-600" id="dropzone-input">
                            <div class="flex flex-col justify-center items-center pt-5 pb-6" id="text-preview">
                                <svg aria-hidden="true" class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-semibold">Click to upload</span>
                                    or drag and drop
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, or JPEG</p>
                            </div>
                            <div id="image-preview" class="hidden">
                                <img id="preview-image" alt="Preview Image" class="max-w-full max-h-64">
                            </div>
                        </label>

                        <label for="link-input" class="hidden w-full" id="link-input">
                            <textarea type="text" name="link-image" id="link-image" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500 w-full h-64" placeholder="Input link Image" required="" style="resize: none;"></textarea>
                        </label>

                        <div class="text-white mb-2" id="radio-image">
                            <input type="radio" id="radio-drag-drop" name="upload-type" checked>
                            <label for="radio-drag-drop">Drag and Drop</label>

                            <input type="radio" id="radio-link" name="upload-type">
                            <label for="radio-link">Link</label>
                        </div>
                    </div>
                    <div class="flex flex-col flex-1 lg:w-1/2 gap-3">
                        <div>
                            <label for="product-price" class="block mb-2 text-sm font-medium text-gray-900 text-white">Price</label>
                            <input type="number" name="product-price" id="product-price" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Price" required="">
                        </div>
                        <div>
                            <label for="product-stock" class="block mb-2 text-sm font-medium text-gray-900 text-white">Stock</label>
                            <input type="text" name="product-stock" id="product-stock" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Stock" required="">
                        </div>
                        <div><label for="product-category" class="block mb-2 text-sm font-medium text-gray-900 text-white">Category</label><select id="product-category" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                                <option selected="">Select category</option>
                                <option value="food">Food</option>
                                <option value="drink">Drink</option>
                            </select></div>
                    </div>
                </div>
                <div class="text-right" id="action-modal">
                    <button type="submit" class="text-white inline-flex items-center focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800 flex justify-center items-center">
                        <span id="icon-action-modal"></span>
                        <span id="actionButtonModal">
                        </span>
                    </button>
                </div>
            </form> -->
<script>
    function submitUniversal() {
        const name = document.getElementsByName('product-name');
        const linkImg = document.getElementsByName('link-image');
        const imgFile = document.getElementById('dropzone-file');
        const price = document.getElementsByName('product-price');
        const stock = document.getElementsByName('product-stock');
        const radio = document.querySelector('input[name="upload-type"]:checked');
        const category = document.getElementById('product-category');

        let alertBox = document.getElementById('box-alert');

        let headersList = {
            "Accept": "*/*",
            "Authorization": `Bearer ${getCookie('Bearer')}`
        }

        // console.log(imgFile.files[0])
        const reader = new FileReader();

        if (radio.value == 'file' && imgFile.value != '') {
            reader.readAsDataURL(imgFile.files[0])

            reader.onloadend = () => {
                if (formMode === 'upd') {
                    const fields = {
                        "itemID": currentID,
                        "imgFile": reader.result,
                        "fields": {
                            "name": name[0].value,
                            "price": Number.parseInt(price[0].value),
                            "category": category.value,
                            "available": true,
                            "imgUrl": radio.value == 'file' && imgFile.value != '' ? imgFile.value.replace(/.*[\/\\]/, '') : linkImg[0].value,
                            "stock": Number.parseInt(stock[0].value)
                        }
                    }

                    fetch(`/api/request-update`, {
                            method: 'PUT',
                            headers: headersList,
                            body: JSON.stringify(fields)
                        })
                        .then(response => response.json())
                        .then(result => {
                            toggleModal('universalProductModal')
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
                                if (radio.value == 'file' && imgFile[0].value != '') imgFile[0].value

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
                  Operation Success whit ID: ${result._id.$oid}
                  </div>
                  </div>
                  `

                            alertBox.innerHTML = succeedTemplate
                            alertBox.classList.toggle('hidden')

                            setTimeout(() => {
                                alertBox.classList.toggle('hidden')
                                document.getElementById('instance-success').classList.toggle('hidden')
                            }, 5000);

                        })
                    currentID = null
                }

                if (formMode === 'crea') {
                    const fields = {
                        "imgFile": reader.result,
                        field: {
                            name: name[0].value,
                            price: Number.parseInt(price[0].value),
                            category: category.value,
                            imgUrl: radio.value == 'file' && imgFile.value != '' ? imgFile.value.replace(/.*[\/\\]/, '') : linkImg[0].value,
                            available: true,
                            stock: Number.parseInt(stock[0].value),
                            is_deleted: false,
                        }
                    }

                    fetch(`/api/request`, {
                            method: 'POST',
                            headers: headersList,
                            body: JSON.stringify(fields)
                        })
                        .then(response => response.json())
                        .then(result => {
                            console.log(result)
                            toggleModal('universalProductModal')

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
                              Operation Success whit ID: ${result._id.$oid}
                              </div>
                              </div>
                              `

                            alertBox.innerHTML = succeedTemplate
                            alertBox.classList.toggle('hidden')

                            setTimeout(() => {
                                alertBox.classList.toggle('hidden')
                                document.getElementById('instance-success').classList.toggle('hidden')
                            }, 5000);
                        })

                }
            }

        } else {


            if (formMode === 'upd') {
                const fields = {
                    "itemID": currentID,
                    "imgFile": null,
                    "fields": {
                        "name": name[0].value,
                        "price": Number.parseInt(price[0].value),
                        "category": category.value,
                        "available": true,
                        "imgUrl": radio.value == 'file' && imgFile.value != '' ? imgFile.value.replace(/.*[\/\\]/, '') : linkImg[0].value,
                        "stock": Number.parseInt(stock[0].value)
                    }
                }

                fetch(`/api/request-update`, {
                        method: 'PUT',
                        headers: headersList,
                        body: JSON.stringify(fields)
                    })
                    .then(response => response.json())
                    .then(result => {
                        toggleModal('universalProductModal')
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
                            if (radio.value == 'file' && imgFile[0].value != '') imgFile[0].value

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
              Operation Success whit ID: ${result._id.$oid}
              </div>
              </div>
              `

                        alertBox.innerHTML = succeedTemplate
                        alertBox.classList.toggle('hidden')

                        setTimeout(() => {
                            alertBox.classList.toggle('hidden')
                            document.getElementById('instance-success').classList.toggle('hidden')
                        }, 5000);

                    })
                currentID = null
            }

            if (formMode === 'crea') {
                const fields = {
                    "imgFile": null,
                    field: {
                        name: name[0].value,
                        price: Number.parseInt(price[0].value),
                        category: category.value,
                        imgUrl: radio.value == 'file' && imgFile.value != '' ? imgFile.value.replace(/.*[\/\\]/, '') : linkImg[0].value,
                        available: true,
                        stock: Number.parseInt(stock[0].value),
                        is_deleted: false,
                    }
                }

                fetch(`/api/request`, {
                        method: 'POST',
                        headers: headersList,
                        body: JSON.stringify(fields)
                    })
                    .then(response => response.json())
                    .then(result => {
                        console.log(result)
                        toggleModal('universalProductModal')

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
                          Operation Success whit ID: ${result._id.$oid}
                          </div>
                          </div>
                          `

                        alertBox.innerHTML = succeedTemplate
                        alertBox.classList.toggle('hidden')

                        setTimeout(() => {
                            alertBox.classList.toggle('hidden')
                            document.getElementById('instance-success').classList.toggle('hidden')
                        }, 5000);
                    })
            }
        }
    }

    function submitStock() {
        const inputStock = document.getElementById('edit-product-stock')
        let alertBox = document.getElementById('box-alert');

        let headersList = {
            "Accept": "*/*",
            "Authorization": `Bearer ${getCookie('Bearer')}`
        }

        fetch(`/api/product`, {
                method: 'PUT',
                headers: headersList,
                body: JSON.stringify({
                    id: currentID,
                    stock: Number.parseInt(inputStock.value)
                })
            })
            .then(response => response.json())
            .then(result => {
                toggleModal('stockProductModal')

                currentID = null
                formMode = null

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
                          Stock Changed
                          </div>
                          </div>
                          `

                alertBox.innerHTML = succeedTemplate
                alertBox.classList.toggle('hidden')

                setTimeout(() => {
                    alertBox.classList.toggle('hidden')
                    document.getElementById('instance-success').classList.toggle('hidden')
                }, 5000);
            })
    }

    function submitDelete() {
        const inputStock = document.getElementById('edit-product-stock')
        let alertBox = document.getElementById('box-alert');

        let headersList = {
            "Accept": "*/*",
            "Authorization": `Bearer ${getCookie('Bearer')}`
        }

        fetch(`/api/product`, {
                method: 'DELETE',
                headers: headersList,
                body: JSON.stringify({
                    id: currentID
                })
            })
            .then(response => response.json())
            .then(result => {
                toggleModal('deleteModal')

                currentID = null
                formMode = null

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
                          Item has been deleted
                          </div>
                          </div>
                          `

                alertBox.innerHTML = succeedTemplate
                alertBox.classList.toggle('hidden')

                setTimeout(() => {
                    alertBox.classList.toggle('hidden')
                    document.getElementById('instance-success').classList.toggle('hidden')
                }, 5000);
            })
    }
</script>

<div class="w-full bg-gray-800 relative shadow-md rounded-lg overflow-hidden">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <!-- <div class="w-full w-full md:w-1/2">
            <form class="flex items-center">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative lg:w-3/5 w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="simple-search" class="border text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 bg-gray-700 border-gray-600 placeholder-gray-400 text-white" placeholder="Search" required="">
                </div>
            </form>
        </div> -->
        <span class="text-xl uppercase font-bold text-white">Product</span>
        <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
            <button type="button" id="createProductModalButton" onclick="actionButtonPress(this, 'crea')" class="flex items-center justify-center text-white bg-blue-600 hover:bg-blue-800 font-medium rounded-lg text-sm px-4 py-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-blue-800">
                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                Add product
            </button>
            <!-- <div class="flex items-center space-x-3 w-full md:w-auto">
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
            </div> -->
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-4">Product name</th>
                    <th scope="col" class="px-4 py-3">Category</th>
                    <th scope="col" class="px-4 py-3">Price</th>
                    <th scope="col" class="px-4 py-3">Stock</th>
                    <th scope="col" class="p-4">Action</th>
                </tr>
            </thead>
            <tbody id="products-list">
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
    <!-- <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-400">
            Showing
            <span class="font-semibold text-white">1-10</span>
            of
            <span class="font-semibold text-white">10</span>
        </span>
        <ul class="inline-flex items-stretch -space-x-px">
            <li>
                <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 rounded-l-lg border bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white">
                    <span class="sr-only">Previous</span>
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight border bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white">1</a>
            </li>
            <li>
                <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight border bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white">2</a>
            </li>
            <li>
                <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight border bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white">...</a>
            </li>
            <li>
                <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight border bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white">10</a>
            </li>
            <li>
                <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight rounded-r-lg border bg-gray-800 border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-white">
                    <span class="sr-only">Next</span>
                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </li>
        </ul>
    </nav> -->
</div>

<!-- Universal Product Modal -->
<div id="universalProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center" style="backdrop-filter: blur(10px); height:100%;">
    <div class="relative p-4 w-full max-w-2xl max-h-full m">
        <!-- Modal content -->
        <div class="relative p-4 rounded-lg shadow bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 border-gray-600">
                <h3 class="text-lg font-semibold text-white" id="title-modal">universal</h3>
                <button type="button" class="text-gray-400 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white" onclick="toggleModal('universalProductModal')">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form id="form-modal">
                <div class="mb-3">
                    <label for="product-name" class="block mb-2 text-sm font-medium text-white">Name</label>
                    <input type="text" name="product-name" id="product-name" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Type product name" required="">
                </div>
                <div class="flex flex-col-reverse lg:flex-row flex-1 gap-3">
                    <div class="flex justify-center items-center w-full mb-4 lg:w-1/2 flex-col">

                        <label for="dropzone-file" class="flex flex-col justify-center items-center w-full h-64 rounded-lg border-2 border-dashed cursor-pointer hover:bg-bray-800 bg-gray-700 border-gray-600 hover:border-gray-500 bg-gray-600" id="dropzone-input">
                            <div class="flex flex-col justify-center items-center pt-5 pb-6" id="text-preview">
                                <svg aria-hidden="true" class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-semibold">Click to upload</span>
                                    or drag and drop
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, or JPEG</p>
                            </div>
                            <div id="image-preview" class="hidden">
                                <img id="preview-image" alt="Preview Image" class="max-w-full max-h-64">
                            </div>
                        </label>

                        <label for="link-input" class="hidden w-full" id="link-input">
                            <textarea type="text" name="link-image" id="link-image" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500 w-full h-64" placeholder="Input link Image" required="" style="resize: none;"></textarea>
                        </label>

                        <div class="text-white mb-2" id="radio-image">
                            <input type="radio" id="radio-drag-drop" name="upload-type" value="file" checked>
                            <label for="radio-drag-drop">Drag and Drop</label>

                            <input type="radio" id="radio-link" name="upload-type" value="link">
                            <label for="radio-link">Link</label>
                        </div>
                    </div>
                    <div class="flex flex-col flex-1 lg:w-1/2 gap-3">
                        <div>
                            <label for="product-price" class="block mb-2 text-sm font-medium text-gray-900 text-white">Price</label>
                            <input type="number" name="product-price" id="product-price" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Price" required="">
                        </div>
                        <div>
                            <label for="product-stock" class="block mb-2 text-sm font-medium text-gray-900 text-white">Stock</label>
                            <input type="text" name="product-stock" id="product-stock" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Stock" required="">
                        </div>
                        <div><label for="product-category" class="block mb-2 text-sm font-medium text-gray-900 text-white">Category</label><select id="product-category" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                                <option selected="">Select category</option>
                                <option value="food">Food</option>
                                <option value="drink">Drink</option>
                            </select></div>
                    </div>
                </div>
                <div class="text-right" id="action-modal">
                    <button type="button" onclick="submitUniversal()" class="text-white inline-flex items-center focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800 flex justify-center items-center">
                        <span id="icon-action-modal"></span>
                        <span id="actionButtonModal">
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- stock Product Modal -->
<div id="stockProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center w-full" style="backdrop-filter: blur(10px); height:100%;">
    <div class="relative p-4 max-w-2xl max-h-full w-3/5">
        <!-- Modal content -->
        <div class="relative p-4 rounded-lg shadow bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 border-gray-600">
                <h3 class="text-lg font-semibold text-white" id="title-modal-edit"></h3>
                <button type="button" class="text-gray-400 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white" onclick="toggleModal('stockProductModal')">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="#" id="form-modal">
                <label for="number-input" class="block mb-2 text-sm font-medium text-white">Input new <span id="product-name-stock" class="font-bold"></span> Stock</label>
                <input type="number" id="edit-product-stock" class="border text-sm rounded-lg focus:border-blue-500 block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 mb-3" placeholder="90210" required>
                <div class="text-right" id="action-modal">
                    <button type="button" onclick="submitStock()" class="text-white inline-flex items-center focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800 flex justify-center items-center">
                        <span id="icon-action-modal-stock"></span>
                        <span id="actionButtonModal-stock">
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create product -->
<div id="createProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full" style="backdrop-filter: blur(10px); height:100%;">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative p-4 rounded-lg shadow bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 border-gray-600">
                <h3 class="text-lg font-semibold text-white">Add Product</h3>
                <button type="button" class="text-gray-400 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white" data-modal-target="createProductModal" data-modal-toggle="createProductModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form onsubmit="submitCreate()">
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-white">Name</label>
                        <input type="text" name="name" id="name-create" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Type product name" required="">
                    </div>
                    <div>
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 text-white">Price</label>
                        <input type="number" name="price" id="price-create" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Price" required="">
                    </div>
                    <div>
                        <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 text-white">Stock</label>
                        <input type="text" name="stock" id="stock-create" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Stock" required="">
                    </div>
                    <div><label for="category" class="block mb-2 text-sm font-medium text-gray-900 text-white">Category</label><select id="category-create" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                            <option selected="">Select category</option>
                            <option value="food">Food</option>
                            <option value="drink">Drink</option>
                        </select></div>
                </div>
                <div class="flex justify-center items-center w-full mb-4">
                    <label for="dropzone-file" class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col justify-center items-center pt-5 pb-6">
                            <svg aria-hidden="true" class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold">Click to upload</span>
                                or drag and drop
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG or JPG</p>
                        </div>
                        <input id="dropzone-file-create" type="file" class="hidden">
                    </label>
                </div>
                <button type="submit" class="text-white inline-flex items-center focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">
                    <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add new product
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Update modal -->
<div id="updateProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full" style="backdrop-filter: blur(10px); height:100%">
    <div class="relative p-4 w-full max-w-2xl max-h-full mx-auto">
        <!-- Modal content -->
        <div class="relative p-4 rounded-lg shadow bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 border-gray-600">
                <h3 class="text-lg font-semibold text-white">Update Product</h3>
                <button type="button" class="text-gray-400 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white" onclick="toggleModal('updateProductModal')">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form>
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-white">Name</label>
                        <input type="text" name="name" id="name" value="" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Type product name" required="" id="upd-product-name">
                    </div>
                    <div>
                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 text-white">Price</label>
                        <input type="number" name="price" id="price" value="" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Price" required="" id="upd-product-price">
                    </div>
                    <div>
                        <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 text-white">Stock</label>
                        <input type="text" name="stock" id="stock" value="" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" placeholder="Stock" required="" id="upd-product-stock">
                    </div>
                    <div>
                        <label for="category" class="block mb-2 text-sm font-medium text-gray-900 text-white">Category</label>
                        <select id="category" name="category" class="border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500" id="upd-product-category" required>
                            <option selected>Select category</option>
                            <option value="food">Food</option>
                            <option value="drink">Drink</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-center items-center w-full mb-4">
                    <label for="dropzone-file" class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col justify-center items-center pt-5 pb-6">
                            <svg aria-hidden="true" class="mb-3 w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold">Click to upload</span>
                                or drag and drop
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG or JPG</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" name="img" required>
                    </label>
                </div>
                <button type="submit" class="text-white inline-flex items-center focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">
                    <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Update product
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Read modal -->
<div id="readProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] h-full flex justify-center align-middle" style="backdrop-filter: blur(10px);height: 100%">
    <div class="relative p-4 w-full max-w-xl h-fit">
        <!-- Modal content -->
        <div class="relative p-4 rounded-lg shadow bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between mb-4 rounded-t sm:mb-5">
                <div class="text-lg md:text-xl text-white">
                    <h3 class="font-semibold" id="prev-product-name">Indomie</h3>
                    <p class="font-bold" id="prev-product-price">Rp. 3000</p>
                </div>
                <div>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm p-1.5 inline-flex hover:bg-gray-600 hover:text-black" onclick="toggleModal('readProductModal')">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
            </div>
            <img class="w-3/5 h-auto mx-auto" src="" alt="" id="prev-product-image">
            <div class="flex w-full gap-4">
                <div>
                    <p class="mb-2 font-semibold leading-none text-white">Category</p>
                    <p class="font-light sm:mb-5 text-gray-400" id="prev-product-category">Food</p>
                </div>
                <div>
                    <p class="mb-2 font-semibold leading-none text-white">Stock</p>
                    <p class="font-light sm:mb-5 text-gray-400" id="prev-product-stock">10</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete modal -->
<div id="deleteModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full" style="backdrop-filter: blur(10px);height: 100%">
    <div class="relative p-4 w-full max-w-md h-full mx-auto flex justify-center items-center">
        <!-- Modal content -->
        <div class="relative p-4 text-center rounded-lg shadow bg-gray-800 sm:p-5 mx-auto">
            <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white" onclick="toggleModal('deleteModal')">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <svg class="text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <p class="mb-4 text-gray-300">Are you sure you want to delete <span id="confirm-del" class="font-bold"></span>?</p>
            <div class="flex justify-center items-center space-x-4">
                <button type="button" onclick="toggleModal('deleteModal')" class="py-2 px-3 text-sm font-medium rounded-lg border focus:ring-4 focus:outline-none  focus:z-10 bg-gray-700 text-gray-300 border-gray-500 hover:text-white hover:bg-gray-600 focus:ring-gray-600">No, cancel</button>
                <button type="button" onclick="submitDelete()" class="py-2 px-3 text-sm font-medium text-center text-white rounded-lg focus:ring-4 focus:outline-none bg-red-500 hover:bg-red-600 focus:ring-red-900">Yes, I'm sure</button>
            </div>
        </div>
    </div>
</div>

<script>
    const productContainer = document.getElementById('products-list');

    if (productContainer) {
        fetch('/api/products', {
                method: 'GET'
            })
            .then(response => response.json())
            .then(result => {
                let item = '';

                result.data.forEach(content => {
                    // console.table(content);
                    let badgeBgColor = content.category === 'food' ? 'bg-blue-900 text-blue-300' : (content.category == 'drink' ? 'bg-yellow-900 text-yellow-300' : '');
                    item += `<tr class="border-b border-gray-700">
                    <th scope="row" class="px-4 py-3 font-medium whitespace-nowrap text-white flex items-center h-full">
                        <img src="${content.imgUrl}" class="h-10 w-10 mr-2 rounded-full" id="item-picture"/>
                        <span id="item-name">${content.name}</span>
                    </th>
                    <td class="px-4 py-3">
                        <span class="text-xs font-medium px-2 py-0.5 rounded ${badgeBgColor}" id="item-category">${content.category}</span>
                    </td>
                    <td class="px-4 py-3 text-white" id="item-price">Rp.${content.price}</td>
                    <td class="px-4 py-3 text-white">
                        <span>${content.stock}</span>
                    </td>
                    <td class="px-4 py-3 font-medium whitespace-nowrap text-white">
                        <div class="flex items-center space-x-4">
                            <button type="button" class="py-2 px-3 flex items-center text-white text-sm font-medium text-center focus:outline-none rounded-lg border focus:ring-green-700 text-green-400 border-green-600 hover:text-white hover:bg-green-700" onclick="stockButtonPress(this)" id="stoc-${content._id}">
                            <svg class="h-4 w-4 mr-2 -ml-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 1v5h-5M2 19v-5h5m10-4a8 8 0 0 1-14.947 3.97M1 10a8 8 0 0 1 14.947-3.97"/>
                            </svg>
                                Update
                            </button>
                            <button type="button" class="py-2 px-3 flex items-center text-white text-sm font-medium text-center focus:outline-none rounded-lg border focus:ring-blue-700 text-blue-400 border-blue-600 hover:text-white hover:bg-blue-700" onclick="actionButtonPress(this, 'upd')" id="upd-${content._id}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 -ml-0.5" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                                Edit
                            </button>
                            <button type="button" class="py-2 px-3 flex items-center text-white text-sm font-medium text-center text-gray-900 focus:outline-none rounded-lg border focus:ring-gray-700 bg-gray-800 text-gray-400 border-gray-600 hover:text-white hover:bg-gray-700" onclick="actionButtonPress(this, 'prev')" id="prev-${content._id}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-2 -ml-0.5">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" />
                                </svg>
                                Preview
                            </button>
                            <button type="button" class="flex items-center hover:text-white border font-medium rounded-lg text-sm px-3 py-2 text-center border-red-500 text-red-500 hover:text-white hover:bg-red-600 focus:ring-red-900" onclick="deleteButtonPress(this)" id="del-${content._id}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 -ml-0.5" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>`;
                });

                document.getElementById('container-spinner').remove();
                productContainer.innerHTML += item;
            }).catch(error => console.error(error))
    } else {
        console.error('Product container not found!');
    }

    // drag and drop
    document.addEventListener("DOMContentLoaded", function() {
        const dropzone = document.getElementById("dropzone-input");
        const dropzoneFile = document.getElementById("dropzone-file");
        const imagePreview = document.getElementById("image-preview");
        const previewImage = document.getElementById("preview-image");
        const textPreview = document.getElementById("text-preview");
        const linkInput = document.getElementById("link-input");
        const radioDragDrop = document.getElementById("radio-drag-drop");
        const radioLink = document.getElementById("radio-link");

        radioDragDrop.addEventListener("change", function() {
            dropzone.classList.remove("hidden");
            linkInput.classList.add("hidden");
        });

        radioLink.addEventListener("change", function() {
            dropzone.classList.add("hidden");
            linkInput.classList.remove("hidden");
            resetImagePreview();
        });

        dropzoneFile.addEventListener("change", handleFileSelect);
        dropzoneFile.addEventListener("dragover", handleDragOver);
        dropzoneFile.addEventListener("drop", handleDrop);

        function resetImagePreview() {
            previewImage.src = "";
            imagePreview.classList.add("hidden");
        }

        function handleFileSelect(event) {
            const file = event.target.files[0];

            if (file && isImageFile(file)) {
                showImagePreview(file);
            } else {
                alert("Please upload a valid image file (PNG, JPG, or JPEG).");
            }
        }

        function handleDragOver(event) {
            event.preventDefault();
            dropzone.classList.add("border-gray-500");
        }

        function handleDrop(event) {
            event.preventDefault();
            dropzone.classList.remove("border-gray-500");

            const file = event.dataTransfer.files[0];

            if (file && isImageFile(file)) {
                showImagePreview(file);
            } else {
                alert("Please upload a valid image file (PNG, JPG, or JPEG).");
            }
        }

        function isImageFile(file) {
            const acceptedTypes = ["image/png", "image/jpeg", "image/jpg"];
            return acceptedTypes.includes(file.type);
        }

        function showImagePreview(file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                imagePreview.classList.remove("hidden");
                textPreview.classList.add("hidden");
                // console.log("gambar masuk");
            };

            reader.readAsDataURL(file);
        }
    });
</script>