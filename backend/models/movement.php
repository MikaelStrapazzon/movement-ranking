<?php
require_once 'database.php';

class Movement {
    private $id;
    private $name;

    /**
     * New object Movement
     * @param int $id Movement ID
     * (opcional) @param string $nameMovement Movement name
     */
    public function __call($idMovement, $nameMovement = '') {
        $this->id = $idMovement;
        $this->name = $nameMovement;
    }
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

    public static function rankingBestRecordMovement($idMovement) {
        $sql =
            "SELECT
                `name`,
                `userRecord`,
                `date`
            FROM
                `personal_record` AS table1
            INNER JOIN (
                SELECT
                    `user_id`,
                    max(`value`) as userRecord
                FROM
                    `personal_record`
                WHERE
                    `movement_id` = [%1]
                GROUP BY(
                    `user_id`
                )
            ) AS table2 on
                table2.user_id = table1.user_id AND
                table2.userRecord = table1.value
            INNER JOIN
                user ON
                    table1.user_id = user.id
            ORDER BY(
                `value`
            ) DESC
            ;";

        $dabase = new Database();
        $rankingUsers = $dabase->bd_select($sql, [$idMovement]);

        $lastPosition = 1;
        $nextPosition = 1;
        $lastValue = 0;

        foreach($rankingUsers as &$userRecord) {
            if($userRecord['userRecord'] != $lastValue) {
                $userRecord['position'] = $nextPosition;

                $lastPosition = $nextPosition;
                $nextPosition++;
            }
            else {
                $userRecord['position'] = $lastPosition;

                $nextPosition++;
            }

            $lastValue = $userRecord['userRecord'];
        }

        return $rankingUsers;
    }
}

//SELECT `user_id`, max(`value`) FROM `personal_record` WHERE `movement_id`=1 GROUP BY(`user_id`) ORDER BY max(`value`) DESC;

// SELECT
// 	*
// from
// 	`personal_record` as t1
// INNER JOIN (
// 	SELECT
//     	`user_id`,
//     	max(`value`) as valuem
//     FROM
//     	`personal_record`
//     WHERE
//     	`movement_id`=1
//     GROUP BY(`user_id`)
// ) as t2 on t2.user_id = t1.user_id and t2.valuem = t1.value;