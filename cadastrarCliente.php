<?php
// salvarCliente.php - Página que recebe os dados do formulário e chama a classe Cliente

include_once './config/config.php'; // Conexão com o banco
include_once './classes/Cliente.php'; // Inclusão da classe Cliente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Instanciando a classe Cliente e passando a conexão com o banco
        $cliente = new Cliente($db);

        // Coletando dados do formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $cpf = $_POST['cpf'];
        $data_nascimento = $_POST['data_nascimento'];
        $cep = $_POST['cep'];
        $endereco = $_POST['endereco'];
        $numero = $_POST['numero'];
        $complemento = $_POST['complemento'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];

        // Chama a função de cadastro
        $cliente->cadastrar($nome, $email, $telefone, $cpf, $data_nascimento, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado);

        echo "Cliente cadastrado com sucesso!"; // Mensagem de sucesso
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage(); // Mensagem de erro
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-4">Cadastro de Cliente</h2>
                <form method="POST" action="cadastrarCliente.php">
                    <!-- Nome -->
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome completo" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Digite o e-mail" required>
                    </div>

                    <!-- Telefone -->
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="(XX) XXXXX-XXXX" required>
                    </div>

                    <!-- CPF -->
                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF" required>
                    </div>

                    <!-- Data de Nascimento -->
                    <div class="mb-3">
                        <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
                    </div>

                    <!-- CEP -->
                    <div class="mb-3 d-flex">
                        <div class="me-2 flex-grow-1">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" placeholder="Digite o CEP" required>
                        </div>
                        <button type="button" id="buscarCep" class="btn btn-primary align-self-end">🔍</button>
                    </div>

                    <!-- Endereço -->
                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua, avenida, etc." required>
                    </div>

                    <!-- Bairro -->
                    <div class="mb-3">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Digite o bairro" required>
                    </div>

                    <!-- Número -->
                    <div class="mb-3">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero" placeholder="Número do imóvel" required>
                    </div>

                    <!-- Complemento -->
                    <div class="mb-3">
                        <label for="complemento" class="form-label">Complemento</label>
                        <input type="text" class="form-control" id="complemento" name="complemento" placeholder="Bloco, apartamento, etc.">
                    </div>

                    <!-- Cidade -->
                    <div class="mb-3">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Digite a cidade" required>
                    </div>

                    <!-- Estado -->
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="">Selecione o estado</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="SP">São Paulo</option>
                            <!-- Outros estados -->
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para buscar CEP -->
    <script>
        // Evento para buscar o CEP
        document.getElementById('buscarCep').addEventListener('click', function () {
            const cep = document.getElementById('cep').value.replace(/\D/g, ''); // Remove caracteres não numéricos

            if (cep.length === 8) {
                // Faz a requisição para a API ViaCEP
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.erro) {
                            alert("CEP não encontrado.");
                        } else {
                            // Preenche os campos automaticamente com os dados retornados
                            document.getElementById('endereco').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('estado').value = data.uf;
                        }
                    })
                    .catch(error => {
                        alert("Erro ao consultar o CEP. Tente novamente.");
                        console.error("Erro na requisição:", error);
                    });
            } else {
                alert("Por favor, insira um CEP válido.");
            }
        });
    </script>

</body>

</html>
