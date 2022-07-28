<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/models/movement.php';

class MovementController {
    public static function listAction() {
        return [
            'code' => '200',
            'data' => Movement::findAll()
        ];
    }

    public static function rankingAction() {
        if(empty($_GET['idMovement']) || !is_numeric($_GET['idMovement']))
            return [
                'code' => '400',
                'error' => 'Movement id informed is not accepted'
            ];

        $movement = new Movement($_GET['idMovement']);

        return [
            'code' => '200',
            'data' => $movement->rankingBestRecordMovement()
        ];
    }
}