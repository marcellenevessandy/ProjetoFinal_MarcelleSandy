<?php

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Cliente.php';

$cliente = new Cliente($db);

$clientes = $cliente->listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Clientes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            margin-top: 80px;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table td {
            font-size: 14px;
        }

        .table th {
            background-color: #cb640d;
            color: #fff;
            font-weight: bold;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #ddd;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }

        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }

        .actions-btn {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .actions-btn a {
            text-decoration: none;
        }

        .btn-warning {
            background-color: #cb640d;
            border-color: #cb640d;
            color: #fff;
        }

        .btn-warning:hover {
            background-color: #ff7f00;
            border-color: #ff7f00;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #c82333;
        }

        /* Responsividade */
        @media (max-width: 767px) {
            .table th, .table td {
                font-size: 12px;
                padding: 8px;
            }

            .actions-btn {
                flex-direction: column;
                gap: 5px;
            }
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
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="logout.php"><button class="btn btn-warning">SAIR</button></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container table-container">
        <h2 class="text-center mb-4">Lista de Clientes</h2>

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo $cliente['nome']; ?></td>
                        <td><?php echo $cliente['cpf']; ?></td>
                        <td><?php echo $cliente['telefone']; ?></td>
                        <td class="actions-btn">
                            <!-- Botão de Alterar -->
                            <a href="editarCliente.php?id=<?php echo $cliente['id']; ?>" class="btn btn-warning btn-sm">
                                Alterar
                            </a>
                            <!-- Botão de Excluir -->
                            <a href="deletarCliente.php?id=<?php echo $cliente['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar?');">
                                Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
