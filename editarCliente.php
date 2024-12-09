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

// Obtém os dados do cliente com o ID fornecido
$id = $_GET['id'];
$dadosCliente = $cliente->buscarPorId($id);

// Verifica se o cliente existe
if (!$dadosCliente) {
    echo "Cliente não encontrado.";
    exit();
}

// Atualiza os dados do cliente se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Coleta os dados atualizados do formulário
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

        // Chama o método de atualização do cliente
        $cliente->atualizar($id, $nome, $email, $telefone, $cpf, $data_nascimento, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado);

        echo "Cliente atualizado com sucesso!";
        // Redireciona para a página de consulta após a atualização
        header('Location: consultarCliente.php');
        exit();
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
    <title>Editar Cliente</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Editar Cliente</h2>

        <form method="POST" action="editarCliente.php?id=<?php echo $id; ?>">

            <!-- Nome -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $dadosCliente['nome']; ?>" required>
            </div>

            <!-- E-mail -->
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $dadosCliente['email']; ?>" required>
            </div>

            <!-- Telefone -->
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo $dadosCliente['telefone']; ?>" required>
            </div>

            <!-- CPF -->
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo $dadosCliente['cpf']; ?>" required>
            </div>

            <!-- Data de Nascimento -->
            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?php echo $dadosCliente['data_nascimento']; ?>" required>
            </div>

            <!-- CEP -->
            <div class="mb-3">
                <label for="cep" class="form-label">CEP</label>
                <input type="text" class="form-control" id="cep" name="cep" value="<?php echo $dadosCliente['cep']; ?>" required>
            </div>

            <!-- Endereço -->
            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <input type="text" class="form-control" id="endereco" name="endereco" value="<?php echo $dadosCliente['endereco']; ?>" required>
            </div>

            <!-- Número -->
            <div class="mb-3">
                <label for="numero" class="form-label">Número</label>
                <input type="text" class="form-control" id="numero" name="numero" value="<?php echo $dadosCliente['numero']; ?>" required>
            </div>

            <!-- Complemento -->
            <div class="mb-3">
                <label for="complemento" class="form-label">Complemento</label>
                <input type="text" class="form-control" id="complemento" name="complemento" value="<?php echo $dadosCliente['complemento']; ?>">
            </div>

            <!-- Bairro -->
            <div class="mb-3">
                <label for="bairro" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo $dadosCliente['bairro']; ?>" required>
            </div>

            <!-- Cidade -->
            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo $dadosCliente['cidade']; ?>" required>
            </div>

            <!-- Estado -->
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="<?php echo $dadosCliente['estado']; ?>" selected><?php echo $dadosCliente['estado']; ?></option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="SP">São Paulo</option>
                    <!-- Outros estados -->
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
