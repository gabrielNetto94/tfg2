<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/config.php';
include_once 'deleteDirectory.php';

$array = explode("_",$_POST['lab_amount']);

$numberLab = $array[0];
$amount = $array[1];


$path = __DIR__ . "/output//LAB" . $numberLab;

if (file_exists($path)) {
    deleteDirectory($path);
}

mkdir($path, 0755, true);

if ($_POST['user'] == "domainUser") {

    $username = "usrlab" . $numberLab;
    $password = "usrlab" . $numberLab;
    $domain = "lanfran.local\\";
    createAccessDomainUser($domain, $username, $password);
    $fileName  = "ACESSO_REMOTO_LAB" . $numberLab . "_USRLAB" . $numberLab . ".zip";
} else if ($_POST['user'] == "localUser") {

    $username = "teste";
    $password = "teste";
    createAccessLocalUser($username, $password);
    $fileName  = "ACESSO_REMOTO_LAB$numberLab" . "_ADMINISTRADOR.zip";
}

function createAccessLocalUser($username, $password)
{
    for ($i = 1; $i <= $GLOBALS['amount']; $i++) {

        if ($i < 10) {

            $machine_name = "LAB" . $GLOBALS['numberLab'] . "DT0" . $i;

            $fileName = $GLOBALS['path'] . "/" . $machine_name . ".bat";
            $file = fopen($fileName, "w");
            fwrite($file, "cmdkey /generic $machine_name /user:$machine_name\\$username" . " /pass: " . $password . "\n");
            fwrite($file, "mstsc /v $machine_name");
            fclose($file);
        } else {

            $machine_name = "LAB" . $GLOBALS['numberLab'] . "DT" . $i;

            $fileName = $GLOBALS['path'] . "/" . $machine_name . ".bat";
            $file = fopen($fileName, "w");
            fwrite($file, "cmdkey /generic $machine_name /user:$machine_name\\$username" . " /pass: " . $password . "\n");
            fwrite($file, "mstsc /v $machine_name");
            fclose($file);
        }
    }
}

function createAccessDomainUser($domain, $username, $password)
{
    for ($i = 1; $i <= $GLOBALS['amount']; $i++) {

        if ($i < 10) {

            $machine_name = "LAB" . $GLOBALS['numberLab'] . "DT0" . $i;

            $fileName = $GLOBALS['path'] . "/" . $machine_name . ".bat";
            $file = fopen($fileName, "w");
            fwrite($file, "cmdkey /generic $machine_name /user: $domain$username" . " /pass: " . $password . "\n");
            fwrite($file, "mstsc /v $machine_name");
            fclose($file);
        } else {

            $machine_name = "LAB" . $GLOBALS['numberLab'] . "DT" . $i;

            $fileName = $GLOBALS['path'] . "/" . $machine_name . ".bat";
            $file = fopen($fileName, "w");
            fwrite($file, "cmdkey /generic $machine_name /user: $domain$username" . " /pass: " . $password . "\n");
            fwrite($file, "mstsc /v $machine_name");
            fclose($file);
        }
    }
}

$fullPath  = $path . '/' . $fileName;
$scanDir = scandir($path);
array_shift($scanDir);
array_shift($scanDir);

$zip = new \ZipArchive();
if ($zip->open($fullPath, \ZipArchive::CREATE)) {

    foreach ($scanDir as $file) {
        $zip->addFile($path . '/' . $file, $file);
    }
    $zip->close();
}

if (file_exists($fullPath)) {
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    readfile($fullPath);
    unlink($fullPath);
}
/*
$dir =  __DIR__ . '\labs_script\output';
$command = 'rd ' . $dir . ' /S /Q';
system($command, $return);
rmdir($dir);
*/
//header('Location: ' . BASE_URL . '/labs/labs_script?status=1');