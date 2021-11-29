<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/labs/Lab.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/machine/Machine.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/storage/Storage.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/location/Location.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/os/OS.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php';

//Lab::LabExists($idLab, $numberLab,$setBuilding,$building,$room);

//location
$fk_idLocation = $_POST['fkIdLocation'];
$setBuilding = $_POST['setBuilding'];
$building = $_POST['building'];
$room = $_POST['room'];

$location = new Location($setBuilding, $building, $room);
Location::Update($fk_idLocation, $location);

//lab
$idLab = $_POST['idLab'];
$numberLab = $_POST['numberLab'];
$lastUpdate = $_POST['lastUpdate'];
$machineModel = $_POST['machineModel'];
$purchaseDate = $_POST['purchaseDate'];
$amount = $_POST['amount'];
$fk_idMachine = $_POST['fkIdMachine'];

$ipAddress = $_POST['ipAddress'];
$subnetMask = $_POST['subnetMask'];
$gateway = $_POST['gateway'];

$lab = new Lab($numberLab, $lastUpdate, $machineModel, $purchaseDate, $amount, $fk_idLocation, $fk_idMachine, $ipAddress,$subnetMask,$gateway);
Lab::Update($idLab, $lab);

//machine
$cpuModel = $_POST['cpu'];
$memorySize = $_POST['memorySize'];
$hasMicrophone = $_POST['hasMicrophone'];
$hasWebcam = $_POST['hasWebcam'];
$serial = $_POST['serial'];

$machineName = "LAB" . $numberLab . "DT01";
$machine = new Machine($machineName, $serial, $hasMicrophone, $hasWebcam, $cpuModel, $memorySize);

Machine::Update($fk_idMachine, $machine);

//inserir novos storages
if (isset($_POST['storageType'])) {
    
    $storageType = $_POST['storageType'];

    Machine::DeleteAllStorage($fk_idMachine);

    for ($i = 0; $i < sizeof($storageType); $i++) {

        $new_idStorage =  Storage::Create($_POST['storageSize'][$i], $storageType[$i]);
        Machine::CreateMachineStorage($fk_idMachine, $new_idStorage);
    }
}

//os_labs
if (isset($_POST['os'])) {

    $os = $_POST['os'];

    OS::DeleteAllOsLab($idLab);

    foreach ($os as $idOS) {
        OS::CreateOsLabs($idLab, $idOS);
    }
}

//software
if (isset($_POST['softwares'])) {

    $softwares = $_POST['softwares'];

    Software::DeleteAllSoftwaresLab($idLab);

    foreach ($softwares as $idSoftware) {
        Software::CreateSoftwareLab($idLab, $idSoftware);
    }
};

echo 1;