<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php';

echo (Software::DeleteLabSoftware($_GET['idLab'], $_GET['idSoftware'])) ? 1 : 0;
