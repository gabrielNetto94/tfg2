<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/labs/Lab.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/machine/Machine.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/storage/Storage.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/location/Location.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/os/OS.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php';

//location
$setBuilding = $_POST['setBuilding'];
$building = $_POST['building'];
$room = $_POST['room'];

$location = new Location($setBuilding, $building, $room);

//lab
$numberLab = $_POST['numberLab'];
$lastUpdate = $_POST['lastUpdate'];
$machineModel = $_POST['machineModel'];
$purchaseDate = $_POST['purchaseDate'];
$amount = $_POST['amount'];

$ipAddress = $_POST['ipAddress'];
$subnetMask = $_POST['subnetMask'];
$gateway = $_POST['gateway'];

//machine
$cpuModel = $_POST['cpu'];
$memorySize = $_POST['memorySize'];
$hasMicrophone = $_POST['hasMicrophone'];
$hasWebcam = $_POST['hasWebcam'];
$serial = $_POST['serial'];


//testar se lab não existe e retornar 2
if (Lab::Exists($numberLab, $location)) {
    echo 2;
    return;
}

$fk_id_location = Location::Create($location);

$machineName = "LAB" . $numberLab . "DT01";
$fk_idMachine = Machine::Create($machineName, $serial, $hasMicrophone, $hasWebcam, $cpuModel, $memorySize);

//storage
$storageType = $_POST['storageType'];
$storageSize = $_POST['storageSize'];

$idsStorage = array();
for ($i = 0; $i < sizeof($storageSize); $i++) {

    $id = Storage::Create($storageSize[$i], $storageType[$i]);
    array_push($idsStorage, $id);
}
//machine_storage
for ($i = 0; $i < sizeof($idsStorage); $i++) {
    Machine::CreateMachineStorage($fk_idMachine, $idsStorage[$i]);
}

//insert lab
$fk_idLab = Lab::CreateLab($fk_id_location, $fk_idMachine, $numberLab, $lastUpdate, $machineModel, $purchaseDate, $amount, $ipAddress, $subnetMask, $gateway);

//os_labs
if (isset($_POST['os'])) {

    $os = $_POST['os'];

    foreach ($os as $idOS) {
        OS::CreateOsLabs($fk_idLab, $idOS);
    }
}

//software
if (isset($_POST['softwares'])) {

    $softwares = $_POST['softwares'];

    foreach ($softwares as $idSoftware) {
        Software::CreateSoftwareLab($fk_idLab, $idSoftware);
    }
};

echo 1;
