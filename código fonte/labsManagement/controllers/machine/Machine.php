<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/database/database.php';

class Machine
{

    var $machineName;
    var $serial;
    var $hasMicrophone;
    var $hasWebcam;
    var $cpuModel;
    var $memorySize;

    function Machine($machineName, $serial, $hasMicrophone, $hasWebcam, $cpuModel, $memorySize)
    {

        $this->machineName = $machineName;
        $this->serial = $serial;
        $this->hasMicrophone = $hasMicrophone;
        $this->hasWebcam = $hasWebcam;
        $this->cpuModel = $cpuModel;
        $this->memorySize = $memorySize;
    }

    public static function Create($machineName, $serial, $hasMicrophone, $hasWebcam, $cpuModel, $memorySize)
    {

        $query = "
                INSERT INTO [dbo].[MACHINE]([MACHINE_NAME],[SERIAL],[HAS_MICROPHONE],[HAS_WEBCAM],[CPU_MODEL],[MEMORY_SIZE])
                VALUES('$machineName','$serial',$hasMicrophone,$hasWebcam,'$cpuModel','$memorySize');";

        try {

            $pdo = Database::getConnection();
            $smt = $pdo->prepare($query);

            if ($smt->execute()) {

                return $pdo->lastInsertId();
            };
        } catch (Exception $e) {

            return 0;
        }
    }

    public static function Update($idMachine, $Machine)
    {

        $query = "UPDATE [dbo].[MACHINE]
            SET [MACHINE_NAME] = '$Machine->machineName'
            ,[SERIAL] = '$Machine->serial'
            ,[HAS_MICROPHONE] = $Machine->hasMicrophone
            ,[HAS_WEBCAM] = $Machine->hasWebcam
            ,[CPU_MODEL] = '$Machine->cpuModel'
            ,[MEMORY_SIZE] = '$Machine->memorySize'
            WHERE ID_MACHINE = $idMachine";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function CreateMachineStorage($idMachine, $idStorage)
    {
        $query = "
                INSERT INTO [dbo].[MACHINE_STORAGE]([FK_ID_STORAGE],[FK_ID_MACHINE])
                VALUES ($idStorage,$idMachine)";

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

    public static function GetValuesWebcamMic($idLab)
    {
        $query = "
        SELECT M.HAS_MICROPHONE, M.HAS_WEBCAM FROM LAB L
        JOIN MACHINE M ON M.ID_MACHINE = L.FK_ID_MACHINE
        WHERE L.ID_LAB = $idLab";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function DeleteStorage($idMachine, $idStorage)
    {
        $query = "
        delete MACHINE_STORAGE 
        where FK_ID_MACHINE = $idMachine and FK_ID_STORAGE = $idStorage
        ";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }
    public static function DeleteAllStorage($idMachine)
    {
        $query = "
        delete MACHINE_STORAGE 
        where FK_ID_MACHINE = $idMachine";

        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }

    public static function GetHistoryMachine($idLab)
    {
        $query = "
        select  mh.CPU_MODEL, mh.MACHINE_NAME,mh.MEMORY_SIZE,mh.HAS_MICROPHONE,mh.HAS_WEBCAM, LOG_DATE from MACHINE_HISTORY mh
        left join lab l on l.FK_ID_MACHINE = mh.FK_ID_MACHINE
        where l.ID_LAB = $idLab 
        order by LOG_DATE desc";
        
        try {

            return Database::runQuery($query);
        } catch (Exception $e) {

            return false;
        }
    }
}
