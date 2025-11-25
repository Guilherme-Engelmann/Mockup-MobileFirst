<?php


include "db.php";

session_start();


if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
    exit;
}

$msg = "";
if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    $user = trim($_POST["username"] ?? "");
    $pass = trim($_POST["senha"] ?? "");
    $stmt =$conn->prepare("SELECT pk, username, senha, cargo FROM Usuarios WHERE username=?");
    $stmt-> bind_param("s", $user);
    $stmt->execute();

    $result = $stmt->get_result();
    $dados = $result -> fetch_assoc();
    $stmt->close();

    // Suporta senhas armazenadas como hash (password_hash) e também senhas legadas em texto puro
    $login_ok = false;
    if($dados){
        $stored = $dados['senha'];
        if(password_verify($pass, $stored)){
            $login_ok = true;
        } elseif($pass === $stored){
            // Senha em texto puro - aceitar e atualizar para hash
            $login_ok = true;
            $newHash = password_hash($pass, PASSWORD_DEFAULT);
            $upd = $conn->prepare("UPDATE Usuarios SET senha=? WHERE pk=?");
            if($upd){
                $upd->bind_param("si", $newHash, $dados['pk']);
                $upd->execute();
                $upd->close();
            }
        }
    }

    if($login_ok){
        session_regenerate_id(true);
        $_SESSION["user_pk"] = $dados["pk"];
        $_SESSION["username"] = $dados["username"];
        $_SESSION["cargo"] = $dados["cargo"];
        // aceita tanto 'func' quanto 'adm' (registro usa 'adm') ou 'admin'
        if(isset($dados["cargo"]) && $dados["cargo"] === "func"){
            header("Location: dashboard3.php");
        }else if(isset($dados["cargo"]) && ($dados["cargo"] === "adm" || $dados["cargo"] === "admin")){
            header("Location: admin_dashboard.php");
        } else {
            // fallback: enviar ao dashboard de funcionário
            header("Location: dashboard3.php");
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
        <?php if(isset($_SESSION["cargo"]) && ( $_SESSION["cargo"] === 'adm' || $_SESSION["cargo"] === 'admin')): ?>
            <form action="admin_dashboard.php" method="get">
                <button type="submit">ADM</button>
            </form>
        <?php elseif(isset($_SESSION["cargo"]) && $_SESSION["cargo"] === 'func'): ?>
            <form action="dashboard3.php" method="get">
                <button type="submit">FUNCIONÁRIO</button>
            </form>
        <?php else: ?>

            <form action="admin_dashboard.php" method="get">
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
                <p> <?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?> </p> 
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
