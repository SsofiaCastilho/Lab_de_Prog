<?php
$con = mysqli_connect("localhost", "root", "", "login");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = "sofiacastilho@gmail.com";
$senha = "123456";
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuario (email, senha) VALUES ('$email', '$senha_hash')";

if (mysqli_query($con, $sql)) {
    echo "Usuário inserido com sucesso!";
} else {
    echo "Erro: " . mysqli_error($con);
}

mysqli_close($con);
