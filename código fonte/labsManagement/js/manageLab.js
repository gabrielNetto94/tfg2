
$(document).ready(function () {
    $('.chosen-select').chosen();
});

$(function ($) {
    $(".ipAddress").mask("999.999.999.999", { placeholder: "000.000.000.000" });
});

$('#lastUpdate').val(DateFormat(new Date()))

$(document).ready(function () {
    var i = 1;
    $('#addStorage').click(function () {
        if (i < 2) {
            i++;
            $('#dynamic_field').append(`<div class="col-sm-4" id="field${i}">
                                            <label class="badge badge-secondary">Tipo de Armazenamento</label>
                                            <button type="button" name="remove" id="${i}" class="btn btn-falcon-danger ml-2 btn-sm btn_remove"><i class="fas fa-minus"></i></button>
                                            <input value="" name="idStorage" type="number" hidden>
                                            <select required class="form-control" name="storageType" >
                                                <option disabled selected value="" >Selecione uma opção</option>
                                                <option value="HD">HD</option>
                                                <option value="SSD SATA">SSD SATA</option>
                                                <option value="SSD M2">SSD M2</option>
                                                <option value="SSD Nvme">SSD Nvme</option>
                                            </select>
                                            <label class="badge badge-secondary">Espaço</label>
                                            <input required class="form-control" type="number" name="storageSize" placeholder="Digitar valor em GB" >
                                        </div>`);
        }
    });

    $(document).on('click', '.btn_remove', function () {
        var button_id = $(this).attr("id");
        i--;
        $('#field' + button_id + '').remove();
    });
});

function deleteStorage(idStorage, idMachine, element) {

    $.post(`/tfg/labsManagement/controllers/machine/deleteStorage.php`, {
        "idMachine": idMachine,
        "idStorage": idStorage
    })
        .done(function (data) {

            //console.log(data)
            if (data == 1)
                $(element).parent().remove();

        }).catch((err) => {
            console.log(err);
        });
}

function validateOS() {

    flag = false;
    $('#selectOs option').each(function () {
        if ($(this).is(':selected')) {
            flag = true;
        }
    })

    return flag;
}

function validateSoftware() {

    flag = false;
    $('#selectSoftware option').each(function () {
        if ($(this).is(':selected')) {
            flag = true;
        }
    })

    return flag;
}

function validateDifferenceDate() {
    return Date.parse($('#lastUpdate').val()) >= Date.parse($('#purchaseDate').val()) ? true : false;
}

$('#form-create,#form-update').submit(function (e) {

    let formId = e.currentTarget.id

    if (formId == 'form-create') {

        fileName = 'createLab';
        messageSuccess = 'Cadastrado';
        messageError = 'Cadastrar';
    } else {

        fileName = 'updateLab'
        messageSuccess = 'Alterado';
        messageError = 'Alterar';
    }

    e.preventDefault();

    if (!validateOS()) {
        toastr.warning('Selecione um sistema operacional');
        return;
    }

    if (!validateSoftware()) {
        toastr.warning('Selecione um software');
        return;
    }

    if (!validateDifferenceDate()) {
        toastr.warning('Data de atualização deve ser maior ou igual a data de compra');
        return;
    }

    valuesForm = GetValuesForm($(`#${formId} :input`));

    storageType = GetArrayByName('storageType');
    storageSize = GetArrayByName('storageSize');
    idStorage = GetArrayByName('idStorage');

    $.post(`/tfg/labsManagement/controllers/labs/${fileName}.php`, {

        "idLab": valuesForm.idLab,
        "setBuilding": valuesForm.setBuilding,
        "building": valuesForm.building,
        "room": valuesForm.room,
        "fkIdLocation": valuesForm.fkIdLocation,

        "lastUpdate": valuesForm.lastUpdate,
        "numberLab": valuesForm.numberLab,
        "machineModel": valuesForm.machineModel,
        "purchaseDate": valuesForm.purchaseDate,
        "amount": valuesForm.amount,

        "ipAddress": valuesForm.ipAddress,
        "subnetMask": valuesForm.subnetMask,
        "gateway": valuesForm.gateway,

        "fkIdMachine": valuesForm.fkIdMachine,
        "cpu": valuesForm.cpu,
        "memorySize": valuesForm.memorySize,
        "hasMicrophone": valuesForm.hasMicrophone,
        "hasWebcam": valuesForm.hasWebcam,
        "serial": valuesForm.serial,

        "idStorage": idStorage,
        "storageSize": storageSize,
        "storageType": storageType,
        "os": valuesForm.os,
        "softwares": valuesForm.softwares
    })
        .done(function (data) {
            console.log(data)
            if (data == 1) {

                toastr.success(`Laboratório ${messageSuccess} com sucesso!`);

            } else if (data == 2) {

                toastr.warning('Laboratório já cadastrado!');

            } else {
                toastr.error(`Falha ao ${messageError} o laboratório`);
            }

        }).catch((err) => {
            console.log(err);
        });
});