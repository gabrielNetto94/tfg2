<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/auth-verify.php' ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/config.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/header.html' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/labs/Lab.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/location/Location.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/machine/Machine.php' ?>

<?php
$idLab = $_GET['id'];

?>
<link href="/tfg/assets/lib/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="/tfg/assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">

<body>
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/nav.html' ?>
            <div class="content">
                <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/top-nav.php' ?>

                <div class="card mb-3">
                    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../../assets/img/illustrations/corner-4.png);"></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10">
                                <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0"><i class="fas fa-history"></i> Histórico de alterações do Laboratório <?php echo Lab::GetLab($idLab)[0]["NAME"]; ?> </h5>
                                <p class="mt-2">Interface apresentando o histórico de alterações apenas dos dados que foram alterados no laboratório, ordenados em ordem decrescente pela data de alteração</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inormações gerais -->
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                                <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0"><i class="fas fa-info-circle"></i> Alterações de Informações Gerais</h5>
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
                                                <th class="align-middle " style="width: 165.203px;">Número Laboratório</th>
                                                <th class="align-middle " style="width: 153.203px;">Modelo Máquina</th>
                                                <th class="align-middle " style="width: 153.203px;">Número de máquinas</th>
                                                <th class="align-middle " style="width: 165.203px;">Data de Compra</th>
                                                <th class="align-middle " style="width: 153.203px;">Data Última Imagem</th>
                                                <th class="align-middle " style="width: 153.203px;">Data Alteração</th>
                                            </tr>
                                        </thead>
                                        <tbody id="customers">
                                            <tr class="btn-reveal-trigger odd" role="row">
                                                <?php
                                                $historyGeneralInfo = Lab::GetHistoryGeneralInfo($idLab);
                                                $numberLab = 90;
                                                foreach ($historyGeneralInfo as  $row) {
                                                    if (($row['NAME'] == null && $row['MODEL_MACHINE'] == null &&  $row['NUMBER_MACHINES'] == null && $row['PURCHASE_DATE'] == null && $row['LAST_UPDATE'] == null)) {
                                                    } else { ?>

                                            <tr class="btn-reveal-trigger odd" role="row">
                                                <td class="py-2 align-middle"><?php echo $row['NAME'] != null ? $row['NAME'] : "---"  ?></td>
                                                <td class="py-2 align-middle"><?php echo $row['MODEL_MACHINE'] != null ? $row['MODEL_MACHINE'] : "---" ?></td>
                                                <td class="py-2 align-middle"><?php echo $row['NUMBER_MACHINES'] != null ? $row['NUMBER_MACHINES'] : "---" ?></td>
                                                <td class="py-2 align-middle"><?php echo $row['PURCHASE_DATE'] != null ? date_format(date_create($row['PURCHASE_DATE']), "d/m/Y") : "---" ?></td>
                                                <td class="py-2 align-middle"><?php echo $row['LAST_UPDATE'] != null ? date_format(date_create($row['LAST_UPDATE']), "d/m/Y") : "---" ?></td>
                                                <td class="py-2 align-middle"><?php echo date_format(date_create($row['LOG_DATE']), "d/m/Y H:i:s") ?></td>

                                            </tr>

                                        <?php }
                                        ?>
                                    <?php } ?>
                                    </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Localização-->
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                                <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0"><i class="fas fa-map-marker-alt"></i> Alterações de Localização</h5>
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
                                                <th class="align-middle " style="width: 165.203px;">Conjunto</th>
                                                <th class="align-middle " style="width: 153.203px;">Prédio</th>
                                                <th class="align-middle " style="width: 153.203px;">Sala</th>
                                                <th class="align-middle " style="width: 153.203px;">Data Alteração</th>
                                            </tr>
                                        </thead>
                                        <tbody id="customers">
                                            <?php
                                            $historyLocation = Location::GetHistoryLab($idLab);
                                            foreach ($historyLocation as  $row) { ?>

                                                <tr class="btn-reveal-trigger odd" role="row">
                                                    <td class="py-2 align-middle"><?php echo $row['SET_BUILDING'] != null ? $row['SET_BUILDING'] : "---"  ?></td>
                                                    <td class="py-2 align-middle"><?php echo $row['BUILDING'] != null ? $row['BUILDING'] : "---" ?></td>
                                                    <td class="py-2 align-middle"><?php echo $row['ROOM'] != null ? $row['ROOM'] : "---" ?></td>
                                                    <td class="py-2 align-middle"><?php echo date_format(date_create($row['LOG_DATE']), "d/m/Y H:i:s") ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Hardware-->
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                                <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0"><i class="fas fa-desktop"></i> Alterações de Hardware</h5>
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
                                                <th class="align-middle " style="width: 165.203px;">Nome máquina</th>
                                                <th class="align-middle " style="width: 153.203px;">CPU</th>
                                                <th class="align-middle " style="width: 153.203px;">Memória RAM</th>
                                                <th class="align-middle " style="width: 153.203px;">Possui Webcam</th>
                                                <th class="align-middle " style="width: 153.203px;">Possui Microfone</th>
                                                <th class="align-middle " style="width: 153.203px;">Data Alteração</th>


                                            </tr>
                                        </thead>
                                        <tbody id="customers">
                                            <?php
                                            $historyMachine = Machine::GetHistoryMachine($idLab);
                                            foreach ($historyMachine as  $row) { ?>

                                                <tr class="btn-reveal-trigger odd" role="row">
                                                    <td class="py-2 align-middle"><?php echo $row['MACHINE_NAME'] != null ? $row['MACHINE_NAME'] : "---"  ?></td>

                                                    <td class="py-2 align-middle"><?php echo $row['CPU_MODEL'] != null ? $row['CPU_MODEL'] : "---" ?></td>
                                                    <td class="py-2 align-middle"><?php echo $row['MEMORY_SIZE'] != null ? $row['MEMORY_SIZE'] : "---" ?></td>
                                                    <?php if ($row['HAS_WEBCAM'] != null) { ?>
                                                        <td class="py-2 align-middle"><?php echo $row['HAS_WEBCAM'] == 0 ? "Não" : "Sim" ?></td>
                                                    <?php } else { ?>
                                                        <td class="py-2 align-middle"> -- </td>
                                                    <?php } ?>

                                                    <?php if ($row['HAS_MICROPHONE'] != null) { ?>
                                                        <td class="py-2 align-middle"><?php echo $row['HAS_MICROPHONE'] == 0 ? "Não" : "Sim" ?></td>
                                                    <?php } else { ?>
                                                        <td class="py-2 align-middle"> -- </td>
                                                    <?php } ?>
                                                    <td class="py-2 align-middle"><?php echo date_format(date_create($row['LOG_DATE']), "d/m/Y H:i:s") ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- IP -->
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
                                <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0"><i class="fas fa-network-wired"></i> Alterações de Rede</h5>
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

                                                <th class="align-middle " style="width: 153.203px;">IP</th>
                                                <th class="align-middle " style="width: 153.203px;">Máscara de rede</th>
                                                <th class="align-middle " style="width: 153.203px;">Gateway</th>
                                                <th class="align-middle " style="width: 153.203px;">Data Alteração</th>

                                            </tr>
                                        </thead>
                                        <tbody id="customers">
                                            <?php
                                            $hisoryNetwork = Lab::GetHistoryNetwork($idLab);
                                            foreach ($hisoryNetwork as  $row) {
                                                if (($row['IP_ADDRESS'] == null && $row['SUBNET_MASK'] == null && $row['GATEWAY'] == null)) {
                                                } else { ?>
                                                    <tr class="btn-reveal-trigger odd" role="row">
                                                        <td class="py-2 align-middle"><?php echo $row['IP_ADDRESS'] != null ? $row['IP_ADDRESS'] : "---"  ?></td>
                                                        <td class="py-2 align-middle"><?php echo $row['SUBNET_MASK'] != null ? $row['SUBNET_MASK'] : "---" ?></td>
                                                        <td class="py-2 align-middle"><?php echo $row['GATEWAY'] != null ? $row['GATEWAY'] : "---" ?></td>
                                                        <td class="py-2 align-middle"><?php echo date_format(date_create($row['LOG_DATE']), "d/m/Y H:i:s") ?></td>
                                                    </tr>
                                                <?php } ?>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="d-flex flex-row-reverse"><a class="btn btn-falcon-default btn-sm  mb-2" href="infoLab.php?id=<?php echo $idLab ?>"><span class="fas fa-arrow-left mr-1"></span> Voltar</a></div>

            </div>
        </div>
    </main>
</body>

<link href="/tfg/assets/lib/toastr/toastr.min.css" rel="stylesheet">
<script src="/tfg/assets/lib/toastr/toastr.min.js"></script>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/footer.html' ?>
<script src="/tfg/labsManagement/js/global.js"></script>