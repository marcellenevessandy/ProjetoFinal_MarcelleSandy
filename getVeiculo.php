<?php
// Incluir a conexão com o banco de dados
include_once './config/config.php';

if (isset($_GET['id'])) {
    $id_veiculo = $_GET['id'];

    // Buscar dados do veículo
    $sql = "SELECT modelo, preco FROM veiculos WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id_veiculo);
    $stmt->execute();
    
    $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Retornar os dados em formato JSON
    echo json_encode($veiculo);
}
?>
