<?php
include_once './config/config.php';
include_once './classes/Veiculo.php';

$veiculo = new Veiculo($db);
$veiculos = $veiculo->listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Veículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Consultar Veículos</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Placa</th>
                    <th>Modelo</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($veiculos as $veiculo): ?>
                    <tr>
                        <td><?= $veiculo['id']; ?></td>
                        <td><?= $veiculo['placa']; ?></td>
                        <td><?= $veiculo['modelo']; ?></td>
                        <td>R$ <?= number_format($veiculo['preco'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="editarVeiculo.php?id=<?= $veiculo['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="deletarVeiculo.php?id=<?= $veiculo['id']; ?>" class="btn btn-danger btn-sm">Deletar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

