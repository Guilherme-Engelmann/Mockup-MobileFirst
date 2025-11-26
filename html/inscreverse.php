<?php

include "db.php";

session_start();

$register_msg = "";
if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])){
    $new_user = $_POST['new_username'] ?? "";
    $new_pass = $_POST['new_password'] ?? "";
    $new_func = $_POST['new_func'] ?? "";
    // Normaliza cargo para 'adm' ou 'func'
    if($new_func !== 'adm' && $new_func !== 'func') {
        $register_msg = "Cargo inválido.";
    } else if($new_user && $new_pass){
        // Verifica se username já existe
        $check = $conn->prepare("SELECT pk FROM Usuarios WHERE username=?");
        $check->bind_param("s", $new_user);
        $check->execute();
        $check->store_result();
        if($check->num_rows > 0){
            $register_msg = "Usuário já existe.";
            $check->close();
        } else {
            $check->close();
            $hash = password_hash($new_pass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO Usuarios (username, senha, cargo) VALUES (?,?,?)");
            if($stmt){
                $stmt->bind_param("sss", $new_user, $hash, $new_func);
                if($stmt->execute()) {
                    $register_msg = "Usuário cadastrado com sucesso!";
                    header("Location: index.php");
                    exit();
                }else{
                    $register_msg = "Erro ao cadastrar novo usuário: " . $stmt->error;
                }
                $stmt->close();
            }else{
                $register_msg = "Erro na preparação do cadastro.";
            }
        }
    }else{
        $register_msg = "Preencha todos os campos.";
    }
}

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Novo Usuário</title>
    <link rel="stylesheet" href="../css/inscrever.css">
</head>
<body>
    
    <form method="post">                                                                                  
        <h2>Inscrever-se</h2>
        <h3>Cadastro Novo Usuário</h3>
        <?php if($register_msg):  ?> <p> <?= $register_msg ?> </p> <?php endif; ?>
        <input type="text" name="new_username" placeholder="Novo Usuário" required>
        <input type="password" name="new_password" placeholder="Nova Senha" required>
        <select name="new_func">
            <option value="func" selected>FUNC</option>
        </select>
        <button type="submit" name="register" value="1"> Cadastrar</button>
        <br>
        <p><a href="index.php">Voltar</a></p>
    </form>
   
    
</body>
</html>
