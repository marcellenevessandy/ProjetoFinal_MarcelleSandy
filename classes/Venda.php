<?php
class Venda {
    private $conn;

    // Construtor da classe, conecta ao banco de dados
    public function __construct($db) {
        $this->conn = $db;
    }

    // Função para calcular o valor final com desconto
    public function calcularValorFinal($preco, $desconto) {
        return $preco - ($preco * $desconto / 100);
    }

    // Função para cadastrar a venda
    public function cadastrarVenda($id_cliente, $id_veiculo, $desconto) {
        // Obter o preço do veículo
        $sql = "SELECT preco FROM veiculos WHERE id_veiculo = :id_veiculo";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_veiculo', $id_veiculo);
        $stmt->execute();
        $veiculo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($veiculo) {
            $preco = $veiculo['preco'];
            $valor_final = $this->calcularValorFinal($preco, $desconto);

            // Inserir a venda na tabela vendas
            $sql = "INSERT INTO vendas (id_cliente, id_veiculo, desconto, valor_final) 
                    VALUES (:id_cliente, :id_veiculo, :desconto, :valor_final)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_cliente', $id_cliente);
            $stmt->bindParam(':id_veiculo', $id_veiculo);
            $stmt->bindParam(':desconto', $desconto);
            $stmt->bindParam(':valor_final', $valor_final);

            if ($stmt->execute()) {
                return true;
            }
        }

        return false;
    }
}
?>
