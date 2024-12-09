<?php
// Cliente.php - Classe que manipula as operações com cliente

class Cliente
{
    private $conn;

    // Construtor que recebe a conexão com o banco
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Função que realiza o cadastro do cliente no banco
    public function cadastrar($nome, $email, $telefone, $cpf, $data_nascimento, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado)
    {
        // SQL para inserir o cliente
        $query = "INSERT INTO clientes (nome, email, telefone, cpf, data_nascimento, cep, endereco, numero, complemento, bairro, cidade, estado) 
                  VALUES (:nome, :email, :telefone, :cpf, :data_nascimento, :cep, :endereco, :numero, :complemento, :bairro, :cidade, :estado)";

        // Preparar o statement
        $stmt = $this->conn->prepare($query);

        // Vincular os parâmetros
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':complemento', $complemento);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);

        // Executar o statement
        if ($stmt->execute()) {
            return true; // Retorna verdadeiro se a inserção for bem-sucedida
        } else {
            throw new Exception("Erro ao cadastrar o cliente.");
        }
    }

    public function listarTodos()
    {
        $query = "SELECT id, nome, email, telefone, cpf, data_nascimento, cep, endereco, numero, complemento, bairro, cidade, estado FROM clientes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados do cliente
    }

    public function atualizar($id, $nome, $email, $telefone, $cpf, $data_nascimento, $cep, $endereco, $numero, $complemento, $bairro, $cidade, $estado)
    {
        $query = "UPDATE clientes SET nome = :nome, email = :email, telefone = :telefone, cpf = :cpf, data_nascimento = :data_nascimento, cep = :cep, endereco = :endereco, numero = :numero, complemento = :complemento, bairro = :bairro, cidade = :cidade, estado = :estado WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':complemento', $complemento);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':estado', $estado);

        $stmt->execute();
    }

    public function deletar($id)
    {

        $query = "DELETE FROM clientes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Dentro da classe Cliente
    public function pesquisar($search)
    {
        $query = "SELECT id, nome, cpf FROM clientes WHERE nome LIKE :search OR cpf LIKE :search LIMIT 3";
        $stmt = $this->conn->prepare($query);
        $search = "%" . $search . "%";  // para realizar uma busca com LIKE
        $stmt->bindParam(':search', $search);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>