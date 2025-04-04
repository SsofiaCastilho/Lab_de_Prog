<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "login");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuario WHERE email = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($resultado)) {
    if (password_verify($senha, $row['senha'])) {
        // Gerar um token único
        $token = bin2hex(random_bytes(32));

        // Salvar o token no banco de dados
        $updateTokenSql = "UPDATE usuario SET token = ? WHERE email = ?";
        $updateStmt = mysqli_prepare($con, $updateTokenSql);
        mysqli_stmt_bind_param($updateStmt, "ss", $token, $email);
        mysqli_stmt_execute($updateStmt);

        // Salvar o token e o usuário na sessão
        $_SESSION['usuario'] = $email;
        $_SESSION['token'] = $token;

        header("Location: login.php?msg=" . urlencode("Login feito com sucesso!"));
    } else {
        header("Location: login.php?msg=" . urlencode("Senha incorreta!"));
    }
} else {
    header("Location: login.php?msg=" . urlencode("Usuário não encontrado!"));
}

mysqli_close($con);
exit();
