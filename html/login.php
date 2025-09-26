<?php
session_start();

include "db.php";

$login_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? "");
    $senha = $_POST['senha'] ?? "";

    if (empty($email) || empty($senha)) {
        $login_msg = "Preencha todos os campos!";
    } else {
        // Prepare and execute query
        $sql = "SELECT idUsuario, nomeUsuario, tipoUsuario, Senha FROM Usuarios WHERE email = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($senha, $row['Senha'])) {
                // Login successful
                $_SESSION['user_id'] = $row['idUsuario'];
                $_SESSION['user_name'] = $row['nomeUsuario'];
                $_SESSION['user_type'] = $row['tipoUsuario'];

                // Update last login
                $update_sql = "UPDATE Usuarios SET ultimoLogin = NOW() WHERE idUsuario = ?";
                $update_stmt = $mysqli->prepare($update_sql);
                $update_stmt->bind_param("i", $row['idUsuario']);
                $update_stmt->execute();
                $update_stmt->close();

                // Redirect based on user type
                if ($row['tipoUsuario'] == 'admin') {
                    header("Location: ../create.php");
                } elseif ($row['tipoUsuario'] == 'funcionario') {
                    header("Location: dashboardGeral.php");
                } else {
                    header("Location: dashboardGeral.php");
                }
                exit();
            } else {
                $login_msg = "Senha incorreta!";
            }
        } else {
            $login_msg = "Usuário não encontrado!";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="phone-content">
        <div class="header">
            <div class="icon-title">
                <i class="fas fa-sign-in-alt header-icon"></i>
                <h2>Login</h2>
            </div>
        </div>

        <div class="login-bg">
            <div class="login-content">
                <div class="login-card">
                    <h2>Entrar</h2>
                    <p>Acesse sua conta</p>
                    <?php if ($login_msg): ?>
                        <p class="message error"><?php echo htmlspecialchars($login_msg); ?></p>
                    <?php endif; ?>
                    <form method="post" id="login-form">
                        <div class="form-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="E-mail" required>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="senha" placeholder="Senha" required>
                        </div>
                        <a href="esqueceuasenha.php" class="forgot-link">Esqueceu a senha?</a>
                        <button type="submit" class="login-btn">Entrar</button>
                    </form>
                    <p class="signup-link">Não tem conta? <a href="inscreverse.php">Inscreva-se</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Basic client-side validation
        document.getElementById('login-form').addEventListener('submit', function(event) {
            const password = document.querySelector('input[name="senha"]').value;
            if (password.length < 6) {
                alert('A senha deve ter pelo menos 6 caracteres.');
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
