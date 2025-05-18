<?php
$servidor = getenv('DB_HOST') ?: 'localhost';
$usuario = getenv('DB_USER') ?: 'root';
$senha = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_NAME') ?: 'login';

$con = mysqli_connect($servidor, $usuario, $senha, $dbname);

if (!$con) {
    die("Erro na conexão: " . mysqli_connect_error());
}
?>

<!-- faz a conexão com o banco de dados e é chamada em verificar_bd.php, validar_token.php e processar_cadastro.php -->