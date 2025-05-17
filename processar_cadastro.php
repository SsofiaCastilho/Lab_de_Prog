<?php
require 'conexao_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //Garante que o script só será executado se a requisição for do tipo POST, se o formulário de cadastro foi enviado.
    //$_SERVER serve para verificar o método de requisição, se é GET ou POST.
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario (email, senha) VALUES ('$email', '$senha')";

    if (mysqli_query($con, $sql)) {
        header("Location: login.php?msg=" . urlencode("Cadastro realizado com sucesso!"));
    } else {
        header("Location: cadastro.php?msg=" . urlencode("Erro ao cadastrar!"));
    }
}
 //tem como função principal processar o cadastro de um novo usuário no sistema. Ele recebe os dados enviados pelo formulário de cadastro, valida o método da requisição, insere os dados no banco de dados e redireciona o usuário com uma mensagem de sucesso ou erro.