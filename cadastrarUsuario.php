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
    <title>Registro de Usuário</title>
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
                <h2 class="text-center mb-4">Registro de Usuário</h2>
                <form method="POST">
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
                
                    <!-- Senha -->
                    <div class="mb-3 position-relative">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Crie uma senha segura" required>
                        <i id="eye-icon" class="bi bi-eye eye-icon" onclick="togglePasswordVisibility('senha')"></i>
                        <small class="form-text text-muted">A senha deve conter pelo menos 8 caracteres, incluindo letras, números e caracteres especiais.</small>
                    </div>

                    <!-- Confirmar Senha -->
                    <div class="mb-3 position-relative">
                        <label for="senha_confirmacao" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" id="senha_confirmacao" name="senha_confirmacao" placeholder="Confirme a senha" required>
                        <i id="eye-icon-confirm" class="bi bi-eye eye-icon" onclick="togglePasswordVisibility('senha_confirmacao')"></i>
                    </div>

                    <!-- Botão de Enviar -->
                    <button type="submit" class="btn btn-primary w-100">Registrar</button>
                </form>
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
