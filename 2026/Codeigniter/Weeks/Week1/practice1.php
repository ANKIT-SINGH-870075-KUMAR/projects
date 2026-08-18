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