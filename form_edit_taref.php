<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Tarefa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="editar_tarefa.php" method="post">
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