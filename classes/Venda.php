<?php
class Vendas
{
    private $conn;
    private $table_name = "vendas";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function cadastrar( $desconto, $forma_pagamento, $valor_total, $data_venda)
    {
        try {
            $query = "INSERT INTO veiculos (desconto, forma_pagamento, valor_total, data_venda) 
                      VALUES (:desconto, :forma_pagamento, :valor_total, :data_venda)";
            $stmt = $this->conn->prepare($query);

            // Binding parameters
            $stmt->bindParam(':desconto', $desconto);
            $stmt->bindParam(':forma_pagamento', $forma_pagamento);
            $stmt->bindParam(':valor_total', $valor_total);
            $stmt->bindParam(':data_venda', $data_venda);

            return $stmt->execute();
        } catch (Exception $e) {
            echo "Erro ao cadastrar venda: " . $e->getMessage();
            return false;
        }
    }
    public function atualizar( $desconto, $forma_pagamento, $valor_total, $data_venda = null)
    {
        try {
            $query = "UPDATE vendas SET desconto = :desconto, forma_pagamento = :forma_pagamento, valor_total = :valor_total,
                      data_venda = :data_venda";

            $query .= " WHERE id = :id";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':desconto', $desconto);
            $stmt->bindParam(':forma_pagamento', $forma_pagamento);
            $stmt->bindParam(':valor_total', $valor_total);
            $stmt->bindParam(':data_venda', $data_venda);

            return $stmt->execute();
        } catch (Exception $e) {
            echo "Erro ao atualizar vendas: " . $e->getMessage();
            return false;
        }
    }

    public function buscarPorId($id)
    {
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

    public function listarTodos()
    {
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

    public function deletar($id)
    {
        try {
            $query = "DELETE FROM vendas WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (Exception $e) {
            echo "Erro ao deletar venda: " . $e->getMessage();
            return false;
        }
    }

}

?>
