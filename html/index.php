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
    $user = $_POST["username"] ?? "";
    $pass = $_POST["senha"] ?? "";

    $stmt =$mysqli->prepare("SELECT pk, username, senha, cargo FROM Usuarios WHERE username=? AND senha=?");
    $stmt-> bind_param("ss", $user, $pass);
    $stmt->execute();

    $result = $stmt->get_result();
    $dados = $result -> fetch_assoc();
    $stmt->close();

    if($dados){
        $_SESSION["user_pk"] = $dados["pk"];
        $_SESSION["username"] = $dados["username"];
        $_SESSION["cargo"] = $dados["cargo"];
        if($dados["cargo"] == "func"){
            header("Location: dashboard3.php");
        }else{
            header("Location: cadastro.php");
        }
        exit;

    }else{
        $msg = "Usuário ou senha incorretos!";
    }
};

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Simples</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>

<?php if(!empty($_SESSION["user_pk"])): ?>

    <div>
        <div class="logo-container">
            <img src="../imagens/perfil.png" alt="Logo TrackTrain" class="logo">
        </div>
        <h3>Bem-vindo, <?= $_SESSION["username"] ?>!</h3>
        <p>Sessão Ativa</p>
        <form action="cadastro.php" method="get">
            <button type="submit">ADM</button>
        </form>
         <form action="dashboard3.php" method="get">
            <button type="submit">FUNCIONÁRIO</button>
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

            <input type="text" name="username" placeholder="Usuário" required>
            <br>
            <br>
            <input type="password" name="senha" placeholder="Senha" required>
            <br>
            <br>
            <button type="submit">Entrar</button>
            <br>
            <a href="esqueceuasenha.php">Esqueceu a senha?</a>
            <br>
             <a href="inscreverse.php">Criar conta</a>
            <p><small>Dica: admin / 123</small></p>
        </form>
    </div>

<?php endif; ?> 
</body>
</html>
