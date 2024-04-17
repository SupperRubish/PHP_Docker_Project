
<html>
    <style>
        body{
            display: flex;
            justify-content: center; /*在容器中央对齐弹性项目*/
align-items: center;
        }
        .a{
            width: 1200px;
            height: 70px;
            background-color: red;
            justify-content: center; /*在容器中央对齐弹性项目*/
            align-items: center;
            overflow: scroll;
        }
        </style>
    <body>

<div class='a'>
<table border='1' width='800' align='center'>
<tr><th>UserID</th><th>Username</th><th>Password</th><th>Identify</th><th>DELETE</th></tr>

        <?php
require("../DIS-COMP4039-CW2-alysc17-20545459/alysc17-20545459_Docker/config/db.inc.php");
$sql1="select * from Users";
$result1 = mysqli_query($conn, $sql1);
while ($row = mysqli_fetch_assoc($result1)){
    echo "<tr>";
    echo "<td>".$row['UserID']."</td>"; 
    echo "<td>".$row['Username']."</td>";
    echo "<td>".$row['Password']."</td>"; 
    echo "<td>".$row['identity']."</td>";
    echo "<td><button onclick=Delete(".$row["UserID"].")>Delete</button></td>";

    echo "</tr>";
}

?>
</table> 
</div>




<input name='money' type='text' style="display:none">






    </body>
</html>

