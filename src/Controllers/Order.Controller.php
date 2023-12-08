<?php
class OrderController
{
    private array $server;

    public function __construct(array $server)
    {
        $this->server = $server;
    }

    public function routes()
    {
        if ($this->server['REQUEST_METHOD'] === 'GET') {
            echo $this->GET();
            return;
        }

        if ($this->server['REQUEST_METHOD'] === 'POST') {
            echo $this->POST();
            return;
        }
    }

    private function POST()
    {
        $postData = json_decode(file_get_contents('php://input'), true);

        if (!isset($postData)) {
            http_response_code(400);
            echo json_encode(array('error' => 'Some Required Property are Missing'));
            return;
        }
    }
    private function GET()
    {
        # code...
    }
}
