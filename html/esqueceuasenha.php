<?php
include "db.php";
session_start();

$reset_msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['reset'])) {
    $email = trim($_POST['email'] ?? "");

    if ($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $reset_msg = "E-mail inválido.";
        } else {
            // Check if email exists
            $stmt = $mysqli->prepare("SELECT pk FROM usuarios WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // For demo, just show success message. In real app, generate token and send email.
                $reset_msg = "Link de redefinição enviado para seu e-mail!";
                // Here you could: generate token, store in DB, send email with mail()
                // Example: mail($email, "Redefinição de Senha", "Clique no link: ...");
            } else {
                $reset_msg = "E-mail não encontrado.";
            }
            $stmt->close();
        }
    } else {
        $reset_msg = "Digite seu e-mail.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueceu a Senha</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="phone-content">
        <div class="header">
            <a href="index.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
            <div class="icon-title">
                <i class="fas fa-key header-icon"></i>
                <h2>Esqueceu a Senha</h2>
            </div>
        </div>

        <div class="forgot-bg">
            <div class="forgot-content">
                <div class="forgot-card">
                    <h2>Esqueceu a Senha?</h2>
                    <p>Digite seu e-mail para receber um link de redefinição de senha.</p>
                    <?php if ($reset_msg): ?>
                        <p class="message"><?php echo htmlspecialchars($reset_msg); ?></p>
                    <?php endif; ?>
                    <form method="post" id="reset-form">
                        <div class="form-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="Digite seu e-mail" required>
                        </div>
                        <button type="submit" name="reset" class="reset-btn">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Optional: Add any client-side enhancements if needed
    </script>
</body>
</html>
