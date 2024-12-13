<?php
// Incluir a conexão com o banco de dados
include_once './config/config.php';

if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];

    // Buscar dados do cliente
    $sql = "SELECT nome, cpf FROM clientes WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id_cliente);
    $stmt->execute();
    
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Retornar os dados em formato JSON
    echo json_encode($cliente);
}
?>
