<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/labs/Lab.php';

$idSoftware = $_GET['id'];

$query = "select ID_LAB, NAME, L.SET_BUILDING, L.BUILDING, L.ROOM FROM LAB 
            JOIN LOCATION L ON LAB.FK_ID_LOCATION = L.ID_LOCATION
            WHERE LAB.ID_LAB NOT IN (SELECT FK_ID_LAB FROM LAB_SOFTWARES WHERE FK_ID_SOFTWARE = $idSoftware) ORDER BY NAME";
try {

    echo json_encode(Database::runQuery($query));
} catch (Exception $e) {
    return false;
}
