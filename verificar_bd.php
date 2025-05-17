<?php
session_start();
require 'conexao_bd.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuario WHERE email = '$email'";
$result = mysqli_query($con, $sql);

if ($row = mysqli_fetch_assoc($result)) { //Se o email existir no banco de dados, os dados do usuário são armazenados na variável $row.
    if (password_verify($senha, $row['senha'])) {
        $token = bin2hex(random_bytes(32)); //Gera um token único e seguro para identificar a sessão do usuário.
        mysqli_query($con, "UPDATE usuario SET token='$token' WHERE email='$email'");
        $_SESSION['token'] = $token;
        $_SESSION['usuario_id'] = $row['id'];
        header("Location: home.php");
    } else {
        header("Location: login.php?msg=" . urlencode("Senha incorreta!"));
    }
} else {
    header("Location: login.php?msg=" . urlencode("Usuário não encontrado!"));
}
?>

<!--É responsável por processar o login do usuário. Ele verifica as credenciais fornecidas (email e senha) com os dados armazenados no banco de dados.