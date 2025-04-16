<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Criar Tarefa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="criar_tarefa.php" method="post">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required></textarea>

        <label for="prazo">Prazo:</label>
        <input type="datetime-local" id="prazo" name="prazo" required>

        <label for="prioridade">Prioridade:</label>
        <select id="prioridade" name="prioridade">
            <option value="1">Baixa</option>
            <option value="2">Média</option>
            <option value="3">Alta</option>
        </select>

        <button type="submit">Criar Tarefa</button>
    </form>
</body>

</html>