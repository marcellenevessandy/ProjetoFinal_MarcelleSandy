<?php
$host = "localhost";
$db_name = "db_revenda";
$username = "root";
$password = "";

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verificar se os dados foram enviados
        if (isset($_POST['name'], $_POST['email'], $_POST['message'])) {
            $nome = $_POST['name'];
            $email = $_POST['email'];
            $mensagem = $_POST['message'];

            // Inserir os dados no banco
            $sql = "INSERT INTO leads (nome, email, mensagem) VALUES (:nome, :email, :mensagem)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':mensagem' => $mensagem
            ]);

            echo "Dados salvos com sucesso!";
        } else {
            echo "Erro: Campos obrigatórios não enviados.";
        }
    } else {
        echo "Requisição inválida.";
    }
} catch (PDOException $e) {
    // Mostrar erros de conexão
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
