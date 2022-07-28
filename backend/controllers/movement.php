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
        $movement = new Movement(1);

        return [
            'code' => '200',
            'data' => $movement->rankingBestRecordMovement()
        ];
    }
}