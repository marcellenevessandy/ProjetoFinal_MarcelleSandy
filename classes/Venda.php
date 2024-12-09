<?php
class Venda {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function cadastrarVenda($cliente_id, $veiculo_id, $desconto, $forma_pagamento, $valor_total, $data_venda) {
        $sql = "INSERT INTO vendas (cliente_id, veiculo_id, desconto, forma_pagamento, valor_total, data_venda) 
                VALUES (:cliente_id, :veiculo_id, :desconto, :forma_pagamento, :valor_total, :data_venda)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cliente_id', $cliente_id);
        $stmt->bindParam(':veiculo_id', $veiculo_id);
        $stmt->bindParam(':desconto', $desconto);
        $stmt->bindParam(':forma_pagamento', $forma_pagamento);
        $stmt->bindParam(':valor_total', $valor_total);
        $stmt->bindParam(':data_venda', $data_venda);

        if ($stmt->execute()) {
            return "Venda cadastrada com sucesso!";
        } else {
            throw new Exception("Erro ao cadastrar venda.");
        }
    }
}
?>
