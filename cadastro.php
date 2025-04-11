<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="processar_cadastro.php" method="post">
        <h2>Cadastro</h2>
        <label for="email">E-mail:</label>
        <input type="email" name="email" required>
        
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>

        <button type="submit">Cadastrar</button>
    </form>
    <a href="login.php">Já tem conta? Faça login</a>
</body>
</html>
