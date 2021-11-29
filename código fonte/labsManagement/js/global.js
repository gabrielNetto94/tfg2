function GetValuesForm(inputs) {

    var values = [];

    inputs.each(function () {
        values[this.name] = $(this).val();
    });

    values['hasMicrophone'] = $("input[name=hasMicrophone]:checked").val();
    values['hasWebcam'] = $("input[name=hasWebcam]:checked").val();
    return values;
}

function GetArrayByName(nameElement) {
    let array = [];

    $(`[name="${nameElement}"]`).each((index, item) => {
        array.push(item.value)
    })

    return array;
}

function getFormatDateToBrazilian(date) {
    
    let month = date.getMonth() + 1;
    month < 10 ? month = (`0${month}`) : month

    return `${date.getDate()}/${month}/${date.getFullYear()}`;

}

function DateFormat(date) {
    
    var local = new Date(date);
    local.setMinutes(date.getMinutes() - date.getTimezoneOffset());
    return local.toJSON().slice(0, 10);
}

toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "2500",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}