<?php

require_once('src/Views/templates/source.php');
if (!isset($TPL)) {
    $TPL = new source();
    $TPL->title = "Login";
    $TPL->bodycontent = __FILE__;
    include "src/Views/layout/no_layout.php";
    exit;
}
?>

<div
    class="bg-cover h-screen absolute bottom-0 left-0 right-0 top-0 h-full w-full overflow-hidden bg-fixed -z-50 opacity-5"
    style="background-image: url('src/lib/Assets/bg-login.png');">
</div>
<div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8 h-screen">
    <div class="mx-auto max-w-lg mt-8">
        <h1 class="text-center text-2xl font-bold text-indigo-600 sm:text-3xl">Kanema</h1>

        <p class="mx-auto mt-4 max-w-md text-center text-gray-500">
        Kantin Polinema
        </p>

        <form action="" class="mb-0 mt-6 space-y-4">
        <div class="bg-blue-100 px-4 pt-4 pb-12 sm:px-6 sm:pt-6 sm:pb-14 lg:px-8 lg:pt-8 lg:pb-16 rounded-lg shadow-lg">
            <div>
                <label for="email" class="font-bold text-neutral-700">Masukan Username</label>

                <div class="relative">
                <input
                    type="email"
                    class="w-full rounded-lg border-gray-200 p-2 pe-12 text-sm shadow-sm"
                    placeholder="Enter email"
                />
                </div>
            </div>

            <div>
                <label for="password" class="font-bold text-neutral-700">Masukan Password</label>

                <div class="relative">
                <input
                    type="password"
                    class="w-full rounded-lg border-gray-200 p-2 pe-12 text-sm shadow-sm"
                    placeholder="Enter password"
                />
                </div>
            </div>
        </div>
        <div class="-mt-8 flex flex-col items-center justify-center" style="margin-top:-18px !important">
            <button type="button" class="text-white bg-blue-900 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-2xl text-sm px-12 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Masuk</button>
        </div>
        </form>
    </div>
</div>