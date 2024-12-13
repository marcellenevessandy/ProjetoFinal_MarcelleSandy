<?php
// Incluir a conexão com o banco e a classe Venda
include_once './config/config.php';
include_once './classes/Venda.php';

// Criar instância da classe Venda
$venda = new Venda($db);

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id'];
    $id_veiculo = $_POST['id_veiculo'];
    $desconto = $_POST['desconto'];
    $valor_final = $_POST['valor_total'];
    $data_venda = $_POST['data_venda'];
    

    $queryVenda = "INSERT INTO vendas (id_cliente, id_veiculo, desconto, valor_final, data_venda) VALUES ('$id_cliente', '$id_veiculo', '$desconto', '$valor_final', '$data_venda')";
    $resultVenda = mysql_query($queryVenda);
    

    if ($venda->cadastrarVenda($id_cliente, $id_veiculo, $desconto)) {
        echo "Venda cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar venda.";
    }
}

// Consultar os clientes e veículos para preencher os campos
$sql_clientes = "SELECT * FROM clientes";
$stmt_clientes = $db->prepare($sql_clientes);
$stmt_clientes->execute();

$sql_veiculos = "SELECT * FROM veiculos";
$stmt_veiculos = $db->prepare($sql_veiculos);
$stmt_veiculos->execute();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Venda</title>
    <script>
        function preencherCampos() {
            const id_veiculo = document.getElementById('id_veiculo').value;
            const id_cliente = document.getElementById('id_cliente').value;

            if (id_veiculo) {
                fetch('getVeiculo.php?id_veiculo=' + id_veiculo)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('modelo').value = data.modelo;
                        document.getElementById('preco').value = data.preco;
                        calcularTotal(); // Calcular o total ao preencher os dados do veículo
                    });
            }

            if (id_cliente) {
                fetch('getCliente.php?id_cliente=' + id_cliente)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('nome').value = data.nome;
                        document.getElementById('cpf').value = data.cpf;
                    });
            }
        }

        function calcularTotal() {
            const preco = parseFloat(document.getElementById('preco').value) || 0;
            const desconto = parseFloat(document.getElementById('desconto').value) || 0;
            const total = preco - (preco * (desconto / 100));
            document.getElementById('valor_total').value = total.toFixed(2); // Exibe o valor total com 2 casas decimais
        }
    </script>
</head>

<body>//////
    <? $queryCampos = "SELECT * FROM clientes WHERE id = 5";
        $resultCampos = mysql_query($queryCampos);
        while($camposT = mysql_fetch_array($resultCampos)){
            $nomeCliente = '';
            $nomeCliente = $camposT['nome'];
            $modelo = '';
            $nomeCliente = $camposT['nome'];
        ?>
    <h2>Cadastrar Venda</h2>
    <form method="POST">
        <label for="id_cliente">Cliente:</label>
        <select name="id_cliente" id="id_cliente" onchange="preencherCampos()">
            <option value="">Selecione um Cliente</option>
            <?php while ($cliente = $stmt_clientes->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= $cliente['id'] ?>"><?= htmlspecialchars($cliente['nome'], ENT_QUOTES, 'UTF-8') ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="nome">Nome do Cliente:</label>
        <input type="text" id="nome" disabled <?if($nomeCliente != ''){ echo $nomeCliente; }?>><br><br>

        <label for="cpf">CPF do Cliente:</label>
        <input type="text" id="cpf" disabled <?if($cpf != ''){ echo $cpf; }?>><br><br>

        <label for="id_veiculo">Veículo:</label>
        <select name="id_veiculo" id="id_veiculo" onchange="preencherCampos()">
            <option value="">Selecione um Veículo</option>
            <?php while ($veiculo = $stmt_veiculos->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?= $veiculo['id'] ?>"><?= $veiculo['modelo'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="modelo">Modelo do Veículo:</label>
        <input type="text" id="modelo" disabled <?if($modelo != ''){ echo $modelo; }?>><br><br>

        <label for="preco">Preço do Veículo:</label>
        <input type="text" id="preco" disabled><br><br>

        <label for="desconto">Desconto (%):</label>
        <input type="number" name="desconto" id="desconto" min="0" max="100" onchange="calcularTotal()"><br><br>

        <label for="valor_total">Valor Final:</label>
        <input type="text" id="valor_total" disabled><br><br>
        <?}?>

        <button type="submit">Cadastrar Venda</button>
    </form>
</body>

</html>
