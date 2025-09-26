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
    $new_email = $_POST['new_email'] ?? "";
    $new_func = $_POST['new_func'] ?? "";
    if($new_user && $new_pass && $new_email){
        // Check if username or email already exists
        $check_stmt = $mysqli->prepare("SELECT pk FROM Usuarios WHERE username = ? OR email = ?");
        $check_stmt->bind_param("ss", $new_user, $new_email);
        $check_stmt->execute();
        $check_stmt->store_result();
        if ($check_stmt->num_rows > 0) {
            $register_msg = "Usuário ou e-mail já cadastrado.";
        } else {
            $stmt = $mysqli -> prepare("INSERT INTO Usuarios (username, senha, cargo, email) VALUES (?,?,?,?)");
            $stmt -> bind_param("ssss", $new_user, $new_pass,$new_func, $new_email);

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
</head>
<body>
    
    <form method="post">
        <h2>Bem-vindo, <?= $_SESSION["username"] ?>!</h2>
        <h3>Cadastro Novo Usuário</h3>
        <?php if($register_msg):  ?> <p> <?= $register_msg ?> </p> <?php endif; ?>
        <input type="text" name="new_username" placeholder="Novo Usuário" required>
        <input type="email" name="new_email" placeholder="E-mail" required>
        <input type="password" name="new_password" placeholder="Nova Senha" required>
        <select name="new_func">
            <option value="adm">ADM</option>
            <option value="func" selected>FUNC</option>
        </select>
        <button type="submit" name="register" value="1"> Cadastrar</button>
    </form>
    <p><a href="index.php">Voltar</a></p>
    
</body>
</html>
