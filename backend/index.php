<?php
    require_once 'configs.php';
    require_once 'routes.php';

    $routes = new Routers([
        [
            'route' => 'movements',
            'method' => 'GET',
            'controller' => 'MovementController::listAction'
        ],
        [
            'route' => 'ranking/<idMovement>',
            'method' => 'GET',
            'controller' => 'MovementController::rankingAction'
        ]
    ]);

    $responseController = $routes->getRequestResponse();

    $response = [
        'code' => $responseController['code'] ?? 500,
        'error' => $responseController['error'] ?? '',
        'data' => $responseController['data'] ?? []
    ];

    echo json_encode($response);