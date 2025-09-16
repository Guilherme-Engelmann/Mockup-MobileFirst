<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tracktrain";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['login']);
    $senha = trim($_POST['senha']);

    if (empty($login) || empty($senha)) {
        $message = "Preencha todos os campos!";
    } else {
        $sql = "SELECT senha FROM usuarios WHERE login = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($senha_hash);
                $stmt->fetch();

                if (password_verify($senha, $senha_hash)) {
                    $_SESSION['login'] = $login;
                    header("Location: html/dashboard3.php");
                    exit();
                } else {
                    $message = "Senha incorreta!";
                }
            } else {
                $message = "Usuário não encontrado!";
            }

            $stmt->close();
        } else {
            $message = "Erro na preparação da consulta: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required>
        <br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
