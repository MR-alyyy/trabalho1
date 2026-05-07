<html>
<head><title> LOGIN </title></head>
<body>
<h1>Login</h1>
<form method="post" action="" autocomplete="off">
<label>Email:</label><br>
<input name="email" size="30" type="text"><br>
<label>Senha:</label><br>
<input name="senha" size="10" type="password"><br>
<button type="submit" name="login">Entrar</button>
</form>
<button>
<a href='cadastro.php'>Cadastro</a>

</button>

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

</body>
</html>
<?php
include 'conexao.php';
if(isset($_POST['login'])):
$email = $_POST['email'];
$senha = $_POST['senha'];
// Busca usuário pelo email
$sql = mysqli_query($conexao, "SELECT * FROM cadastro WHERE email = '$email'");
$dados = mysqli_fetch_assoc($sql);
// Verifica se encontrou e se a senha confere
if ($dados && password_verify($senha, $dados['senha'])) {
   $_SESSION['usuario'] = $dados['nome'];
   header("Location: menu.php");
} else {
   echo "<p style='color:red;'>Email ou senha inválidos!</p>";
}
endif;
?>
