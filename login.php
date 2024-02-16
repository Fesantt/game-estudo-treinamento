<?php
session_start();

// Verificar se o usuário já está logado
if (isset($_SESSION['phone'])) {
    header("Location: game"); // Redirecionar para a página game se o usuário já estiver logado
    exit();
}

include_once 'conexao.php';

$response = []; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM usuarios WHERE celular = '$phone'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['senha'])) {
                $_SESSION['phone'] = $phone;
                $response['status'] = 'success'; 
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Senha incorreta';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Usuário não encontrado';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Erro ao realizar consulta';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Método inválido de requisição';
}

echo json_encode($response);
?>
