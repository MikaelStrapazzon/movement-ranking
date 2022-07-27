<?php
    require_once 'routes.php';

    $routes = new Routers([
        [
            'route' => 'teste',
            'method' => 'GET',
            'controller' => 'MovementController::listAction'
        ]
    ]);

    $responseController = $routes->getRequestResponse();

    $response = [
        'code' => $responseController['code'] ?? 500,
        'error' => $responseController['error'] ?? '',
        'data' => $responseController['data'] ?? []
    ];

    echo json_encode($response);