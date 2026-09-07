<!-- Form Data Processing -->
<?php

require 'data.php';


if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $newpassword = $_POST['password'];
      $password1 = password_hash($newpassword, PASSWORD_DEFAULT);

  $ERRORLIST = ["error" => ""];

  forEach($numFields as $key => $value){
     $field[$value[0]] = $value[0];
  }
     
  forEach($field as $key => $value){
    try{
        if(!isset($_POST[$value]) || $_POST[$value] === ""){
            $ERRORLIST["error"] = "Error: ".$key." field is required.";
        }else if($value === 'name' && (strlen($_POST[$value]) < 3)){
            $ERRORLIST["error"] = "Error: ".$key." must be at least 3 characters long.";
        }else if($value === 'email' && (!filter_var($_POST[$value], FILTER_VALIDATE_EMAIL))){
            $ERRORLIST["error"] = "Error: ".$key." must be a valid email address.";
        }else if($value === 'product_price' && ($_POST[$value] <= 0)){
            $ERRORLIST["error"] = "Error: ".$key." must be a positive number.";
        }else if($value === 'product_name' && (strlen($_POST[$value]) < 5 || strlen($_POST[$value]) > 30)){
            $ERRORLIST["error"] = "Error: ".$key." must be between 5 and 30 characters long.";
        }else{
            if($ERRORLIST["error"] === ''){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password =  $password1;
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_quantity = $_POST['product_quantity'];
            $product_gst = $_POST['product_gst'];
            $subscription = $_POST['subscription'];

            
           // Database connection
              require 'db.php';

                if(!empty($name) && !empty($email) && !empty($password) && !empty($product_name) && !empty($product_price) && !empty($product_quantity) && !empty($product_gst) && !empty($subscription)){
                  require_once 'processinvoice.php';

                  $resultprocessinvoice = processInvoiceData($product_quantity, $subscription, $product_price, $product_gst);
                  // Insert data into the database
                  $sql = "INSERT INTO invoice (name, email, password, productname, productprice, productquantity, productgst, isMember,subtotal,subtotaldiscount,discountrate,discountamount,taxamount,finaltotal,deliverycharge) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                  $stmt = $conn->prepare($sql);
                  $stmt->bind_param("ssssdiisddidddd", $name, $email, $password, $product_name, $product_price, $product_quantity, $product_gst, $subscription, $resultprocessinvoice['subtotal'], $resultprocessinvoice['subtotaldiscount'], $resultprocessinvoice['discountrate'], $resultprocessinvoice['discountamount'], $resultprocessinvoice['taxamount'], $resultprocessinvoice['finaltotal'], $resultprocessinvoice['deliverycharge']);
               
                  if($stmt->execute()){
                        echo "Invoice data inserted successfully!";
                        break;
                  } else {
                        echo "Error: " . $stmt->error;
                  }
                }

             mysqli_close($conn);
            }else{
                echo "<h1>";
                print_r($ERRORLIST["error"]);
                echo "</h1>";
            }
            }
    }catch(Throwable $e){
        $ERRORLIST["error"] = "Error: ".$e->getMessage();
    }
  }
}

?> 