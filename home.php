<?php
session_start();
require 'validar_token.php';
require 'conexao_bd.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php?msg=" . urlencode("Você precisa estar logado."));
    exit();
}

$usuario_id = $_SESSION['usuario_id']; //Obtém o ID do usuário logado.
$sql = "SELECT * FROM tarefas WHERE usuario_id = '$usuario_id' ORDER BY prazo ASC";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Organiza-me</title>
</head>

<body>
    <h1>Bem-vindo ao sistema protegido!</h1>
    <p>Seu login foi realizado com sucesso.</p>

    <h2>Suas Tarefas</h2>
    <a href="form_tarefa.php">Criar Nova Tarefa</a>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <li>
                <strong><?php echo htmlspecialchars($row['titulo']); ?></strong> -
                <?php echo htmlspecialchars($row['descricao']); ?>
                (<?php echo htmlspecialchars($row['prazo']); ?>)
                <a href="editar_tarefa.php?id=<?php echo $row['id']; ?>">Editar</a>
                <a href="excluir_tarefa.php?id=<?php echo $row['id']; ?>">Excluir</a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>

</html>

<!-- página pós login sucedido