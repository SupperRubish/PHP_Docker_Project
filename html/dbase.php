<?php
//连接的服务器地址
//$db_host="localhost";
////连接数据库的用户名
//$db_user="root";
////连接数据库的密码
//$db_psw="admin123";
////连接的数据库名称
//$db_name="douban";
//
//$mysqli=new mysqli();
//$mysqli->connect($db_host,$db_user,$db_psw,$db_name);

//也可以这样：
//$mysqli->connect($db_host,$db_user,$db_psw);
//$mysqli->select_db($db_name);

$mysql_server="localhost";
$mysql_username="root";
$mysql_password="admin123";
$mysql_database="newdata_schema";

$db=new mysqli($mysql_server,$mysql_username,$mysql_password,$mysql_database);
if(mysqli_connect_error()){
    echo 'Could not connect to database.';
    exit;
}
// $pwd="139";

$result=$db->query("select * from user");

foreach($result as $value){

   echo "{$value['name']} br";
   }
// while ($row = mysqli_fetch_assoc($result)) {
//    echo "Name: " . $row["name"] . " - ID: " . $row["id"] . "<br>";
// }







?>
