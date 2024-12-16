<?php
include_once './config/config.php';
include_once './classes/Venda.php';

// Criar a conexão com o banco de dados
$database = new Database();
$db = $database->getConnection();

// Criar uma instância da classe Venda
$venda = new Venda($db);

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST['cliente_id'];
    $id_veiculo = $_POST['veiculo_id'];
    $desconto = $_POST['desconto'];

    // Cadastrar a venda
    if ($venda->cadastrar($id_cliente, $id_veiculo, $desconto)) {
        echo "Venda cadastrada com sucesso!";
        
        // Redirecionar para a página portal.php
        header('Location: portal.php');
        exit();
    } else {
        echo "Erro ao cadastrar venda.";
    }
}

// Buscar os veículos disponíveis
$queryVeiculos = "SELECT id, modelo, preco FROM veiculos WHERE status = 'disponível'";
$stmtVeiculos = $db->prepare($queryVeiculos);
$stmtVeiculos->execute();

// Buscar os clientes
$queryClientes = "SELECT id, nome, cpf FROM clientes";
$stmtClientes = $db->prepare($queryClientes);
$stmtClientes->execute();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./imagens/raposa.png" type="image/x-icon">
    <title>Cadastrar Venda</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            width: 100%;
        }


        .btn-warning:hover {
            background-color: var(--hover-color);
            border-color: var(--hover-color);
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
    </style>
</head>

<body>

    
<header>
        <nav class="navbar navbar-expand-lg navbar-dark d-flex align-items-center fixed-top">
            <div class="container">
                <a class="navbar-brand me-auto" href="portal.php"><img src="./imagens/logo.png" alt="Logo" class="img-fluid"></a>
                <!-- Botão de alternância (hambúrguer) para dispositivos móveis -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Menu Navbar (vai ser colapsado no mobile e expandido no desktop) -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Opções de navegação para o desktop (visível em telas grandes) -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center d-none d-lg-flex">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Cadastrar
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="cadastrarUsuario.php">Novo Usuário</a></li>
                                <li><a class="dropdown-item" href="cadastrarCliente.php">Novo Cliente</a></li>
                                <li><a class="dropdown-item" href="cadastrarVeiculo.php">Novo Veículo</a></li>
                                <li><a class="dropdown-item" href="cadastrarVenda.php">Nova Venda</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Consultar
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="consultarUsuario.php">Consultar Usuários</a></li>
                                <li><a class="dropdown-item" href="consultarCliente.php">Consultar Clientes</a></li>
                                <li><a class="dropdown-item" href="consultarVeiculo.php">Consultar Veículos</a></li>
                                <li><a class="dropdown-item" href="consultarVenda.php">Consultar Venda</a></li>
                            </ul>
                        </li>

                        <!-- Sair -->
                        <li class="nav-item"><a class="nav-link fw-bold" href="logout.php"><button class="btn btn-warning fw-bold">SAIR</button></a></li>
                    </ul>

                    <!-- Opções de navegação para o mobile (visível apenas em telas pequenas) -->
                    <ul class="navbar-nav ms-auto d-flex flex-column d-lg-none">
                        <li><a class="dropdown-item" href="cadastrarUsuario.php">Novo Usuário</a></li>
                        <li><a class="dropdown-item" href="cadastrarCliente.php">Novo Cliente</a></li>
                        <li><a class="dropdown-item" href="cadastrarVeiculo.php">Novo Veículo</a></li>
                        <li><a class="dropdown-item" href="cadastrarVenda.php">Novo Venda</a></li>
                        <li><a class="dropdown-item" href="consultarUsuario.php">Consultar Usuários</a></li>
                        <li><a class="dropdown-item" href="consultarCliente.php">Consultar Clientes</a></li>
                        <li><a class="dropdown-item" href="consultarVeiculo.php">Consultar Veículos</a></li>
                        <li><a class="dropdown-item" href="consultarVendas.php">Consultar Vendas</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="logout.php"><button class="btn btn-warning fw-bold">SAIR</button></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="titulo">Cadastrar Venda</h2><br><br>

                <form method="POST" action="cadastrarVenda.php" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col">
                            <!-- Cliente -->
                            <div class="mb-3">
                                <label class="form-label" for="cliente">Selecione o Cliente</label><br>
                                <select class="form-select" name="cliente_id" id="cliente" required onchange="preencherCPF()">
                                    <option value="" disabled selected>Selecione um cliente</option>
                                    <?php while ($cliente = $stmtClientes->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?= $cliente['id'] ?>" data-cpf="<?= $cliente['cpf'] ?>">
                                            <?= $cliente['nome'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- CPF do Cliente -->
                            <div class="mb-3">
                                <label class="form-label" for="cpf">CPF do Cliente</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" readonly>
                            </div>

                            <!-- Veículo -->
                            <div class="mb-3">
                                <label class="form-label" for="veiculo">Veículo:</label>
                                <select class="form-select" name="veiculo_id" id="veiculo" required onchange="preencherVeiculo()">
                                    <option value="" disabled selected>Selecione um veículo</option>
                                    <?php while ($veiculo = $stmtVeiculos->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?= $veiculo['id'] ?>" data-preco="<?= number_format($veiculo['preco'], 2, '.', '') ?>">
                                            <?= $veiculo['modelo'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>

                        <div class="col">
                            <!-- Preço -->
                            <div class="mb-3">
                                <label for="preco" class="form-label">Preço</label>
                                <input type="number" step="0.01" class="form-control" id="preco" name="preco" required readonly>
                            </div>

                            <!-- Desconto -->
                            <div class="mb-3">
                                <label class="form-label" for="desconto">Desconto (%):</label>
                                <input class="form-control" type="number" id="desconto" name="desconto" min="0" max="100" value="0" onchange="calcularValorFinal()">
                            </div>

                            <!-- Valor Final -->
                            <div class="mb-3">
                                <label class="form-label" for="valor_final">Valor Final:</label>
                                <input class="form-control" type="text" id="valor_final" name="valor_final" readonly>
                            </div>
                        </div>
                    </div><br>


                    
                    <button type="submit" class="btn btn-warning w-100 fw-bold">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Preenche o campo CPF ao selecionar o cliente
        function preencherCPF() {
            const clienteSelect = document.getElementById('cliente');
            const cpfInput = document.getElementById('cpf');
            const cpf = clienteSelect.options[clienteSelect.selectedIndex]?.getAttribute('data-cpf');
            cpfInput.value = cpf || '';
        }

        // Preenche o preço ao selecionar o veículo
        function preencherVeiculo() {
            const veiculoSelect = document.getElementById('veiculo');
            const precoInput = document.getElementById('preco');
            const preco = veiculoSelect.options[veiculoSelect.selectedIndex]?.getAttribute('data-preco');
            precoInput.value = preco || 0;
            calcularValorFinal();
        }

        // Calcula o valor final com desconto
        function calcularValorFinal() {
            const preco = parseFloat(document.getElementById('preco').value) || 0;
            const desconto = parseFloat(document.getElementById('desconto').value) || 0;
            const valorFinal = preco - (preco * desconto / 100);
            document.getElementById('valor_final').value = valorFinal.toFixed(2);
        }

        // Inicializa os campos ao carregar a página
        window.onload = () => {
            preencherCPF();
            preencherVeiculo();
        };
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>