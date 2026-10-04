<?php

namespace App\Classes;

class ExpenseReport{
    private \mysqli $db;
    private string $paymentMethod;

    public function __construct(\mysqli $db){
        $this->db = $db;
    }

    public function getAll(): array{
        $sql ="SELECT id, expense_date, title, category_id, amount, payment_method,description FROM expenses";

        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategory(): array{
         $sql = "SELECT ID, name FROM categories ORDER BY ID";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function categorywithnoexpense(): array{
        $sql = "SELECT 
                c.id,
                c.name
            FROM categories c
            LEFT JOIN expenses e ON e.category_id = c.id
            WHERE e.id IS NULL";

         $result = $this->db->query($sql);

         return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function topspender(): array{
        $sql = "SELECT u.ID, u.name, SUM(e.amount) AS total_spent FROM users u INNER JOIN expenses e ON u.ID = e.user_id GROUP BY u.ID, u.name ORDER BY total_spent DESC LIMIT 1";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function expensesdate(): array{
        $sql = "SELECT id, expense_date, title, category_id, amount, payment_method,description FROM expenses WHERE expenses_date >= '2026-09-01' AND expense_date <= '2026-09-30'";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function categorytotal(): array{
        $sql = "SELECT c.name AS category, SUM(e.amount) AS total_spent FROM expenses e INNER JOIN categories c ON e.category_id = c.ID GROUP BY c.ID, c.name HAVING SUM(e.amount) > 1000";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function filterByamount($a): array{
        $sql = "SELECT id, expense_date, title, category_id, amount, payment_method,description FROM expenses WHERE amount > ?";
        $stmt = $this->db->prepare($sql); 
        $stmt->bind_param("d", $a); 
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Explaination Query 2:- in this sql query use expenses table and itrate all index column value according to expense date also in broswer show in descending order and only 5 row is display
    public function recentexpesne(): array{
        $sql = "SELECT id,expense_date, title, category_id, amount, payment_method, description FROM expenses ORDER BY expense_date DESC Limit 5";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function totalspent(): array{
        $sql = "SELECT SUM(amount) AS total_spent FROM expenses";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function expensebyCategory($cid): array{
        $sql = "SELECT e.id, e.expense_date, e.title, e.category_id, e.amount, e.payment_method, e.description FROM expenses e INNER JOIN categories c ON c.ID = e.category WHERE c.name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $cid);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);

    }

    public function expensebypaymentMethod($pay): array{
        $sql = "SELECT id, expense_date, title, category_id, amount, payment_method, description FROM expenses WHERE payment_method = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $pay);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function averageexpensebypaymentMethod($pay): array{
        $sql = "SELECT AVG(amount) AS average_amount FROM expenses WHERE payment_method = ? GROUP BY payment_method";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $pay);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function expensebyuser($user): array{
        $sql = "SELECT e.id, e.expense_date, e.title, e.category_id, e.amount, e.payment_method, e.description FROM expenses e INNER JOIN users u ON u.ID = e.user_id WHERE u.name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countexpensebyuser($user): array{
        $sql = "SELECT COUNT(e.id) AS expense_count, u.name FROM expenses e INNER JOIN users u ON u.ID = e.user_id WHERE u.name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addexpense(
        string $expenseDate,
        string $title,
        string $category,
        float $amount,
        string $paymentmethod,
        string $description
    ): bool{

      $sql = "INSERT INTO expenses(expense_date,title, category_id, amount, payment_method, description) VALUES(?,?,?,?,?,?)";

      $stmt = $this->db->prepare($sql);
      $stmt->bind_param(
        "sssdss",$expenseDate,$title,$category,$amount,$paymentmethod,$description
      );

      return $stmt->execute();

    }

    public function find(int $id): ?array{
        $sql = "SELECT id, expense_date, title, category_id, amount, payment_method, description FROM expenses WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function update(int $id, string $expenseDate, string $title, string $category, float $amount, string $paymentmethod, string $description) : bool{
        $sql = "UPDATE expenses SET expense_date = ?, title = ?, category_id = ?, amount = ?, payment_method = ?, description = ? WHERE id = ? ";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssdssi", $expenseDate, $title, $category, $amount, $paymentmethod, $description, $id);
        return $stmt->execute() && $stmt->affected_rows > 0;
    }

    public function delete(int $id): bool{
        $sql ="DELETE FROM expenses WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute() && $stmt->affected_rows > 0;
    }

    
}

?>