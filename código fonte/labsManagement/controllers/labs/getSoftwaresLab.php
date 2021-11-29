<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/labs/Lab.php';

echo(json_encode(Lab::GetSoftwaresContainLab($_GET['id'])));