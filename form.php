<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./imagens/raposa.png" type="image/x-icon">
    <title>Tenho Interesse</title>
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

        form {
            background-color: var(--background-color);
            color: var(--text-color);
            border: none;
            /* Removida a borda */
        }

        .form-label {
            font-weight: bold;
        }

        .titulo {
            text-align: center;
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
                        <li class="nav-item"><a class="nav-link fw-bold" href="index.php"><button class="btn btn-warning fw-bold">VOLTAR</button></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="border-bottom border-2"></div>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6"><br><br>
            <h1 class="text-center mb-4 titulo">Tenho Interesse</h1>

            <!-- Aviso de sucesso ou erro -->
            <div id="message-box" class="alert d-none" role="alert"></div>

            <form id="contact-form" action="salvar_lead.php" method="POST">
                
                <!-- Campo Nome -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome" required>
                </div>

                <!-- Campo E-mail -->
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail" required>
                </div>

                <!-- Campo Mensagem -->
                <div class="mb-3">
                    <label for="message" class="form-label">Mensagem</label>
                    <textarea class="form-control" id="message" name="message" rows="4" placeholder="Digite sua mensagem" required></textarea>
                </div>
                <br>
                <!-- Botão Enviar -->
                <button type="submit" class="btn btn-warning fw-bold w-100">ENVIAR</button>
            </form>
        </div>
    </div>

    <!-- Link para o JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('contact-form').addEventListener('submit', async function(event) {
            event.preventDefault(); // Impede o comportamento padrão do formulário

            const form = event.target;
            const formData = new FormData(form);
            const messageBox = document.getElementById('message-box');

            try {
                // Envia os dados para o Getform
                const response = await fetch('https://getform.io/f/awnnkmwb', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    // Mostra a mensagem de sucesso
                    messageBox.classList.remove('d-none', 'alert-danger');
                    messageBox.classList.add('alert-success');
                    messageBox.textContent = 'E-mail enviado com sucesso!';
                    form.reset(); // Limpa o formulário
                } else {
                    throw new Error('Erro ao enviar o formulário.');
                }
            } catch (error) {
                // Mostra a mensagem de erro
                messageBox.classList.remove('d-none', 'alert-success');
                messageBox.classList.add('alert-danger');
                messageBox.textContent = 'Falha ao enviar o e-mail. Tente novamente.';
            }
        });
    </script>
</body>

</html>