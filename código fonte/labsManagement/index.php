<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/auth-verify.php' ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/config.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/header.html' ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/labs/Lab.php' ?>

<link href="/tfg/assets/lib/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="/tfg/assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">


<?php
$amount = Lab::GetAmountLabAndMachines();
$amountLab = $amount[0]['AMOUNT_LAB'];
$amountMachines = $amount[0]['AMOUNT_MACHINES'];

$amountSoftwares = Software::GetAmountSoftwares()[0]['AMOUNT_SOFTWARE'];

$lastUpdateLabs = Lab::GetLastUpdateLabs();

$purchaseLabs = Lab::GetLastPurchaseLabs();
?>

<body>
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/nav.html' ?>
            <div class="content">
                <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/top-nav.php' ?>
                <div class="card mb-3">
                    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../tfg/assets/img/illustrations/corner-4.png);"></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h3 class="mb-0">Laboratórios de informática</h3>
                                <p class="mt-2">Gerenciamento dos laboratórios de informática da Universidade Franciscana</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-12 col-md-4 mt-2 ">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/illustrations/corner-2.png);"></div>

                            <div class="card-body position-relative">
                                <h6>Total de Laboratórios</h6>
                                <div class="display-4 fs-4 mb-2  fw-normal font-sans-serif text-info"><?php echo $amountLab ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 mt-2">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/illustrations/corner-2.png);"></div>
                            <div class="card-body position-relative">
                                <h6>Quantidade Total de Computadores</h6>
                                <div class="display-4 fs-4 mb-2  fw-normal font-sans-serif text-info"><?php echo $amountMachines ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4 mt-2 ">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/illustrations/corner-2.png);"></div>
                            <div class="card-body position-relative">
                                <h6>Quantidade Total de Softwares</h6>
                                <div class="display-4 fs-4 mb-2  fw-normal font-sans-serif text-info"><?php echo $amountSoftwares ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6 mt-2">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/illustrations/corner-2.png);"></div>
                            <div class="card-body position-relative">
                                <h6>Últimos Laboratórios Atualizados</h6>

                                <div class="table-responsive scrollbar">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Laboratório</th>
                                                <th scope="col">Data de Atualização</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            foreach ($lastUpdateLabs as $lab) { ?>

                                                <tr>
                                                    <td>
                                                        <a href="/tfg/labsManagement/views/labs/infoLab.php?id=<?php echo $lab['ID_LAB']; ?>"> Laboratório <?php echo $lab['NAME']; ?></a>
                                                    </td>
                                                    <td><?php echo date_format(date_create($lab['LAST_UPDATE']), "d/m/Y") ?></td>
                                                </tr>

                                            <?php }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-2 ">
                        <div class="card overflow-hidden" style="min-width: 12rem">
                            <div class="bg-holder bg-card" style="background-image:url(../assets/img/illustrations/corner-2.png);"></div>
                            <div class="card-body position-relative">
                                <h6>Últimos Laboratórios Adquiridos</h6>
                                <div class="table-responsive scrollbar">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Laboratório</th>
                                                <th scope="col">Data de Compra</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($purchaseLabs as $lab) { ?>

                                                <tr>
                                                    <td>
                                                        <a href="/tfg/labsManagement/views/labs/infoLab.php?id=<?php echo $lab['ID_LAB']; ?>"> Laboratório <?php echo $lab['NAME']; ?></a>
                                                    </td>
                                                    <td><?php echo date_format(date_create($lab['PURCHASE_DATE']), "d/m/Y") ?></td>
                                                </tr>

                                            <?php }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</body>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/footer.html' ?>
<script src="/tfg/assets/lib/datatables/js/jquery.dataTables.min.js"></script>
<script src="/tfg/assets/lib/datatables-bs4/dataTables.bootstrap4.min.js"></script>
<script src="/tfg/assets/lib/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="/tfg/assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>