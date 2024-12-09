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
    <title>Editar Dados de Usuário</title>
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
                <h2 class="text-center mb-4">Editar Dados de Usuário</h2>
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                    <!-- Nome -->
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
                    </div>

                    <!-- Botão de Enviar -->
                    <button type="submit" class="btn btn-primary w-100">Atualizar Dados</button>
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
