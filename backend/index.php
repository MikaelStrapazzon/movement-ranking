<?php
    require_once 'configs.php';
    require_once 'routes.php';

    $routes = new Routers([
        [
            'route' => 'movement',
            'method' => 'GET',
            'controller' => 'MovementController::listAction'
        ],
        [
            'route' => 'ranking',
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