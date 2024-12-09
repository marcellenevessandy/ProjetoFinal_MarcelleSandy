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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Estilo para o botão de olho */
        .eye-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .form-control {
            padding-right: 30px; /* Deixa espaço para o ícone de olho */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Login</h2>

                <?php
                if (isset($erro)) {
                    echo "<div class='alert alert-danger'>$erro</div>";
                }
                ?>

                <form method="POST">
                    <!-- E-mail -->
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
                    </div>

                    <!-- Senha -->
                    <div class="mb-3 position-relative">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
                        <i id="eye-icon" class="bi bi-eye eye-icon" onclick="togglePasswordVisibility()"></i>
                    </div>

                    <!-- Botão de Login -->
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>

            </div>
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
