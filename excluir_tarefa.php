<?php
require 'validar_token.php';
require 'conexao_bd.php';

if (isset($_GET['id'])) {
    $tarefa_id = intval($_GET['id']); // Garante que o ID seja um número inteiro.
    $usuario_id = $_SESSION['usuario_id']; // Obtém o ID do usuário logado.

    // Verifica se a tarefa pertence ao usuário logado antes de excluir.
    $sql = "DELETE FROM tarefas WHERE id = ? AND usuario_id = ?";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $tarefa_id, $usuario_id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: home.php?msg=" . urlencode("Tarefa excluída com sucesso!"));
        } else {
            header("Location: home.php?msg=" . urlencode("Erro ao excluir a tarefa."));
        }
    } else {
        header("Location: home.php?msg=" . urlencode("Erro ao preparar a consulta."));
    }
} else {
    header("Location: home.php?msg=" . urlencode("Tarefa inválida."));
}
exit();
