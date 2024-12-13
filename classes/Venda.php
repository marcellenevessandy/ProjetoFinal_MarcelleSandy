<?php

class Venda
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Função para cadastrar a venda
    public function cadastrar($id_cliente, $id_veiculo, $desconto)
    {
        // Obter o modelo e preço do veículo
        $veiculo = $this->getVeiculo($id_veiculo);
        $preco = $veiculo['preco'];
        $valorFinal = $preco - ($preco * $desconto / 100);

        // Inserir a venda no banco
        $query = "INSERT INTO vendas (id_cliente, id_veiculo, desconto, valor_final) 
                  VALUES (:id_cliente, :id_veiculo, :desconto, :valor_final)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_veiculo', $id_veiculo);
        $stmt->bindParam(':desconto', $desconto);
        $stmt->bindParam(':valor_final', $valorFinal);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Função para obter os detalhes do veículo
    private function getVeiculo($id_veiculo)
    {
        $query = "SELECT modelo, preco FROM veiculos WHERE id = :id_veiculo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_veiculo', $id_veiculo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Função para buscar as vendas realizadas
    public function listarVendas()
    {
        $query = "SELECT v.id, c.nome, c.cpf, ve.modelo, v.desconto, v.valor_final, v.data_venda 
                  FROM vendas v
                  JOIN clientes c ON v.id_cliente = c.id
                  JOIN veiculos ve ON v.id_veiculo = ve.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Função para buscar os detalhes de uma venda específica
    public function buscarVenda($id)
    {
        $query = "SELECT v.id, c.nome, c.cpf, ve.modelo, v.desconto, v.valor_final, v.data_venda 
                  FROM vendas v
                  JOIN clientes c ON v.id_cliente = c.id
                  JOIN veiculos ve ON v.id_veiculo = ve.id
                  WHERE v.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarVenda($id, $id_cliente, $id_veiculo, $desconto)
    {
        // Obter o modelo e preço do veículo
        $veiculo = $this->getVeiculo($id_veiculo);
        $preco = $veiculo['preco'];
        $valorFinal = $preco - ($preco * $desconto / 100);

        // Atualizar a venda no banco
        $query = "UPDATE vendas 
              SET id_cliente = :id_cliente, id_veiculo = :id_veiculo, desconto = :desconto, valor_final = :valor_final 
              WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_veiculo', $id_veiculo);
        $stmt->bindParam(':desconto', $desconto);
        $stmt->bindParam(':valor_final', $valorFinal);

        return $stmt->execute();
    }

    public function deletarVenda($id)
    {
        $query = "DELETE FROM vendas WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function consultarTodas() {
        $query = "SELECT * FROM vendas"; // Supondo que você tenha uma tabela 'vendas'
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Retorna todos os resultados
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
