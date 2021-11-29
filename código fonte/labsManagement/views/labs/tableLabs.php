<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/labsManagement/controllers/labs/Lab.php' ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tfg/requires/config.php' ?>
<style>
    table tbody tr:hover {
        background-color: #f9fafd;
    }
</style>
<div class="falcon-data-table">
    <table id="tableLab" class="table table-sm table-dashboard no-wrap mb-0 fs--1 w-100" style="display: none">
        <thead class="bg-200">
            <tr>
                <th class="sort">Laboratório</th>
                <th class="sort">Localização</th>
                <th class="sort">Modelo máquina</th>
                <th class="sort">Quantidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            foreach (Lab::GetAll() as $row) { ?>
                <tr>
                    <td><?PHP echo $row['NAME_LAB'] ?></td>
                    <td><?php echo "Conjunto {$row['SET_BUILDING']}, Prédio {$row['BUILDING']}, Sala {$row['ROOM']}" ?></td>
                    <td><?PHP echo $row['MODEL_MACHINE'] ?></td>
                    <td><?PHP echo $row['NUMBER_MACHINES'] ?></td>
                    <td>
                        <div class="dropdown text-sans-serif"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="customer-dropdown-10" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><svg class="svg-inline--fa fa-ellipsis-h fa-w-16 fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis-h" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M328 256c0 39.8-32.2 72-72 72s-72-32.2-72-72 32.2-72 72-72 72 32.2 72 72zm104-72c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72zm-352 0c-39.8 0-72 32.2-72 72s32.2 72 72 72 72-32.2 72-72-32.2-72-72-72z"></path>
                                </svg><!-- <span class="fas fa-ellipsis-h fs--1"></span> Font Awesome fontawesome.com --></button>
                            <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="customer-dropdown-10">
                                <div class="bg-white py-2">
                                    <a class="dropdown-item" href="/tfg/labsManagement/views/labs/infoLab.php?id=<?php echo $row['ID_LAB'] ?>">Informações</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/tfg/labsManagement/views/labs/manageLab.php?id=<?php echo $row['ID_LAB'] ?>">Editar</a>
                                    <a href="#" class="dropdown-item href text-danger" onclick="deleteLab(<?php echo $row['ID_LAB'] ?>)">Excluir</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>


<link href="/tfg/assets/lib/toastr/toastr.min.css" rel="stylesheet">
<script src="/tfg/assets/lib/toastr/toastr.min.js"></script>
<script src="/tfg/labsManagement/js/tableLabs.js"></script>
<script src="/tfg/labsManagement/js/global.js"></script>