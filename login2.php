<?php
session_start();

if (isset($_SESSION['cadastro'])) {
    header("Location: menu.php");
    exit();
}

include 'conexao.php';
$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $senha = $_POST["senha"] ?? "";

    $email_seg = mysqli_real_escape_string($conexao, $email);
    $sql = mysqli_query($conexao, "SELECT * FROM cadastro WHERE email = '$email_seg'");
    $cadastro = mysqli_fetch_assoc($sql);

    if ($cadastro && password_verify($senha, $cadastro['senha'])) {
        $_SESSION['usuario'] = $cadastro['email'];
        $_SESSION['nome']    = $cadastro['email']; // troque por 'nome' se tiver a coluna
        header("Location: menu.php");
        exit();
    } else {
        $erro = "Email ou senha incorretos.";
    }
}
?>
<html>
<head><title> LOGIN </title></head>
<body>
<h1>Login</h1>
<form method="post" action="" autocomplete="off">
<label>Email:</label><br>
<input name="email" size="30" type="text"><br>
<label>Senha:</label><br>
<input name="senha" size="30" type="password"><br>
<button type="submit" name="login">Entrar</button>
</form>
<button>
<a href='cadastro.php'>Cadastro</a>
</button>
</body>
</html>
<?php
