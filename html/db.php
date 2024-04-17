

<?php
$servername = "mariadb";
$username = "root";
$password = "rootpwd";
$dbname = "Week6test";
// 创建连接
$conn = new mysqli($servername, $username, $password,$dbname);
 
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
echo "连接成功";

$sql = "SELECT * FROM Offences";
$result = $conn->query($sql);
while($row = mysqli_fetch_assoc($result)) {
    echo "id: " . $row["OffenceID"]. " - Name: " . $row["Description"]. "<br>";
}

$conn->close();

?>