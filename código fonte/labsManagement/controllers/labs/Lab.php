<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/database/database.php';

class Lab
{
    var $name;
    var $lastUpdate;
    var $machineModel;
    var $purchaseDate;
    var $numberMachines;
    var $fKIdLocation;
    var $fkIdMachine;
    var $ipAddress;
    var $subnetMask;
    var $gateway;

    function Lab($name, $lastUpdate, $machineModel, $purchaseDate, $numberMachines, $fKIdLocation, $fkIdMachine, $ipAddress, $subnetMask, $gateway)
    {
        $this->name = $name;
        $this->lastUpdate = $lastUpdate;
        $this->machineModel = $machineModel;
        $this->purchaseDate = $purchaseDate;
        $this->numberMachines = $numberMachines;
        $this->fKIdLocation = $fKIdLocation;
        $this->fkIdMachine = $fkIdMachine;
        $this->ipAddress = $ipAddress;
        $this->subnetMask = $subnetMask;
        $this->gateway = $gateway;
    }

    public static function CreateLab($fk_id_location, $fk_idMachine, $name, $lastUpdate, $machineModel, $purchaseDate, $number_machines, $ipAddress, $subnetMask, $gateway)
    {

        $query = "
        INSERT INTO [dbo].[LAB]([FK_ID_LOCATION],[FK_ID_MACHINE],[NAME],[LAST_UPDATE],[MODEL_MACHINE],[PURCHASE_DATE],[NUMBER_MACHINES],[IP_ADDRESS],[SUBNET_MASK],[GATEWAY])
        VALUES
           ($fk_id_location,$fk_idMachine,'$name','$lastUpdate','$machineModel','$purchaseDate',$number_machines,'$ipAddress','$subnetMask','$gateway');
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

    public static function GetLab($id)
    {

        
        $query = "
        SELECT L.ID_LAB,FK_ID_LOCATION,FK_ID_MACHINE, L.NAME, L.NUMBER_MACHINES,L.MODEL_MACHINE,L.PURCHASE_DATE, L.LAST_UPDATE, LO.SET_BUILDING, LO.BUILDING,  LO.ROOM, M.CPU_MODEL,M.SERIAL ,M.MEMORY_SIZE , L.IP_ADDRESS,L.SUBNET_MASK,L.GATEWAY from LAB L
        JOIN LOCATION LO on LO.ID_LOCATION = L.FK_ID_LOCATION
        join MACHINE M ON M.ID_MACHINE = L.FK_ID_MACHINE
        WHERE L.ID_LAB = $id";
    
        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function Exists($numberLab, $location)
    {
        $query = "
        select ID_LAB from lab 
        join LOCATION l on l.ID_LOCATION = lab.FK_ID_LOCATION 
        where NAME = $numberLab or SET_BUILDING = $location->setBuilding and BUILDING = $location->building and ROOM = '$location->room';
        ";

        try {

            $return = Database::runQuery($query);
            return sizeof($return) >= 1 ? true :  false;
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetAll()
    {

        $query = "
                SELECT LAB.ID_LAB, LAB.NAME AS NAME_LAB, LAB.MODEL_MACHINE, L.SET_BUILDING, L.BUILDING,  L.ROOM , LAB.NUMBER_MACHINES from LAB
                JOIN LOCATION l on l.ID_LOCATION = lab.FK_ID_LOCATION ";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function Update($idLab, $Lab)
    {

        $query = "
        UPDATE [dbo].[LAB]
        SET [FK_ID_LOCATION] = $Lab->fKIdLocation
      ,[FK_ID_MACHINE] = $Lab->fkIdMachine
      ,[NAME] = '$Lab->name'
      ,[LAST_UPDATE] = '$Lab->lastUpdate'
      ,[MODEL_MACHINE] = '$Lab->machineModel'
      ,[PURCHASE_DATE] = '$Lab->purchaseDate'
      ,[NUMBER_MACHINES] = '$Lab->numberMachines'
      ,[IP_ADDRESS] = '$Lab->ipAddress'
      ,[SUBNET_MASK] = '$Lab->subnetMask'
      ,[GATEWAY] = '$Lab->gateway'
        WHERE ID_LAB = $idLab ";

        try {

            $connection = Database::getConnection();
            $connection->exec($query);
            $connection = NULL;

            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    public static function Delete($id)
    {

        $query = "
            DELETE FROM OS_LABS WHERE FK_ID_LAB = $id
            DELETE FROM LAB_SOFTWARES WHERE FK_ID_LAB = $id
            DELETE FROM lab WHERE ID_LAB = $id

            ";

        // delete MACHINE_STORAGE from lab l
        // join MACHINE m on m.ID_MACHINE = l.FK_ID_MACHINE
        // join MACHINE_STORAGE ms on ms.FK_ID_MACHINE = m.ID_MACHINE
        // where ID_LAB =$id
        try {

            $connection = Database::getConnection();
            $stmt = $connection->prepare($query);
            $stmt->execute();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    //INFO LABS
    public static function GetGeneralInfo($id)
    {

        $query = "
        SELECT LAB.ID_LAB,
                LAB.NAME AS NAME_LAB,
                --LAB.MODEL_MACHINE,
                L.SET_BUILDING,
                L.BUILDING,
                L.ROOM ,
                LAB.PURCHASE_DATE,
                LAB.LAST_UPDATE,
                LAB.NUMBER_MACHINES,
                LAB.IP_ADDRESS,
                LAB.SUBNET_MASK,
                LAB.GATEWAY

            FROM LAB
            JOIN LOCATION L on L.ID_LOCATION = LAB.FK_ID_LOCATION
            WHERE LAB.ID_LAB = $id
         ";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetHardwareLab($id)
    {
        $query = "
         SELECT LAB.MODEL_MACHINE, M.CPU_MODEL, M.MEMORY_SIZE, M.HAS_MICROPHONE,M.HAS_WEBCAM FROM MACHINE M
         JOIN LAB ON LAB.FK_ID_MACHINE = M.ID_MACHINE
         WHERE LAB.ID_LAB = $id
         ";

        try {
            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetStorageLab($id)
    {
        $query = "
            SELECT S.DISK_TYPE,S.STORAGE_SIZE FROM LAB
            JOIN MACHINE M ON M.ID_MACHINE = LAB.FK_ID_MACHINE
            JOIN MACHINE_STORAGE MS ON MS.FK_ID_MACHINE = M.ID_MACHINE
            JOIN STORAGE S ON S.ID_STORAGE = MS.FK_ID_STORAGE
            WHERE LAB.ID_LAB = $id
         ";

        try {
            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetSoLab($id)
    {
        $query = "
         SELECT OS.ID_OS, OS.OS_NAME FROM OS
         JOIN OS_LABS OL ON OL.FK_ID_OS = OS.ID_OS
         JOIN LAB L ON L.ID_LAB = OL.FK_ID_LAB
         WHERE ID_LAB = $id
         ORDER BY OS.OS_NAME
         ";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }
    public static function SetLastUpdate($id, $date)
    {
        $query = "
        UPDATE LAB
        SET LAST_UPDATE = '$date'
        WHERE LAB.ID_LAB = $id
        ";

        try {

            $connection = Database::getConnection();
            $stmt = $connection->prepare($query);
            $stmt->execute();

            return true;
        } catch (Exception $e) {

            return false;
        }
    }
    public static function GetSoftwaresContainLab($idLab)
    {

        $query = "    
            SELECT S.ID_SOFTWARE, S.NAME,S.VERSION FROM SOFTWARE S
            JOIN LAB_SOFTWARES LS ON S.ID_SOFTWARE = LS.FK_ID_SOFTWARE
            JOIN LAB L ON L.ID_LAB = LS.FK_ID_LAB
            WHERE L.ID_LAB= $idLab";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function GetAmountLabAndMachines()
    {
        $query = "SELECT COUNT(ID_LAB)AMOUNT_LAB, sum(NUMBER_MACHINES)AMOUNT_MACHINES FROM LAB";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetLastUpdateLabs()
    {
        $query = "select top 5 * from lab order by LAST_UPDATE desc";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetLastPurchaseLabs()
    {
        $query = "select top 5 * from lab order by PURCHASE_DATE desc";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetHistoryNetwork($idLab){

        $query = "
        select IP_ADDRESS, SUBNET_MASK, GATEWAY, LOG_DATE from LAB_HISTORY
        where FK_ID_LAB = $idLab
        ORDER BY LOG_DATE DESC
        ";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetHistoryGeneralInfo($idLab){

        //convert(varchar, LOG_DATE, 13) as 
        $query = "
        select NAME,MODEL_MACHINE, PURCHASE_DATE, LAST_UPDATE,NUMBER_MACHINES, LOG_DATE FROM LAB_HISTORY
        WHERE FK_ID_LAB = $idLab
        ORDER BY LOG_DATE DESC
        
        ";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }
}
