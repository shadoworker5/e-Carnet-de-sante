const valide_form = () => {
    // var forms = document.querySelector('.needs-validation')
    var forms = document.getElementsByTagName('form');

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
}
valide_form();