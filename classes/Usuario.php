<?php
class Usuario
{
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register($nome, $sexo, $fone, $email, $senha)
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, sexo, fone, email, senha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
        $stmt->execute([$nome, $sexo, $fone, $email, $hashed_password]);
        return $stmt;
    }

    // Método de login
    public function login($email, $senha)
    {
        $query = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Verifica se encontrou o usuário
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verifica se a senha corresponde
            if (password_verify($senha, $user['senha'])) {
                return $user; // Retorna os dados do usuário
            }
        }
        return false; // Retorna false caso as credenciais estejam incorretas
    }

    /**
     * Verifica se um e-mail está cadastrado no banco de dados.
     *
     * @param string $email
     * @return bool
     */
    public function verificarEmail($email)
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);

        // Vincular o parâmetro
        $stmt->bindParam(':email', $email);

        // Executar a consulta
        $stmt->execute();

        // Verificar se o e-mail foi encontrado
        return $stmt->rowCount() > 0;
    }

    /**
     * Salva um token de redefinição de senha no banco de dados.
     *
     * @param string $email
     * @param string $token
     * @return bool
     */
    public function salvarTokenRedefinicao($email, $token)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET token_redefinicao = :token, expiracao_token = :expiracao
                  WHERE email = :email";
        $stmt = $this->conn->prepare($query);

        // Gerar uma data de expiração para o token (ex: 1 hora a partir de agora)
        $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Vincular os parâmetros
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expiracao', $expiracao);
        $stmt->bindParam(':email', $email);

        // Executar a consulta
        return $stmt->execute();
    }

    public function create($nome, $sexo, $fone, $email, $senha)
    {
        return $this->register($nome, $sexo, $fone, $email, $senha);
    }

    public function ler()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $nome, $sexo, $fone, $email)
    {
        $query = "UPDATE " . $this->table_name . " SET nome = ?, sexo = ?, fone = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$nome, $sexo, $fone, $email, $id]);
        return $stmt;
    }

    public function deletar($id)
    {
        $query = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function listarTodos()
    {
        $query = "SELECT id, nome, sexo, fone, email FROM usuarios";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
