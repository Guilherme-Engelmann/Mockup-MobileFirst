<?php
session_start();
include 'html/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeUsuario = $_POST['nomeUsuario'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirm_senha = $_POST['confirm_senha'];

    // Check if passwords match
    if ($senha !== $confirm_senha) {
        header("Location: html/inscreverse.php?error=As senhas não coincidem");
        exit();
    }

    // Check if email or username already exists
    $stmt = $mysqli->prepare("SELECT idUsuario FROM Usuarios WHERE email = ? OR nomeUsuario = ?");
    $stmt->bind_param("ss", $email, $nomeUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $stmt->close();
        header("Location: html/inscreverse.php?error=Usuário ou e-mail já cadastrado");
        exit();
    }
    $stmt->close();

    // Hash the password
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $mysqli->prepare("INSERT INTO Usuarios (nomeUsuario, email, Senha, tipoUsuario) VALUES (?, ?, ?, 'Usuário')");
    $stmt->bind_param("sss", $nomeUsuario, $email, $senha_hash);
    if ($stmt->execute()) {
        $stmt->close();
        header("Location: html/index.php?message=Cadastro realizado com sucesso. Faça login.");
        exit();
    } else {
        $stmt->close();
        header("Location: html/inscreverse.php?error=Erro ao cadastrar usuário");
        exit();
    }
} else {
    header("Location: html/inscreverse.php");
    exit();
}
?>
