<?php
session_start();
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
