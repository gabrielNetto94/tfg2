<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/softwares/Software.php' ?>
<style>
    table tbody tr:hover {
        background-color: #f9fafd;
    }
</style>
<div class="falcon-data-table">
    <table id="tableSoftwares" class="table table-sm table-dashboard no-wrap mb-0 fs--1 w-100" style="display: none">
        <thead class="bg-200">
            <tr>
                <th class="sort">Nome</th>
                <th class="sort">Versão</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            foreach (Software::GetAll() as $row) { ?>
                <tr>
                    <td><?php echo  $row['NAME'] ?></td>
                    <td><?php echo  $row['VERSION'] != null ?  $row['VERSION'] : "--" ?></td>

                    <td>
                        <div class="dropdown text-sans-serif">
                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="customer-dropdown-10" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                <svg class="svg-inline--fa fa-ellipsis-h fa-w-16 fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis-h" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M328 256c0 39.8-32.2 72-72 72s-72-32.2-72-72 32.2-72 72-72 72 32.2 72 72zm104-72c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72zm-352 0c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72z"></path>
                                </svg>
                            </button>

                            <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="customer-dropdown-10">
                                <div class="bg-white py-2">
                                    <a class="dropdown-item" href="#" data-toggle="modal" onclick="openModalInformations(<?php echo $row['ID_SOFTWARE'] ?>,'<?php echo $row['NAME'] ?>','<?php echo $row['VERSION'] ?>','<?php echo $row['INSTRUCTION_INSTALL'] ?>')">Informações</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" onclick="openModalInsertLab(<?php echo $row['ID_SOFTWARE'] ?>)">Incluir Novo Laboratório</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/tfg/labsManagement/views/softwares/manageSoftware.php?id=<?php echo $row['ID_SOFTWARE']; ?>">Editar</a>
                                    <a class="dropdown-item text-danger delete-software" href="#" onclick="deleteSoftware(<?php echo $row['ID_SOFTWARE']; ?>)">Excluir</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- MODAL INFO INSTALAÇÃO-->
<div class="modal fade" id="informations" tabindex="-1" role="dialog" aria-labelledby="fullNameSoftware" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullNameSoftware"></h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Informações Adicionais</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm">
                                <p id="instructionInstall">Aqui a info de como instalar o programa, licenciamento, etc...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Laboratórios que possuem o software instalado</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm">
                                <ul class="list-group" id="informationLabs">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button id="modal-btn-close" type="button" class="btn btn-falcon-default btn-sm" data-dismiss="modal"><i class="far fa-times-circle"></i> Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- ADICIONAR NOVO LAB-->
<div class="modal fade" id="modalAddNewLab" tabindex="-1" role="dialog" aria-labelledby="fullNameSoftware" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullNameSoftware"></h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span class="font-weight-light" aria-hidden="true">&times;</span></button>
            </div>
            <form id="formAddLab">
                <div class="modal-body">
                    <h3 class="mb-4">Incluir Novo Laboratório</h3>
                    <input type="number" name="idSoftware" id="idSoftware" value="" hidden>
                    <div class="row">
                        <div class="col-sm">
                            <select id="listLabs" class="form-control" data-placeholder="Selecione os Labs" name="idLab">

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
<script src="/tfg/labsManagement/js/global.js"></script>
<script src="/tfg/labsManagement/js/tableSoftwares.js"></script>