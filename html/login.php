<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tracktrain";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (empty($email) || empty($senha)) {
        echo "Preencha todos os campos!";
        exit();
    }

    // Prepare and execute query
    $sql = "SELECT idUsuario, nomeUsuario, tipoUsuario, Senha FROM Usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
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
            $update_stmt = $conn->prepare($update_sql);
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
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }

    $stmt->close();
}

$conn->close();
?>
