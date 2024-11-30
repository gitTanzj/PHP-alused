<?php
use Dotenv\Dotenv;

require_once '' . __DIR__ . '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__)->load();
class Database
{
    private $dbConn = null;

    public function __construct()
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $db = getenv('DB_DATABASE');
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');

        echo $host;

        try {
            $this->dbConnection = new \PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );

        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->dbConn;
    }

}
?>