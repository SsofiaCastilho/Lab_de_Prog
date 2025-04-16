<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'conexao_bd.php';

if (!isset($_SESSION['token'])) {
    header("Location: login.php?msg=" . urlencode("Você precisa estar logado."));
    exit();
}

$token = $_SESSION['token'];
$sql = "SELECT * FROM usuario WHERE token = '$token'";
$result = mysqli_query($con, $sql);

if (!mysqli_fetch_assoc($result)) {
    session_destroy();
    header("Location: login.php?msg=" . urlencode("Sessão inválida. Faça login novamente."));
    exit();
}
?>

<!--Esse código é usado para proteger páginas que só podem ser acessadas por usuários autenticados. Ele é incluído no início de arquivos protegidos, como home.php, para garantir que apenas usuários com um token válido possam acessar essas páginas.