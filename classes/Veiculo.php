<?php

class Veiculo {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function cadastrar($placa, $modelo, $ano_modelo, $marca, $cor, $observacao, $status, $preco, $imagem) {
        try {
            $query = "INSERT INTO veiculos (placa, modelo, ano_modelo, marca, cor, observacao, status, preco, imagem) 
                      VALUES (:placa, :modelo, :ano_modelo, :marca, :cor, :observacao, :status, :preco, :imagem)";
            $stmt = $this->conn->prepare($query);

            // Binding parameters
            $stmt->bindParam(':placa', $placa);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':ano_modelo', $ano_modelo);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':cor', $cor);
            $stmt->bindParam(':observacao', $observacao);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':imagem', $imagem);

            return $stmt->execute();
        } catch (Exception $e) {
            echo "Erro ao cadastrar veículo: " . $e->getMessage();
            return false;
        }
    }

    public function atualizar($id, $placa, $modelo, $ano_modelo, $marca, $cor, $observacao, $status, $preco, $imagem = null) {
        try {
            $query = "UPDATE veiculos SET placa = :placa, modelo = :modelo, ano_modelo = :ano_modelo,
                      marca = :marca, cor = :cor, observacao = :observacao, status = :status, preco = :preco";

            if ($imagem) {
                $query .= ", imagem = :imagem";
            }

            $query .= " WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            // Binding parameters
            $stmt->bindParam(':placa', $placa);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':ano_modelo', $ano_modelo);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':cor', $cor);
            $stmt->bindParam(':observacao', $observacao);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':id', $id);

            if ($imagem) {
                $stmt->bindParam(':imagem', $imagem);
            }

            return $stmt->execute();
        } catch (Exception $e) {
            echo "Erro ao atualizar veículo: " . $e->getMessage();
            return false;
        }
    }

    public function buscarPorId($id) {
        try {
            $query = "SELECT * FROM veiculos WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Erro ao buscar veículo: " . $e->getMessage();
            return false;
        }
    }

    public function listarTodos() {
        try {
            $query = "SELECT * FROM veiculos";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Erro ao listar veículos: " . $e->getMessage();
            return false;
        }
    }

    public function deletar($id) {
        try {
            $query = "DELETE FROM veiculos WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo "Erro ao deletar veículo: " . $e->getMessage();
            return false;
        }
    }

    public function listarDisponiveis() {
        try {
            $query = "SELECT id, modelo, placa, preco, imagem FROM veiculos WHERE status = 'disponível'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Erro ao listar veículos disponíveis: " . $e->getMessage();
            return false;
        }
    }    

    public function pesquisar($search) {
        try {
            $query = "SELECT id, placa, modelo, ano_modelo, marca, preco, imagem 
                      FROM veiculos 
                      WHERE placa LIKE :search OR modelo LIKE :search OR marca LIKE :search
                      ORDER BY preco LIMIT 3";
            $stmt = $this->conn->prepare($query);
            $search = "%" . $search . "%";
            $stmt->bindParam(':search', $search);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Erro ao pesquisar veículos: " . $e->getMessage();
            return false;
        }
    }
}

?>
