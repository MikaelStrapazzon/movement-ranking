<?php
require_once 'database.php';

class Movement {
    /**
     * int id => Movement ID
     * string name => Movement name
     */

    /**
     * Return all movement
     * @return array all movement
     *  int id => Movement ID
     *  string name => Movement name
     */
    public static function findAll() {
        $dabase = new Database();

        return $dabase->bd_select('select * from movement');
    }
}