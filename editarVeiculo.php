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
    <link rel="shortcut icon" href="./imagens/raposa.png" type="image/x-icon">
    <title>Editar Veículo</title>
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
                <a class="navbar-brand me-auto" href="#home"><img src="./imagens/logo.png" alt="Logo" class="img-fluid"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto d-flex align-items-center"> <!-- Ajustado aqui -->
                        <li class="nav-item"><a class="nav-link fw-bold" href="consultarVeiculo.php"><button class="btn btn-warning fw-bold">VOLTAR</button></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="titulo">Editar Veículo</h2><br><br>

                <form method="POST" action="atualizarVeiculo.php">
                    <input type="hidden" name="id" value="<?php echo $veiculoData['id']; ?>">

                    <div class="row">
                        <div class="col">
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


                            <!-- Ano Modelo -->
                            <div class="mb-3">
                                <label for="ano_modelo" class="form-label">Ano do Modelo</label>
                                <input type="number" class="form-control" id="ano_modelo" name="ano_modelo" value="<?php echo $veiculoData['ano_modelo']; ?>" required>
                            </div>

                            <!-- Imagem -->
                            <div class="mb-3">
                                <label for="imagem" class="form-label">Imagem</label>
                                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" required>
                            </div>
                        </div>

                        <div class="col">

                            <!-- Preço -->
                            <div class="mb-3">
                                <label for="preco" class="form-label">Preço</label>
                                <input type="number" step="0.01" class="form-control" id="preco" name="preco" value="<?= $veiculoData['preco']; ?>" required>
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
                        </div>
                    </div>
 
                    <!-- Observação -->
                    <div class="mb-3">
                        <label for="observacao" class="form-label">Observação</label>
                        <textarea class="form-control" id="observacao" name="observacao"><?php echo $veiculoData['observacao']; ?></textarea>
                    </div><br>


                    <button type="submit" class="btn btn-warning w-100 fw-bold">Atualizar</button><br><br>
                </form>
            </div>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>