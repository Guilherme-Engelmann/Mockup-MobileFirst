<?php
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header("Location: html/tela de login2.php");
    exit();
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tracktrain";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];

    // Validação simples
    if (empty($nome) || empty($email) || empty($senha) || empty($tipo)) {
        echo "Preencha todos os campos!";
    } else {
        // Hash da senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Insere no banco
        $sql = "INSERT INTO Usuarios (nomeUsuario, email, Senha, tipoUsuario, ultimoLogin) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nome, $email, $senha_hash, $tipo);

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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Funcionário - Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="phone-content">
        <div class="header">
            <i id="logoutBtn" class="fas fa-sign-out-alt back-icon"></i>
            <div class="icon-title">
                <i class="fas fa-user-plus header-icon"></i>
                <h2>Cadastrar Funcionário</h2>
            </div>
        </div>

        <div class="login-box">
            <form class="login-form" method="POST">
                <h2>Cadastrar Novo Usuário</h2>

                <div class="input-group">
                    <span class="icon">👤</span>
                    <input type="text" name="nome" placeholder="Nome completo" required />
                </div>

                <div class="input-group">
                    <span class="icon">📧</span>
                    <input type="email" name="email" placeholder="E-mail" required />
                </div>

                <div class="input-group">
                    <span class="icon">🔒</span>
                    <input type="password" name="senha" placeholder="Senha" required />
                </div>

                <div class="input-group">
                    <span class="icon">🏷️</span>
                    <select name="tipo" required>
                        <option value="">Selecione o tipo</option>
                        <option value="funcionario">Funcionário</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn-login">Cadastrar</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('logoutBtn').addEventListener('click', () => {
            window.location.href = "html/logout.php";
        });
    </script>
</body>
</html>