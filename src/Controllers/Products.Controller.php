<?php
class ProductsController
{
    function route()
    {
        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //     $postData = json_decode(file_get_contents('php://input'), true);

        //     if (isset($postData['name'])) {
        //         $name = $postData['name'];
        //         $encodedName = base64_encode($name);

        //         header('Location: index.html?encoded_name=' . urlencode($encodedName));
        //         exit;
        //     } else {
        //         http_response_code(400);
        //         echo json_encode(array('error' => 'Parameter "name" is missing.'));
        //         exit;
        //     }
        // }

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/products') {
            require('src/Models/Product.Model.php');
            $model = new ProductModel();
            $data = $model->getAll();

            if (array_key_exists('error', $data)) {
                http_response_code(400);
                echo json_encode($data);
            } else {
                http_response_code(200);
                echo json_encode($data);
            }
        }
    }
}
