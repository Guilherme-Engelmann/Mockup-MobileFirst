<?php
include "db.php";
session_start();

$register_msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
    $new_user = trim($_POST['new_username'] ?? "");
    $new_pass = $_POST['new_password'] ?? "";
    $new_email = trim($_POST['new_email'] ?? "");
    $new_func = $_POST['new_func'] ?? "";

    if ($new_user && $new_pass && $new_email && $new_func) {
        // Validate email
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $register_msg = "E-mail inválido.";
        } else {
            // Check if username or email already exists
            $check_stmt = $mysqli->prepare("SELECT idUsuario FROM Usuarios WHERE nomeUsuario = ? OR email = ?");
            $check_stmt->bind_param("ss", $new_user, $new_email);
            $check_stmt->execute();
            $check_stmt->store_result();
            if ($check_stmt->num_rows > 0) {
                $register_msg = "Nome de usuário ou e-mail já existe.";
            } else {
                // Hash password
                $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);

                // Map cargo
                $tipoUsuario = ($new_func === 'adm') ? 'admin' : 'funcionario';

                $stmt = $mysqli->prepare("INSERT INTO Usuarios (nomeUsuario, Senha, tipoUsuario, email) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $new_user, $hashed_pass, $tipoUsuario, $new_email);

                if ($stmt->execute()) {
                    $register_msg = "Usuário cadastrado com sucesso!";
                    // Redirect to login after success
                    header("Location: index.php?msg=" . urlencode($register_msg));
                    exit();
                } else {
                    $register_msg = "Erro ao cadastrar usuário.";
                }
                $stmt->close();
            }
            $check_stmt->close();
        }
    } else {
        $register_msg = "Preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Novo Usuário</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="phone-content">
        <div class="header">
            <a href="index.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
            <div class="icon-title">
                <i class="fas fa-user-plus header-icon"></i>
                <h2>Inscrever-se</h2>
            </div>
        </div>

        <div class="signup-bg">
            <div class="signup-content">
                <div class="signup-card">
                    <h2>Bem-vindo</h2>
                    <p>Cadastro de Novo Usuário</p>
                    <?php if ($register_msg): ?>
                        <p class="message"><?php echo htmlspecialchars($register_msg); ?></p>
                    <?php endif; ?>
                    <form method="post" id="signup-form">
                        <div class="form-group">
                            <i class="fas fa-user"></i>
                            <input type="text" name="new_username" placeholder="Nome de Usuário" required>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="new_email" placeholder="E-mail" required>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="new_password" placeholder="Senha" required>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-briefcase"></i>
                            <select name="new_func" required>
                                <option value="adm">ADM</option>
                                <option value="func" selected>FUNC</option>
                            </select>
                        </div>
                        <button type="submit" name="register" class="signup-btn">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Basic client-side validation
        document.getElementById('signup-form').addEventListener('submit', function(event) {
            const password = document.querySelector('input[name="new_password"]').value;
            if (password.length < 6) {
                alert('A senha deve ter pelo menos 6 caracteres.');
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
