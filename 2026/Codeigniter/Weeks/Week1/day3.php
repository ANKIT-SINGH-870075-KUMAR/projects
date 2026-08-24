<?php

// Creating a fruit array
$Fruits = ["Apple","Banana","Grapes","Mango","Orange"];

// foreach loop
foreach($Fruits as $Fruit){
    echo $Fruit . "<br>";
}

// for loop
for($i = 0; $i < count($Fruits); $i++){
    echo $Fruits[$i] . "<br>";
}

$i = 0;
// while loop
while($i < count($Fruits)){
    echo $Fruits[$i] . "<br>";
    $i++;
}

$j = 0;
// do while loop
if(count($Fruits) > 0){
    do {
        echo $Fruits[$j] . "<br>";
        $j++;
    } while($j < count($Fruits));
}

// function to add fruits to the array (Parameterized function)
function addFruit(array $array,string $name): array{
    $array[] = $name;
    return $array;
}

$newFruits = addFruit($Fruits, "Pineapple");

foreach($newFruits as $Fruit){
    echo $Fruit . "<br>";
}

?>