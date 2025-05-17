<?php
require 'validar_token.php';
require 'conexao_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $tarefa_id = intval($_GET['id']);
    $usuario_id = $_SESSION['usuario_id'];

    // Busca os dados da tarefa no banco de dados.
    $sql = "SELECT * FROM tarefas WHERE id = ? AND usuario_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $tarefa_id, $usuario_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($tarefa = mysqli_fetch_assoc($result)) {
        // Exibe o formulário com os dados da tarefa.
?>
        <!DOCTYPE html>
        <html lang="pt-br">

        <head>
            <meta charset="UTF-8">
            <title>Editar Tarefa</title>
            <link rel="stylesheet" href="style.css">
        </head>

        <body>
            <h1>Editar Tarefa</h1>
            <form action="editar_tarefa.php" method="post">
                <!-- Campo oculto para enviar o ID da tarefa -->
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($tarefa['id']); ?>">

                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($tarefa['titulo']); ?>" required>

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($tarefa['descricao']); ?></textarea>

                <label for="prazo">Prazo:</label>
                <input type="datetime-local" id="prazo" name="prazo" value="<?php echo date('Y-m-d\TH:i', strtotime($tarefa['prazo'])); ?>" required>

                <label for="prioridade">Prioridade:</label>
                <select id="prioridade" name="prioridade">
                    <option value="1" <?php echo $tarefa['prioridade'] == 1 ? 'selected' : ''; ?>>Baixa</option>
                    <option value="2" <?php echo $tarefa['prioridade'] == 2 ? 'selected' : ''; ?>>Média</option>
                    <option value="3" <?php echo $tarefa['prioridade'] == 3 ? 'selected' : ''; ?>>Alta</option>
                </select>

                <button type="submit">Salvar Alterações</button>
            </form>
        </body>

        </html>
<?php
    } else {
        header("Location: home.php?msg=" . urlencode("Tarefa não encontrada ou não pertence a você."));
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $tarefa_id = intval($_POST['id']);
    $usuario_id = $_SESSION['usuario_id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $prazo = $_POST['prazo'];
    $prioridade = $_POST['prioridade'];

    // Atualiza os dados da tarefa no banco de dados.
    $sql = "UPDATE tarefas SET titulo = ?, descricao = ?, prazo = ?, prioridade = ?, atualizado_em = NOW() 
            WHERE id = ? AND usuario_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "sssiii", $titulo, $descricao, $prazo, $prioridade, $tarefa_id, $usuario_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: home.php?msg=" . urlencode("Tarefa atualizada com sucesso!"));
    } else {
        header("Location: home.php?msg=" . urlencode("Erro ao atualizar a tarefa."));
    }
    exit();
} else {
    header("Location: home.php?msg=" . urlencode("Requisição inválida."));
    exit();
}
