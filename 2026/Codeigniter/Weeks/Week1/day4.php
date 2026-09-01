<?php

$invoicepanel = []; //All invoice

// Process 1: - when use Get Method
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['name']) && isset($_GET['email']) && isset($_GET['productname']) && isset($_GET['productprice']) && isset($_GET['productquantity']) && isset($_GET['productGST']) && isset($_GET['ismember'])){
$name = $_GET['name']; // name variable
$email = $_GET['email']; // email variable
$newpassword = $name . $email;
$password = password_hash($newpassword, PASSWORD_DEFAULT); // password variable
$productname = $_GET['productname']; // Product name variable
$productprice = $_GET['productprice']; // Product Price variable
$productquantity = $_GET['productquantity']; // Product Quantity variable
$productGST = $_GET['productGST']; // Product GST variable
$ismember = $_GET['ismember']; // password variable

if($name === '' || $email === '' || $productname === '' || $productprice === '' || $productquantity === '' || $productGST === '' || $ismember === ''){
    echo "Please fill required field";
}else if(strlen($name) < 3){
    echo "Invalid Name";
}else if(strlen($name) >=12 ){
    echo "Name exceed about 12 character";
}else if(strlen($productname) < 3){
    echo "Invalid Product Name";
}else if(strlen($productname) >=30 ){
    echo "Product Name exceed about 30 character";
}else if($productprice <= 0 || $productquantity <= 0){
    echo "Invalid Price and Quantity";
}else{

// Apply Invoice Calculation
if($productquantity <= 5){
    $discount = 0;
}else if($productquantity >=6 && $productquantity <=10 ){
    $discount = 10;
}else if($productquantity > 10){
    $discount = 15;
}

if($ismember === "Member"){
    $discount = $discount + 5;
}else{
    $discount = $discount;
}

$subtotal = $productquantity * $productprice;
$discountamount = ($subtotal * $discount)/100;
$finalsubtotal = $subtotal - $discountamount;
$taxamount = ($finalsubtotal * $productGST)/100;
$finalaftertax = $finalsubtotal - $taxamount;

if($finalsubtotal >= 100000){
    $deliverycharge = 0;
}else{
    $deliverycharge = 1200;
}

$sellingprice = $finalsubtotal + $taxamount + $deliverycharge;

// establish database connection
$conn = new mysqli("localhost","practice","1234","practice_code");

if($conn->connect_error){
    die("Database connection failed: ". $conn->connect_error);
}

echo"Database connected successfully!";

$sqlquery = "INSERT INTO invoice (name, email, password, productname, productprice, productquantity, productgst, isMember, subtotal,subtotaldiscount, discountrate, discountamount, taxamount, finaltotal, deliverycharge) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $conn->prepare($sqlquery);
$stmt->bind_param("ssssdiisddidddd",$name, $email,$password,$productname,$productprice,$productquantity,$productGST,$ismember,$subtotal,$finalsubtotal,$discount,$discountamount,$taxamount,$sellingprice,$deliverycharge);

if ($stmt->execute()) {
    echo "User inserted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$dataquery = "SELECT name, email, password, productname, productprice, productquantity, productgst, isMember, subtotal,subtotaldiscount, discountrate, discountamount, taxamount, finaltotal, deliverycharge FROM invoice";

$invoicepanel = $conn->query($dataquery);

while($invoice = $invoicepanel->fetch_assoc()){
    $formatinprice = number_format($invoice['productprice']);
    $formatinsubtotal = number_format($invoice['subtotal']);
    $formatindiscountamount = number_format($invoice['discountamount']);
    $formatinsubtototaldiscount = number_format($invoice['subtotaldiscount']);
    $formatintaxamount = number_format($invoice['taxamount']);
    $formatindeliverycharge = number_format($invoice['deliverycharge']);
    $formatinfinaltotal = number_format($invoice['finaltotal']);


     echo "Product: ".htmlspecialchars($invoice['productname']). "<br>";
    echo "Price: ₹". htmlspecialchars($formatinprice). "<br>";
    echo "Quantity: ". htmlspecialchars($invoice['productquantity']). "<br>";
    echo "Subtotal: ₹". htmlspecialchars($formatinsubtotal). "<br>";
    echo "Discount rate: ". htmlspecialchars($invoice['discountrate'])."% <br>";
    echo "Discount amount: ₹". htmlspecialchars($formatindiscountamount)."<br>";
    echo "Amount after discount: ₹". htmlspecialchars($formatinsubtototaldiscount). "<br>";
    echo "GST: (". htmlspecialchars($invoice['productgst']). "%) : ₹". htmlspecialchars($formatintaxamount). "<br>";
    echo "Delivery Charge: ₹". htmlspecialchars($formatindeliverycharge). "<br>";
    echo "Final total: ₹". htmlspecialchars($formatinfinaltotal). "<br>";
}

}


}

// Process 2: - when use Post Method
else if($_SERVER['REQUEST_METHOD']==='POST'){
$name = $_POST['name']; // name variable
$email = $_POST['email']; // email variable
$newpassword = $_POST['password'];
$password = password_hash($newpassword, PASSWORD_DEFAULT); // password variable
$productname = $_POST['productname']; // Product name variable
$productprice = $_POST['productprice']; // Product Price variable
$productquantity = $_POST['productquantity']; // Product Quantity variable
$productGST = $_POST['productGST']; // Product GST variable
$ismember = $_POST['ismember']; // password variable

if($name === '' || $email === '' || $password === '' || $productname === '' || $productprice === '' || $productquantity === '' || $productGST === '' || $ismember === ''){
    echo "Please fill required field";
}else if(strlen($name) < 3){
    echo "Invalid Name";
}else if(strlen($name) >=12 ){
    echo "Name exceed about 12 character";
}else if(strlen($productname) < 3){
    echo "Invalid Product Name";
}else if(strlen($productname) >=30 ){
    echo "Product Name exceed about 30 character";
}else if($productprice <= 0 || $productquantity <= 0){
    echo "Invalid Price and Quantity";
}else{

// Apply Invoice Calculation
if($productquantity <= 5){
    $discount = 0;
}else if($productquantity >=6 && $productquantity <=10 ){
    $discount = 10;
}else if($productquantity > 10){
    $discount = 15;
}

if($ismember === "Member"){
    $discount = $discount + 5;
}else{
    $discount = $discount;
}

$subtotal = $productquantity * $productprice;
$discountamount = ($subtotal * $discount)/100;
$finalsubtotal = $subtotal - $discountamount;
$taxamount = ($finalsubtotal * $productGST)/100;
$finalaftertax = $finalsubtotal - $taxamount;

if($finalsubtotal >= 100000){
    $deliverycharge = 0;
}else{
    $deliverycharge = 1200;
}

$sellingprice = $finalsubtotal + $taxamount + $deliverycharge;

// establish database connection
$conn = new mysqli("localhost","practice","1234","practice_code");

if($conn->connect_error){
    die("Database connection failed: ". $conn->connect_error);
}

echo"Database connected successfully!";

$sqlquery = "INSERT INTO invoice (name, email, password, productname, productprice, productquantity, productgst, isMember, subtotal,subtotaldiscount, discountrate, discountamount, taxamount, finaltotal, deliverycharge) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $conn->prepare($sqlquery);
$stmt->bind_param("ssssdiisddidddd",$name, $email,$password,$productname,$productprice,$productquantity,$productGST,$ismember,$subtotal,$finalsubtotal,$discount,$discountamount,$taxamount,$sellingprice,$deliverycharge);

if ($stmt->execute()) {
    echo "User inserted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$dataquery = "SELECT name, email, password, productname, productprice, productquantity, productgst, isMember, subtotal,subtotaldiscount, discountrate, discountamount, taxamount, finaltotal, deliverycharge FROM invoice";

$invoicepanel = $conn->query($dataquery);

while($invoice = $invoicepanel->fetch_assoc()){
    $formatinprice = number_format($invoice['productprice']);
    $formatinsubtotal = number_format($invoice['subtotal']);
    $formatindiscountamount = number_format($invoice['discountamount']);
    $formatinsubtototaldiscount = number_format($invoice['subtotaldiscount']);
    $formatintaxamount = number_format($invoice['taxamount']);
    $formatindeliverycharge = number_format($invoice['deliverycharge']);
    $formatinfinaltotal = number_format($invoice['finaltotal']);


    echo "Product: ".htmlspecialchars($invoice['productname']). "<br>";
    echo "Price: ₹". htmlspecialchars($formatinprice). "<br>";
    echo "Quantity: ". htmlspecialchars($invoice['productquantity']). "<br>";
    echo "Subtotal: ₹". htmlspecialchars($formatinsubtotal). "<br>";
    echo "Discount rate: ". htmlspecialchars($invoice['discountrate'])."% <br>";
    echo "Discount amount: ₹". htmlspecialchars($formatindiscountamount)."<br>";
    echo "Amount after discount: ₹". htmlspecialchars($formatinsubtototaldiscount). "<br>";
    echo "GST: (". htmlspecialchars($invoice['productgst']). "%) : ₹". htmlspecialchars($formatintaxamount). "<br>";
    echo "Delivery Charge: ₹". htmlspecialchars($formatindeliverycharge). "<br>";
    echo "Final total: ₹". htmlspecialchars($formatinfinaltotal). "<br>";
}

}


}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>H</title>
  </head>
  <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1>Day 4 Invoice Report Panel</h1>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <form method="GET" action="day4.php">
                        <div class="form-control">
                            <label for="name">
                             Full Name
                            </label>
                            <input type="text" name="name" id="name" value="" placeholder="Please enter your complete name" required>
                        </div>
                        <div class="form-control">
                            <label for="email">
                            Email Address
                            </label>
                            <input type="email" name="email" id="email" value="" placeholder="Please enter your valid email" required>
                        </div>
                        <div class="form-control">
                            <label for="productname">
                             Product Name
                            </label>
                            <input type="text" name="productname" id="productname" value="" placeholder="Please enter your Product name" required>
                        </div>
                        <div class="form-control">
                            <label for="productprice">
                             Price
                            </label>
                            <input type="number" name="productprice" id="productprice" value="" placeholder="Please enter your Product Price" required>
                        </div>
                        <div class="form-control">
                            <label for="productquantity">
                             Quantity
                            </label>
                            <select name="productquantity" id="productquantity">
                                <option value="">Select Quantity</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <label for="productGST">
                             GST
                            </label>
                            <div class="d-flex">
                                <input type="radio" name="productGST" id="productGST12" value="12"  required>12%
                                <input type="radio" name="productGST" id="productGST18" value="18"  required>18%
                            </div>
                        </div>
                        <div class="form-control">
                            <label for="member">
                             Subscribtion
                            </label>
                            <select name="ismember" id="member">
                                <option value="">Select Subscribtion</option>
                                <option value="Member">Member</option>
                                <option value="Non Member">Non Member</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <button type="submit">Generate Invoice</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1>Day 4 Invoice Report Panel</h1>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                     <form method="POST" action="day4.php">
                        <div class="form-control">
                            <label for="pname">
                             Full Name
                            </label>
                            <input type="text" name="name" id="pname" value="" placeholder="Please enter your complete name" required>
                        </div>
                        <div class="form-control">
                            <label for="pemail">
                            Email Address
                            </label>
                            <input type="email" name="email" id="pemail" value="" placeholder="Please enter your valid email" required>
                        </div>
                        <div class="form-control">
                            <label for="ppassword">
                             Password
                            </label>
                            <input type="password" name="password" id="ppassword" value="" placeholder="Please enter your password here" required>
                        </div>
                        <div class="form-control">
                            <label for="pproductname">
                             Product Name
                            </label>
                            <input type="text" name="productname" id="pproductname" value="" placeholder="Please enter your Product name" required>
                        </div>
                        <div class="form-control">
                            <label for="pproductprice">
                             Price
                            </label>
                            <input type="number" name="productprice" id="pproductprice" value="" placeholder="Please enter your Product Price" required>
                        </div>
                        <div class="form-control">
                            <label for="pproductquantity">
                             Quantity
                            </label>
                            <select name="productquantity" id="pproductquantity">
                                <option value="">Select Quantity</option>
                                 <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <label for="productGST">
                             GST
                            </label>
                            <div class="d-flex">
                                <input type="radio" name="productGST" id="pproductGST12" value="12"  required>12%
                                <input type="radio" name="productGST" id="pproductGST18" value="18"  required>18%
                            </div>
                        </div>
                        <div class="form-control">
                            <label for="pmember">
                             Subscribtion
                            </label>
                            <select name="ismember" id="pmember">
                                <option value="">Select Subscribtion</option>
                                <option value="Member">Member</option>
                                <option value="Non Member">Non Member</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <button type="submit">Generate Invoice</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
  </body>
</html>