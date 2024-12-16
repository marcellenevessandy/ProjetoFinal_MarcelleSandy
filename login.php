<?php
session_start();

// Verificar se o usuário já está logado
if (isset($_SESSION['usuario_id'])) {
    header('Location: portal.php'); // Redireciona para o portal caso já esteja logado
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once './config/config.php';
    include_once './classes/Usuario.php';

    $usuario = new Usuario($db);

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Tentar fazer o login
    $usuarioLogado = $usuario->login($email, $senha);

    if ($usuarioLogado) {
        // Armazenar dados do usuário na sessão
        $_SESSION['usuario_id'] = $usuarioLogado['id'];
        $_SESSION['usuario_nome'] = $usuarioLogado['nome'];

        header('Location: portal.php');
        exit();
    } else {
        $erro = "Email ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="./imagens/raposa.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .btn-custom {
            background-color: var(--primary-color);
            color: #fff;
            font-weight: bold;
            border-radius: 15px;
            width: 100%;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: transform 0.3s, background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: var(--text-color);
            color: #000;
            transform: scale(1.05);
        }

        .container-login {
            max-width: 400px;
            margin: 0 auto;
            padding: 50px;
            margin-top: 100px;
            background-color: var(--hover-color);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: var(--primary-color);
            font-weight: bold;
            text-align: center;
        }

        .eye-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            color: #000;
        }

        .form-control {
            padding-right: 30px;
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

        .textoSobre2 {
            font-weight: bold;
            color: #000;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark d-flex align-items-center fixed-top">
        <div class="container">
            <a class="navbar-brand me-auto" href="./"><img src="./imagens/logo.png" alt="Logo" class="img-fluid"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto d-flex align-items-center">
                    <li class="nav-item"><a class="nav-link fw-bold" href="index.php"><button class="btn btn-warning fw-bold">VOLTAR</button></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="container-login">
            <h2>Login</h2>

            <?php
            if (isset($erro)) {
                echo "<div class='alert alert-danger'>$erro</div>";
            }
            ?>

            <form method="POST">
                <!-- E-mail -->
                <div class="mb-3">
                    <label for="email" class="form-label textoSobre2">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
                </div>

                <!-- Senha -->
                <div class="mb-3 position-relative">
                    <label for="senha" class="form-label textoSobre2">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
                    <i id="eye-icon" class="bi bi-eye eye-icon" onclick="togglePasswordVisibility()"></i>
                </div>

                <!-- Botão de Login -->
                <button type="submit" class="btn btn-custom w-100">Entrar</button>

                <!-- Botão "Esqueci minha senha" -->
                <div class="text-center mt-3">
                    <a href="esqueciSenha.php" class="btn btn-link textoSobre2">Esqueci minha senha</a>
                </div>

            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Função para alternar a visibilidade da senha
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('senha');
            const eyeIcon = document.getElementById('eye-icon');

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