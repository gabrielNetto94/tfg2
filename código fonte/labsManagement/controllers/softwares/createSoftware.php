<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php';

if (strlen($_POST['softwareName']) > 0) {

    $softwareName = $_POST['softwareName'];
    $version = $_POST['version'];
    $instructionInstall = $_POST['instructionInstall'];

    $software = new Software($softwareName, $version, $instructionInstall);

    echo($software->Create($software)[0]['RETURN']);
    
}
