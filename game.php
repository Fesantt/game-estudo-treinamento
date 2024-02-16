<?php
include_once 'conexao.php';
session_start();

//obtem saldo do usuario
if (!isset($_SESSION['phone'])) {
    header("Location: index.php");
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
$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Game - Role o Dado</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="navbar">
        <a href="#">Página Inicial</a>
        <a href="#">Perfil</a>
        <div class="sair">
            <a href="logout.php">Sair</a>
        </div>
        <div class="saldo">
            <p id="balance">Saldo: R$
                <?php echo $_SESSION['balance'] ?>
            </p>
        </div>
    </div>
    <p id="placeholder"></p>
    <div>
        <label for="betAmount">Numero de 1 a 6</label>
    </div>
    <div class="inputs">
        <input type="number" id="betNumber" placeholder="Digite o número" min="1" max="6" step="1"
            oninput="validateNumber(this)">
    </div>
    <div>
        <label for="betAmount">Valor da Aposta</label>
    </div>
    <div class="inputs">
        <input type="number" id="betAmount" placeholder="Valor da aposta" oninput="validateAmount(this)">
    </div>
    <button id="button">Rolar dado</button>
    <p id="message"></p>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="script.js"></script>
</body>

</body>

</body>

</html>