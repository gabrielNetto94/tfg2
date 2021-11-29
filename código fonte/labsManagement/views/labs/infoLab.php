<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/auth-verify.php' ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/config.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/header.html' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/labs/Lab.php' ?>

<?php
$idLab = $_GET['id'];
?>
<link href="/tfg/assets/lib/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="/tfg/assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">

<?php
$numberLab;
$numberMachines;
$ipAddress;
?>

<body>
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/nav.html' ?>
            <div class="content">
                <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/top-nav.php' ?>

                <!-- Informações Laboratório-->
                <?php
                foreach (Lab::GetGeneralInfo($idLab) as $row) {
                    $numberLab = $row['NAME_LAB'];
                    $numberMachines = $row['NUMBER_MACHINES'];
                    $ipAddress = $row['IP_ADDRESS'];
                    $subnetMask = $row['SUBNET_MASK'];
                    $gateway = $row['GATEWAY'];
                ?>
                    <div class="card mb-3">

                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">Informações Gerais</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-light border-top">
                            <div class="row">
                                <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../../assets/img/illustrations/corner-4.png);"></div>
                                <div class="col" style="margin-top: .5em">
                                    <h3 class="mb-2">Laboratório <?php echo $row['NAME_LAB'] ?></h3>
                                    <p class="font-weight-semi-bold mb-1"><i class="fas fa-map-marker-alt">
                                        </i> Conjunto <?php echo $row['SET_BUILDING'] ?>, Prédio <?php echo $row['BUILDING'] ?>, Sala <?php echo $row['ROOM'] ?>
                                    </p>
                                    <p class="font-weight-semi-bold mb-1"><i class="far fa-calendar-alt">
                                        </i> Data de compra: <?php echo date_format(date_create($row['PURCHASE_DATE']), "d/m/Y") ?>
                                    </p>
                                    <p class="font-weight-semi-bold mb-1"><i class="far fa-calendar-alt">
                                        </i> Última imagem:<span class="ml-1" id="lastUpdate"><?php echo date_format(date_create($row['LAST_UPDATE']), "d/m/Y") ?></span>
                                        <button onclick="confirm('Deseja realmente atualizar a data?')?updateLastUpdate(<?php echo $idLab ?>):null" data-toggle="tooltip" data-placement="bottom" title="Atualizar data da última imagem" style="height: 30px" class="btn ml-3 btn-falcon-default btn-sm" type="button">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </p>
                                    <p class="font-weight-semi-bold mb-1"><i class="fas fa-history"></i> Histórico de Atualizações
                                        <a href="labHistory.php?id=<?php echo $idLab ?>">
                                            <button data-toggle="tooltip" data-placement="bottom" title="Visualizar histórico de alterações" style="height: 30px" class="btn ml-3 btn-falcon-default btn-sm" type="button">
                                                <i class="fas fa-history"></i>
                                            </button>
                                        </a>
                                    </p>
                                    <p class="font-weight-semi-bold mb-1">
                                        <i class="fas fa-network-wired"></i>
                                        Ip inicial: <?php echo $row['IP_ADDRESS'] ?>
                                        &nbsp;
                                        Máscara de rede: <?php echo $row['SUBNET_MASK'] ?>
                                        &nbsp;
                                        Gateway: <?php echo $row['GATEWAY'] ?>
                                    </p>
                                </div>
                                <div class="col-auto d-none d-sm-block mt-3">
                                    <i class="fas fa-desktop fa-3x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!-- Hardware-->
                <?php
                foreach (Lab::GetHardwareLab($idLab) as $row) {
                ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">Configuração de Hardware</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body bg-light border-top">
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="font-weight-semi-bold mb-1"><i class="fas fa-desktop"></i> <?php echo $row['MODEL_MACHINE'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="font-weight-semi-bold mb-1"> <i class="fas fa-microchip"></i> <?php echo $row['CPU_MODEL'] ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="font-weight-semi-bold mb-1"><i class="fas fa-memory"></i> <?php echo $row['MEMORY_SIZE'] ?> GB</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <?php
                                            foreach (Lab::GetStorageLab($idLab) as $rowSoftware) {
                                            ?>
                                                <p class="font-weight-semi-bold mb-1"><i class="fas fa-hdd"></i> <?php echo $rowSoftware['DISK_TYPE'] . ' ' . $rowSoftware['STORAGE_SIZE'] . ' GB' ?></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">

                                    <div class="row">
                                        <div class="col-12">
                                            <?php
                                            foreach (Lab::GetSoLab($idLab) as $rowSO) {
                                                if (strpos(strtolower($rowSO['OS_NAME']), 'indows')) {
                                            ?>
                                                    <p class="font-weight-semi-bold mb-1"><i class="fab fa-windows"></i> <?php echo $rowSO['OS_NAME'] ?></p>
                                                <?php
                                                } else { ?>
                                                    <p class="font-weight-semi-bold mb-1"><i class="fab fa-linux"></i> <?php echo $rowSO['OS_NAME'] ?></p>
                                            <?php }
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="font-weight-semi-bold mb-1"><i class="fas fa-microphone"></i>
                                                <?php
                                                if ($row['HAS_MICROPHONE'] == 1) {
                                                    echo "Sim";
                                                } else {
                                                    echo "Não";
                                                } ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="font-weight-semi-bold mb-1"><i class="fas fa-camera"></i>
                                                <?php
                                                if ($row['HAS_WEBCAM'] == 1) {
                                                    echo "Sim";
                                                } else {
                                                    echo "Não";
                                                } ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <!--Softwares-->
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                                <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0"><i class="fas fa-code"></i> Softwares Instalados</h5>
                                <p class="text-500 ml-4 fs--1 mb-0" id="numberSoftwares"></p>
                            </div>
                            <div class="col-6 col-sm-auto ml-auto text-right pl-0">
                                <div id="dashboard-actions" class="">
                                    <button onclick="openModalSoftwares(<?php echo $idLab ?>)" class="btn btn-falcon-default btn-sm" type="button">
                                        <svg class="svg-inline--fa fa-plus fa-w-14" data-fa-transform="shrink-3 down-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="" style="transform-origin: 0.4375em 0.625em;">
                                            <g transform="translate(224 256)">
                                                <g transform="translate(0, 64)  scale(0.8125, 0.8125)  rotate(0 0 0)">
                                                    <path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" transform="translate(-224 -256)"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        <span class="d-none d-sm-inline-block ml-1">Incluir novo(s) software(s)</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0">
                        <div class="dashboard-data-table">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row mx-1">
                                    <div class="col-sm-12 col-md-6 px-3"></div>
                                    <div class="col-sm-12 col-md-6 px-3"></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-dashboard fs--1 data-table border-bottom dataTable no-footer" data-options="{&quot;responsive&quot;:false,&quot;pagingType&quot;:&quot;simple&quot;,&quot;lengthChange&quot;:false,&quot;searching&quot;:false,&quot;pageLength&quot;:8,&quot;columnDefs&quot;:[{&quot;targets&quot;:[0,6],&quot;orderable&quot;:false}],&quot;language&quot;:{&quot;info&quot;:&quot;_START_ to _END_ Items of _TOTAL_ — <a href=\&quot;#!\&quot; class=\&quot;font-weight-semi-bold\&quot;> view all <span class=\&quot;fas fa-angle-right\&quot; data-fa-transform=\&quot;down-1\&quot;></span> </a>&quot;},&quot;buttons&quot;:[&quot;copy&quot;,&quot;excel&quot;]}" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                        <thead class="bg-200 text-900">
                                            <tr role="row">

                                                <th class="sort pr-1 align-middle sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Customer: activate to sort column ascending" style="width: 137.203px;">Nome Software</th>
                                                <th class="sort pr-1 align-middle sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 143.203px;">Versão</th>

                                            </tr>
                                        </thead>
                                        <tbody id="purchases">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mx-1 align-items-center justify-content-center justify-content-md-between">
                                    <div class="col-auto mb-2 mb-sm-0">

                                    </div>

                                    <div class="col-auto">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Máquinas-->
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                                <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0"><i class="fas fa-desktop"></i> Computadores</h5>
                                <p class="text-500 ml-4 fs--1 mb-0"><?php echo $numberMachines ?> computadores</p>
                            </div>
                            <div class="col-8 col-sm-auto text-right pl-2">
                                <div class="d-none" id="customers-actions">
                                    <div class="input-group input-group-sm"><select class="custom-select cus" aria-label="Bulk actions">
                                            <option selected="">Download Acesso remoto</option>
                                            <option value="Delete">Excluir</option>
                                        </select><button class="btn btn-falcon-default btn-sm ml-2" type="button"><i class="fas fa-check"></i></button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="falcon-data-table">
                            <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row mx-1">
                                    <div class="col-sm-12 col-md-6"></div>
                                    <div class="col-sm-12 col-md-6"></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0 table-striped table-dashboard fs--1 data-table border-bottom border-200 dataTable no-footer" data-options="{&quot;searching&quot;:false,&quot;responsive&quot;:false,&quot;pageLength&quot;:12,&quot;info&quot;:false,&quot;lengthChange&quot;:false,&quot;sWrapper&quot;:&quot;falcon-data-table-wrapper&quot;,&quot;dom&quot;:&quot;<'row mx-1'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'table-responsive'tr><'row no-gutters px-1 py-3 align-items-center justify-content-center'<'col-auto'p>>&quot;,&quot;language&quot;:{&quot;paginate&quot;:{&quot;next&quot;:&quot;<span class=\&quot;fas fa-chevron-right\&quot;></span>&quot;,&quot;previous&quot;:&quot;<span class=\&quot;fas fa-chevron-left\&quot;></span>&quot;}}}" id="DataTables_Table_1" role="grid">
                                        <thead class="bg-200 text-900">
                                            <tr role="row">
                                                <th class="align-middle sort sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 165.203px;">Nome máquina</th>
                                                <th class="align-middle sort sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 153.203px;">IP</th>
                                                <th class="align-middle sort sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 153.203px;">Máscara de rede</th>
                                                <th class="align-middle sort sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" style="width: 153.203px;">Gateway</th>

                                                <th class="align-middle no-sort sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label=": activate to sort column ascending" style="width: 56.2031px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="customers">
                                            <?php
                                            $ip = explode('.', $ipAddress);
                                            for ($i = 1; $i <= $numberMachines; $i++) { ?>
                                                <tr class="btn-reveal-trigger odd" role="row">
                                                    <td class="py-2 align-middle white-space-nowrap customer-name-column">
                                                        <div class="media d-flex align-items-center">
                                                            <div class="media-body">
                                                                <h5 class="mb-0 fs--1"><?php
                                                                                        echo 'LAB' . $numberLab . 'DT' . ($i < 10 ? '0' . $i : $i); ?></h5>
                                                            </div>
                                                        </div>
                                                        </a>
                                                    </td>
                                                    <td class="py-2 align-middle"><?php echo "$ip[0].$ip[1].$ip[2].$ip[3]" ?></td>

                                                    <td class="py-2 align-middle"><?php echo $subnetMask ?></td>
                                                    <td class="py-2 align-middle"><?php echo $gateway ?></td>
                                                    <?php $ip[3]++; ?>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row-reverse"><a class="btn btn-falcon-default btn-sm  mb-2" href="/tfg/labsManagement/views/labs/"><span class="fas fa-arrow-left mr-1"></span> Voltar</a></div>

            </div>
        </div>
    </main>
</body>

<!-- ADICIONAR NOVO SOFTWARE-->
<div class="modal fade" id="modalAddNewSoftware" tabindex="-1" role="dialog" aria-labelledby="fullNameSoftware" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullNameSoftware"></h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
            </div>
            <form id="formAddSoftware">
                <div class="modal-body">
                    <h3 class="mb-4">Incluir Novo Software</h3>
                    <input type="number" name="idLab" value="<?php echo  $idLab; ?>" hidden>
                    <div class="row">
                        <div class="col-sm">
                            <select id="listSoftwares" class="form-control" data-placeholder="Selecione os Softwares" name="softwares">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-falcon-success btn-sm"> <i class="fas fa-check"></i> Incluir</button>
                    <button id="modal-btn-close" type="button" class="btn btn-falcon-default btn-sm" data-dismiss="modal"><i class="far fa-times-circle"></i> Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<link href="/tfg/assets/lib/toastr/toastr.min.css" rel="stylesheet">
<script src="/tfg/assets/lib/toastr/toastr.min.js"></script>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/footer.html' ?>
<script src="/tfg/labsManagement/js/global.js"></script>
<script src="/tfg/labsManagement/js/infoLab.js"></script>
<script>
    loadSoftwaresTable(<?php echo $idLab; ?>);
</script>