<?php
// Inicia a sessão
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

include_once './config/config.php'; // Conexão com o banco de dados
include_once './classes/Cliente.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: consultarCliente.php');
    exit();
}

$cliente = new Cliente($db);
$id = $_GET['id'];

try {
    // Primeiro, remove as vendas relacionadas ao cliente
    $queryVendas = "DELETE FROM vendas WHERE id_cliente = :id_cliente";
    $stmtVendas = $db->prepare($queryVendas);
    $stmtVendas->bindParam(':id_cliente', $id, PDO::PARAM_INT);
    $stmtVendas->execute();

    // Depois, remove o cliente
    $cliente->deletar($id);

    header('Location: consultarCliente.php?msg=Cliente deletado com sucesso');
    exit();
} catch (Exception $e) {
    echo "Erro ao deletar o cliente: " . $e->getMessage();
}
?>
