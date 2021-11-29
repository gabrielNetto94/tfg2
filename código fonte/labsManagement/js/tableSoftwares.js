function openModalInformations(id, name, version, instructionInstall) {

    $('#fullNameSoftware').text(`${name} ${version}`);

    if (instructionInstall.length > 0) {

        $('#instructionInstall').text(instructionInstall).css('font-style', 'normal').css("font-weight", "Bold");
    } else {

        $('#instructionInstall').text('Sem informações adicionais').css('font-style', 'italic').css('font-weight', 'normal');
    }

    loadLabsContainSoftware(id);

    $('#informations').modal('show');
}

function openModalInsertLab(id) {

    $('#listLabs').empty();
    $.get(`/tfg/labsManagement/controllers/labs/listLabsNotContainSoftware.php?id=${id}`)
        .done(function (data) {

            let jsonParsed = jQuery.parseJSON(data);

            $('#idSoftware').val(id);

            if (jsonParsed.length != 0) {

                jsonParsed.map((value) => {

                    $('#listLabs').append(`<option value="${value.ID_LAB}">LABORATÓRIO ${value.NAME} - <label>Conjunto ${value.SET_BUILDING}, Prédio ${value.BUILDING}, Sala ${value.ROOM} </label></option>`)
                })
            } else {
                $('#listLabs').append('<option selected disable>Sem Laboratório disponível para inclusão</option>');
            }

        }).catch((err) => {
            console.log(err);
        });


    $('#modalAddNewLab').modal('show');
}

$("#formAddLab").submit(function (event) {
    event.preventDefault();

    valuesForm = GetValuesForm($('#formAddLab :input'));

    $.post(`/tfg/labsManagement/controllers/softwares/bindLabwithSoftware.php`, {
        "idLab": valuesForm.idLab,
        "idSoftware": valuesForm.idSoftware
    })
        .done(function (data) {

            if (data == 1) {

                toastr.success('Laboratório incluído com sucesso!');
                openModalInsertLab(valuesForm.idSoftware);

            } else {
                toastr.error('Falha ao incluir o laboratório');
            }

        }).catch((err) => {
            console.log(err);
        });
});

var row;

$('.delete-software').mouseover((event) => {
    row = $(event.target).parent().parent().parent().parent().parent();
})

function deleteSoftware(id) {

    if (confirm('Deseja realmente remover?')) {

        $.get(`/tfg/labsManagement/controllers/softwares/deleteSoftware.php?id=${id}`)
            .done(function (status) {
                if (status == 1) {

                    $(row).remove();
                    toastr.success('Software Removido!');
                } else {
                    toastr.error('Falha ao remover!');
                }
            }).catch((err) => {
                console.log(err);
            });
    }
}

function loadLabsContainSoftware(idSoftware) {
    $('#informationLabs').empty();
    $.get(`/tfg/labsManagement/controllers/softwares/getLabsSoftware.php?id=${idSoftware}`)
        .done(function (data) {

            let jsonParse = jQuery.parseJSON(data);

            if (jsonParse.length != 0) {

                jsonParse.map((value) => {
                    $('#informationLabs').append(`<a href="/tfg/labsManagement/views/labs/infoLab.php?id=${value.ID_LAB}">
                                                <li class="list-group-item">LABORATÓRIO ${value.NAME}</a> Cojunto ${value.SET_BUILDING},Prédio ${value.BUILDING}, Sala ${value.ROOM} 
                                                    <a onclick="deleteLab(this,${value.ID_SOFTWARE},${value.ID_LAB})" href="#"  data-toggle="tooltip" data-placement="top" data-original-title="Adicionar novo armazenamento">
                                                        <i class="ml-2 fas fa-trash-alt"></i> 
                                                    </a>
                                                </li>`);
                })
            } else {
                $('#informationLabs').text('Software não instalado em nenhum laboratório');
            }
        }).catch((err) => {
            console.log(err);
        });
}

function deleteLab(e, idSoftware, idLab) {

    $.get(`/tfg/labsManagement/controllers/softwares/deleteLab.php?idLab=${idLab}&idSoftware=${idSoftware}`)
        .done(function (data) {

            console.log(data)
            if (data == 1) {

                $(e).parent().remove();
                toastr.success('Laboratório removido!');
            } else {
                toastr.error('Erro ao remover laboratório!');
            }

        }).catch((err) => {
            console.log(err);
        });
}

window.utils.$document.ready(function () {
    var dataTables = $('#tableSoftwares');
    var customDataTable = function customDataTable(elem) {
        elem.find('.pagination').addClass('pagination-sm');
    };

    dataTables.length && dataTables.each(function (index, value) {
        var $this = $(value);
        var options = $.extend({
            order: [
                [0, 'asc']
            ],
            /*"columnDefs": [{
                "width": "10%",
                "targets": 4
            }],*/
            responsive: true,
            pageLength: 15,
            lengthMenu: [
                [15, 30, 100],
                [15, 30, 100]
            ],
            lengthChange: true,
            info: false,
            sWrapper: "falcon-data-table-wrapper",
            initComplete: function () {
                $('#processing-spin').hide();
                $('#processing-text').hide();
                $this.show();
            },
            language: {
                emptyTable: "Sem registro",
                lengthMenu: "Registros por página: _MENU_",
                zeroRecords: "Nenhum registro encontrado",
                search: "Buscar:",
                paginate: {
                    next: "<span class=\"fas fa-chevron-right\"></span>",
                    previous: "<span class=\"fas fa-chevron-left\"></span>",
                },
            },
            dom: "<'row mx-1'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'table-responsive'tr><'row no-gutters px-1 py-3 align-items-center justify-content-center'<'col-auto' p>>"
        }, $this.data('options'));
        $this.DataTable(options);
        var $wrpper = $this.closest('.dataTables_wrapper');
        customDataTable($wrpper);
        $this.on('draw.dt', function () {
            return customDataTable($wrpper);
        });
    });
});
$('#processing-text').show();
