<?php
class Database {
    protected $connection = null;

    /**
     * Create the connection to the MySQL database
     */
    public function __construct() {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME, DB_PORT);

            if(mysqli_connect_errno())
                throw new Exception("Could not connect to database.");
        }
        catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Executes a SELECT type SQL in the database and returns the result
     * @param string $sql SQL that will be executed (note: must have the wildcard [%N] in the values to be treated)
     * @param array $values Values to be treated in SQL (The value is always substituted in the posterior wildcard. ex: index 0 will be substituted in the wildcard [%1])
     * @return array|false
     *  Array with the result of SELECT
     *  False if there was an error
     */
    public function bd_select($sql, $values = array())
    {
        if(!is_array($values))
            return false;

        $wildcard = array();

        foreach($values as $index => &$value) {
            $value = $this->connection->real_escape_string($value);
            $wildcard[] = "[%" . ++$index . "]";
        }

        $result = $this->connection->query(str_replace($wildcard, $values, $sql));

        $return = array();

        while($row = $result->fetch_assoc())
            $return[] = $row;

        return $return;
    }
}