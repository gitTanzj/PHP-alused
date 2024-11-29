<?php
class Database
{
    protected $connection = null;

    public function __construct()
    {
        $DB_HOST = $_ENV["DB_HOST"];
        $DB_USERNAME = $_ENV["DB_USERNAME"];
        $DB_PASSWORD = $_ENV["DB_PASSWORD"];
        $DB_DATABASE = $_ENV["DB_DATABASE"];

        try {
            $this->connection = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);

            if (mysqli_connect_errno()) {
                throw new Exception("" . mysqli_connect_error());
            }
        } catch (Exception $e) {
            throw new Exception("" . $e->getMessage());
        }
        ;
    }

    public function select($query = "", $params = [])
    {
        try {
            $stmt = $this->executeStatement($query, $params);
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $result;
        } catch (Exception $e) {
            throw new Exception("" . $e->getMessage());
        }
    }

    private function executeStatement($query = "", $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);
            if ($stmt === false) {
                throw new Exception("Unable to do prepared statement: " . $query);
            }
            if ($params) {
                $stmt->bind_param($params[0], $params[1]);
            }
            $stmt->execute();
            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>