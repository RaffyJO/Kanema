<?php
// session_start();


require_once('src/Views/templates/source.php');
if (!isset($TPL)) {
    $TPL = new source();
    $TPL->title = "Main Page";
    $TPL->bodycontent = __FILE__;
    include "src/Views/layout/layout.php";
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

    <script>
        let tbody = document.getElementById('table-content-user');

        fetch('/user-all',{ method: 'GET' })
        .then(value => value.json())
        .then(result => {            
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
        table, th, td {
            border:1px solid black;
        }

        table ,tbody {
            max-height: 50px !important;
            overflow: auto;
        }
    </style>