<?php
session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tracktrain";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['username']); // matches form input name
    $senha = trim($_POST['password']);

    // Validação simples
    if (empty($login) || empty($senha)) {
        $message = "Preencha todos os campos!";
        header("Location: html/index.php?error=" . urlencode($message));
        exit();
    } else {
        // Busca usuário por nomeUsuario ou email
        $sql = "SELECT Senha FROM Usuarios WHERE nomeUsuario = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ss", $login, $login);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($senha_hash);
                $stmt->fetch();

                if (password_verify($senha, $senha_hash)) {
                    // Login sucesso
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $login;
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
            $message = "Erro na consulta: " . $conn->error;
        }

        if (!empty($message)) {
            header("Location: html/index.php?error=" . urlencode($message));
            exit();
        }
    }
}

$conn->close();
?>
