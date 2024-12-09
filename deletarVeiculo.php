<?php
// Inicia a sessão
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver logado
    exit();
}

include_once './config/config.php';
include_once './classes/Veiculo.php'; // Inclui a classe Veiculo

// Verifica se o ID do veículo foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Cria uma instância da classe Veiculo
    $veiculo = new Veiculo($db);

    try {
        // Chama o método de exclusão passando o ID do veículo
        $veiculo->deletar($id);
        
        // Redireciona para a página de consulta de veículos com uma mensagem de sucesso
        header('Location: consultarVeiculo.php?msg=Veículo excluído com sucesso!');
        exit();
    } catch (Exception $e) {
        // Se ocorrer algum erro, exibe a mensagem de erro
        echo "Erro: " . $e->getMessage();
    }
} else {
    // Caso o ID não tenha sido passado, redireciona de volta para a lista de veículos
    header('Location: consultarVeiculo.php');
    exit();
}
?>

