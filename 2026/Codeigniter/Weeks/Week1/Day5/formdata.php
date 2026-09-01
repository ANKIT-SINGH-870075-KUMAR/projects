<!-- Form Data Processing -->
<?php

require 'data.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

     
    forEach($numFields as $key => $value){
        if(!isset($_POST[$value[0]]) || empty($_POST[$value[0]])){
            die("Error: ".$key." field is required.");
        }

        $value[0] = $_POST[$value[0]];
    }

    // Database connection
    require 'db.php';

    // Insert data into the database
    $sql = "INSERT INTO products (name, email, password, product_name, product_price, product_quantity, product_gst, subscription) VALUES ('$name', '$email', '$password', '$product_name', '$product_price', '$product_quantity', '$product_gst', '$subscription')";

    if(mysqli_query($conn, $sql)){
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

?> 