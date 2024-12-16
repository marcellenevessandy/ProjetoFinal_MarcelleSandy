<?php
include_once './config/config.php';
include_once './classes/Venda.php';

// Criar a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Criar uma instância da classe Venda
$venda = new Venda($db);

// Verificar se o ID foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Tentar deletar a venda
    if ($venda->deletarVenda($id)) {
        header('Location: consultarVenda.php?msg=Venda deletada com sucesso');
        exit();
    } else {
        header('Location: consultarVenda.php?msg=Erro ao deletar venda');
        exit();
    }
} else {
    header('Location: consultarVenda.php?msg=ID inválido');
    exit();
}
