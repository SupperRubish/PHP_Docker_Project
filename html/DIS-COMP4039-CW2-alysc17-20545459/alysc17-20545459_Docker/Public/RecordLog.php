
<html>
    <style>
        body{
            display: flex;
            justify-content: center; /*在容器中央对齐弹性项目*/
            align-items: center;
        }
        .a{
            width: 1200px;
            height: 500px;
            
            justify-content: center; /*在容器中央对齐弹性项目*/
            align-items: center;
            overflow: scroll;
        }
        .back{
            height: 100px;
            width: 100px;
        }
        </style>
    <body style="background-image: url(../images/3.jpg)">

    <button class="back" onclick="javascrtpt:window.location.href='./login.php'">Back</button>

<div class='a'>

    <form method="post">Username: <input type="text" name="data" ><input class="select" type="submit" name="select" value="SELECT"></form>
    <form method="post"><input class="select" type="submit" name="all" value="SELECTALL"></form>
<table border='1' width='800' align='center'>
<tr><th>Log_ID</th><th>Username</th><th>Page</th><th>Action</th><th>Time</th></tr>

<?php
require("../config/db.inc.php");

if(isset($_POST['truncate'])){
    echo "<script>alert('select successful')</script>";
    $sql7="truncate table Log";
    $result7 = mysqli_query($conn, $sql7);
    echo "<script>alert('delete table successful')</script>";
}
if(isset($_POST['select'])){
    if(empty($_POST['data'])){
        echo "<script>alert('Do not let the input empty!')</script>";
    }
    else{
        echo "<script>alert('select successful')</script>";
        $data = $_POST['data'];
        $sql1="select * from Log where Username= '$data'";
        $result1 = mysqli_query($conn, $sql1);
        while ($row = mysqli_fetch_assoc($result1)){
            echo "<tr>";
            echo "<td>".$row['Log_ID']."</td>";
            echo "<td>".$row['Username']."</td>";
            echo "<td>".$row['Page']."</td>";
            echo "<td>".$row['Action']."</td>";
            echo "<td>".$row['Time']."</td>";

            echo "</tr>";
        }
    }

}
else{
    $sql1="select * from Log";
    $result1 = mysqli_query($conn, $sql1);
    while ($row = mysqli_fetch_assoc($result1)){
        echo "<tr>";
        echo "<td>".$row['Log_ID']."</td>";
        echo "<td>".$row['Username']."</td>";
        echo "<td>".$row['Page']."</td>";
        echo "<td>".$row['Action']."</td>";
        echo "<td>".$row['Time']."</td>";

        echo "</tr>";
    }
}




?>
</table> 
</div>
    <form method="post"><input class="back" type="submit" name="truncate" value="delete"></form>







    </body>
</html>

