<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php';

if (isset($_POST['idSoftware']) && !empty($_POST['idSoftware']) && isset($_POST['version']) && isset($_POST['softwareName']) && !empty($_POST['softwareName'])) {

    $id = $_POST['idSoftware'];
    $softwareName = $_POST['softwareName'];
    $version = $_POST['version'];
    $instructionInstall = $_POST['instructionInstall'];

    $software = new Software($softwareName, $version, $instructionInstall);

    echo($software->Update($id,$software)[0]['RETURN']);

} else {

    echo 0;
}
