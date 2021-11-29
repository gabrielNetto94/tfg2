<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php';

$idLab = $_POST['idLab'];
$idSoftware = $_POST['idSoftware'];

if(Software::BindLabwithSoftware($idLab,$idSoftware)){
    
    echo 1;
}