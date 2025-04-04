<?php
session_start();
require 'conexao_bd.php';

$email = $_SESSION['usuario'];
$token = $_SESSION['token'];

if (!verificarToken($con, $email, $token)) {
    header("Location: login.php?msg=" . urlencode("Sessão inválida! Faça login novamente."));
    exit();
}

//adicionar restrições aqui, quando for solicitado pelo professor