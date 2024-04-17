<?php

// MySQL database information       
$servername = "mariadb";
$username = "root";
$password = "rootpwd";
$dbname = "coursework2";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if(mysqli_connect_errno()) 
{
   echo "Failed to connect to MySQL: ".mysqli_connect_error();
   die();
} 
?>