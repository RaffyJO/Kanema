<?php
class ProductsController
{
    private array $server;

    public function __construct(array $server)
    {
        $this->server = $server;
    }

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

        if ($this->server['REQUEST_METHOD'] === 'GET' && $this->server['REQUEST_URI'] === '/api/products') {
            echo $this->products();
        }
        if ($this->server['REQUEST_METHOD'] === 'GET' && str_contains($this->server['REQUEST_URI'], '/api/product?')) {
            echo $this->product();
        }
    }

    private function products(): string
    {
        require('src/Models/Product.Model.php');
        $model = new ProductModel();
        $data = $model->getAll();

        if (array_key_exists('error', $data)) {
            http_response_code(400);
            return json_encode($data);
        } else {
            http_response_code(200);
            return json_encode($data);
        }
    }
    private function product(): string
    {
        $parameter = $this->server['QUERY_STRING'];
        $searchStr = str_replace('search=', '', $parameter);
        $parsedStr = str_replace('%20', ' ', $searchStr);

        require('src/Models/Product.Model.php');
        $model = new ProductModel();
        $data = $model->getItem($parsedStr);

        if (array_key_exists('error', $data)) {
            http_response_code(400);
            return json_encode($data);
        } else {
            http_response_code(200);
            return json_encode($data);
        }
    }
}
