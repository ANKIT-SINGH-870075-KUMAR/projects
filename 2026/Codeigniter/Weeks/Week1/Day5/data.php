<!-- Data Processing -->
<?php

$numFields = Array(
    "Name" => ["name","text"],
    "Email" => ["email","email"],
    "Password" => ["password","password"],
    "Product Name" => ["product_name","text"],
    "Product Price" => ["product_price","number"],
    "Product Quantity" => ["product_quantity","dropdown"],
    "Product GST" => ["product_gst","radio"],
    "Subscribtion" => ["subscription", "dropdown"]
)

$dropddownOptions = Array(
    "Product Quantity" => ["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20"],
    "Product GST" => ["12"=> "12%", "18"=> "18%", "28"=> "28%"]
)

 ?>