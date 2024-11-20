<?php

namespace Cloudstorage\App\Controllers;

class ApiController
{
    public function getData()
    {
        $data = [
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'data' => [
                'id' => 1,
                'name' => 'Voorbeeld Data',
                'description' => 'Dit is een voorbeeld item'
            ]
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function createData()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $response = [
            'status' => 'success',
            'message' => 'Data created successfully',
            'data' => $input
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
