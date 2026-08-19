<!-- Create a $product associative array containing:
 Product name
Price
Quantity
In-stock status
Three categories

Result: Laptop costs ₹50,000. We currently have 5 units. Categories: Electronics, Computers, Office.
-->

<?php 

$product = array(
    "productname" => "Laptop",
    "price" => 50000,
    "quantity" => 5,
    "in_stock" => true,
    "categories" => ["Electronics", "Computers", "Office"]
);

$stockstatus = $product['in_stock'] ? "In Stock" : "Out of Stock"; //This is a ternary operator that checks the in_stock status of the product and assigns the appropriate string value to the $stockstatus variable.

echo "{$product['productname']} costs ₹{$product['price']}. We currently have {$product['quantity']} units. Categories: " . implode(', ', $product['categories']) . ". Stock Status: $stockstatus"; //This will print the product details using string interpolation and implode function to convert the categories array into a string.

?>

<!-- Extend the product code to print one of these messages:

Quantity is 0: Product is out of stock.
Quantity is between 1 and 5: Only a few units are left.
Quantity is greater than 5: Product is available.
Requirements:

Use if, elseif, and else.
Store quantity as an integer.
Do not use the existing in_stock Boolean for the decision.
Also calculate total inventory value:

Result: Laptop costs ₹50,000. Only a few units are left. Total inventory value: ₹250,000.
-->

<?php 

$product = array(
    "productname" => "Laptop",
    "price" => 50000,
    "quantity" => 5,
    "in_stock" => true,
    "categories" => ["Electronics", "Computers", "Office"]
);

$formaproductprice = number_format($product['price']); //Formats the product price to include commas for better readability.
$totalinventaryvalue = $product['price'] * $product['quantity']; //Calculates the total inventory value by multiplying the price and quantity of the product.
$formattotalinventaryvalue = number_format($totalinventaryvalue); //Formats the total inventory value to include commas for better readability.
$quantity = (int)$product['quantity']; //Ensures that the quantity is stored as an integer for accurate comparisons.

function stockchecker(int $quantity): string{
if ($quantity < 0){
    return "Invalid quantity.";
}    
else if ($quantity === 0){
    return "Product is out of stock.";
} else if ($quantity >= 1 && $quantity <= 5){
    return "Only a few units are left.";
} else {
    return "Product is available.";
}
} //This function checks the quantity of the product and returns an appropriate stock alert message based on the specified conditions.

$stockalertmessage = stockchecker($quantity); //Calls the stockchecker function and assigns the returned message to the $stockalertmessage variable.
echo "{$product['productname']} costs ₹{$formaproductprice}. {$stockalertmessage} Total inventory value: ₹{$formattotalinventaryvalue}"; //This will print the product details along with the stock alert message and total inventory value.

?>

<!-- 
function calculateDiscount(float $price, int $quantity): float

Rules:

Quantity below 5: no discount
Quantity from 5 to 10: 10% discount
Quantity above 10: 20% discount
Negative price or quantity: return 0

Calculate and display: 

Product: Laptop
Original total: ₹250,000
Discount: ₹25,000
Final total: ₹225,000
-->

<?php

$product = array(
    "productname" => "Laptop",
    "price" => 50000,
    "quantity" => 5,
    "in_stock" => true,
    "categories" => ["Electronics", "Computers", "Office"]
);

$quantity = (int)$product['quantity'];
$formatprice = number_format($product['price']);
$totalinventoryvalue = $product['price'] * $quantity;
$formatotalinventoryvalue = number_format($totalinventoryvalue);

function calculateDiscount(float $price, int $quantity): float{
    if($price < 0 || $quantity < 0){
        return 0.0;
    } elseif($quantity < 5){
        return 0.0;
    } elseif($quantity >= 5 && $quantity <= 10){
        return $price * $quantity * 0.10; //10% discount
    } else {
        return $price * $quantity * 0.20; //20% discount
    }
}

$discount = calculateDiscount($product['price'], $quantity);
$formatdiscount = number_format($discount);
$finaltotal = $totalinventoryvalue - $discount;
$formatfinaltotal = number_format($finaltotal);

echo "Product: {$product['productname']}<br>";
echo "Original total: ₹{$formatotalinventoryvalue}<br>";
echo "Discount: ₹{$formatdiscount}<br>";
echo "Final total: ₹{$formatfinaltotal}";

?>