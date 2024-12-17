<?php
include_once './config/config.php';
include_once './classes/Venda.php';

// Criar a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Criar uma instância da classe Venda
$venda = new Venda($db);

// Verificar se o ID da venda foi passado
if (!isset($_GET['id'])) {
    header('Location: consultarVenda.php?msg=ID inválido');
    exit();
}

$id_venda = $_GET['id'];
$vendaAtual = $venda->buscarVenda($id_venda);

// Verificar se a venda foi encontrada
if (!$vendaAtual) {
    header('Location: consultarVenda.php?msg=Venda não encontrada');
    exit();
}

// Atualizar a venda
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['cliente_id'];
    $id_veiculo = $_POST['veiculo_id'];
    $desconto = $_POST['desconto'];

    if ($venda->atualizarVenda($id_venda, $id_cliente, $id_veiculo, $desconto)) {
        header('Location: consultarVenda.php?msg=Venda atualizada com sucesso');
        exit();
    } else {
        $msg = "Erro ao atualizar venda";
    }
}

// Buscar clientes e veículos
$queryClientes = "SELECT id, nome FROM clientes";
$stmtClientes = $db->prepare($queryClientes);
$stmtClientes->execute();

$queryVeiculos = "SELECT id, modelo, preco FROM veiculos";
$stmtVeiculos = $db->prepare($queryVeiculos);
$stmtVeiculos->execute();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./imagens/raposa.png" type="image/x-icon">
    <title>Editar Venda</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #cb640d;
            --background-color: #000;
            --text-color: #ffffff;
            --link-color: #cb640d;
            --border-color: #ff7f00;
            --hover-color: #f9bb64;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            padding-top: 70px;
        }

        .navbar {
            background-color: var(--background-color);
            border-bottom: 2px solid var(--border-color);
        }

        .navbar-nav .nav-link {
            color: var(--text-color);
        }

        .navbar-nav .nav-link:hover {
            color: var(--link-color);
        }

        .navbar-brand img {
            max-width: 200px;
        }

        .btn-warning {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--text-color);
        }

        .btn-warning:hover {
            background-color: var(--hover-color);
            border-color: var(--hover-color);
        }

        .eye-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .titulo {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: bold;
            display: inline-block;
            position: relative;
        }

        .titulo::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary-color);
        }

        .custom-text {
            color: gray;
            text-align: center;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark d-flex align-items-center fixed-top">
            <div class="container">
                <a class="navbar-brand me-auto" href="#home"><img src="./imagens/logo.png" alt="Logo" class="img-fluid"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto d-flex align-items-center"> <!-- Ajustado aqui -->
                        <li class="nav-item"><a class="nav-link fw-bold" href="consultarVenda.php"><button class="btn btn-warning fw-bold">VOLTAR</button></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8"><br>
                <h2 class="titulo">Editar Venda</h2><br><br><br>

                <?php if (isset($msg)) { ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
                <?php } ?>
                <form method="POST" action="editarVenda.php?id=<?= $id_venda ?>" id="vendaForm">
                    <div class="row">
                        <div class="col">

                            <!-- Cliente -->
                            <div class="mb-3">
                                <label for="cliente_id" class="form-label">Cliente</label>
                                <select class="form-select" id="cliente_id" name="cliente_id" required>
                                    <?php while ($cliente = $stmtClientes->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?= $cliente['id'] ?>" <?= $cliente['id'] == $vendaAtual['id_cliente'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cliente['nome']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Veículo -->
                            <div class="mb-3">
                                <label for="veiculo_id" class="form-label">Veículo</label>
                                <select class="form-select" id="veiculo_id" name="veiculo_id" required onchange="atualizarValor()">
                                    <?php while ($veiculo = $stmtVeiculos->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?= $veiculo['id'] ?>" data-preco="<?= $veiculo['preco'] ?>" <?= $veiculo['id'] == $vendaAtual['id_veiculo'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($veiculo['modelo']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col">

                            <!-- Valor do Veículo -->
                            <div class="mb-3">
                                <label for="preco" class="form-label">Valor do Veículo</label>
                                <input type="text" class="form-control" id="preco" name="preco" readonly>
                            </div>

                            <!-- Desconto -->
                            <div class="mb-3">
                                <label for="desconto" class="form-label">Desconto (%)</label>
                                <input type="number" class="form-control" id="desconto" name="desconto" min="0" max="100" value="<?= $vendaAtual['desconto'] ?>" required onchange="calcularValorTotal()">
                            </div>
                        </div>
                    </div>

                    <!-- Valor Total -->
                    <div class="mb-3">
                        <label for="valor_total" class="form-label">Valor Total com Desconto</label>
                        <input type="text" class="form-control" id="valor_total" name="valor_total" readonly>
                    </div><br><br>

                    <button type="submit" class="btn btn-warning w-100 fw-bold">Atualizar Venda</button><br><br>

                </form>
            </div>


        </div>
    </div>

    <script>
        function atualizarValor() {
            const veiculoSelect = document.getElementById('veiculo_id');
            const precoInput = document.getElementById('preco');
            const descontoInput = document.getElementById('desconto');
            const valorTotalInput = document.getElementById('valor_total');

            const preco = parseFloat(veiculoSelect.options[veiculoSelect.selectedIndex].dataset.preco || 0);
            precoInput.value = preco.toFixed(2);
            calcularValorTotal();
        }

        function calcularValorTotal() {
            const preco = parseFloat(document.getElementById('preco').value) || 0;
            const desconto = parseFloat(document.getElementById('desconto').value) || 0;

            const valorTotal = preco - (preco * desconto / 100);
            document.getElementById('valor_total').value = valorTotal.toFixed(2);
        }

        window.onload = () => {
            atualizarValor();
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>