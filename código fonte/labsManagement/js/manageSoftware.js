$('#form-create').submit((event) => {

    event.preventDefault();

    let valuesForm = GetValuesForm($('#form-create :input'));

    $.post("/tfg/labsManagement/controllers/softwares/createSoftware.php", {
        "softwareName": valuesForm.softwareName,
        "version": valuesForm.version,
        "instructionInstall": valuesForm.instructionInstall
    })
        .done(function (data) {
            if (data == 1) {
                toastr.success("Software Cadastrado!");
                $('#form-create').trigger("reset");
            } else if (data == 2) {
                toastr.warning("Software já cadastrado!");
            } else {
                toastr.error("Erro ao Cadastrar!");
            }
        }).catch((err) => {
            console.log(err);
            toastr.error("Erro ao Cadastrar!");
        });
})

$('#form-update').submit((event) => {

    event.preventDefault();

    var valuesForm = GetValuesForm($('#form-update :input'));

    $.post("/tfg/labsManagement/controllers/softwares/updateSoftware.php", {
        "idSoftware": valuesForm.idSoftware,
        "softwareName": valuesForm.softwareName,
        "version": valuesForm.version,
        "instructionInstall": valuesForm.instructionInstall
    })
        .done(function (data) {
            if (data == 1) {
                toastr.success("Software alterado!");
            } else if (data == 2) {
                toastr.warning("Software já cadastrado!");
            }else{
                toastr.error("Erro ao alterar!");   
            }
        }).catch((err) => {
            console.log(err);
            toastr.error("Erro ao alterar!");
        });
})