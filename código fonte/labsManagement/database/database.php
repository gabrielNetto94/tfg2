<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/database/config.php';

class Database
{

    private static $connection;

    public static function runQuery($query)
    {

        try {
            $connection = self::getConnection();
            $stmt = $connection->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function getConnection()
    {

        $pdoConfig  = DB_DRIVER . ":" . "Server=" . DB_HOST . ";";
        $pdoConfig .= "Database=" . DB_NAME . ";";

        try {
            if (!isset(self::$connection)) {
                self::$connection =  new PDO($pdoConfig, DB_USER, DB_PASSWORD);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$connection;
        } catch (PDOException $e) {
            $message = "Drivers disponiveis: " . implode(",", PDO::getAvailableDrivers());
            $message .= "\nErro: " . $e->getMessage();
            throw new Exception($message);
        }
    }
}
