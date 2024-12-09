<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redireciona para login se não estiver logado
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="login-button">
        <a href="cadastrarUsuario.php"><button>Cadastrar Colaborador</button></a>
        <a href="consultarUsuario.php"><button>Consultar Colaborador</button></a>
        <a href="cadastrarCliente.php"><button>Cadastrar Cliente</button></a>
        <a href="consultarCliente.php"><button>Consultar Cliente</button></a>
        <a href="./cadastrarVeiculo.php"><button>Cadastrar Veiculo</button></a>
        <a href="./consultarVeiculo.php"><button>Consultar Veiculo</button></a>
        <a href="./cadastrarVenda.php"><button>Cadastrar Venda</button></a>
        <a href="./consultarVenda.php"><button>Consultar Venda</button></a>
    </div>
</body>

</html>