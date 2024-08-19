const toastContainer = '<div aria-live="polite" aria-atomic="true" class="position-relative"><div class="toast-container position-fixed top-0 end-0 p-2"></div></div>';

$('html body').append(toastContainer);

function fireNotif(message = '', icon = 'info', delay = 5000) {

    const toastElm = $('.toast-container');
    let data = getType(icon);
    let Elm =
        '<div class="toast align-items-center border-0 ' + data.class + '" role="alert" aria-live="assertive" aria-atomic="true">' +
        '<div class="toast-header">' +
        data.icon +
        '<strong class="me-auto">' + data.type + '</strong>' +
        '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>' +
        '</div>' +
        '<div class="d-flex">' +
        '<div class="toast-body">' +
        message +
        '</div>' +
        '</div>' +
        '</div>';
    toastElm.append(Elm);

    var toast = new bootstrap.Toast($('.toast:last'), {
        delay: delay,
        autohide: delay == 0 ? false : true
    });
    toast.show();

    function getType(name) {
        let data;
        switch (name) {
            case 'success':
                data = {
                    class: 'text-bg-success',
                    icon: '<i class="fa-solid fa-check-circle me-1"></i>',
                    type: 'Success'
                }
                return data
                break;

            case 'error':
                data = {
                    class: 'text-bg-danger',
                    icon: '<i class="fa-solid fa-xmark-circle me-1"></i>',
                    type: 'Error'
                }
                return data
                break;
            case 'warning':
                data = {
                    class: 'text-bg-warning',
                    icon: '<i class="fa-solid fa-triangle-exclamation me-1"></i>',
                    type: 'Warning'
                }
                return data
                break;

            case 'question':
                data = {
                    class: 'text-bg-secondary',
                    icon: '<i class="fa-solid fa-question-circle me-1"></i>',
                    type: 'Question'
                }
                return data
                break;

            case 'info':
                data = {
                    class: 'text-bg-primary',
                    icon: '<i class="fa-solid fa-info-circle me-1"></i>',
                    type: 'Info'
                }
                return data
                break;

            default:
                data = {
                    class: 'text-bg-primary',
                    icon: '<i class="fa-solid fa-info-circle me-1"></i>',
                    type: 'Info'
                }
                return data
                break;
        }
    }
}







(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })




    var form = $('#form_inserir'),
    checkbox = $('#prefixado_inserir'),
    divpercent_cdi = $('#divpercent_cdi'),
    divtaxa_aa = $('#divtaxa_aa');

    divpercent_cdi.show();
    divtaxa_aa.hide();

checkbox.on('click', function() {
    if($(this).is(':checked')) {
      divtaxa_aa.show();
      divtaxa_aa.find('input').attr('required', true);
      divpercent_cdi.hide();
      divpercent_cdi.find('input').attr('required', false);
    } else {
      divpercent_cdi.show();
      divpercent_cdi.find('input').attr('required', true);
      divtaxa_aa.hide();
      divtaxa_aa.find('input').attr('required', false);
    }
})

})()

