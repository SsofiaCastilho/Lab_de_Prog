<?php
$con = mysqli_connect("localhost", "root", "", "login");

if (!$con) {
    die("Erro na conexão: " . mysqli_connect_error());
}
?>

<!-- faz a conexão com o banco de dados e é chamada em verificar_bd.php, validar_token.php e processar_cadastro.php -->