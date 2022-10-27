$(document).ready(function () {

    $('form').submit(function (e) {

        e.preventDefault();

        $('input').removeClass('is-invalid');
        $('.text-danger').remove();
        $('#error-alert').remove();

        var formData = {
            name: $('#name').val(),
            surname: $('#surname').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            confirm_password: $('#confirm_password').val(),
        }

        $.ajax({
            url: 'processing.php',
            type: 'POST',
            datatype: 'json',
            data: formData,
        }).done(function (response) {
            var data = JSON.parse(response);
            Object.keys(data.fields).forEach(function (field) {
                $(`input[id="${field}"]`)
                    .addClass('is-invalid')
                    .after('<label class="text-danger">' + data.fields[`${field}`] + '</label>');
            });
            if (data.is_correct_input) {
                if (data.is_new_user) {
                    $('form')
                        .addClass("d-none")
                        .before('<div class="alert alert-success">' + 'Success sing up!' + '</div>');
                } else {
                    $('form')
                        .before('<div id="error-alert" class="alert alert-danger">' + 'User with this email already singed up!' + '</div>');
                }
            }
        });
    });
});
