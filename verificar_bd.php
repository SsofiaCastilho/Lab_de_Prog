<?php
session_start();
require 'conexao_bd.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuario WHERE email = '$email'";
$result = mysqli_query($con, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    if (password_verify($senha, $row['senha'])) {
        $token = bin2hex(random_bytes(32));
        mysqli_query($con, "UPDATE usuario SET token='$token' WHERE email='$email'");
        $_SESSION['token'] = $token;
        header("Location: home.php");
    } else {
        header("Location: login.php?msg=" . urlencode("Senha incorreta!"));
    }
} else {
    header("Location: login.php?msg=" . urlencode("Usuário não encontrado!"));
}
?>
