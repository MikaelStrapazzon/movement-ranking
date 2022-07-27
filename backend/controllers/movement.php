<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/models/movement.php';

class MovementController {
    public static function listAction() {
        return [
            'code' => '200',
            'data' => Movement::findAll()
        ];
    }
}