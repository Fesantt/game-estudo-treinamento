<?php
session_start();

// Verificar se o usuário já está logado
if (isset($_SESSION['phone'])) {
    header("Location: game"); // Redirecionar para a página game se o usuário já estiver logado
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login e Cadastro</title>
    <style>
        form {
            margin: 20px auto;
            width: 300px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        input[type="text"], input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div id="loginForm">
        <form id="loginFormAjax">
            <h2>Login</h2>
            <input type="text" name="phone" id="loginPhone" placeholder="Telefone" required>
            <input type="password" name="password" id="loginPassword" placeholder="Senha" required>
            <input type="submit" value="Entrar">
            <p>Ainda não tem uma conta? <a href="#" onclick="showRegisterForm()">Cadastre-se</a></p>
        </form>
    </div>

    <div id="registerForm" style="display: none;">
        <form id="registerFormAjax">
            <h2>Cadastro</h2>
            <input type="text" name="phone" id="registerPhone" placeholder="Telefone" required>
            <input type="password" name="password" id="registerPassword" placeholder="Senha" required>
            <input type="submit" value="Cadastrar">
            <p>Já tem uma conta? <a href="#" onclick="showLoginForm()">Faça login</a></p>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="login.js"></script>
</body>
</html>
