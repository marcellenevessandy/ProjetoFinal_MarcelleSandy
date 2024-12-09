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
            $ano_fabricado = (int) $_POST['ano_fabricado'];
            $ano_modelo = (int) $_POST['ano_modelo'];
            $marca = htmlspecialchars($_POST['marca']);
            $cor = htmlspecialchars($_POST['cor']);
            $tipo = htmlspecialchars($_POST['tipo']);
            $combustivel = htmlspecialchars($_POST['combustivel']);
            $chassi = htmlspecialchars($_POST['chassi']);
            $renavan = htmlspecialchars($_POST['renavan']);
            $observacao = htmlspecialchars($_POST['observacao']);
            $status = $_POST['status'];
            $preco = (float) $_POST['preco'];

            // Criando objeto Veiculo e cadastrando no banco de dados
            $veiculo = new Veiculo($db);
            $veiculo->cadastrar($placa, $modelo, $ano_fabricado, $ano_modelo, $marca, $cor, $tipo, $combustivel, $chassi, $renavan, $observacao, $status, $preco, $filePath);

            echo '<div class="alert alert-success" role="alert">Veículo cadastrado com sucesso!</div>';
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
    <title>Cadastro de Veículo</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Cadastro de Veículo</h2>

        <form method="POST" action="cadastrarVeiculo.php" enctype="multipart/form-data">
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

            <!-- Preço -->
            <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
            </div>

            <!-- Ano Fabricado -->
            <div class="mb-3">
                <label for="ano_fabricado" class="form-label">Ano Fabricado</label>
                <input type="number" class="form-control" id="ano_fabricado" name="ano_fabricado" placeholder="Digite o ano de fabricação" required>
            </div>

            <!-- Ano Modelo -->
            <div class="mb-3">
                <label for="ano_modelo" class="form-label">Ano Modelo</label>
                <input type="number" class="form-control" id="ano_modelo" name="ano_modelo" placeholder="Digite o ano do modelo" required>
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

            <!-- Tipo -->
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Digite o tipo" required>
            </div>

            <!-- Combustível -->
            <div class="mb-3">
                <label for="combustivel" class="form-label">Combustível</label>
                <input type="text" class="form-control" id="combustivel" name="combustivel" placeholder="Digite o tipo de combustível" required>
            </div>

            <!-- Chassi -->
            <div class="mb-3">
                <label for="chassi" class="form-label">Chassi</label>
                <input type="text" class="form-control" id="chassi" name="chassi" placeholder="Digite o chassi" required>
            </div>

            <!-- Renavan -->
            <div class="mb-3">
                <label for="renavan" class="form-label">Renavan</label>
                <input type="text" class="form-control" id="renavan" name="renavan" placeholder="Digite o Renavan" required>
            </div>

            <!-- Imagem -->
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem</label>
                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" required>
            </div>

            <!-- Observação -->
            <div class="mb-3">
                <label for="observacao" class="form-label">Observação</label>
                <textarea class="form-control" id="observacao" name="observacao" rows="3" placeholder="Digite uma observação"></textarea>
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

            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
