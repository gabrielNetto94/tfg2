<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/auth-verify.php' ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/config.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/header.html' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php' ?>

<link href="/tfg/assets/lib/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="/tfg/assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">

<script src="/tfg/assets/js/jquery.min.js"></script>
<link href="/tfg/assets/css/theme.min.css" rel="stylesheet">

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
                                <h3 class="mb-0">Softwares</h3>
                                <p class="mt-2">Lista de todos os softwares instalados nos laboratórios de informática da Universidade Franciscana</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3" style="padding-top: 2em; padding-bottom: 1em">
                    <div id="dashboard-actions" class="pl-4 mb-4">

                        <a href="/tfg/labsManagement/views/softwares/manageSoftware.php?id=0">
                            <button class="btn btn-success btn-sm" data-toggle="modal" type="button">
                                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                                <span class="d-none d-sm-inline-block ml-1">Novo Software</span>
                            </button>
                        </a>
                    </div>

                    <div id="processing-spin" class="text-center">
                        <div class="spinner-border" role="status"><span class="sr-only">Carregando...</span></div>
                        <h6 id="processing-text" style="text-align: center; display: none; margin-top: 1em; padding-bottom: 1em" class="text-800">Processando registros</h6>
                    </div>
                    <div id="table">
                        <h6 style="text-align: center; margin-top: 1em; padding-bottom: 1em" class="text-800">Consultando Laboratórios</h6>
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
<script>
    $("#table").load("/tfg/labsManagement/views/softwares/tableSoftwares.php")
</script>