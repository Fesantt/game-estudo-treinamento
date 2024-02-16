$(document).ready(function() {
    $("#loginFormAjax").submit(function(event) {
        event.preventDefault(); 

        var formData = {
            phone: $("#loginPhone").val(),
            password: $("#loginPassword").val()
        };

        $.ajax({
            type: "POST",
            url: "login.php",
            data: formData,
            dataType: 'json', 
            success: function(response) {
                if (response.status === 'success') {
                    window.location.href = "game.php";
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

        var formData = {
            phone: $("#registerPhone").val(),
            password: $("#registerPassword").val()
        };

        $.ajax({
            type: "POST",
            url: "register.php",
            data: formData,
            success: function(response) {
                alert(response); 
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