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
    // sanitize inputs
    $user = trim($_POST["username"] ?? "");
    $pass = trim($_POST["senha"] ?? "");
    $stmt =$conn->prepare("SELECT pk, username, senha, cargo FROM Usuarios WHERE username=?");
    $stmt-> bind_param("s", $user);
    $stmt->execute();

    $result = $stmt->get_result();
    $dados = $result -> fetch_assoc();
    $stmt->close();

    if($dados && password_verify($pass, $dados['senha'])){
        // prevent session fixation
        session_regenerate_id(true);
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
        <h3>Bem-vindo, <?= htmlspecialchars($_SESSION["username"], ENT_QUOTES, 'UTF-8') ?>!</h3>
        <p>Sessão Ativa</p>
        <?php if(isset($_SESSION["cargo"]) && $_SESSION["cargo"] === 'admin'): ?>
            <form action="cadastro.php" method="get">
                <button type="submit">ADM</button>
            </form>
        <?php elseif(isset($_SESSION["cargo"]) && $_SESSION["cargo"] === 'func'): ?>
            <form action="dashboard3.php" method="get">
                <button type="submit">FUNCIONÁRIO</button>
            </form>
        <?php else: ?>
            <!-- fallback: show both if cargo is unexpected -->
            <form action="cadastro.php" method="get">
                <button type="submit">ADM</button>
            </form>
             <form action="dashboard3.php" method="get">
                <button type="submit">FUNCIONÁRIO</button>
            </form>
        <?php endif; ?>
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
            <p><small>Dica: adm / 123</small></p>
        </form>
    </div>

<?php endif; ?> 
</body>
</html>
