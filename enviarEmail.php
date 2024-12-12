<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtendo os dados do formulário
    $nome = htmlspecialchars($_POST['nome']);
    $email = htmlspecialchars($_POST['email']);
    $descricao = htmlspecialchars($_POST['descricao']);

    // Configurando os detalhes do e-mail
    $to = 'marcellesandy3@gmail.com';
    $subject = 'Sou um novo lead';
    $message = "Você recebeu um novo lead:\n\n" .
               "Nome: $nome\n" .
               "E-mail: $email\n" .
               "Descrição: $descricao";
    $headers = "From: $email\r\n" .
               "Reply-To: $email\r\n" .
               "Content-Type: text/plain; charset=UTF-8";

    // Enviando o e-mail
    if (mail($to, $subject, $message, $headers)) {
        echo "E-mail enviado com sucesso!";
    } else {
        echo "Falha ao enviar o e-mail. Tente novamente.";
    }
}
?>
