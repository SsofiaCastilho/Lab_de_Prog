<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="processar_cadastro.php" method="post">
        <h1>Cadastro de Usuário</h1>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <a href="login.php" class="link-login">Já tem conta? Faça login</a>
        <button type="submit">Cadastrar</button>
    </form>
</body>

</html>

<!--
    O código acima é uma página de cadastro de usuário. Ele contém um formulário que solicita o e-mail e a senha do usuário. 
    Quando o formulário é enviado, os dados são enviados para o arquivo "processar_cadastro.php" para serem processados.
    Além disso, há um link que redireciona o usuário para a página de login caso já tenha uma conta.