<?php

class ExpenseCalculator{

   public function total(array $expense): float{
    $total = 0;

    foreach ($expense as $key => $value) {
        $total += (float) $value['amount']; 
    }

    return $total;
   }

   public function remainingBudget(float $budget, float $totalbuget): float{

     return $budget - $totalbuget;

   }

   public function lowbalancealert(float $budget): bool {

     $alert = false;
     if($budget == 10000.00){
        $alert = true; 
     }

     return $alert;

   }
}


?>