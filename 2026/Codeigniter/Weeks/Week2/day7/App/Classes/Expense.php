<?php

namespace App\Classes;

class Transaction{
    protected string $title;
    protected float $amount;
    protected string $date;

    public function __construct(string $title, float $amount, string $date){
        $this->title = $title;
        $this->amount = $amount;
        $this->date = $date;
    }

    public function describe(): string{
        return $this->title .": Rs. ". number_format($this->amount, 2) . " on " . $this->date;
    }
}

class Income extends Transaction{
    private string $source;

    public function __construct(string $title, float $amount, string $date, string $source){
        parent::__construct($title,$amount,$date);
        $this->source = $source;
    }

    public function describe(): string{
           return $this->title .": Rs. ". number_format($this->amount, 2) . " on " . $this->date . " from " . $this->source;
    }
}

class Expense extends Transaction{
    private \mysqli $db;
    private string $paymentMethod;

    public function __construct(\mysqli $db, string $title, float $amount, string $date, string $paymentMethod){
        $this->db = $db;
        parent::__construct($title, $amount, $date);
        $this->paymentMethod = $paymentMethod;
    }

    public function describe(): string{
         return $this->title .": Rs. ". number_format($this->amount, 2) . " on " . $this->date . " paid by " . $this->paymentMethod;
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