<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Usuario.php';

$usuario = new Usuario($db);

// Atualizar dados do usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; // Senha recebida
    $senha_confirmacao = $_POST['senha_confirmacao']; // Confirmação da senha

    // Se a senha foi alterada e as senhas coincidem, vamos atualizar a senha também
    if (!empty($senha) && $senha === $senha_confirmacao) {
        // Hash a senha para garantir segurança
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT);
        $usuario->atualizar($id, $nome, $sexo, $fone, $email, $senhaHash);
    } else {
        // Caso a senha não tenha sido alterada ou as senhas não coincidam, não atualizamos a senha
        $usuario->atualizar($id, $nome, $sexo, $fone, $email);
    }

    header('Location: portal.php');
    exit();
}

// Obter dados do usuário para edição
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $usuario->lerPorId($id);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./imagens/raposa.png" type="image/x-icon">
    <title>Editar Usuário</title>
    <!-- Link do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

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
                        <li class="nav-item"><a class="nav-link fw-bold" href="consultarUsuario.php"><button class="btn btn-warning fw-bold">VOLTAR</button></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="border-bottom border-2"></div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <h2 class="titulo">Editar Usuário</h2><br><br>
                <form method="POST">

                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" value="<?php echo htmlspecialchars($row['nome']); ?>" required>
                            </div>

                            <!-- Sexo -->
                            <div class="mb-3">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select class="form-select" id="sexo" name="sexo" required>
                                    <option value="">Selecione</option>
                                    <option value="Masculino" <?php echo ($row['sexo'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                                    <option value="Feminino" <?php echo ($row['sexo'] == 'Feminino') ? 'selected' : ''; ?>>Feminino</option>
                                </select>
                            </div>
                        </div>

                        <div class="col">
                            <!-- Telefone -->
                            <div class="mb-3">
                                <label for="fone" class="form-label">Telefone</label>
                                <input type="text" class="form-control" id="fone" name="fone" placeholder="(XX) XXXXX-XXXX" value="<?php echo htmlspecialchars($row['fone']); ?>" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                            </div>
                        </div>
                    </div>


                    <!-- Nova Senha -->
                    <div class="mb-3 position-relative">
                        <label for="senha" class="form-label">Nova Senha (opcional)</label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite uma nova senha">
                        <i id="eye-icon" class="bi bi-eye eye-icon" onclick="togglePasswordVisibility()"></i>
                    </div>

                    <!-- Confirmar Nova Senha -->
                    <div class="mb-3 position-relative">
                        <label for="senha_confirmacao" class="form-label">Confirmar Nova Senha</label>
                        <input type="password" class="form-control" id="senha_confirmacao" name="senha_confirmacao" placeholder="Confirme a nova senha">
                        <i id="eye-icon-confirm" class="bi bi-eye eye-icon" onclick="togglePasswordVisibility('confirm')"></i>
                    </div><br>

                    <!-- Botão de Enviar -->
                    <button type="submit" class="btn btn-warning w-100 fw-bold">Atualizar Dados</button><br><br>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Função para alternar a visibilidade da senha
        function togglePasswordVisibility(type = '') {
            const passwordField = type === 'confirm' ? document.getElementById('senha_confirmacao') : document.getElementById('senha');
            const eyeIcon = type === 'confirm' ? document.getElementById('eye-icon-confirm') : document.getElementById('eye-icon');

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