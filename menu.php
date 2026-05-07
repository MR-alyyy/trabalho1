<html>
<body>
<?php
if (isset($_POST['logout']))
{    session_destroy();    header('Location: login.php');    exit; } ?>

<form method="post">
    <button name="logout">Sair</button>
</form></body>
</html>
