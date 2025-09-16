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

// Recebe dados do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST['email']); // assuming email is used as login
    $senha = trim($_POST['senha']);

    // Validação simples
    if (empty($login) || empty($senha)) {
        $message = "Preencha todos os campos!";
        header("Location: html/tela de login2.php?error=" . urlencode($message));
        exit();
    } else {
        // Busca usuário
        $sql = "SELECT senha FROM usuarios WHERE login = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($senha_hash);
                $stmt->fetch();

                if (password_verify($senha, $senha_hash)) {
                    // Login sucesso
                    $_SESSION['loggedin'] = true;
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
            $message = "Erro na consulta: " . $conn->error;
        }

        if (!empty($message)) {
            header("Location: html/tela de login2.php?error=" . urlencode($message));
            exit();
        }
    }
}

$conn->close();
?>
