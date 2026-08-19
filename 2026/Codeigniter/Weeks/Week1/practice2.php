<!-- 
 
Create a $student associative array containing:

$name
$marks
$attendance
$feesPaid

Determine the result using these rules:

Marks must be between 0 and 100; otherwise print "Invalid marks".
Attendance must be between 0 and 100; otherwise print "Invalid attendance".
The student passes when marks are at least 40 and attendance is at least 75.
If fees are not paid, print "Result withheld due to unpaid fees."
Assign a grade:
90–100: A+
75–89: A
60–74: B
40–59: C
Below 40: Fail
Use if, elseif, else, &&, ||, !, and strict Boolean comparison.
-->

<?php

$student = [
    "name" => "John Doe",
    "marks" => 95,
    "attendance" => 85,
    "feesPaid" => true
];

if($student['marks'] < 0 || $student['marks'] > 100){
    echo "Invalid marks.";
    die(); // Terminate the script if marks are invalid
}else if($student['attendance'] < 0 || $student['attendance'] > 100){
    echo "Invalid attendance.";
    die(); // Terminate the script if attendance is invalid
}else if(!$student['feesPaid']){
    echo "Result withheld due to unpaid fees.";
    die(); // Terminate the script if fees are not paid
}elseif($student['marks'] >= 90 && $student['marks'] <= 100){
     echo "A+ ";
}else if($student['marks'] >= 75 && $student['marks'] <= 89){
    echo "A ";
}else if($student['marks'] >= 60 && $student['marks'] <= 74){
    echo "B ";
}else if($student['marks'] >= 40 && $student['marks'] <= 59){
    echo "C";
}else if($student['marks'] < 40){
    echo "Fail ";
}

if($student['marks'] >=40 && $student['attendance'] >= 75){
    echo "Student has passed.";
} else if($student['marks'] < 40){
    echo "Student has failed.";
} else if($student['attendance'] < 75){
    echo "Student has failed due to low attendance.";
}
?>