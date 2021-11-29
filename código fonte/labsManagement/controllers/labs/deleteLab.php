<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/labs/Lab.php';

if(Lab::Delete($_GET['id'])){
    
    header("Refresh:0; url=../../views/labs/index.php");

    echo 1;
}else{
    echo 0;
}

