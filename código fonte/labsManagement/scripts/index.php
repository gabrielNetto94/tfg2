<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/auth-verify.php' ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/config.php' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/header.html' ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/labs/Lab.php' ?>

<link href="/assets/lib/datatables-bs4/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="/assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css" rel="stylesheet">

<?php

$labs = Lab::GetAll();

?>

<body>
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/nav.html' ?>
            <div class="content">
                <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/includes/top-nav.php' ?>
                <div class="card mb-3">
                    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/illustrations/corner-4.png);"></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 class="mb-0">Scripts de acesso remoto e transferência de arquivos</h3>
                                <p class="mt-2">Funcionalidade que permite download de um arquivo .zip, com scripts .bat para acesso remoto via Microsoft Terminal Service e scripts para transferir arquivos para diversas máquinas de laboratório.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-sm-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">Acesso Remoto</h5>
                            </div>
                            <div class="card-body bg-light">
                                <div class="row">
                                    <div class="col-12">
                                        <form method="post" action="remoteAccess.php">
                                            <label class="badge badge-secondary">Laboratório</label><br>
                                            <select required class="form-control" name="lab_amount" required>
                                                <option selected <?php  ?> value="">Selecione um laboratório</option>
                                                <?php
                                                foreach ($labs as $lab) { ?>
                                                    <option value="<?php echo $lab['NAME_LAB'] . '_' . $lab['NUMBER_MACHINES'] ?>">Laboratório <?php echo  $lab['NAME_LAB'] ?></option>
                                                <?php }
                                                ?>
                                            </select>

                                            <label class="badge badge-secondary mt-2">Usuário que deseja realizar login:</label><br>

                                            <div class="form-group form-check">
                                                <input id="domainUser" class="form-check-input" type="radio" name="user" value="domainUser" checked>
                                                <label class="form-check-label" for="domainUser">Usuário do laboratório</label><br>

                                                <input id="localUser" class="form-check-input" type="radio" name="user" value="localUser">
                                                <label class="form-check-label" for="localUser">Administrador local</label>
                                            </div>

                                            <button class="btn btn-success btn-sm" data-toggle="modal" type="submit">
                                                <span class="fas fa-download" data-fa-transform="shrink-3 down-2"></span>
                                                <span class="d-none d-sm-inline-block ml-1">Download</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-sm-12">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">Transferência de arquivos</h5>
                            </div>
                            <div class="card-body bg-light mt-0">
                                <div class="row">
                                    <div class="col-12">
                                        <form method="post" action="transferScript.php"><br>

                                            <label class="badge badge-secondary">Laboratório</label><br>

                                            <select required class="form-control" name="lab_amount" required>
                                                <option selected <?php  ?> value="">Selecione um laboratório</option>
                                                <?php
                                                foreach ($labs as $lab) { ?>
                                                    <option value="<?php echo $lab['NAME_LAB'] . '_' . $lab['NUMBER_MACHINES'] ?>">Laboratório <?php echo  $lab['NAME_LAB'] ?></option>
                                                <?php }
                                                ?>
                                            </select>

                                            <label class="badge badge-secondary mt-2">Caminho de origem:</label><br>
                                            <input class="form-control" type="text" name="origin_path" placeholder="Exemplo:\\172.16.0.13\d$\software " required><br>

                                            <label class="badge badge-secondary">Caminho de destino:</label><br>
                                            <input class="form-control" type="text" name="destination_path" placeholder="Exemplo: c$\users\usrlab10\Desktop\(nome da pasta)" required><br>

                                            <button class="btn btn-success btn-sm" data-toggle="modal" type="submit">
                                                <span class="fas fa-download" data-fa-transform="shrink-3 down-2"></span>
                                                <span class="d-none d-sm-inline-block ml-1">Download</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
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