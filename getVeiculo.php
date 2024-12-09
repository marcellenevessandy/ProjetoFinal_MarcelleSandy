<?php
include_once './config/config.php';

if (isset($_GET['veiculo_id'])) {
    $veiculo_id = $_GET['veiculo_id'];

    $sql = "SELECT placa, modelo, ano_modelo, valor FROM veiculos WHERE id = :veiculo_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':veiculo_id', $veiculo_id);
    $stmt->execute();

    $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($veiculo);
}
?>
