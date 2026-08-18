<?php

$message = "Hello, World!"; //This is a variable that stores a string value

// Associative array containing user information
$userProfile = [
    "name" => "Ajit Kumar",
    "age" => 25,
    "email" =>"ajit@gmail.com",
    "address" => "123 Gali-no 10, Prem Nagar - II, New Delhi - 110086, India",
    "phone number" => "+91-9876543210",
    "Married" => false,
    "education" => array("BCA", "MCA")
];

echo $message; //This will print the value of the variable $message
echo "Good Morning, {$userProfile['name']} and My age is {$userProfile['age']}"; //This is a example of string interpolation in PHP, where we are using the variable $userProfile to access the name and age of the user.


?> <!-- This is a Php tags -->