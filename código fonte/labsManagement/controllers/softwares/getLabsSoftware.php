<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php';

 echo(Software::GetLabsContainSoftware($_GET['id']));