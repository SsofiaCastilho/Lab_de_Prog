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

    <button type="submit">Entrar</button>
  </form>
</body>

</html>