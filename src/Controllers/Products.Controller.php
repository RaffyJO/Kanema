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
        $requestUri = parse_url($this->server['REQUEST_URI'], PHP_URL_PATH);
        $urlQuery = parse_url($this->server['REQUEST_URI'], PHP_URL_QUERY);
        $queryParams =  array();

        parse_str($urlQuery, $queryParams);

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
        if ($this->server['REQUEST_METHOD'] === 'GET' && $requestUri === '/api/product' && array_key_exists('search', $queryParams)) {
            echo $this->product();
        }
    }

    private function products()
    {
        require_once('src/Models/Product.Model.php');
        $model = new ProductModel();
        $data = $model->getAll();

        if (array_key_exists('error', $data)) {
            http_response_code(400);
            echo json_encode($data);
            return;
        } else {
            http_response_code(200);
            echo json_encode($data);
            return;
        }
    }
    private function product()
    {
        $urlQuery = parse_url($this->server['REQUEST_URI'], PHP_URL_QUERY);
        $queryParams =  array();

        parse_str($urlQuery, $queryParams);

        require_once('src/Models/Product.Model.php');
        $model = new ProductModel();
        $data = $model->getItem($queryParams['search']);

        if (array_key_exists('error', $data)) {
            http_response_code(400);
            echo json_encode($data);
            return;
        } else {
            http_response_code(200);
            echo json_encode($data);
            return;
        }
    }
}
