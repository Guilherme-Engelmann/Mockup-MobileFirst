<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "tracktrain"; // Altere para o nome do seu banco

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$message = "";

// Recebe dados do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeUsuario = trim($_POST['nomeUsuario']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $confirm_senha = trim($_POST['confirm_senha']);

    // Validação simples
    if (empty($nomeUsuario) || empty($email) || empty($senha) || empty($confirm_senha)) {
        $message = "Preencha todos os campos!";
    } elseif ($senha !== $confirm_senha) {
        $message = "As senhas não coincidem!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "E-mail inválido!";
    } else {
        // Hash da senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Insere no banco
        $sql = "INSERT INTO Usuarios (nomeUsuario, email, Senha, tipoUsuario) VALUES (?, ?, ?, 'user')";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sss", $nomeUsuario, $email, $senha_hash);

            if ($stmt->execute()) {
                header("Location: html/tela de login2.php?message=Usuário criado com sucesso!");
                exit();
            } else {
                $message = "Erro ao criar usuário: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "Erro na preparação da consulta: " . $conn->error;
        }
    }
}

$conn->close();

// If there's an error message, redirect back with error
if (!empty($message)) {
    header("Location: html/inscreverse.php?error=" . urlencode($message));
    exit();
}
