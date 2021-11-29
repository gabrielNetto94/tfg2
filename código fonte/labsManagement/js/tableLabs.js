window.utils.$document.ready(function () {
    var dataTables = $('#tableLab');
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

function deleteLab(id) {

    if (confirm('Deseja realmente remover?')) {

        let tableRow = $(event.target).parent().parent().parent().parent().parent();

        $.get(`/tfg/labsManagement/controllers/labs/deleteLab.php?id=${id}`)
            .done(function (status) {
                if (status == 1) {

                    tableRow.remove();

                    toastr.success('Laboratório Removido!');
                } else {
                    toastr.error('Falha ao remover!');
                }
            }).catch((err) => {
                console.log(err);
            });
    } else {
        
    };
}