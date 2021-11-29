function loadSoftwaresTable(id) {

    $('#purchases').empty()

    $.get(`/tfg/labsManagement/controllers/labs/getSoftwaresLab.php?id=${id}`)

        .done(function (data) {

            dataJson = jQuery.parseJSON(data);

            let numberSoftwares = Object.keys(dataJson).length

            $('#numberSoftwares').text(`Número de softwares instalados: ${numberSoftwares}`);

            dataJson.map((value) => {

                $('#purchases').append(` 
                    <tr class="btn-reveal-trigger odd" role="row">
                        <th class="align-middle">${value.NAME}</th>
                        <td class="align-middle">${value.VERSION}</td>
                    </tr>
                `);
            })
        }).catch((err) => {
            console.log(err);
        });
}

function updateLastUpdate(id) {

    let dateToDatabase = new Date().toISOString().split('T')[0];
    let dateToView = getFormatDateToBrazilian(new Date());

    $.post("/tfg/labsManagement/controllers/labs/updateLastUpdate.php", {
        "id": id,
        "date": dateToDatabase
    })
        .done((data) => {
            if (data == 1) {
                $('#lastUpdate').text(dateToView);
                toastr.success("Data atualizada com sucesso!");
            } else {
                toastr.error("Erro ao alterar a data!");
            }

        }).catch((err) => {
            console.log(err);
        });
}

function openModalSoftwares(id) {

    $('#listSoftwares').empty();

    $.get(`/tfg/labsManagement/controllers/softwares/listSoftwareNotContainLab.php?idLab=${id}`)
        .done(function (data) {

            let jsonParsed = jQuery.parseJSON(data);

            if (jsonParsed.length != 0) {

                jsonParsed.map((value) => {
                    $('#listSoftwares').append(`<option value="${value.ID_SOFTWARE}">${value.NAME} ${value.VERSION}</option>`)
                })
            } else {

                $('#listSoftwares').append(`<option selected disable>Sem software disponível para inclusão</option>`)
            }

        }).catch((err) => {
            console.log(err);
        });

    $('#modalAddNewSoftware').modal('show');
}

$("#formAddSoftware").submit(function (event) {
    event.preventDefault();

    valuesForm = GetValuesForm($('#formAddSoftware :input'));

    $.post(`/tfg/labsManagement/controllers/softwares/bindLabwithSoftware.php`, {
        "idLab": valuesForm.idLab,
        "idSoftware": valuesForm.softwares
    })
        .done(function (data) {

            if (data == 1) {

                toastr.success('Software incluído com sucesso!');

                openModalSoftwares(valuesForm.idLab);
                loadSoftwaresTable(valuesForm.idLab);
            } else {
                toastr.error('Falha ao incluir o software');
            }

        }).catch((err) => {
            console.log(err);
        });
});