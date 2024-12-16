<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Veiculo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            // Verificação do tipo MIME da imagem
            $fileType = mime_content_type($_FILES['imagem']['tmp_name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception("O arquivo enviado não é uma imagem válida.");
            }

            // Definindo diretório de upload
            $uploadDir = 'uploads/';
            $fileName = basename($_FILES['imagem']['name']);
            $filePath = $uploadDir . uniqid() . '_' . $fileName;

            // Verifica se o diretório de upload existe
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Move o arquivo para o diretório de uploads
            if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $filePath)) {
                throw new Exception("Falha ao mover o arquivo de imagem.");
            }

            // Sanitizando as entradas
            $placa = htmlspecialchars($_POST['placa']);
            $modelo = htmlspecialchars($_POST['modelo']);
            $ano_modelo = (int) $_POST['ano_modelo'];
            $marca = htmlspecialchars($_POST['marca']);
            $cor = htmlspecialchars($_POST['cor']);
            $observacao = htmlspecialchars($_POST['observacao']);
            $status = $_POST['status'];
            $preco = (float) $_POST['preco'];

            // Criando objeto Veiculo e cadastrando no banco de dados
            $veiculo = new Veiculo($db);
            $veiculo->cadastrar($placa, $modelo, $ano_modelo, $marca, $cor, $observacao, $status, $preco, $filePath);

            // Mensagem de sucesso
            echo '<div class="alert alert-success" role="alert">Veículo cadastrado com sucesso!</div>';

            // Redireciona para portal.php
            header('Location: portal.php');
            exit();
        } else {
            throw new Exception("Nenhuma imagem foi enviada ou ocorreu um erro no upload.");
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">Erro: ' . $e->getMessage() . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./imagens/raposa.png" type="image/x-icon">
    <title>Cadastrar Veículos</title>
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
                <h2 class="titulo">Cadastro de Veículo</h2><br><br>

                <form method="POST" enctype="multipart/form-data">


                    <div class="row">
                        <div class="col">
                            <!-- Placa -->
                            <div class="mb-3">
                                <label for="placa" class="form-label">Placa</label>
                                <input type="text" class="form-control" id="placa" name="placa" placeholder="Digite a placa" required>
                            </div>

                            <!-- Modelo -->
                            <div class="mb-3">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Digite o modelo" required>
                            </div>

                            <!--Ano Modelo -->
                            <div class="mb-3">
                                <label for="ano_modelo" class="form-label">Ano do Modelo</label>
                                <input type="text" class="form-control" id="modelo" name="ano_modelo" placeholder="Digite o ano modelo" required>
                            </div>

                            <!-- Imagem -->
                            <div class="mb-3">
                                <label for="imagem" class="form-label">Imagem</label>
                                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" required>
                            </div>
                        </div>

                        <div class="col">
                            <!-- Preço -->
                            <div class="mb-3">
                                <label for="preco" class="form-label">Preço</label>
                                <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
                            </div>

                            <!-- Marca -->
                            <div class="mb-3">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" class="form-control" id="marca" name="marca" placeholder="Digite a marca" required>
                            </div>

                            <!-- Cor -->
                            <div class="mb-3">
                                <label for="cor" class="form-label">Cor</label>
                                <input type="text" class="form-control" id="cor" name="cor" placeholder="Digite a cor" required>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Selecione o status</option>
                                    <option value="disponivel">Disponível</option>
                                    <option value="reservado">Reservado</option>
                                    <option value="manutencao">Em Manutenção</option>
                                    <option value="vendido">Vendido</option>
                                </select>
                            </div>
                        </div>

                        <!-- Observação -->
                        <div class="mb-3">
                            <label for="observacao" class="form-label">Observação</label>
                            <textarea class="form-control" id="observacao" name="observacao" rows="3" placeholder="Digite uma observação"></textarea>

                        </div>
                        <br><br>
                    </div><br>

                    <button type="submit" class="btn btn-warning w-100 fw-bold">Cadastrar</button><br><br>





                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>