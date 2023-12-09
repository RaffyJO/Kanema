<?php

require_once __DIR__ . '/templates/source.php';
if (!isset($TPL)) {
    $TPL = new source();
    $TPL->title = "Login";
    $TPL->bodycontent = __FILE__;
    include "src/Views/layout/no_layout.php";
    exit;
}
?>

<div class="bg-cover h-screen absolute bottom-0 left-0 right-0 top-0 h-full w-full overflow-hidden bg-fixed -z-50 opacity-5" style="background-image: url('src/lib/Assets/bg-login.png');">
</div>
<div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8 h-screen">
    <div class="absolute top-0 right-0 w-full h-fit hidden flex justify-end z-[100]" id="box-alert">
    </div>
    <div class="mx-auto max-w-lg mt-8">
        <h1 class="text-center text-2xl font-bold text-indigo-600 sm:text-3xl">Kanema</h1>

        <p class="mx-auto mt-4 max-w-md text-center text-gray-500">
            Kantin Polinema
        </p>

        <form method="POST" class="mb-0 mt-6 space-y-4">
            <div class="bg-blue-100 px-4 pt-4 pb-12 sm:px-6 sm:pt-6 sm:pb-14 lg:px-8 lg:pt-8 lg:pb-16 rounded-lg shadow-lg">
                <div>
                    <label for="email" class="font-bold text-neutral-700">Masukan Username</label>

                    <div class="relative">
                        <input type="text" class="w-full rounded-lg border-gray-200 p-2 pe-12 text-sm shadow-sm" placeholder="Enter email" name="username" id="username" />
                    </div>
                </div>

                <div>
                    <label for="password" class="font-bold text-neutral-700">Masukan Password</label>

                    <div class="relative">
                        <input type="password" class="w-full rounded-lg border-gray-200 p-2 pe-12 text-sm shadow-sm" placeholder="Enter password" name="password" id="password" />
                    </div>
                </div>
            </div>
            <div class="-mt-8 flex flex-col items-center justify-center" style="margin-top:-18px !important">
                <!-- <button type="submit" ></button> -->
                <input type="submit" value="Masuk" class="text-white bg-blue-900 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-2xl text-sm px-12 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('submit', (evt) => signin(evt))

    function signin(evt) {
        evt.preventDefault();

        const username = document.getElementById('username').value
        const password = document.getElementById('password').value

        fetch('/api/auth', {
                method: 'POST',
                body: JSON.stringify({
                    "username": username,
                    "password": password
                })
            })
            .then(response => response.json())
            .then(result => {
                if (new Object(result).hasOwnProperty('error')) {
                    let alertBox = document.getElementById('box-alert');
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
                    }, 5000);

                    return;
                }

                let cookieString = `Bearer=${encodeURIComponent(result.token)}; expires=${result.expire_at}; path=/`;
                document.cookie = cookieString;
                window.location.href = '/cashier?token=Bearer%20' + result.token
                localStorage.setItem('Bearer', result.token);
            }).catch(err => console.error(err))
    }
</script>