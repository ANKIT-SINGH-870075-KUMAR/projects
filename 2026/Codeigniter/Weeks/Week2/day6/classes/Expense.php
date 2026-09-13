<?php

class Expense{
    private mysqli $db;

    public function __construct(mysqli $db){
        $this->db = $db;
    }

    public function addexpense(
        string $expenseDate,
        string $title,
        string $category,
        string $amount,
        string $paymentmethod,
        string $description
    ): bool{

      $sql = "INSERT INTO expenses(expense_date,title, category, amount, payment_method, description) VALUES(?,?,?,?,?,?)";

      $stmt = $this->db->prepare($sql);
      $stmt->bind_param(
        "sssdss",$expenseDate,$title,$category,$amount,$paymentmethod,$description
      );

      return $stmt->execute();

    }

    public function getAll(): array{
        $sql ="SELECT id, expense_date, title, category, amount, payment_method,description FROM expenses";

        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find(int $id): ?array{
        $sql = "SELECT id, expense_date, title, category, amount, payment_method, description FROM expenses WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function update(int $id, string $expenseDate, string $title, string $category, float $amount, string $paymentmethod, string $description) : bool{
        $sql = "UPDATE expenses SET expense_date = ?, title = ?, category = ?, amount = ?, payment_method = ?, description = ? WHERE id = ? ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssdssi", $expenseDate, $title, $category, $amount, $paymentmethod, $description, $id);
        return $stmt->execute();
    }

    public function delete(int $id): bool{
        $sql ="DELETE FROM expenses WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    
}

?>