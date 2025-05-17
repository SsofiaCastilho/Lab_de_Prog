<?php
header('Content-Type: application/json');
require_once 'conexao_bd.php';

try {
    $db = new Database();
    $connection = $db->getConnection();
    
    if ($connection->ping()) {
        echo json_encode(['connected' => true]);
    } else {
        echo json_encode(['connected' => false, 'error' => 'Connection lost']);
    }
} catch (Exception $e) {
    echo json_encode(['connected' => false, 'error' => $e->getMessage()]);
}
?>
