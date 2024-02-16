<?php
include_once 'conexao.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM usuarios WHERE celular = '$phone'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $response["error"] = "O telefone ja esta em uso";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (celular, senha) VALUES ('$phone', '$hashed_password')";
        if (mysqli_query($conn, $sql)) {
            $response["success"] = "Usuário registrado com sucesso";
        } else {
            $response["error"] = "Erro ao registrar usuário";
        }
    }
    echo json_encode($response);
}
?>
