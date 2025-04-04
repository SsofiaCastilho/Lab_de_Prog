<?php
$con = mysqli_connect("localhost", "root", "", "login");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

function verificarToken($con, $email, $token)
{
    $sql = "SELECT token FROM usuario WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultado)) {
        return hash_equals($row['token'], $token);
    }
    return false;
}
