<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/auth-verify.php' ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/config.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/header.html' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/labs/Lab.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/os/OS.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/machine/Machine.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/storage/Storage.php' ?>

<link href="/tfg/assets/lib/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="/tfg/assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">
<link href="/tfg/assets/chosen_v1.8.7/chosen.css" rel="stylesheet">
<link href="/tfg/assets/lib/toastr/toastr.min.css" rel="stylesheet">

<?php
//UPDATE
$id = $_GET['id'];
$AllOS =  OS::GetAll();
$Softwares = Software::GetAll();

if ($id > 0) {
    foreach (Lab::GetLab($id) as $row) {

        $idLab = $row['ID_LAB'];
        $fkIdLocation = $row['FK_ID_LOCATION'];
        $fkIdMachine = $row['FK_ID_MACHINE'];
        $numberLab = $row['NAME'];
        $numberMachines = $row['NUMBER_MACHINES'];
        $machineModel = $row['MODEL_MACHINE'];
        $purchaseDate = $row['PURCHASE_DATE'];
        $lastUpdate = $row['LAST_UPDATE'];
        $setBuilding = $row['SET_BUILDING'];
        $building = $row['BUILDING'];
        $room = $row['ROOM'];

        $ipAddress = $row['IP_ADDRESS'];
        $subnetMask = $row['SUBNET_MASK'];
        $gateway = $row['GATEWAY'];

        $cpu = $row['CPU_MODEL'];
        $serial = $row['SERIAL'];
        $memorySize = $row['MEMORY_SIZE'];

        $formName = 'form-update';
        $nameButtonSubmit = 'Alterar';
        $fileName = 'updateLab.php';
    }

    $OS = Lab::GetSoLab($id);
    $SoftwareLab = Lab::GetSoftwaresContainLab($id);
    $Storage = Storage::GetStorageLab($id);

    $hasMicrophone = Machine::GetValuesWebcamMic($id)[0]['HAS_MICROPHONE'];
    $hasWebCam = Machine::GetValuesWebcamMic($id)[0]['HAS_WEBCAM'];
} else {
    //INSERT
    $idLab = '';
    $fkIdLocation = '';
    $fkIdMachine = '';
    $numberLab = '';
    $numberMachines = '';
    $machineModel = '';
    $purchaseDate = '';
    $lastUpdate = '';
    $setBuilding = '';
    $building = '';
    $room = '';

    $ipAddress = '';
    $subnetMask = '';
    $gateway = '';

    $cpu = '';
    $serial = '';
    $memorySize = 0;

    $formName = 'form-create';
    $nameButtonSubmit = 'Cadastrar';
    $fileName = 'createLab.php';

    $hasMicrophone = 0;
    $hasWebCam = 0;

    $Storage = [
        [
            'ID_STORAGE' => '',
            'DISK_TYPE' => '',
            'STORAGE_SIZE' => ''
        ]
    ];
}
?>

<body>
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/nav.html' ?>
            <div class="content">
                <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/top-nav.php' ?>
                <!-- <form method="post" id="<?php echo $formName ?>" action="/labsManagement/controllers/labs/<?php echo $fileName ?>"> -->
                <form id="<?php echo $formName ?>">

                    <!-- Informação laboratório-->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-1">Informações Gerais</h5>
                            <div class="row">
                                <div class="col-sm-6 col-md-4">

                                    <input value="<?php echo $idLab ?>" name="idLab" hidden>
                                    <label class="badge badge-secondary">Número Laboratório</label>
                                    <input value="<?php echo $numberLab ?>" class="form-control" type="text" name="numberLab" placeholder="Ex: 08" required>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <label class="badge badge-secondary">Quantidade de máquinas</label>
                                    <input value="<?php echo $numberMachines ?>" class="form-control" type="number" name="amount" placeholder="Quantidade" min="1" max="50" maxlength="3" required>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <label class="badge badge-secondary">Data de compra</label>
                                    <input id="purchaseDate" value="<?php echo $purchaseDate ?>" class="form-control" type="date" name="purchaseDate" placeholder="" required>
                                </div>

                                <div class="col-sm-6 col-md-4 mt-2">
                                    <label class="badge badge-secondary">Modelo máquina</label>
                                    <input value="<?php echo $machineModel ?>" class="form-control" type="text" name="machineModel" placeholder="Digite marca e modelo" required>
                                </div>

                                <div class="col-sm-6 col-md-4 mt-2">
                                    <label class="badge badge-secondary">Data última atualização</label>
                                    <input id="lastUpdate" value="<?php echo $lastUpdate ?>" class="form-control" type="date" name="lastUpdate" placeholder="" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Localização-->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-1">Localização</h5>
                            <div class="row">
                                <div class="col-sm">
                                    <input value="<?php echo $fkIdLocation ?>" hidden name="fkIdLocation" type="number">
                                    <label class="badge badge-secondary">Conjunto</label>
                                    <input value="<?php echo $setBuilding ?>" class="form-control" type="number" name="setBuilding" placeholder="Conjunto" required>
                                </div>
                                <div class="col-sm">
                                    <label class="badge badge-secondary">Prédio</label>
                                    <input value="<?php echo $building ?>" class="form-control" type="number" name="building" placeholder="Prédio" required>
                                </div>
                                <div class="col-sm">
                                    <label class="badge badge-secondary">Sala</label>
                                    <input value="<?php echo $room ?>" class="form-control" type="text" name="room" placeholder="Sala" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Rede-->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-1">Informações de Rede</h5>
                            <div class="row">
                                <div class="col-sm">
                                    <label class="badge badge-secondary">Ip Inicial</label>
                                    <input value="<?php echo $ipAddress ?>" class="form-control ipAddress" type="text" name="ipAddress" required>
                                </div>
                                <div class="col-sm">
                                    <label class="badge badge-secondary">Máscara de rede</label>
                                    <input value="<?php echo $subnetMask ?>" class="form-control ipAddress" type="text" name="subnetMask" required>
                                </div>
                                <div class="col-sm">
                                    <label class="badge badge-secondary">Gateway</label>
                                    <input value="<?php echo $gateway ?>" class="form-control ipAddress" type="text" name="gateway" required>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Hardware-->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-1">Informações de Hardware</h5>
                            <div class="row" id="dynamic_field">
                                <div class="col-sm-4">

                                    <input value="<?php echo $fkIdMachine ?>" hidden name="fkIdMachine" type="number">
                                    <label class="badge badge-secondary">Processador</label>
                                    <input value="<?php echo $cpu ?>" class="form-control" type="text" name="cpu" placeholder="Intel Core i5-8400 2.8GHz" required>

                                </div>
                                <div class="col-sm-4">
                                    <label class="badge badge-secondary">Memória RAM</label><br>
                                    <select required class="form-control" name="memorySize" required>
                                        <option disabled <?php echo $memorySize == 0 ? 'selected' : '' ?> value="">Selecione uma opção</option>
                                        <option <?php echo $memorySize == 2 ? 'selected' : '' ?> value="2">2GB</option>
                                        <option <?php echo $memorySize == 4 ? 'selected' : '' ?> value="4">4GB</option>
                                        <option <?php echo $memorySize == 6 ? 'selected' : '' ?> value="6">6GB</option>
                                        <option <?php echo $memorySize == 8 ? 'selected' : '' ?> value="8">8GB</option>
                                        <option <?php echo $memorySize == 12 ? 'selected' : '' ?> value="12">12GB</option>
                                        <option <?php echo $memorySize == 16 ? 'selected' : '' ?> value="16">16GB</option>
                                        <option <?php echo $memorySize == 32 ? 'selected' : '' ?> value="32">32GB</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label class="badge badge-secondary">Possui Microfone?</label>
                                    <div class="form-group form-check mb-0">
                                        <input id="yesMicrophone" <?php echo $hasMicrophone == 1 ? 'checked' : '' ?> class="form-check-input" type="radio" name="hasMicrophone" value="1">
                                        <label class="form-check-label" for="yesMicrophone">Sim</label>
                                    </div>

                                    <div class="form-group form-check mb-0 mt-0">
                                        <input id="noMicrophone" <?php echo $hasMicrophone == 0 ? 'checked' : '' ?> class="form-check-input" type="radio" name="hasMicrophone" value="0">
                                        <label class="form-check-label" for="noMicrophone">Não</label>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <label class="badge badge-secondary">Possui Webcam?</label>
                                    <div class="form-group form-check mb-0">
                                        <input id="yesWebcam" <?php echo $hasWebCam == 1 ? 'checked' : '' ?> class="form-check-input" type="radio" name="hasWebcam" value="1">
                                        <label class="form-check-label" for="yesWebcam">Sim</label>
                                    </div>
                                    <div class="form-group form-check mb-0 mt-0">
                                        <input id="noWebcam" <?php echo $hasWebCam == 0 ? 'checked' : '' ?> class="form-check-input" type="radio" name="hasWebcam" value="0">
                                        <label class="form-check-label" for="noWebcam">Não</label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <label class="badge badge-secondary">Serial</label>
                                    <input value="<?php echo $serial ?>" class="form-control" type="text" name="serial" placeholder="Serial de apenas uma máquina" required>

                                </div>


                                <?php
                                $i = 0;
                                foreach ($Storage as $s) { ?>
                                    <div class="col-sm-4">
                                        <label class="badge badge-secondary">Tipo de Armazenamento</label>

                                        <input value="<?php echo $s['ID_STORAGE'] ?>" name="idStorage" type="number" hidden>
                                        <?php
                                        if ($i == 0) { ?>
                                            <button type="button" name="add" id="addStorage" class="btn btn-falcon-success btn-sm" data-toggle="tooltip" data-placement="top" title="Adicionar novo armazenamento"><i class="fas fa-plus"></i></button>
                                        <?php } else { ?>
                                            <button type="button" name="remove" onclick="deleteStorage(<?php echo $s['ID_STORAGE'] . ',' . $fkIdMachine ?>,this)" class="btn btn-falcon-danger ml-2 btn-sm btn_remove"><i class="fas fa-minus"></i></button>
                                        <?php }
                                        $i++;
                                        ?>
                                        <select required class="form-control" name="storageType" required>
                                            <option <?php echo $s['DISK_TYPE'] == '' ? 'selected' : '' ?> value="" disabled> Selecione uma opção</option>
                                            <option <?php echo $s['DISK_TYPE'] == 'HD' ? 'selected' : ''  ?> value="HD">HD</option>
                                            <option <?php echo $s['DISK_TYPE'] == 'SSD SATA' ? 'selected' : ''  ?> value="SSD SATA">SSD SATA</option>
                                            <option <?php echo $s['DISK_TYPE'] == 'SSD M2' ? 'selected' : ''  ?> value="SSD M2">SSD M2</option>
                                            <option <?php echo $s['DISK_TYPE'] == 'SSD Nvme' ? 'selected' : ''  ?> value="SSD Nvme">SSD Nvme</option>
                                        </select>
                                        <label class="badge badge-secondary">Espaço</label>
                                        <input value="<?php echo $s['STORAGE_SIZE'] ?>" class="form-control" min="0" max="9999" type="number" name="storageSize" placeholder="Digitar valor em GB" required>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <?php

                    function ContainsInArray($array, $index, $value)
                    {
                        foreach ($array as $item) {
                            if ($item[$index] == $value)
                                return true;
                        }
                        return false;
                    }
                    ?>
                    <!-- Softwares-->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="mb-1">Informações de Software</h5>
                            <div class="row">
                                <div class="col-sm">

                                    <label class="badge badge-secondary">Sistema Operacional</label><br>
                                    <select id="selectOs" data-placeholder="Selecione os SO's" multiple name="os" class="chosen-select">
                                        <?php
                                        foreach ($AllOS as $row) {
                                            if ($id > 0) { ?>
                                                <option <?php echo ContainsInArray($OS, "ID_OS", $row['ID_OS']) ? 'selected' : ' ' ?> value="<?php echo $row['ID_OS'] ?>"><?php echo  $row['OS_NAME'] ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $row['ID_OS'] ?>"><?php echo  $row['OS_NAME'] ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-sm">
                                    <label class="badge badge-secondary">Softwares</label><br>
                                    <select id="selectSoftware" data-placeholder="Selecione os softwares" name="softwares" multiple class="chosen-select">
                                        <?php
                                        foreach ($Softwares as $row) {
                                            if ($id > 0) { ?>

                                                <option <?php echo ContainsInArray($SoftwareLab, "ID_SOFTWARE", $row['ID_SOFTWARE']) ? 'selected' : ' ' ?> value="<?php echo $row['ID_SOFTWARE'] ?>"><?php echo  $row['NAME'] . ' - ' . $row['VERSION'] ?></option>

                                            <?php } else { ?>

                                                <option value="<?php echo $row['ID_SOFTWARE'] ?>"><?php echo  $row['NAME']; ?> <?php echo $row['VERSION'] != null ? " - " . $row['VERSION'] : "" ?></option>

                                            <?php } ?>

                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row-sm">
                        <div class="d-flex justify-content-end mb-4">

                            <button type="submit" class="btn btn-falcon-success btn-sm"> <i class="fas fa-check"></i> <?php echo $nameButtonSubmit ?></button>
                            <a href="/tfg/labsManagement/views/labs"> <button type="button" class="btn btn-falcon-default btn-sm ml-2"> <i class="fas fa-arrow-left mr-1"></i> Voltar</button></a>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

<script src="/tfg/assets/chosen_v1.8.7/chosen.jquery.min.js" type="text/javascript"></script>
<script src="/tfg/assets/lib/toastr/toastr.min.js"></script>
<script src="/tfg/labsManagement/js/global.js"></script>
<script src="/tfg/labsManagement/js/manageLab.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/footer.html' ?>