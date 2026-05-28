<?php
// cadastrar.php
session_start();

// Redireciona para login se não estiver logado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include("conexao.php");

// Botão sair
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Cadastrar
if (isset($_POST['inserir'])) {
    $coisa = $_POST["coisa"];

    $stmt = $conn->prepare("INSERT INTO menu (coisa) VALUES (?)");
    $stmt->bind_param("s", $coisa);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro ao cadastrar.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>

    <h2>Cadastrar Coisa</h2>
    <br>

    <a href="cadastrar.php?logout=1">
        <button type="button">Sair</button>
    </a>

    <br><br>

    <form method="post">
        <input type="text" name="coisa" placeholder="Digite algo" required>
        <button name="inserir" type="submit">Cadastrar</button>
    </form>

</body>
</html>
