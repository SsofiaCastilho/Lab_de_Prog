<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "login");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuario WHERE email = '$email'";
$resultado = mysqli_query($con, $sql);

if ($row = mysqli_fetch_assoc($resultado)) {
    if (password_verify($senha, $row['senha'])) {
        $_SESSION['usuario'] = $email;
        header("Location: index.php?msg=" . urlencode("Login feito com sucesso!"));
    } else {
        header("Location: index.php?msg=" . urlencode("Senha incorreta!"));
    }
} else {
    header("Location: index.php?msg=" . urlencode("Usuário não encontrado!"));
}

mysqli_close($con);
exit();
