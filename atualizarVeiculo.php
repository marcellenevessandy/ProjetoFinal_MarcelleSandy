<?php
include_once './config/config.php';
include_once './classes/Veiculo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $veiculo = new Veiculo($db);

        // Pegue os dados do formulário, incluindo o campo "preco"
        $id = $_POST['id'];
        $placa = $_POST['placa'];
        $modelo = $_POST['modelo'];
        $ano_modelo = $_POST['ano_modelo'];
        $marca = $_POST['marca'];
        $cor = $_POST['cor'];
        $observacao = $_POST['observacao'];
        $status = $_POST['status'];
        $preco = $_POST['preco'];

        // Chame o método de atualização
        $veiculo->atualizar($id, $placa, $modelo, $ano_modelo, $marca, $cor, $observacao, $status, $preco);

        echo "Veículo atualizado com sucesso!";
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>
