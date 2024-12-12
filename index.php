<?php

include_once './config/config.php';
include_once './classes/Veiculo.php';

$veiculo = new Veiculo($db);

$resultados = [];

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $resultados = $veiculo->pesquisar($search);
} else {
    $resultados = $veiculo->listarDisponiveis();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./imagens/raposa.png" type="image/x-icon">
    <title>FOXMOTORS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #cb640d;
            --background-color: #000;
            --text-color: #ffffff;
            --link-color: #cb640d;
            --border-color: #ff7f00;
            --hover-color: #f9bb64;
            --azul-color: #13293e;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
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

        .border-bottom {
            border-color: var(--border-color);
        }

        .card {
            margin-bottom: 20px;
            background-color: var(--text-color);
            color: black;
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

        .titulo {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: bold;
            display: inline-block;
            position: relative;
        }

        .textoSobre {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: bold;
            position: relative;
            text-align: justify;
        }

        .textoSobre2 {
            color: var(--text-color);
            font-size: 1.5rem;
            font-weight: bold;
            position: relative;
            text-align: justify;
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

        .btn-custom {
            background-color: #ff7f00;
            color: #fff;
            font-weight: bold;
            border-radius: 15px;
            width: 100%;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: transform 0.3s, background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #f9bb64;
            transform: scale(1.05);
        }

        h2 {
            color: #ff7f00;
            font-weight: bold;
            text-transform: uppercase;
        }

        .footer {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        .footer-logo img {
            max-width: 100px;
        }

        section {
            margin: 60px 0;
            padding: 40px 20px;
        }

        .btn-custom {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: bold;
            padding: 10px 15px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            width: 100%;
            text-transform: uppercase;
        }

        .btn-custom i {
            margin-right: 8px;
            font-size: 1.2rem;
        }

        .btn-custom:hover {
            background-color: var(--hover-color);
            color: #000;
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
                        <li class="nav-item"><a class="nav-link fw-bold" href="#sobre">SOBRE</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="#veiculos">VEÍCULOS</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="#contato">CONTATO</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold" href="login.php"><button class="btn btn-warning fw-bold">LOGIN</button></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="border-bottom border-2"></div>

    <main>
        <section id="home">
            <div class="container mt-5">
                <h2 class="titulo">Home</h2><br><br>

                <div id="carouselExampleAutoplaying" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <picture>
                                <source media="(max-width: 768px)" srcset="./imagens/1.png">
                                <source media="(min-width: 769px)" srcset="./imagens/CARD1.png">
                                <img src="./imagens/CARD1.png" class="d-block w-100 rounded" alt="Imagem 1">
                            </picture>
                        </div>
                        <div class="carousel-item">
                            <picture>
                                <source media="(max-width: 768px)" srcset="./imagens/2.png">
                                <source media="(min-width: 769px)" srcset="./imagens/CARD2.png">
                                <img src="./imagens/CARD2.png" class="d-block w-100 rounded" alt="Imagem 2">
                            </picture>
                        </div>
                        <div class="carousel-item">
                            <picture>
                                <source media="(max-width: 768px)" srcset="./imagens/3.png">
                                <source media="(min-width: 769px)" srcset="./imagens/CARD3.png">
                                <img src="./imagens/CARD3.png" class="d-block w-100 rounded" alt="Imagem 3">
                            </picture>
                        </div>
                    </div>

                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                </div>
            </div>
        </section>


        <section id="veiculos">

            <div class="container mt-5">

                <h2 class="titulo">Veículos</h2><br><br>

                <div class="row">
                    <?php if ($resultados): ?>
                        <?php foreach ($resultados as $veiculo): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">


                                    <img src="<?= $veiculo['imagem'] ?>" alt="Imagem do veículo" class="card-img-top" style="height: 200px; object-fit: cover;">

                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?= htmlspecialchars($veiculo['modelo']) ?></h5>
                                        <p class="card-text"><strong>Preço:</strong> R$ <?= number_format($veiculo['preco'], 2, ',', '.') ?></p>
                                        <a href="form.php" class="btn btn-warning fw-bold">Tenho Interesse</a>
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

        </section>

        <section id="sobre">

            <div class="container">
                <h2 class="titulo">Quem Somos?</h2>
                <br><br><br><br>
                <p class="content-text textoSobre">
                    FoxMotors São Leopoldo: Uma Década de Excelência no Mercado Automotivo
                </p>

                <p class="content-text textoSobre2">
                    Com 10 anos de atuação no ramo de vendas automotivas, a FoxMotors São Leopoldo se consolidou como uma
                    referência em qualidade, confiança e atendimento personalizado. Nosso compromisso é oferecer uma experiência
                    única a cada cliente, conectando as melhores oportunidades de compra e venda de veículos em um ambiente seguro e
                    eficiente.
                    <br><br>
                    Ao longo da nossa trajetória, construímos uma reputação sólida, baseada na transparência e no compromisso com a
                    satisfação de nossos clientes. Trabalhamos diariamente para garantir um portfólio diversificado, que atenda às
                    necessidades e expectativas de quem busca qualidade e valor em cada negociação.
                    <br><br>
                    Na FoxMotors São Leopoldo, acreditamos que cada cliente merece o melhor. Por isso, investimos continuamente em
                    inovação, aprimoramento de nossos serviços e em uma equipe altamente qualificada, pronta para oferecer o suporte
                    que você precisa.
                    <br><br>
                <p class="content-text textoSobre">
                    FoxMotors: 10 anos de história, conectando você ao veículo ideal com excelência e confiança.
                </p>
                </p>
            </div>

        </section>

        <section id="contato">
            <div class="container">
                <h2 class="titulo">Contato</h2>
                <br><br><br><br>
                <div class="container text-center">
                    <div class="row justify-content-center mt-4">
                        <div class="col-6 col-md-3 mb-3">
                            <a href="https://wa.me/5551998458940" target="_blank" class="btn btn-custom">
                                <i class="fab fa-whatsapp"></i> WHATSAPP
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <a href="mailto:marcellesandy3@gmail.com?subject=Assunto%20do%20E-mail&body=Oi%20Marcelle,%20gostaria%20de%20falar%20sobre..." class="btn btn-custom">
                                <i class="fas fa-envelope"></i> E-MAIL
                            </a>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-4">
                        <div class="col-6 col-md-3 mb-3">
                            <a href="https://instagram.com/marcellenevessandy" target="_blank" class="btn btn-custom">
                                <i class="fab fa-instagram"></i> INSTAGRAM
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <a href="https://linkedin.com/in/marcellesandy" target="_blank" class="btn btn-custom">
                                <i class="fas fa-briefcase"></i> TRABALHE CONOSCO
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </main>

    <footer class="footer">
        <p>FOXMOTORS©2024<br>Todos os Direitos Reservados</p>
        <div class="footer-logo">
            <img src="./imagens/logo.png" alt="FoxMotors">
        </div>
    </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>