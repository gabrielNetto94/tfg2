<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/database/database.php';

class Software
{

    var $name;
    var $version;
    var $instructionInstall;

    function Software($name, $version, $instructionInstall)
    {
        $this->name = $name;
        $this->version = $version;
        $this->instructionInstall = $instructionInstall;
    }

    public static function Create($software)
    {

        $query = "
        IF EXISTS (
            SELECT * FROM SOFTWARE
            WHERE NAME = '$software->name' AND VERSION = '$software->version'
            ) 
            BEGIN
                SELECT 'RETURN' = '2'
            END
        ELSE BEGIN
                SELECT 'RETURN' = '1'
            INSERT INTO
                [dbo].[SOFTWARE]([NAME], [VERSION], [INSTRUCTION_INSTALL])
                VALUES
                ('$software->name',
                '$software->version',
                '$software->instructionInstall')
        END";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function Update($id, $software)
    {
        $query = "IF EXISTS (
                    SELECT * FROM SOFTWARE
                    WHERE NAME = '$software->name' AND VERSION = '$software->version' AND ID_SOFTWARE != $id
                    ) 
                    BEGIN
                        SELECT 'RETURN' = '2'
                    END
                ELSE BEGIN
                        SELECT 'RETURN' = '1'
                        UPDATE [dbo].[SOFTWARE]
                        SET [NAME] = '$software->name'
                            ,[VERSION] = '$software->version'
                            ,[INSTRUCTION_INSTALL] = '$software->instructionInstall'
                        WHERE ID_SOFTWARE = $id
                    END ";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }
    public static function Delete($id)
    {

        $query = " DELETE SOFTWARE WHERE ID_SOFTWARE = $id ";

        try {
            $connection = Database::getConnection();
            $resultSet =  $connection->exec($query);
            $connection = NULL;

            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetAll()
    {
        $query = "SELECT * FROM SOFTWARE 
                    order by SOFTWARE.NAME asc";

        try {

            $connection = Database::getConnection();
            $resultSet =  $connection->query($query);
            $connection = NULL;

            return $resultSet;
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetSoftware($id)
    {

        $query = " SELECT * FROM SOFTWARE WHERE ID_SOFTWARE = $id";

        $connection = Database::getConnection();
        $resultSet =  $connection->query($query);
        $connection = NULL;

        return $resultSet;
    }

    public static function GetLabsContainSoftware($id)
    {

        $query = "    
        SELECT L.ID_LAB,L.NAME, LOC.SET_BUILDING, LOC.BUILDING, LOC.ROOM ,INSTRUCTION_INSTALL, S.ID_SOFTWARE FROM SOFTWARE S
        JOIN LAB_SOFTWARES LS ON LS.FK_ID_SOFTWARE = S.ID_SOFTWARE
        JOIN LAB L ON L.ID_LAB = LS.FK_ID_LAB
        JOIN LOCATION LOC ON LOC.ID_LOCATION = L.FK_ID_LOCATION
        WHERE S.ID_SOFTWARE = $id
        ORDER BY L.NAME
        ";

        $connection = Database::getConnection();
        $statement =  $connection->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $json = json_encode($results);

        $connection = NULL;
        return $json;
    }

    public static function GetSoftwaresNotContainLab($idLab)
    {


        $query = "SELECT ID_SOFTWARE, NAME, VERSION FROM SOFTWARE WHERE SOFTWARE.ID_SOFTWARE  
                    NOT IN ( select FK_ID_SOFTWARE from LAB_SOFTWARES where FK_ID_LAB = $idLab )ORDER BY NAME ";

        try {

            $connection = Database::getConnection();
            $statement =  $connection->query($query);
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            $json = json_encode($results);

            return $json;
        } catch (Exception $e) {

            return false;
        }
    }

    public static function BindLabwithSoftware($idLab, $idSoftware)
    {
        $query = " INSERT INTO LAB_SOFTWARES ([FK_ID_LAB],[FK_ID_SOFTWARE]) VALUES( $idLab, $idSoftware)";

        try {

            $connection = Database::getConnection();
            $connection->query($query);

            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    public static function CreateSoftwareLab($fk_idLab, $fk_id_software)
    {
        $query = "
        INSERT INTO [dbo].[LAB_SOFTWARES]([FK_ID_LAB],[FK_ID_SOFTWARE])
          VALUES ($fk_idLab, $fk_id_software)
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

    public static function DeleteAllSoftwaresLab($idLab)
    {
        $query = "DELETE FROM LAB_SOFTWARES WHERE FK_ID_LAB = $idLab";

        try {

            $connection = Database::getConnection();
            $connection->query($query);

            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    public static function DeleteLabSoftware($idLab, $idSoftware)
    {
        $query = "DELETE FROM LAB_SOFTWARES WHERE FK_ID_LAB = $idLab AND FK_ID_SOFTWARE = $idSoftware";

        try {

            $connection = Database::getConnection();
            $connection->query($query);

            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetAmountSoftwares(){
        $query = "SELECT COUNT(ID_SOFTWARE) AMOUNT_SOFTWARE FROM SOFTWARE";

        try {

            return Database::runQuery($query);

        } catch (Exception $e) {

            return false;
        }
    }
}
