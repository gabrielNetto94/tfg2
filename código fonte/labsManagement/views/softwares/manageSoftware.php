<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/auth-verify.php' ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/config.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/header.html' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php' ?>

<link href="/tfg/assets/lib/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="/tfg/assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">
<link href="/tfg/assets/lib/toastr/toastr.min.css" rel="stylesheet">
<link href="/tfg/assets/css/theme.min.css" rel="stylesheet">
<script src="/tfg/assets/js/jquery.min.js"></script>

<?php

if ($_GET['id'] > 0) {
    foreach (Software::GetSoftware($_GET['id']) as $row) {

        $idSoftware = $row['ID_SOFTWARE'];
        $name = $row['NAME'];
        $version = $row['VERSION'];
        $instructionInstall = $row['INSTRUCTION_INSTALL'];
        $formName = 'form-update';
        $nameButtonSubmit = 'Alterar';
    }
} else {
    $name = '';
    $version = '';
    $instructionInstall = '';
    $formName = 'form-create';
    $nameButtonSubmit = ' Cadastrar';
}
?>

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
                                <h3 class="mb-0">Gerenciamento de Softwares</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="<?php echo $formName; ?>" method="post">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row-sm">

                                <input value="<?php echo $idSoftware ?>" id="idSoftware" name="idSoftware" hidden type="number">

                                <div class="col-sm">
                                    <label class="badge badge-secondary">Nome</label><br>
                                    <input value="<?php echo $name ?>" class="form-control" type="text" name="softwareName" placeholder="Nome do software" required>
                                </div>
                                <div class="col-sm">
                                    <label class="badge badge-secondary">Versão</label><br>
                                    <input value="<?php echo $version ?>" class="form-control" type="text" name="version" placeholder="Versão do software">
                                </div>
                                <div class="col-sm">
                                    <label class="badge badge-secondary">Informações Adicionais</label><br>
                                    <textarea rows="5" class="form-control" name="instructionInstall" placeholder="Instrução de instalação, licenciamento ou qualquer informação que seja relevante para instalação"><?php echo $instructionInstall ?></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-falcon-success btn-sm"> <i class="fas fa-check"></i><?php echo $nameButtonSubmit ?></button>
                            <a href="/tfg/labsManagement/views/softwares/"><button type="button" class="btn btn-falcon-default btn-sm"><i class="fas fa-arrow-left mr-1"></i> Voltar</button></a>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/footer.html' ?>

<script src="/tfg/assets/lib/toastr/toastr.min.js"></script>
<script src="/tfg/assets/lib/datatables/js/jquery.dataTables.min.js"></script>
<script src="/tfg/assets/lib/datatables-bs4/dataTables.bootstrap4.min.js"></script>
<script src="/tfg/assets/lib/datatables.net-responsive/dataTables.responsive.js"></script>
<script src="/tfg/assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js"></script>
<script src="/tfg/labsManagement/js/global.js"></script>
<script src="/tfg/labsManagement/js/manageSoftware.js"></script>