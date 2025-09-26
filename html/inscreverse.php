<?php

include "db.php";

session_start();

$register_msg = "";
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])){
    $new_user = $_POST['new_username'] ?? "";
    $new_pass = $_POST['new_password'] ?? "";
    $new_func = $_POST['new_func'] ?? "";
    if($new_user && $new_pass){
        $stmt = $mysqli -> prepare("INSERT INTO usuarios (username, senha, cargo) VALUES (?,?,?)");
        $stmt -> bind_param("sss", $new_user, $new_pass,$new_func);
        
        if($stmt->execute()) {
            $register_msg = "Usuário cadastrado com sucesso!";
            header("Location: index.php");
            exit();
        }else{
            $register_msg = "Erro ao cadastrar novo usuário.";
        };

        $stmt->close();
    }else{
        $register = "Preencha todos os campos.";
    };
};

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Novo Usuário</title>
</head>
<body>
    
    <form method="post">
        <h2>Inscrever-se</h2>
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
    <p><a href="index.php">Voltar</a></p>
    
</body>
</html>
