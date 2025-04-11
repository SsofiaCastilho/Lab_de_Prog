<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <form action="verificar_bd.php" method="post">
        <div class="titulo">
            <h1>Faça o seu login</h1>
            <div class="barra-horizontal"></div>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div class="mensagem <?php echo strpos($_GET['msg'], 'sucesso') !== false ? 'sucesso' : 'erro'; ?>">
                <?php echo htmlspecialchars($_GET['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="input">
            <label for="email">Seu e-mail*</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="input">
            <label for="senha">Sua senha*</label>
            <input type="password" id="senha" name="senha" required>
        </div>

        <a href="cadastro.php" class="link-cadastro">Não tem conta? Cadastre-se</a>
        <button type="submit">Entrar</button>
    </form>
</body>

</html>

<!--
    O código acima é uma página de login. Ele contém um formulário que solicita o e-mail e a senha do usuário. 
    Quando o formulário é enviado, os dados são enviados para o arquivo "verificar_bd.php" para serem processados.
    Além disso, há um link que redireciona o usuário para a página de cadastro caso não tenha uma conta.