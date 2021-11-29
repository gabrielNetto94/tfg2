<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/machine/Machine.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/storage/Storage.php';


Machine::DeleteStorage($_POST['idMachine'], $_POST['idStorage']);
Storage::Delete($_POST['idStorage']);

echo 1;