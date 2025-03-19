<?php

$con = mysqli_connect("localhost", "root", "", "login");

$email = 'sofiacastilho@gmail.com';
$senha = '123456';

$email = 'tatiane@gmail.com';
$senha = '12345';

$sql = "INSERT INTO usuario (email, senha) VALUES ('$email', '$senha')";

$resultado = mysqli_query($con, $sql);


/*if ($row = mysqli_fetch_assoc($resultado)) {
    // Verifica a senha usando password_verify
    if (password_verify($senha, $row['senha'])) {
        $_SESSION['usuario'] = $email;
        header("Location: index.html?msg=" . urlencode("Login feito com sucesso!"));
    } else {
        header("Location: index.html?msg=" . urlencode("Senha incorreta!"));
    }
} else {
    header("Location: index.html?msg=" . urlencode("Usuário não encontrado!"));
}*/

mysqli_close($con);
