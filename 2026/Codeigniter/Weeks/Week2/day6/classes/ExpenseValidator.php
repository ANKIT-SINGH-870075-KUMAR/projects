<?php

class ExpenseValidator{
    private array $errors = [];
    
    public function validate(array $data): bool{
        $this -> errors = [];

        if(empty($data['expense_date'])){
            $this->errors['expense_date'] = "Expense date is Required.";
        }

        if(empty(trim($data['title']))){
            $this->errors['title'] = "Expense title is Required.";
        }else if(strlen($data['title']) < 3){
            $this->errors['title'] = "title must be at least 3 charcaters.";
        }

        if(empty($data['category'])){
            $this->errors['category'] = "category is Required.";
        }

        if(!isset($data['amount']) || !is_numeric($data['amount']) || $data['amount'] <= 0){
            $this->errors['amount'] = "Amount must be greater than Zero.";
        }

        if(empty($data['payment_method'])){
            $this->errors['payment_method'] = "Payment method is required";
        }

        return empty($this->errors);
    }

    public function getErrors(): array{
        return $this->errors;
    }
}

?>