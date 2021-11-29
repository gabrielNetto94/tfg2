<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/database/database.php';

class Storage
{

    var $storageSize;
    var $diskType;

    function Storage($storageSize, $diskType)
    {
        $this->storageSize = $storageSize;
        $this->diskType = $diskType;
    }

    public static function Create($storageSize, $diskType)
    {

        $query = "
        INSERT INTO [dbo].[STORAGE] ([STORAGE_SIZE],[DISK_TYPE])
            VALUES ('$storageSize','$diskType')
        ";
        try {

            $pdo = Database::getConnection();
            $smt = $pdo->prepare($query);

            if ($smt->execute()) {
                return $pdo->lastInsertId();
            };
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetStorageLab($idLab)
    {
        $query = "
        SELECT S.ID_STORAGE, S.DISK_TYPE, S.STORAGE_SIZE FROM LAB L
        JOIN MACHINE M ON M.ID_MACHINE = L.FK_ID_MACHINE
        JOIN MACHINE_STORAGE MS ON M.ID_MACHINE = MS.FK_ID_MACHINE
        JOIN STORAGE S ON S.ID_STORAGE = MS.FK_ID_STORAGE
        WHERE L.ID_LAB = $idLab";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function Update($idStorage, $storage)
    {
        $query = "
        UPDATE [STORAGE]
        SET [STORAGE_SIZE] = '$storage->storageSize'
            ,[DISK_TYPE] = '$storage->diskType'
        WHERE ID_STORAGE = $idStorage
        ";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }
    public static function Delete($idStorage)
    {

        $query = " DELETE from STORAGE where ID_STORAGE = $idStorage";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }
}
