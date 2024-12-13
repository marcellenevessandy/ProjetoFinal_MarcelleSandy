<?php
// Inicia a sessão
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver logado
    exit();
}

include_once './config/config.php';
include_once './classes/Usuario.php';

// Cria uma instância da classe Usuario
$usuario = new Usuario($db);

// Obtém todos os usuários do banco de dados
$usuarios = $usuario->listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Usuários</title>
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
        <h2 class="text-center">Lista de Usuários</h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Sexo</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo $usuario['nome']; ?></td>
                        <td><?php echo $usuario['sexo']; ?></td>
                        <td><?php echo $usuario['fone']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td>
                            <!-- Botão de Editar -->
                            <a href="editarUsuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <!-- Botão de Deletar -->
                            <a href="deletarUsuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar?');">Deletar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
