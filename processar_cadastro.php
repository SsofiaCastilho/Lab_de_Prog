<?php
require 'conexao_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario (email, senha) VALUES ('$email', '$senha')";
    
    if (mysqli_query($con, $sql)) {
        header("Location: login.php?msg=" . urlencode("Cadastro realizado com sucesso!"));
    } else {
        header("Location: cadastro.php?msg=" . urlencode("Erro ao cadastrar!"));
    }
}
?>
