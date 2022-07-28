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
    public function __construct($idMovement, $nameMovement = '') {
        $this->id = $idMovement;

        if($nameMovement == '') {
            $dabase = new Database();

            $informationsMovement = $dabase->bd_select(
                'SELECT `name` FROM movement WHERE id=[%1]',
                [$idMovement]
            );

            $this->name = $informationsMovement[0]['name'];
        }
        else
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

        return $dabase->bd_select('SELECT * FROM movement');
    }

    /**
     * Returns each user's record ranking in a Movement
     * @return array Ranking movement
     *  string movementName => Movement name
     *  array userRecordsList => List users record
     *    [{
     *      string name => User name
     *      string userRecordValue => Highest user record
     *      string date => User highest record date
     *      int position => User position in the ranking
     *    }]
     */
    public function rankingBestRecordMovement() {
        $sql =
            "SELECT
                `name`,
                `userRecordValue`,
                `date`
            FROM
                `personal_record` AS table1
            INNER JOIN (
                SELECT
                    `user_id`,
                    max(`value`) as userRecordValue
                FROM
                    `personal_record`
                WHERE
                    `movement_id` = [%1]
                GROUP BY(
                    `user_id`
                )
            ) AS table2 on
                table2.user_id = table1.user_id AND
                table2.userRecordValue = table1.value
            INNER JOIN
                user ON
                    table1.user_id = user.id
            ORDER BY(
                `value`
            ) DESC";

        $dabase = new Database();
        $rankingUsers = $dabase->bd_select($sql, [$this->id]);

        $lastPosition = 1;
        $nextPosition = 1;
        $lastValue = 0;

        foreach($rankingUsers as &$userRecord) {
            if($userRecord['userRecordValue'] != $lastValue) {
                $userRecord['position'] = $nextPosition;

                $lastPosition = $nextPosition;
                $nextPosition++;
            }
            else {
                $userRecord['position'] = $lastPosition;

                $nextPosition++;
            }

            $lastValue = $userRecord['userRecordValue'];
        }

        return [
            'movementName' => $this->name,
            'userRecordsList' => $rankingUsers
        ];
    }
}