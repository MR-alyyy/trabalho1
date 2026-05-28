<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include("conexao.php");

// Botão sair
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php"); // ✅ Corrigido: volta pro login, não pro cadastro
    exit();
}

// Cadastrar
if (isset($_POST['inserir'])) {
    $coisa = $_POST["coisa"];

    $stmt = $conexao->prepare("INSERT INTO menu (coisa) VALUES (?)"); // ✅ $conn → $conexao
    $stmt->bind_param("s", $coisa);

    if ($stmt->execute()) {
        echo "<p style='color:green'>Cadastro realizado com sucesso!</p>";
    } else {
        echo "<p style='color:red'>Erro ao cadastrar: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conexao->close(); // ✅ $conn → $conexao
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
</head>
<body>

    <h2>Cadastrar Coisa</h2>
    <br>

    <a href="menu.php?logout=1"> <!-- ✅ Corrigido: apontava pra cadastrar.php, mas o logout está aqui no menu.php -->
        <button type="button">Sair</button>
    </a>

    <br><br>

    <form method="post">
        <input type="text" name="coisa" placeholder="Digite algo" required>
        <button name="inserir" type="submit">Cadastrar</button>
    </form>

</body>
</html>
