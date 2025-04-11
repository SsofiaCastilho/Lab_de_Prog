<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="verificar_bd.php" method="post">
        <h2>Login</h2>
        <label for="email">E-mail:</label>
        <input type="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>

        <button type="submit">Entrar</button>
    </form>
    <a href="cadastro.php">Não tem conta? Cadastre-se</a>
</body>
</html>
