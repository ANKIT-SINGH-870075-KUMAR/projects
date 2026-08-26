<!-- 

Using your $fruits array:

Print every fruit using foreach.
Print each fruit with a number.
Count how many fruits are present.
Write a function:

function findFruit(array $fruits, string $search): string

Return "Fruit found" if the fruit exists, otherwise return "Fruit not found".
Make the search case-insensitive, so "mango" finds "Mango".

-->

<?php

$Fruits = ["Apple","Banana","Grapes","Mango","Orange"];

// Print fruits using foreach
foreach($Fruits as $Fruit){
    echo $Fruit . ",";
}

// Print each fruit with a number
$num = 0;
while($num < count($Fruits)){
    echo ($num + 1) . ". " . $Fruits[$num] . "<br>";
    $num++;
}

echo "Total fruits: " . count($Fruits); // Count how many fruits are present

function findFruit(array $arr, string $query): string {

    foreach($arr as $fruit){
        if(strtolower($fruit) === strtolower($query)){
            return "Fruit found";
        }
    }
    return "Fruit not found";

}

echo findFruit($Fruits, "mango"); // Example usage of the function
echo findFruit($Fruits, "Pineapple"); // Example usage of the function
?>

<!-- 

Scenario
A customer is purchasing a product. Write a PHP program that calculates the invoice subtotal, discount, tax, delivery charge, and final total.

Product information
Create this associative array:

$product = [
    "name" => "Laptop",
    "price" => 50000,
    "quantity" => 6,
];
-->

<?php

$product = array(
    "productName" => "Desi soota",
    "price" => 50000,
    "quantity" => 7,
    "gst" => 0.18,
    "isMember" => true
);

function calculateInvoiceTotal(float $parprice, int $parquantity, bool $parisMember, array $product ): array {

if($parquantity <= 0 || $parprice <= 0){
     return ["error"=>"Quantity and price cannot be negative or zero."];
}

if($parquantity < 5){
    $discount = 0;
}else if($parquantity >= 6 && $parquantity <=10){
    $discount = 0.10;
}else if($parquantity > 10){
    $discount = 0.15;
    }else if($parquantity > 12){
    $discount = 0.15;
}

if($parisMember){
    $discount = $discount + 0.05;
}

$formatprice = number_format($parprice);

$subtotal = $parprice * $parquantity;
$formatsubtotal = number_format($subtotal);

$discountamount = ($subtotal * ($discount*100)) / 100;
$formatdiscountamount = number_format($discountamount);

$subtotalafterdiscount = $subtotal - $discountamount;
$formatsubtotalafterdiscount = number_format($subtotalafterdiscount);

$taxamount = ($subtotalafterdiscount * $product['gst']) / 100;

$subtotalaftertax = $subtotalafterdiscount - $taxamount;
$formatsubtotalaftertax = number_format($subtotalaftertax);

if($subtotalafterdiscount >= 100000){
    $deliveryCharge = 0;
}else{
    $deliveryCharge = 500;
}

$finalprice = $subtotalafterdiscount + $taxamount + $deliveryCharge;
$formatfinalprice = number_format($finalprice);

$discountRate =  $discount * 100;
$productGst = $product['gst'] * 100;

$invoicearray = [
     "Product" => "{$product['productName']}",
     "Price" => "₹ {$formatprice}",
     "Quantity" => "{$parquantity}",
     "Subtotal" => "₹{$formatsubtotal}",
     "Discount rate" => "{$discountRate}%",
     "Discount amount" => "₹{$formatdiscountamount}",
     "Amount after discount" => "₹{$formatsubtotalafterdiscount}",
     "GST" => "({$productGst}%) : ₹{$formatdiscountamount}",
     "Delivery Charge" => "₹ {$deliveryCharge}",
     "Final total" => "₹{$formatfinalprice}"
];


return $invoicearray;
}

$invoiceresult = calculateInvoiceTotal($product['price'], $product['quantity'], $product['isMember'], $product);

echo "<pre>";
print_r($invoiceresult);
echo "</pre>";

foreach($invoiceresult as $key => $result){
    echo "{$key}: {$result} <br> ";
}


?>