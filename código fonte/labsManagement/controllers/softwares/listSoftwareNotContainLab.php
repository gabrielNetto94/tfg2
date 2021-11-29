<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php';

$idLab = $_GET['idLab'];

echo (Software::GetSoftwaresNotContainLab($idLab));
