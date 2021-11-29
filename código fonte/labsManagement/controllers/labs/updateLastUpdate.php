<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/labs/Lab.php';

if (Lab::SetLastUpdate($_POST['id'], $_POST['date'])) {
    echo 1;
} else {
    echo 0;
}
