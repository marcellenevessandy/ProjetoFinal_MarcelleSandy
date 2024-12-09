<?php
include_once './config/config.php'; // Certifique-se de que este arquivo está configurado corretamente

if (isset($_GET['cliente_id'])) {
    $cliente_id = intval($_GET['cliente_id']); // Garante que o ID seja um número inteiro

    // Query para buscar os dados do cliente
    $sql = "SELECT nome, cpf, email, fone FROM clientes WHERE id = :cliente_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
    $stmt->execute();

    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        echo json_encode($cliente); // Retorna os dados como JSON
    } else {
        echo json_encode(['error' => 'Cliente não encontrado']); // Mensagem de erro
    }
} else {
    echo json_encode(['error' => 'ID do cliente não fornecido']); // Caso o ID não seja passado
}
?>
