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
    "discount" => null,
    "gst" => 0.12,
    "deliveryCharge" => 1200,
    "isMember" => true
)

if($product['quantity'] <= 0 || $product['price'] <= 0){
    echo "Quantity and price cannot be negative or zero.";
    die();
}

if($product['quantity'] < 5){
    $product['discount'] = 0;
}else if($product['qquantity'] >= 6 && $product['quantity'] <=10 && !$product['isMember']){
    $product['discount'] = 0.05;
}else if($product['quantity'] > 10 && $produt['isMember']){
    $product['discount'] = 0.10;
    }else if($product['quantity'] > 12 && $product['isMember']){
    $product['discount'] = 0.15;
}

$subtotal = $product['price'] * $product['quantity'];
$formatsubtotal = number_format($subtotal);

$discountamount = ($subtotal * $product['discount']) / 100;
$formatdiscountamount = number_format($discountamount);

$subtotalafterdiscount = $subtotal - $discountamount;
$formatsubtotalafterdiscount = number_format($subtotalafterdiscount);

$taxamount = ($subtotalafterdiscount * $product['gst']) / 100;

$subtotalaftertax = $subtotalafterdiscount - $taxamount;
$formatsubtotalaftertax = number_format($subtotalaftertax);



?>