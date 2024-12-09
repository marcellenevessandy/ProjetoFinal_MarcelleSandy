<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Usuario.php';

$usuario = new Usuario($db);

// Verifica se o ID do usuário foi passado pela URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Chama a função de deletar (certifique-se de que a função delete está implementada na classe Usuario)
    $usuario->deletar($id);
}

// Redireciona para a página de consulta de usuários após a exclusão
header('Location: consultaUsuario.php');
exit();
?>
