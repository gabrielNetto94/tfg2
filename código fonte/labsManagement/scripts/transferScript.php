<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/config.php';
include_once 'deleteDirectory.php';

$array = explode("_",$_POST['lab_amount']);

$numberLab = $array[0];
$amount = $array[1];

$origin_path = $_POST['origin_path'];
$destination_path = $_POST['destination_path'];

$username = "teste";
$password = "teste";

$path = __DIR__ . "/output//LAB" . $numberLab;
$content = '';

if (file_exists($path)) {
    deleteDirectory($path);
}

mkdir($path, 0755, true);

for ($i = 1; $i <= $amount; $i++) {

    if ($i < 10) {

        $machine_name = "LAB" . $numberLab . "DT0" . $i;

        $content = $content .  "NET USE \\\\$machine_name\c$" . " $password /user:$username \n";
        $content = $content . "RMDIR /Q /S \\\\$machine_name\\$destination_path \n \n";
    } else {
        $machine_name = "LAB" . $numberLab . "DT" . $i;

        $content = $content .  "NET USE \\\\$machine_name\c$" . " $password /user:$username \n";
        $content = $content . "RMDIR /Q /S \\\\$machine_name\\$destination_path \n \n";
    }
}

$fileName = $path . "/DELETE_FOLDERS_LAB" . $numberLab . ".bat";
$file = fopen($fileName, "w");
fwrite($file, $content);
fclose($file);

for ($i = 1; $i <= $amount; $i++) {
    if ($i < 10) {
        $machine_name = "LAB" . $numberLab . "DT0" . $i;
        $fileName = $path . "/$machine_name.bat";

        $file = fopen($fileName, "w");
        fwrite($file, "NET USE \\$machine_name\c$" . " $password /user:$username \n");
        fwrite($file, "MKDIR \\\\$machine_name\\$destination_path \n");
        fwrite($file, "XCOPY /S /I /E /D \"" . $origin_path . "\" " . "\"\\\\$machine_name\\$destination_path\"");
        fclose($file);
    } else {

        $machine_name = "LAB" . $numberLab . "DT" . $i;
        $fileName = $path . "/$machine_name.bat";

        $file = fopen($fileName, "w");
        fwrite($file, "NET USE \\$machine_name\c$" . " $password /user:$username \n");
        fwrite($file, "MKDIR \\\\$machine_name\\$destination_path \n");
        fwrite($file, "XCOPY /S /I /E /D \"" . $origin_path . "\" " . "\"\\\\$machine_name\\$destination_path\"");
        fclose($file);
    }
}

$fileName  = "TRANSFER_SCRIPT_LAB$numberLab.zip";
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
    unlink($fullPath);//remove o arquivo .zip criado
    
    array_map('unlink', glob("$path/*.*"));//remove os arquivos do diretório
    rmdir($path);
}

//header('Location: ' . BASE_URL . '/labs/labs_script?status=1');