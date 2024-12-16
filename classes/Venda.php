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

    public function listarVendas()
    {
        $query = "SELECT 
                       vendas.id_venda AS venda_id,
                       clientes.nome AS cliente_nome,
                       clientes.cpf AS cliente_cpf,
                       veiculos.modelo AS veiculo_modelo,
                       vendas.desconto,
                       vendas.valor_final,
                       vendas.data_venda
                  FROM vendas
                  INNER JOIN clientes ON vendas.id_cliente = clientes.id
                  INNER JOIN veiculos ON vendas.id_veiculo = veiculos.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarVenda($id_venda)
    {
        $query = "SELECT 
                       vendas.id_venda AS venda_id,
                       vendas.id_cliente,
                       vendas.id_veiculo,
                       clientes.nome AS cliente_nome,
                       veiculos.modelo AS veiculo_modelo,
                       vendas.desconto,
                       vendas.valor_final,
                       vendas.data_venda
                  FROM vendas
                  INNER JOIN clientes ON vendas.id_cliente = clientes.id
                  INNER JOIN veiculos ON vendas.id_veiculo = veiculos.id
                  WHERE vendas.id_venda = :id_venda";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_venda', $id_venda);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    

    public function atualizarVenda($id_venda, $id_cliente, $id_veiculo, $desconto)
    {
        // Obter o modelo e preço do veículo
        $veiculo = $this->getVeiculo($id_veiculo);
        $preco = $veiculo['preco'];
        $valorFinal = $preco - ($preco * $desconto / 100);
    
        // Atualizar a venda no banco
        $query = "UPDATE vendas 
                  SET id_cliente = :id_cliente, 
                      id_veiculo = :id_veiculo, 
                      desconto = :desconto, 
                      valor_final = :valor_final 
                  WHERE id_venda = :id_venda";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':id_venda', $id_venda);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_veiculo', $id_veiculo);
        $stmt->bindParam(':desconto', $desconto);
        $stmt->bindParam(':valor_final', $valorFinal);
    
        return $stmt->execute();
    }
    
    public function deletarVenda($id_venda)
    {
        $query = "DELETE FROM vendas WHERE id_venda = :id_venda";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_venda', $id_venda);
    
        return $stmt->execute();
    }
    
}
?>