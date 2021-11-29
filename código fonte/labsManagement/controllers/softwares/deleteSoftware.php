<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php';

if (Software::Delete($_GET['id'])) {

    echo 1;
} else {

    echo 0;
}
