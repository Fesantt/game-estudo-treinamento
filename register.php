<?php
include_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM usuarios WHERE celular = '$phone'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $error = "O telefone já está em uso";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (celular, senha) VALUES ('$phone', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Erro ao registrar usuário";
        }
    }
}
?>
