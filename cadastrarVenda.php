<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Venda</title>
</head>
<body>
    <form method="POST" action="cadastrarVenda.php">
        <label>Cliente:</label>
        <select name="cliente_id" id="cliente_id" onchange="preencherCliente(this.value)">
            <option value="">Selecione um cliente</option>
            <!-- Exemplo de opções de clientes -->
            <option value="1">Marcelle Sandy</option>
            <option value="2">Outro Cliente</option>
        </select>
        <input type="text" id="cpf" name="cpf" placeholder="CPF" readonly>
        <input type="email" id="email" name="email" placeholder="E-mail" readonly>
        <input type="text" id="fone" name="fone" placeholder="Fone" readonly>

        <label>Veículo:</label>
        <select name="veiculo_id" id="veiculo_id" onchange="preencherVeiculo(this.value)">
            <option value="">Selecione um veículo</option>
            <!-- Exemplo de opções de veículos -->
            <option value="1">Veículo 1</option>
            <option value="2">Veículo 2</option>
        </select>
        <input type="text" id="placa" name="placa" placeholder="Placa" readonly>
        <input type="text" id="modelo" name="modelo" placeholder="Modelo" readonly>
        <input type="text" id="valor_veiculo" name="valor_veiculo" placeholder="Valor" readonly>

        <label>Desconto:</label>
        <input type="number" name="desconto" id="desconto" step="0.01" onchange="calcularValorTotal()">
        
        <label>Forma de pagamento:</label>
        <select name="forma_pagamento">
            <option value="Dinheiro">Dinheiro</option>
            <option value="Cartão">Cartão</option>
            <option value="Financiamento">Financiamento</option>
        </select>
        
        <label>Valor Total:</label>
        <input type="number" name="valor_total" id="valor_total" readonly>

        <button type="submit">Cadastrar Venda</button>
    </form>

    <!-- Coloque o código JavaScript aqui -->
    <script>
        // Função para preencher os dados do cliente
        function preencherCliente(clienteId) {
            if (clienteId) {
                fetch(`getClienteData.php?id=${clienteId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('cpf').value = data.cpf;
                        document.getElementById('email').value = data.email;
                        document.getElementById('fone').value = data.fone;
                    })
                    .catch(error => console.error('Erro ao buscar dados do cliente:', error));
            } else {
                limparCamposCliente();
            }
        }

        // Função para limpar os campos do cliente
        function limparCamposCliente() {
            document.getElementById('cpf').value = '';
            document.getElementById('email').value = '';
            document.getElementById('fone').value = '';
        }

        // Função para preencher os dados do veículo
        function preencherVeiculo(veiculoId) {
            if (veiculoId) {
                fetch(`getVeiculoData.php?id=${veiculoId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('placa').value = data.placa;
                        document.getElementById('modelo').value = data.modelo;
                        document.getElementById('valor_veiculo').value = data.valor;
                        calcularValorTotal(); // Atualiza o valor total após preencher o valor do veículo
                    })
                    .catch(error => console.error('Erro ao buscar dados do veículo:', error));
            } else {
                limparCamposVeiculo();
            }
        }

        // Função para limpar os campos do veículo
        function limparCamposVeiculo() {
            document.getElementById('placa').value = '';
            document.getElementById('modelo').value = '';
            document.getElementById('valor_veiculo').value = '';
            document.getElementById('valor_total').value = '';
        }

        // Função para calcular o valor total
        function calcularValorTotal() {
            const valorVeiculo = parseFloat(document.getElementById('valor_veiculo').value) || 0;
            const desconto = parseFloat(document.getElementById('desconto').value) || 0;
            const valorTotal = valorVeiculo - desconto;

            document.getElementById('valor_total').value = valorTotal.toFixed(2);
        }
    </script>
</body>
</html>
