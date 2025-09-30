
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
    $pass = $_POST["senha"] ?? "";

    $stmt =$mysqli->prepare("SELECT pk, nomeUsuario, Senha, tipoUsuario FROM Usuarios WHERE nomeUsuario=?");
    $stmt-> bind_param("s", $user);
    $stmt->execute();

    $result = $stmt->get_result();
    $dados = $result -> fetch_assoc();
    $stmt->close();

    if($dados && password_verify($pass, $dados["Senha"])){
        $_SESSION["user_pk"] = $dados["pk"];
        $_SESSION["nomeUsuario"] = $dados["nomeUsuario"];
        $_SESSION["tipoUsuario"] = $dados["tipoUsuario"];
        if($dados["tipoUsuario"] == "funcionario"){
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
</head>
<body>

<?php if(!empty($_SESSION["user_pk"])): ?>

    <div>
        <h3>Bem-vindo, <?= $_SESSION["nomeUsuario"] ?>!</h3>
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

            <input type="text" name="nomeUsuario" placeholder="Usuário" required>
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
