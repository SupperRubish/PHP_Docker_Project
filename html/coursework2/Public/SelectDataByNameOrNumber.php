<?php
    ob_start(); // start output buffering
    session_start();
    $Page = "SelectDataByNameOrNumber.php";
require '../config/vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$logger = new Logger('my_logger');
    ?>
<html>
    <head>    <link rel="stylesheet" type="text/css" href="../css/SelectDataByNameOrNumber.css"></head>
<style>
    /* Tables */
    table {
        border: 1px solid var(--color-bg-secondary);
        border-radius: var(--border-radius);
        border-spacing: 0;
        display: inline-block;
        max-width: 120%;
        overflow-x: auto;
        padding: 0;
        white-space: nowrap;
    }

    table td,
    table th,
    table tr {
        padding: 0.8rem 0.8rem;
        text-align: var(--justify-important);
    }

    table thead {
        background-color: var(--color);
        border-collapse: collapse;
        border-radius: var(--border-radius);
        color: var(--color-bg);
        margin: 0;
        padding: 0;
    }

    table thead th:first-child {
        border-top-left-radius: var(--border-radius);
    }

    table thead th:last-child {
        border-top-right-radius: var(--border-radius);
    }

    table thead th:first-child,
    table tr td:first-child {
        text-align: var(--justify-normal);
    }

    table tr:nth-child(even) {
        background-color: var(--color-accent);
    }
</style>
    <body style="background-image: url(../images/3.jpg)">
    <button class="back" onclick="javascrtpt:window.location.href='./login.php'">Back</button>
    <form class="select-box" method="post">

        <h4>Select People</h4>
        <div class="input-box"><label style="color: white">Name or LicenseID</label>: <input  type="text" name="data"></div><br>
        <!-- <li> <label> </label> <input type="checkbox" name="remember" value="yes">7 </li> -->
        <label> </label> <input class="button" type="submit" name="select" value="select"> </li>
        
    </form>

   
    
    
    <?php
    if(!$_SESSION['islogin']==1){
        echo "<script>alert('Please login first!')</script>";
        echo "<script>location.href='./login.php'</script>";
        exit;
    }
    $user=$_SESSION['username'];
//    echo "<script>alert('Welcome $user')</script>";
    require("../config/db.inc.php");


    if (isset($_POST['select'])) {
        if(empty($_POST['data'])){
            echo "<script>alert('Do not let input empty')</script>";
        }
        else{
            $data= trim($_POST['data']);

            $sql = "SELECT * FROM People where People.People_Name like '%$data%' or People.People_licence like '%$data%'";


            // send query to database
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);

            if(!empty($data)){
                if($num>=1){
                    echo "<table border='1' width='800' align='center'>";  // start table
                    echo "<tr><th>PersonID</th><th>Name</th><th>LicenseNumber</th><th>Address</th></tr>"; // table header
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>".$row['People_ID']."</td>";
                        echo "<td>".$row['People_name']."</td>";
                        echo "<td>".$row['People_licence']."</td>";
                        echo "<td>".$row['People_address']."</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    $Username = $_SESSION['username'];
                    $UID=$_SESSION['userid'];
                    echo $_SESSION['userid'];
                    $currentDateTime = date("Y-m-d H:i:s");
                    $sql5="INSERT INTO Log (Username,U_ID,Page,Action,Time) VALUES ('$Username','$UID','$Page','Using name to select People','$currentDateTime');";
                    $result5 = mysqli_query($conn, $sql5);
                    $logFile = '../Log/file.log';
                    $handler = new StreamHandler($logFile, Logger::DEBUG);
                    $logger->pushHandler($handler);
                    $logger->info('Select Data  in SelectDataByNameOrNumber.php', array('username' => $Username));


                }
//                if($num2>=1){
//                    echo "<table border='1' width='800' align='center'>";  // start table
//                    echo "<tr><th>PersonID</th><th>Name</th><th>LicenseNumber</th><th>Address</th></tr>"; // table header
//                    while ($row = mysqli_fetch_assoc($result2)){
//                        echo "<tr>";
//                        echo "<td>".$row['People_ID']."</td>";
//                        echo "<td>".$row['People_name']."</td>";
//                        echo "<td>".$row['People_licence']."</td>";
//                        echo "<td>".$row['People_address']."</td>";
//                        echo "</tr>";
//                    }
//                    echo "</table>";
//                    $Username = $_SESSION['username'];
//                    $currentDateTime = date("Y-m-d H:i:s");
//                    $sql5="INSERT INTO Log (Username,Page,Action,Time) VALUES ('$Username','$Page','Using People licence to select People','$currentDateTime');";
//                    $result5 = mysqli_query($conn, $sql5);
//                }
                if($num==0){
                    echo "<h4 style='color: red'>NULL</h4>";
                }
            }
            else{
                echo "empty!";
            }
        }
        
    }
    
    ?>




    </body>
</html>
