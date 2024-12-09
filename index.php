<?php
// Incluindo a conexão com o banco de dados e a classe Veiculo
include_once './config/config.php';
include_once './classes/Veiculo.php';

$veiculo = new Veiculo($db);

// Inicializando variável para armazenar os resultados da busca
$resultados = [];

// Verificando se foi feita uma busca
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $resultados = $veiculo->pesquisar($search);
} else {
    // Se não houver busca, você pode pegar todos os veículos ou deixar em branco
    $resultados = $veiculo->listarTodos();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./imagens/raposa.png" type="image/x-icon">
    <title>FOXMOTORS</title>
    <!-- Link do CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Definindo as variáveis de cores no :root */
        :root {
            --primary-color: #cb640d;
            /* Laranja */
            --background-color: #000;
            /* Fundo escuro */
            --text-color: #ffffff;
            /* Texto branco */
            --link-color: #cb640d;
            /* Laranja mais suave para links */
            --border-color: #ff7f00;
            /* Laranja para bordas */
            --hover-color: #f9bb64;
            /* Laranja mais claro para hover */
        }

        /* Usando as variáveis de cor */
        body {
            background-color: var(--background-color);
            color: var(--text-color);
            padding-top: 70px;
            /* Ajuste a altura do padding para não esconder o conteúdo atrás do navbar */
        }

        /* Estilos para o navbar */
        .navbar {
            background-color: var(--background-color);
            /* Fundo preto */
            border-bottom: 2px solid var(--border-color);
            /* Linha abaixo da navbar */
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

        .border-bottom {
            border-color: var(--border-color);
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: var(--primary-color);
        }

        .card {
            margin-bottom: 20px;
            background-color: var(--primary-color);
            color: black;
            /* Texto preto */
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .btn-buy {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--text-color);
        }

        .btn-buy:hover {
            background-color: var(--hover-color);
            border-color: var(--hover-color);
        }

        /* Estilos para o título e o traço laranja */
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
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark d-flex align-items-center fixed-top">
        <div class="container">
            <a class="navbar-brand me-auto" href="./"><img src="./imagens/logo.png" alt="Logo" class="img-fluid"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto d-flex align-items-center"> <!-- Ajustado aqui -->
                    <li class="nav-item"><a class="nav-link fw-bold" href="#">SOBRE</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="#">VEÍCULOS</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="#">CONTATO</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="login.php"><button class="btn btn-warning fw-bold">LOGIN</button></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="border-bottom border-2"></div>

    <div class="container mt-5">

        <!-- Título da seção "Home" com traço laranja -->
        <h2 class="titulo">Home</h2><br><br>

        <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./imagens/CARD1.png" class="d-block w-100 rounded" alt="Imagem 1">
                </div>
                <div class="carousel-item">
                    <img src="./imagens/CARD2.png" class="d-block w-100 rounded" alt="Imagem 2">
                </div>
                <div class="carousel-item">
                    <img src="./imagens/CARD3.png" class="d-block w-100 rounded" alt="Imagem 3">
                </div>
            </div>

            <!-- Indicadores circulares -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <!-- Título da seção "Veículos" com traço laranja -->
        <h2 class="titulo">Veículos</h2><br><br>

        <div class="row">
            <?php if ($resultados): ?>
                <?php foreach ($resultados as $veiculo): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <!-- Verifique se a imagem está sendo passada corretamente -->
                            <img src="./uploads/<?= $veiculo['imagem'] ?>" alt="Imagem do veículo" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($veiculo['modelo']) ?></h5>
                                <p class="card-text"><strong>Preço:</strong> R$ <?= number_format($veiculo['preco'], 2, ',', '.') ?></p>
                                <a href="detalhes.php?id=<?= $veiculo['id'] ?>" class="btn btn-primary">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">Nenhum veículo encontrado.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

<!-- Título da seção "Quem Somos" -->
<div class="container">
        <h2 class="titulo">QUEM SOMOS?</h2>
        <p class="content-text">
            FoxMotors São Leopoldo: Uma Década de Excelência no Mercado Automotivo

            Com 10 anos de atuação no ramo de vendas automotivas, a FoxMotors São Leopoldo se consolidou como uma
            referência em qualidade, confiança e atendimento personalizado. Nosso compromisso é oferecer uma experiência
            única a cada cliente, conectando as melhores oportunidades de compra e venda de veículos em um ambiente seguro e
            eficiente.

            Ao longo da nossa trajetória, construímos uma reputação sólida, baseada na transparência e no compromisso com a
            satisfação de nossos clientes. Trabalhamos diariamente para garantir um portfólio diversificado, que atenda às
            necessidades e expectativas de quem busca qualidade e valor em cada negociação.

            Na FoxMotors São Leopoldo, acreditamos que cada cliente merece o melhor. Por isso, investimos continuamente em
            inovação, aprimoramento de nossos serviços e em uma equipe altamente qualificada, pronta para oferecer o suporte
            que você precisa.

            FoxMotors: 10 anos de história, conectando você ao veículo ideal com excelência e confiança.
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
