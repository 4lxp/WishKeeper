$(document).ready(function() {

    $('.signup_form').validate({
        rules: {
            first_name: {
                required: true,
                maxlength: 20
            },
            last_name: {
                required: true,
                maxlength: 20
            },
            username_signup: {
                required: true,
                maxlength: 15
            },
            password_signup: {
                required: true,
                maxlength: 30
            },
            password_confirm_signup: {
                required: true,
                equalTo: ".password_signup"
            }
        }
    });

    $('.login_form').validate({
        rules: {
            username_login: {
                required: true
            },
            password_login: {
                required: true
                    /*minlength: 5*/
            }
        }
    });

    $('.signup_form').on('submit', function(e) {
        if ($(this).valid()) {

            var signup_form_data = $('.signup_form').serializeArray();

            var first_name = signup_form_data[0].value;
            var last_name = signup_form_data[1].value;
            var username_signup = signup_form_data[2].value;
            var password_signup = signup_form_data[3].value;

            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "Signup.php",
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    username_signup: username_signup,
                    password_signup: password_signup
                },
                success: function(data) {
                    console.log(data); //restituisce eventuali errori, username gia presente, ad esempio, deve essere visualizzato
                    location.reload();
                }
            });
        }
    });

    $('.login_form').on('submit', function(e) {
        if ($(this).valid()) {

            var login_form_data = $('.login_form').serializeArray();

            var username_login = login_form_data[0].value;
            var password_login = login_form_data[1].value;

            console.log(password_login);

            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "Login.php",
                data: {
                    username_login: username_login,
                    password_login: password_login
                },
                success: function(data) {
                    console.log(data); //restituisce eventuali errori, username gia presente, ad esempio, deve essere visualizzato
                    if (data == true) {
                        window.location.href = "Home.php";
                    }
                }
            });
        }
    });

    $("#modal_signup_button").click(function() {

      var inst = $('[data-remodal-id=modal_signup]').remodal();

      inst.open();
    });

    $("#modal_login_button").click(function() {

      var inst = $('[data-remodal-id=modal_login]').remodal();

      inst.open();
    });
});
