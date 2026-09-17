<?php

interface DiscountStrategy{
    public function getRate(float $subtotal, int $quantity): float;
}

class QuantityDiscount implements DiscountStrategy{
    public function getRate(float $subtotal, int $quantity): float{

         if($quantity < 5){
            return 0.0;
         }else if($quantity >=5 && $quantity <= 10){
            return 10.0;
         }else if($quantity > 10){
            return 15.0;
         }
    }
  

}

class MemberBonus implements DiscountStrategy{
    private bool $isMember;

    public function __construct(bool $isMember){
        $this->isMember = $isMember;
    }

    public function getRate(float $subtotal, int $quantity): float{

         if($this->isMember){
            return 5.0;
         }

         return 0.0;
    }

}

abstract class Transaction{
  abstract public function describe(): string;

  public function save(): string{
    return "Invoice Save Successfully";
  }
}

trait Formatters{
    public function money(float $v): string{
        return "Rs." . number_format($v, 2);
    }
}

class Invoice extends Transaction{

    use Formatters;

    private array $strategies;
    private int $quantity;
    private float $price;
    private bool $isMember;
    private int $tax;
    private float $rate;
    private float $subtotal;
    private float $discountamount;
    private float $finalsubtotal;
    private float $taxamount;
    private float $deliverycharge;
    private float $finaltotal;
    private string $productname;

    
    public function __construct(string $productname, array $strategies, float $price, int $tax, int $quantity, bool $isMember ){
        $this->strategies = $strategies;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->isMember = $isMember;
        $this->tax = $tax;
        $this->productname = $productname;
        $this->rate = 0.0;
        $this->discountamount = 0.0;
        $this->finalsubtotal = 0.0;
        $this->taxamount = 0.0;
        $this->deliverycharge = 0.0;
        $this->finaltotal = 0.0;
        
        $this->strategies[] = new MemberBonus($this->isMember);
    }

    public function calculate(): array{
        

        foreach($this->strategies as $s){
            $this->rate += $s->getRate($this->price * $this->quantity, $this->quantity);
        }

        $this->subtotal = $this->price * $this->quantity;
        $this->discountamount = ($this->subtotal * $this->rate)/100;
        $this->finalsubtotal = $this->subtotal - $this->discountamount;
        $this->taxamount = ($this->finalsubtotal * $this->tax)/100;

        if($this->finalsubtotal >= 100000){
            $this->deliverycharge = 0.0;
        }else{
            $this->deliverycharge = 12000.0;
        }

        $this->finaltotal = $this->finalsubtotal + $this->taxamount + $this->deliverycharge;

        return ['subtotal'=>$this->money($this->subtotal), 'discountamount'=> $this->money($this->discountamount), 'taxamount' => $this->money($this->taxamount), 'deliverycharge' => $this->money($this->deliverycharge), 'finaltotal'=> $this->money($this->finaltotal)];
    }

    public function describe(): string{
        return "The customer purchased " . $this->quantity ." " . $this->productname . " at " . $this->money($this->price) . " each. The discount rate is " . $this->rate . "%, resulting in a discount amount of " . $this->money($this->discountamount) .". The taxable amount is ". $this->money($this->finalsubtotal) .", the tax rate is ".$this->tax."%, the tax amount is ". $this->money($this->taxamount) .", and the delivery charge is ". $this->money($this->deliverycharge) .". The total price is ". $this->money($this->finaltotal) .".";
    }


}

// P1
$calculator = new Invoice("Laptop",[ new QuantityDiscount() ], 1000, 18, 20, false);

// P2
$calculator2 = new Invoice("Laptop",[ new QuantityDiscount() ], 2000, 18, 6, true);

$result1 = $calculator->describe();

// Result for P1
$result = $calculator->calculate();

// Result for P2
$result2 = $calculator2->calculate();


$result1 = $calculator->describe();
$saveresult = $calculator->save();
echo "<pre>";
echo "Result for P1";
echo "<br>";
print_r($result);

echo "Result for P2";
echo "<br>";
print_r($result2);

echo $result1;
echo "<br>";
echo $saveresult;
echo "</pre>";

?>