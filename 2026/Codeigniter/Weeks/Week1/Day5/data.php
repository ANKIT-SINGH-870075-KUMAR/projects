<!-- Data Processing -->
<?php

$numFields = Array(
    "Name" => ["name","text"],
    "Email" => ["email","email"],
    "Password" => ["password","password"],
    "Product Name" => ["product_name","text"],
    "Product Price" => ["product_price","number"],
    "Product Quantity" => ["product_quantity","dropdown"],
    "Product GST" => ["product_gst","dropdown"],
    "Subscribtion" => ["subscription", "radio"]
);

$dropdownOptions = Array(
    "Product Quantity" => ["1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17","18"=>"18","19"=>"19","20"=>"20"],
    "Product GST" => ["12"=> "12%", "18"=> "18%", "28"=> "28%"]
);

 ?>