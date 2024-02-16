<?php
include_once 'conexao.php';
session_start();

if (!isset($_SESSION['phone'])) {
    header("Location: index.php");
    exit();
}

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$phone = $_SESSION['phone'];

if (!isset($_SESSION['balance'])) {
    $_SESSION['balance'] = 0;
}

$userCelular = isset($_SESSION['phone']) ? $_SESSION['phone'] : '';

$userNumber = isset($_POST['userNumber']) ? intval($_POST['userNumber']) : 0;
$betAmount = isset($_POST['betAmount']) ? intval($_POST['betAmount']) : 0;
$turn = isset($_SESSION['turn']) ? $_SESSION['turn'] : 0;
$_SESSION['turn'] = ++$turn;

$randomNumber = rand(1, 6);

if ($_SESSION['balance'] >= $betAmount) {
    if ($randomNumber == $userNumber) { 
        $_SESSION['balance'] += $betAmount * 10;
        $message = "Ganhou R$ " . $betAmount * 10 . "!";
        $code = 1;
        $_SESSION['turn'] = 0;
    } else {
        $_SESSION['balance'] -= $betAmount;
        $message = "Você perdeu!";
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

if(isset($randomNumber)) {
    $requestId = $_POST['requestId'];
    $insertSql = "INSERT INTO jogadas (betAmount, RandomNumber, requestId, userCelular, userNumber, winAmount) VALUES (?, ?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("iissss", $betAmount, $randomNumber, $requestId, $userCelular, $userNumber, $message);
    $insertStmt->execute();
}

$conn->close();

echo json_encode(array('result' => $randomNumber, 'balance' => $_SESSION['balance'], 'message' => $message, 'code' => $code));
?>
