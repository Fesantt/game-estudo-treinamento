$(document).ready(function() {
    $("#loginFormAjax").submit(function(event) {
        event.preventDefault(); 

        var phone = $("#loginPhone").val();
        var password = $("#loginPassword").val();


        if(phone === '' || password === '') {
            alert("Por favor, preencha todos os campos.");
            return;
        }

        var formData = {
            phone: phone,
            password: password
        };

        $.ajax({
            type: "POST",
            url: "login",
            data: formData,
            dataType: 'json', 
            success: function(response) {
                if (response.status === 'success') {
                    window.location.href = "game";
                } else {
                    alert("Ocorreu um erro: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert("Ocorreu um erro na requisição: " + error);
            }
        });
    });

    $("#registerFormAjax").submit(function(event) {
        event.preventDefault(); 

        var phone = $("#registerPhone").val();
        var password = $("#registerPassword").val();

        if(phone === '' || password === '') {
            alert("Por favor, preencha todos os campos.");
            return;
        }

        var formData = {
            phone: phone,
            password: password
        };

        $.ajax({
            type: "POST",
            url: "register",
            data: formData,
            dataType: 'json', 
            success: function(response) {
                if (response.success) {
                    alert(response.success); 
                    window.location.href = "index";
                } else {
                    alert("Ocorreu um erro: " + response.error);
                }
            },
            error: function(xhr, status, error) {
                alert("Ocorreu um erro na requisição: " + error);
            }
        });
    });
});

function showRegisterForm() {
    $("#loginForm").hide();
    $("#registerForm").show();
}

function showLoginForm() {
    $("#loginForm").show();
    $("#registerForm").hide();
}