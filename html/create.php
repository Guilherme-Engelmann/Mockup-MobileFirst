<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    if (empty($login) || empty($senha)) {
        echo "Preencha todos os campos!";
    } else {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Usuarios (username, senha) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $login, $senha_hash);
        if ($stmt->execute()) {
            echo "Usuário criado com sucesso!";
        } else {
            echo "Erro ao criar usuário: " . $conn->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body>
<form method="POST">
    <label>Login:</label>
    <input type="text" name="login" required>
    <br>
    <label>Senha:</label>
    <input type="password" name="senha" required>
    <br>
    <button type="submit">Criar Usuário</button>
</form>
</body>
</html>