<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/database/database.php';

class OS
{
    var $name;
    var $instalationInfo;

    function OS($name, $instalationInfo)
    {
        $this->name = $name;
        $this->instalationInfo = $instalationInfo;
    }
    public static function CreateOsLabs($fk_idLab, $fk_id_os)
    {
        $query = "
        INSERT INTO [dbo].[OS_LABS]([FK_ID_LAB],[FK_ID_OS])
            VALUES ($fk_idLab,$fk_id_os)
        ";

        try {

            $pdo = Database::getConnection();
            $smt = $pdo->prepare($query);

            if ($smt->execute()) {

                return true;
            };
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetAll()
    {
        $query = "SELECT * FROM OS";

        try {
            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }
    public static function DeleteAllOsLab($idLab){

        $query = "delete from OS_LABS where FK_ID_LAB = $idLab";

        try {
            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }
        
}
