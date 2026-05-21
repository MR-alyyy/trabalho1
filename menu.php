<html>
<body>
<?php
if (isset($_POST['logout']))
{    session_destroy();    header('Location: login.php');    exit; } ?>

<form method="post">
    <button name="logout">Sair</button>
    <button name="add" type="inserir">cadastro santo</button>
</form></body>
</html>

<?php
include "conexao.php";



$mensagem = "";

if (isset($_POST['inserir'])) {


$santo = trim($_POST['santo']);

$erro = false;


$stmt = $conexao->prepare("INSERT INTO menu (santo) VALUES (?)");

$stmt->bind_param("s", $santo);

if ($stmt->execute()) {
    $mensagem = "<p class='sucesso'>Cadastro realizado com sucesso!</p>";
} else {
    $mensagem = "<p class='erro'>Erro ao cadastrar: ".$stmt->error."</p>";
}

$stmt->close();

}


?>
