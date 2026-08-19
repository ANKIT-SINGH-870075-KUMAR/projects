<?php

// Creating a fruit array
$fruits = ["Apple","Banana","Grapes","Mango","Orange"];

// Creating an associative array for a days of the week
$days =array(
    1 => "Monday",
    2 => "Tuesday",
    3 => "Wednesday",
    4 => "Thursday",
    5 => "Friday",
    6 => "Saturday",
    7 => "Sunday"
);

// Conditional Statements like if, else if, else
$age = 20;
if ($age >= 18) {
    echo "You are eligible to vote.";
} else if ($age < 18 && $age >= 0) {
    echo "You are not eligible to vote.";
} else {
    echo "Invalid age entered.";
}

// Comparison Operators: ==, ===, !=, !==, <, >, <=, >= and Logical Operators: &&, ||, !
$number1 = 10;
$number2 = 20;
if ($number1 < $number2) {
    echo "{$number1} is less than {$number2}.";
} else if ($number1 > $number2) {
    echo "{$number1} is greater than {$number2}.";
} else {
    echo "{$number1} is equal to {$number2}.";
}

if ($number1 == $number2) {
    echo "{$number1} is equal to {$number2}.";
} else if ($number1 != $number2) {
    echo "{$number1} is not equal to {$number2}.";
}

if ($number1 === $number2) {
    echo "{$number1} is identical to {$number2}.";
} else if ($number1 !== $number2) {
    echo "{$number1} is not identical to {$number2}.";
}

if ($age >= 18 && $age <= 65) {
    echo "You are eligible for employment.";
} else if ($age < 18 || $age > 65) {
    echo "You are not eligible for employment.";
} else {
    echo "Invalid age entered.";
}
?>