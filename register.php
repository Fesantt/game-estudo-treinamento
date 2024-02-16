<?php
include_once 'conexao.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar entrada
    $phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    if (empty($phone) || empty($password)) {
        $response["error"] = "Por favor, preencha todos os campos.";
    } elseif (!preg_match('/^\d{10,}$/', $phone)) {
        $response["error"] = "Número de telefone inválido.";
    } else {
        // Verificar se o telefone já está em uso
        $sql = "SELECT * FROM usuarios WHERE celular = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response["error"] = "O telefone já está em uso.";
        } else {
            // Inserir usuário
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (celular, senha) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $phone, $hashed_password);

            if ($stmt->execute()) {
                $response["success"] = "Usuário registrado com sucesso.";
            } else {
                $response["error"] = "Erro ao registrar usuário.";
            }
        }
    }
    echo json_encode($response);
}
?>
