<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tela de Login</title>

  <script src="validador.js"></script>

  <link rel="stylesheet" href="style.css" />

</head>
<body>

  <div class="container">
    <div class="login-box">
      <div class="avatar">
        <img src="https://i.pinimg.com/736x/cf/3c/82/cf3c827e94daede62d82c30f28f5aab2.jpg" alt="Avatar">
      </div>
      <div class="login-form">
        <h2>Login</h2>
        <div class="input-group">
          <span class="icon">📧</span>
          <input type="text" placeholder="Usuário ou e-mail" />
        </div>

        <div class="input-group">
          <span class="icon">🔒</span>
          <input type="password" placeholder="Senha..." />
        </div>

        <div class="options">
          <label><input type="checkbox" checked /> Mantenha-me Conectado</label>
          <a href="#">Esqueceu a senha?</a>
        </div>

        <button class="btn-login">Login</button>

        <p class="register">Não tem uma conta ainda? <a href="#">Inscrever-se</a></p>
      </div>
    </div>
  </div>
</body>
</html>
=======
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

    $stmt =$mysqli->prepare("SELECT pk, username, senha FROM usuarios WHERE username=? AND senha=?");
    $stmt-> bind_param("ss", $user, $pass);
    $stmt->execute();

    $result = $stmt->get_result();
    $dados = $result -> fetch_assoc();
    $stmt->close();

    if($dados){
        $_SESSION["user_pk"] = $dados["pk"];
        $_SESSION["username"] = $dados["username"];
        header("Location: index.php");
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
        <h3>Bem-vindo, <?= $_SESSION["username"] ?>!</h3>
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
>>>>>>> 0ee28495d0023a99efe46be529334c2d1c08c6d0
