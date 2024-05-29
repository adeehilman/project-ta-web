function showError(field, message) {
    if(!message) {
        $('#' + field)
        .addClass('is-valid')
        .removeClass('is-invalid')
        .siblings('.invalid-feedback')
        .text('')
    } else {
        $('#' + field)
        .addClass('is-invalid')
        .removeClass('is-valid')
        .siblings('.invalid-feedback')
        .text(message)
    }
}

function removeValidationClass(form) {
    $(form).each(function() {
        $(form).find(':input').removeClass('is-valid is-invalid');
    })
}

function showMessage(type, message) {

    if(!type || type === '' || !message || message === ''){
        return;
    }

    return Swal.fire({
        icon: type,
        title: message,
        showConfirmButton: false,
        timer: 2000
    })

}

function spinner(spinnerId, buttonId) {
    if(!spinnerId || spinnerId === '' || !buttonId || buttonId === ''){
        return;
    }
    $('#' + spinnerId).removeClass('d-none').prop('disabled', true);
    $('#' + buttonId).hide();
}

function hideSpinner(spinnerId, buttonId) {
    $('#' + spinnerId).addClass('d-none').prop('disabled', false);
    $('#' + buttonId).show();
}
