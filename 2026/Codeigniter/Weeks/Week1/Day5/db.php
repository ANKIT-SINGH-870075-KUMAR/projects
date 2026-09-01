<!-- Write your database connection code here -->
 <?php
 $host = "localhost";
 $username = "practice";
 $password = "1234";
 $database = "practice_code";

 $conn = mysqli_connect($host, $username, $password, $database);
 if(!$conn){die("Connection failed: " . mysqli_connect_error());}
 ?>