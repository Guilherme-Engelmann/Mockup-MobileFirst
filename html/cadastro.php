<?php

include "db.php";

session_start();

if(empty($_SESSION["user_pk"])){
    header("Location: index.php");
    exit;
};

$register_msg = "";
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])){
    $new_user = $_POST['new_username'] ?? "";
    $new_pass = $_POST['new_password'] ?? "";
    $new_func = $_POST['new_func'] ?? "";
    if($new_user && $new_pass){
        
        $check_stmt = $conn->prepare("SELECT pk FROM Usuarios WHERE username = ?");
        $check_stmt->bind_param("s", $new_user);
        $check_stmt->execute();
        $check_stmt->store_result();
        if ($check_stmt->num_rows > 0) {
            $register_msg = "Usuário já cadastrado.";
        } else {
            $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
            $stmt = $conn -> prepare("INSERT INTO Usuarios (username, senha, cargo) VALUES (?,?,?)");
            $stmt -> bind_param("sss", $new_user, $hashed_pass,$new_func);
            
            if($stmt->execute()) {
                $register_msg = "Usuário cadastrado com sucesso!";
            }else{
                $register_msg = "Erro ao cadastrar novo usuário.";
            };

            $stmt->close();
        }
        $check_stmt->close();
    }else{
        $register_msg = "Preencha todos os campos.";
    };
};

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Novo Usuário do Sistema</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="header">
      <a href="index.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
      <div class="icon-title">
        <i class="fas fa-clipboard-list header-icon"></i>
        <h2>Cadastro de Novo Usuário</h2>
      </div>
    </div>
    <div class="dashboard-content">
      <form method="post" style="width:100%;max-width:500px;margin:0 auto;">
        <h2>Bem-vindo, <?= $_SESSION["username"] ?>!</h2>
        <h3>Cadastro Novo Usuário</h3>
        <?php if($register_msg):  ?> <p> <?= $register_msg ?> </p> <?php endif; ?>
        <input type="text" name="new_username" placeholder="Novo Usuário" required>
        <input type="password" name="new_password" placeholder="Nova Senha" required>
        <select name="new_func">
            <option value="adm">ADM</option>
            <option value="func" selected>FUNC</option>
        </select>
        <button type="submit" name="register" value="1"> Cadastrar</button>
      </form>
      <p style="text-align:center;margin-top:20px;"><a href="index.php">Voltar</a></p>
    </div>
  </div>
</body>
</html>
