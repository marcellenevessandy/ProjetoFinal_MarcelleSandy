<?php
// Inicia a sessão
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver logado
    exit();
}

include_once './config/config.php'; // Conexão com o banco de dados
include_once './classes/Cliente.php'; // Inclusão da classe Cliente

// Verifica se o ID foi passado via URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: consultarCliente.php'); // Redireciona para a página de consulta se o ID não for fornecido
    exit();
}

// Cria uma instância da classe Cliente
$cliente = new Cliente($db);

// Obtém o ID do cliente a ser deletado
$id = $_GET['id'];

// Deleta o cliente
try {
    // Chama o método de deletar cliente
    $cliente->deletar($id);

    // Redireciona para a página de consulta após a exclusão
    header('Location: consultarCliente.php');
    exit();
} catch (Exception $e) {
    echo "Erro ao deletar o cliente: " . $e->getMessage(); // Exibe mensagem de erro
}
?>
