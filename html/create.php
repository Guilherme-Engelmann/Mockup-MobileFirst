<?php
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "seu_banco";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

  
    if (empty($login) || empty($senha)) {
        echo "Preencha todos os campos!";
    } else {
       
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        
        $sql = "INSERT INTO usuarios (login, senha) VALUES (?, ?)";
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

$conn->close();
?>

<!-- Formulário HTML -->
<form method="POST">
    <label>Login:</label>
    <input type="text" name="login" required>
    <br>
    <label>Senha:</label>
    <input type="password" name="senha" required>
    <br>
    <button type="submit">Criar Usuário</button>
</form>