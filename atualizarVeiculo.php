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
        $ano_fabricado = $_POST['ano_fabricado'];
        $ano_modelo = $_POST['ano_modelo'];
        $marca = $_POST['marca'];
        $cor = $_POST['cor'];
        $tipo = $_POST['tipo'];
        $combustivel = $_POST['combustivel'];
        $chassi = $_POST['chassi'];
        $renavan = $_POST['renavan'];
        $observacao = $_POST['observacao'];
        $status = $_POST['status'];
        $preco = $_POST['preco'];

        // Chame o método de atualização
        $veiculo->atualizar($id, $placa, $modelo, $ano_fabricado, $ano_modelo, $marca, $cor, $tipo, $combustivel, $chassi, $renavan, $observacao, $status, $preco);

        echo "Veículo atualizado com sucesso!";
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>
