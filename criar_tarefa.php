<?php
require 'validar_token.php';
require 'conexao_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $prazo = $_POST['prazo'];
    $prioridade = $_POST['prioridade'];
    $usuario_id = $_SESSION['usuario_id']; //Assumindo que o ID do usuário está salvo na sessão.

    $sql = "INSERT INTO tarefas (titulo, descricao, prazo, prioridade, usuario_id, criado_em, atualizado_em) 
            VALUES ('$titulo', '$descricao', '$prazo', '$prioridade', '$usuario_id', NOW(), NOW())";

    if (mysqli_query($con, $sql)) {
        header("Location: home.php?msg=" . urlencode("Tarefa criada com sucesso!"));
    } else {
        header("Location: home.php?msg=" . urlencode("Erro ao criar tarefa."));
    }
    exit();
}
