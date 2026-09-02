<!-- Invoice Processing -->
 <?php
// Function to Process Invoice Data
function processInvoiceData(INT $product_quantity, STRING $subscription, FLOAT $product_price, FLOAT $product_gst): Array {

    //  Provide discount according to Product Quantity and Subscription status
    if($product_quantity <= 5){
        $discountrate = 0;
    }else if($product_quantity >=6 && $product_quantity <= 10){
        $discountrate = 10;
    }else if($product_quantity >= 12){
        $discountrate = 15;
    }

    if($subscription == "Member"){
        $discountrate += 5;
    }else{
        $discountrate += 0;
    }
    
    // Calculate Subtotal, Discount amount, Subtotal After Discount, Tax Amount, Final Total and Delivery Charge
    $subtotal = $product_price * $product_quantity;
    $discountamount = ($subtotal * $discountrate) / 100;
    $subtotaldiscount = $subtotal - $discountamount;

    if($subtotaldiscount > 100000){
        $deliverycharge = 0;
    }else{
        $deliverycharge = 1200;
    }

    $taxamount = ($subtotaldiscount * $product_gst) / 100;
    $finaltotal = $subtotaldiscount + $taxamount + $deliverycharge;

    return Array(
        "subtotal" => $subtotal,
        "subtotaldiscount" => $subtotaldiscount,
        "discountrate" => $discountrate,
        "discountamount" => $discountamount,
        "taxamount" => $taxamount,
        "finaltotal" => $finaltotal,
        "deliverycharge" => $deliverycharge
    );

}


 ?>