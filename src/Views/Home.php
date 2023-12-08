<?php
require_once __DIR__ . '/templates/source.php';
if (!isset($TPL)) {
    $TPL = new source();
    $TPL->title = "Home";
    $TPL->bodycontent = __FILE__;
    include __DIR__ . '/layout/layout.php';
    exit;
}
?>

<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Password</th>
            <th>Role</th>
            <!-- <th>list_price</th>
          <th>model_year</th>
          <th>brand_name</th>
          <th>category_name</th> -->
        </tr>
    </thead>
    <tbody id="table-content-user">
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>

    <script type="text/javascript" src="src/lib/Functions/CookieUtils.js"></script>
    <script>
        let tbody = document.getElementById('table-content-user');
        let headersList = {
            "Accept": "*/*",
            "Authorization": `Bearer ${getCookie('Bearer')}`
        }

        fetch('/api/user-all', {
                method: 'GET',
                headers: headersList
            })
            .then(value => value.json())
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

                result.data.forEach(item => {
                    let row = document.createElement('tr'); // Create a table row

                    // Create table cells for each property and add data to the row
                    let cell1 = document.createElement('td');
                    cell1.textContent = item.username;
                    row.appendChild(cell1);

                    let cell2 = document.createElement('td');
                    cell2.textContent = item.password;
                    row.appendChild(cell2);

                    let cell3 = document.createElement('td');
                    cell3.textContent = item.role;
                    row.appendChild(cell3);

                    // Append the row to the table body
                    tbody.appendChild(row);
                })
            })
            .catch(error => console.error(error))
    </script>
</table>

<style>
    table,
    th,
    td {
        border: 1px solid black;
    }

    table,
    tbody {
        max-height: 50px !important;
        overflow: auto;
    }
</style>