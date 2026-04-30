<?php
include "conexao.php";

function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) != 11) return false;
    if (preg_match('/(\d)\1{10}/', $cpf)) return false;

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) return false;
    }

    return true;
}

$mensagem = "";

if (isset($_POST['inserir'])) {

$emailcelular = trim($_POST['emailcelularcpf']);
$senha = trim($_POST['senha']);

$erro = false;

/* VALIDAÇÃO DE SENHA */
$senhaForte = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $senha);

if (!$senhaForte) {
    $mensagem .= "<p class='erro'>A senha deve ter no mínimo 8 caracteres, com letra maiúscula, minúscula, número e símbolo.</p>";
    $erro = true;
}

/* VALIDAÇÃO EMAIL / TELEFONE / CPF */

$emailValido = filter_var($emailcelular, FILTER_VALIDATE_EMAIL);

$numeroLimpo = preg_replace('/[^0-9]/', '', $emailcelular);

$telefoneValido = preg_match('/^[0-9]{10,11}$/', $numeroLimpo);

$cpfValido = validarCPF($emailcelular);

if (!$emailValido && !$telefoneValido && !$cpfValido) {
    $mensagem .= "<p class='erro'>Digite um e-mail, telefone ou CPF válido.</p>";
    $erro = true;
}

/* SE NÃO TIVER ERROS */
if (!$erro) {

if ($cpfValido) {
    $emailcelular = password_hash($numeroLimpo, PASSWORD_DEFAULT);
}

$senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $conexao->prepare("INSERT INTO cadastro (emailcelularcpf, senha) VALUES (?, ?)");

$stmt->bind_param("ss", $emailcelular, $senhaCriptografada);

if ($stmt->execute()) {
    $mensagem = "<p class='sucesso'>Cadastro realizado com sucesso!</p>";
} else {
    $mensagem = "<p class='erro'>Erro ao cadastrar: ".$stmt->error."</p>";
}

$stmt->close();

}

}


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Cadastro</title>

<style>

body{
background:#f5ecd9;
font-family:"Times New Roman", serif;
}

.container{
width:380px;
margin:120px auto;
}

form{
background:#fffaf0;
padding:35px;
border:3px solid #5a3b1c;
box-shadow:4px 4px 10px rgba(0,0,0,0.3);
}

h2{
text-align:center;
color:#3b2a1a;
margin-bottom:25px;
}

label{
font-weight:bold;
color:#3b2a1a;
}

input{
width:100%;
padding:10px;
margin-top:5px;
margin-bottom:18px;
border:1px solid #5a3b1c;
background:#fffdf7;
font-family:"Times New Roman", serif;
}

button{
width:100%;
padding:12px;
background:#5a3b1c;
color:white;
border:none;
font-size:16px;
cursor:pointer;
}

button:hover{
background:#3b2a1a;
}

.erro{
color:#8b0000;
font-weight:bold;
text-align:center;
margin-bottom:10px;
}

.sucesso{
color:green;
font-weight:bold;
text-align:center;
margin-bottom:10px;
}

</style>

</head>

<body>

<div class="container">

<form method="post">

<h2>Registro</h2>

<?php echo $mensagem; ?>

<label>E-mail, Celular ou CPF</label>
<input name="emailcelularcpf" type="text" autocomplete="off" required>

<label>Senha</label>
<input name="senha" type="password" required>

<button type="submit" name="inserir">Cadastrar</button>

<a href="login.php">
	<button type="button">ja fez login?</button>
</a>


</form>

</div>

</body>
</html>
