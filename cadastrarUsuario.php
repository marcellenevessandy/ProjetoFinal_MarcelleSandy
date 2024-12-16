<?php
session_start();

include_once './config/config.php';
include_once './classes/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($db);

    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senha_confirmacao = $_POST['senha_confirmacao'];

    // Validar senha (mínimo 8 caracteres, incluindo letras, números e caracteres especiais)
    if (strlen($senha) < 8) {
        echo "A senha deve ter no mínimo 8 caracteres.";
        exit();
    }

    if (!preg_match('/[A-Za-z]/', $senha)) {
        echo "A senha deve conter pelo menos uma letra.";
        exit();
    }

    if (!preg_match('/[0-9]/', $senha)) {
        echo "A senha deve conter pelo menos um número.";
        exit();
    }

    if (!preg_match('/[\W_]/', $senha)) {
        echo "A senha deve conter pelo menos um caractere especial (ex: !@#$%^&*).";
        exit();
    }

    // Validar confirmação da senha
    if ($senha !== $senha_confirmacao) {
        echo "As senhas não coincidem.";
        exit();
    }

    // Registrar usuário
    $usuario->register($nome, $sexo, $fone, $email, $senha);
    header('Location: portal.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./imagens/raposa.png" type="image/x-icon">
    <title>Cadastrar Usuários</title>
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
                <h2 class="titulo">Cadastrar Usuário</h2><br><br>
                <form method="POST">

                    <div class="row">
                        <div class="col">
                            <!-- Nome -->
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required>
                            </div>
                            <!-- Sexo -->
                            <div class="mb-3">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select class="form-select" id="sexo" name="sexo" required>
                                    <option value="">Selecione</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Feminino">Feminino</option>
                                </select>
                            </div>

                        </div>

                        <div class="col">

                            <!-- Telefone -->
                            <div class="mb-3">
                                <label for="fone" class="form-label">Telefone</label>
                                <input type="text" class="form-control" id="fone" name="fone" placeholder="(XX) XXXXX-XXXX" required>
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
                            </div>


                        </div>

                    </div>

                    <!-- Senha -->
                    <div class="mb-3 position-relative">
                        <label for="senha" class="form-label">Senha</label>
                        <i id="eye-icon" class="bi bi-eye eye-icon" onclick="togglePasswordVisibility('senha')"></i>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Crie uma senha segura" required>
                        <i id="eye-icon" class="bi bi-eye eye-icon" onclick="togglePasswordVisibility('senha')"></i>
                        <small class="form-text custom-text">
                            A senha deve conter pelo menos 8 caracteres, incluindo letras, números e caracteres especiais.
                        </small>
                    </div>

                    <!-- Confirmar Senha -->
                    <div class="mb-3 position-relative">
                        <label for="senha_confirmacao" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" id="senha_confirmacao" name="senha_confirmacao" placeholder="Confirme a senha" required>
                        <i id="eye-icon-confirm" class="bi bi-eye eye-icon" onclick="togglePasswordVisibility('senha_confirmacao')"></i>
                    </div>
                    <br>
                    <!-- Botão de Enviar -->
                    <button type="submit" class="btn btn-warning w-100 fw-bold">Registrar</button>
                </form><br><br> 
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Função para alternar a visibilidade da senha
        function togglePasswordVisibility(id) {
            const passwordField = document.getElementById(id);
            const eyeIcon = document.getElementById('eye-icon' + (id === 'senha' ? '' : '-confirm'));

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>

</html>