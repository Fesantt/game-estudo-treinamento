<?php
include_once 'conexao.php';
session_start();

if (!isset($_SESSION['phone'])) {
    header("Location: index");
    exit();
}

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$phone = $_SESSION['phone'];
$sql = "SELECT saldo FROM usuarios WHERE celular = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['balance'] = $row['saldo'];
} else {
    $_SESSION['balance'] = 0;
}

$userNumber = isset($_POST['userNumber']) ? intval($_POST['userNumber']) : 0;
$betAmount = isset($_POST['betAmount']) ? intval($_POST['betAmount']) : 0;
$turn = isset($_SESSION['turn']) ? $_SESSION['turn'] : 0;
$_SESSION['turn'] = ++$turn;

if ($_SESSION['balance'] >= $betAmount) {
    if ($turn == 50) {
        $randomNumber = $userNumber;
    } else {
        $randomNumber = rand(1, 6);
    }

    if (($turn >= 3 && $turn <= 30) && ($randomNumber == $userNumber)) { 
        $_SESSION['balance'] += $betAmount * 10;
        $message = "Parabéns! Você ganhou " . $betAmount * 10 . "!";
        $code = 1;
    } else {
        $_SESSION['balance'] -= $betAmount;
        $message = "Tente novamente!";
        $code = 0;
    }
} else {
    $message = "Saldo insuficiente para realizar a aposta.";
    $randomNumber = null;
    $code = -1;
}

$updateSql = "UPDATE usuarios SET saldo = ? WHERE celular = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("is", $_SESSION['balance'], $phone);
$updateStmt->execute();

// Reinicie a contagem de turnos se o usuário ganhou
if ($code === 1) {
    $_SESSION['turn'] = 0;
}

$conn->close();

echo json_encode(array('result' => $randomNumber, 'balance' => $_SESSION['balance'], 'message' => $message, 'code' => $code));
?>
