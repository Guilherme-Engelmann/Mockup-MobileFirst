<?php

//faz a conexao
include "db.php";
//inicia a sessao
session_start();

//logout
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
    exit;
}

$msg = "";
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $user = $_POST["nomeUsuario"] ?? "";
    $pass = $_POST["Senha"] ?? "";

    $stmt =$mysqli->prepare("SELECT idUsuario, nomeUsuario, Senha FROM Usuarios WHERE nomeUsuario=? AND senha=?");
    $stmt-> bind_param("ss", $user, $pass);
    $stmt->execute();

    $result = $stmt->get_result();
    $dados = $result -> fetch_assoc();
    $stmt->close();

    if($dados){
        $_SESSION["user_id"] = $dados["id"];
        $_SESSION["nomeUsuario"] = $dados["=nomeUsuario"];
        header("Location: index.php");
        exit;

    }else{
        $msg = "Usuário ou senha incorretos!";
    }
};

?>


<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tela de Login</title>
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body>

<?php if(!empty($_SESSION["user_id"])): ?>

    <div>
        <h3>Bem-vindo, <?= $_SESSION["nomeUsuario"] ?>!</h3>
        <p>Sessão Ativa</p>
        <form action="cadastro.php" method="get">
            <button type="submit">Cadastrar novos usuários.</button>
        </form>
        <p><a href="?logout=1">Sair</a></p>
    </div>

<?php else: ?>

    <div>
        <h3>Login</h3>
        <form method="POST">

            <?php if($msg): ?> 
                <p> <?= $msg ?> </p> 
            <?php endif; ?>

            <input type="text" name="nomeUsuario" placeholder="Usuário" required>
            <br>
            <br>
            <input type="password" name="Senha" placeholder="Senha" required>
            <br>
            <br>
            <button type="submit">Entrar</button>
            <p><small>Dica: admin / 123</small></p>
        </form>
    </div>
  </div>



</body>
</html>
