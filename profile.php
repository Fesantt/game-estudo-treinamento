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

$sql_saldo = "SELECT saldo FROM usuarios WHERE celular = ?";
$stmt_saldo = $conn->prepare($sql_saldo);
$stmt_saldo->bind_param("s", $phone);
$stmt_saldo->execute();
$result_saldo = $stmt_saldo->get_result();

if ($result_saldo->num_rows > 0) {
    $row_saldo = $result_saldo->fetch_assoc();
    $_SESSION['balance'] = $row_saldo['saldo'];
} else {
    $_SESSION['balance'] = 0;
}

$sql_jogadas = "SELECT * FROM jogadas WHERE userCelular = ?";
$stmt_jogadas = $conn->prepare($sql_jogadas);
$stmt_jogadas->bind_param("s", $phone);
$stmt_jogadas->execute();
$result_jogadas = $stmt_jogadas->get_result();

$jogadas = array();

if ($result_jogadas->num_rows > 0) {
    while ($row_jogadas = $result_jogadas->fetch_assoc()) {
        $jogadas[] = $row_jogadas;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Perfil</title>
</head>

<body>
    <div class="navbar1">
        <a href="game">Página Inicial</a>
        <a href="#">Perfil</a>
        <div class="sair">
            <a href="logout">Sair</a>
        </div>
        <div class="saldo">
            <p id="balance">Saldo: R$
                <?php echo $_SESSION['balance'] ?>
            </p>
        </div>
    </div>
    <div class="mt-5">
        <h1>Histórico de Jogadas</h1>
        <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Jogada</th>
                        <th scope="col">Aposta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jogadas as $jogada): ?>
                        <tr>
                            <td><?= $jogada['requestId'] ?></td>
                            <td><?= 'R$ ' . $jogada['betAmount'] . ',00' ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($jogadas)): ?>
                        <tr>
                            <td colspan="3">
                                <p>Nenhuma jogada realizada</p>
                                <p>Faça uma jogada agora!</p>
                                <a href="game">Jogar</a>
                                <p>ou</p>
                                <a href="profile">Ver Perfil</a>
                                <p>para ver o saldo atual</p>
                                <p>e o histórico de jogadas</p> 
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>