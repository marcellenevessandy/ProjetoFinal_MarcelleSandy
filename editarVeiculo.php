<?php
// editarVeiculo.php - Exibe o formulário para editar os dados do veículo

include_once './config/config.php';
include_once './classes/Veiculo.php';

// Obtemos o id do veículo a ser editado
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    // Caso não haja id, redirecionamos para a página de consulta
    header('Location: consultarVeiculo.php');
    exit();
}

// Instanciamos a classe Veiculo
$veiculo = new Veiculo($db);

// Buscamos as informações do veículo
$veiculoData = $veiculo->buscarPorId($id);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Veículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Editar Veículo</h2>

        <form method="POST" action="atualizarVeiculo.php">
            <input type="hidden" name="id" value="<?php echo $veiculoData['id']; ?>">

            <!-- Placa -->
            <div class="mb-3">
                <label for="placa" class="form-label">Placa</label>
                <input type="text" class="form-control" id="placa" name="placa" value="<?php echo $veiculoData['placa']; ?>" required>
            </div>

            <!-- Modelo -->
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo $veiculoData['modelo']; ?>" required>
            </div>

            <!-- Preço -->
            <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="number" step="0.01" class="form-control" id="preco" name="preco" value="<?= $veiculoData['preco']; ?>" required>
            </div>

            <!-- Ano Fabricado -->
            <div class="mb-3">
                <label for="ano_fabricado" class="form-label">Ano de Fabricação</label>
                <input type="number" class="form-control" id="ano_fabricado" name="ano_fabricado" value="<?php echo $veiculoData['ano_fabricado']; ?>" required>
            </div>

            <!-- Ano Modelo -->
            <div class="mb-3">
                <label for="ano_modelo" class="form-label">Ano do Modelo</label>
                <input type="number" class="form-control" id="ano_modelo" name="ano_modelo" value="<?php echo $veiculoData['ano_modelo']; ?>" required>
            </div>

            <!-- Marca -->
            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $veiculoData['marca']; ?>" required>
            </div>

            <!-- Cor -->
            <div class="mb-3">
                <label for="cor" class="form-label">Cor</label>
                <input type="text" class="form-control" id="cor" name="cor" value="<?php echo $veiculoData['cor']; ?>" required>
            </div>

            <!-- Tipo -->
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $veiculoData['tipo']; ?>" required>
            </div>

            <!-- Combustível -->
            <div class="mb-3">
                <label for="combustivel" class="form-label">Combustível</label>
                <input type="text" class="form-control" id="combustivel" name="combustivel" value="<?php echo $veiculoData['combustivel']; ?>" required>
            </div>

            <!-- Chassi -->
            <div class="mb-3">
                <label for="chassi" class="form-label">Chassi</label>
                <input type="text" class="form-control" id="chassi" name="chassi" value="<?php echo $veiculoData['chassi']; ?>" required>
            </div>

            <!-- RENAVAN -->
            <div class="mb-3">
                <label for="renavan" class="form-label">RENAVAN</label>
                <input type="text" class="form-control" id="renavan" name="renavan" value="<?php echo $veiculoData['renavan']; ?>" required>
            </div>

            <!-- Observação -->
            <div class="mb-3">
                <label for="observacao" class="form-label">Observação</label>
                <textarea class="form-control" id="observacao" name="observacao"><?php echo $veiculoData['observacao']; ?></textarea>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="disponivel" <?php echo $veiculoData['status'] == 'disponivel' ? 'selected' : ''; ?>>Disponível</option>
                    <option value="vendido" <?php echo $veiculoData['status'] == 'vendido' ? 'selected' : ''; ?>>Vendido</option>
                    <option value="reservado" <?php echo $veiculoData['status'] == 'reservado' ? 'selected' : ''; ?>>Reservado</option>
                    <option value="manutencao" <?php echo $veiculoData['status'] == 'manutencao' ? 'selected' : ''; ?>>Em Manutenção</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
