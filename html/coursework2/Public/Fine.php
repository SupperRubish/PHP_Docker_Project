<?php
ob_start(); // start output buffering
session_start();
require '../config/vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$logger = new Logger('my_logger');
?>
<html>
<style>
            body{
            display: flex;
            justify-content: center; /*在容器中央对齐弹性项目*/
            align-items: center;
        }
        div{
            width: 100%;
            height: 1200px;
            /* background-color: red; */
            justify-content: center; /*在容器中央对齐弹性项目*/
            align-items: center;
            overflow: scroll;
        }
            .back{
                height: 100px;
                width: 100px;
            }
            /* Tables */
            table {
                border: 1px solid var(--color-bg-secondary);
                border-radius: var(--border-radius);
                border-spacing: 0;
                display: inline-block;
                width: 100%;
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

<?php
    

$Page="Fine.php";
    require("../config/db.inc.php");

if($_SESSION['identify']!=1){
    echo "<script>alert('You don't have permission')</script>";
    echo "<script>location.href='./login.php'</script>";
    exit;
}




$sql1="select *,Offence.Offence_maxFine, Offence.Offence_maxPoints from Incident join Offence on Incident.Offence_ID = Offence.Offence_ID where Incident_ID not in (select Incident_ID from Fines)";
$result1 = mysqli_query($conn, $sql1);
echo "<div>";
echo "<table border='1' width='1000' align='center'>";  // start table

echo "<tr><th>Incident_ID</th><th>Vehicle_licence</th><th>People_licence</th><th>People_name</th><th>Incident_Report</th><th>Offence_ID</th><th>Offence_maxFine</th><th>Offence_maxPoints</th><th>Fines</th></tr>"; // table header
while ($row = mysqli_fetch_assoc($result1)){
    echo "<form method='post'>";
    $Inid = $row['Incident_ID'];
    $v_id= $row['Vehicle_ID'];
    $p_id= $row['People_ID'];
    $sql2="select * from People where People_ID = '$p_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2= mysqli_fetch_assoc($result2);

    $sql3="select * from Vehicle where Vehicle_ID = '$v_id'";
    $result3 = mysqli_query($conn, $sql3);
    $row3= mysqli_fetch_assoc($result3);

    echo "<tr>";
    echo "<td>".$row['Incident_ID']."</td>"; 
    echo "<td>".$row3['Vehicle_licence']."</td>";
    echo "<td>".$row2['People_licence']."</td>";
    echo "<td>".$row2['People_name']."</td>";
    echo "<td>".$row['Incident_Report']."</td>";
    echo "<td>".$row['Offence_ID']."</td>";
    echo "<td>".$row['Offence_maxFine']."</td>";
    echo "<td>".$row['Offence_maxPoints']."</td>";
    echo "<td>"."Money: <input name='money' type='text'><br>";
    echo "Point: <select name='point'>";
    $i=1;
    while($i!=13){
        echo "<option>";
        echo $i;
        echo "</option>";
        $i++;
    }
    echo "</select>";
    echo "<input name='id' type='text' value='$Inid' style='display:none'><input name='fine' type='submit'>"."</td>";

    echo "</tr>";
    echo "</form>";
}
echo "</table>"; 
echo "</div>";
if(isset($_POST['fine'])){
    if(empty($_POST['money'])||empty($_POST['point'])){
        echo "<h3>Don't let input empty!</h3>";
    }
    else{
        $Money =  $_POST['money'];
        $Incident_ID =  $_POST['id'];
        $Point =  $_POST['point'];



//        $sql="select * from Fines order by Fine_ID DESC LIMIT 1";
//        $result = mysqli_query($conn,$sql);
//        $row = mysqli_fetch_assoc($result);
//        $Fine_ID = $row['Fine_ID']+1;


        $sql1="INSERT INTO Fines (Fine_Amount,Fine_Points,Incident_ID) VALUES ($Money,$Point,$Incident_ID);";
        $result1 = mysqli_query($conn,$sql1);
        if($result1==1){
            $Username = $_SESSION['username'];
            $UID=$_SESSION['userid'];
            $currentDateTime = date("Y-m-d H:i:s");
            $sql5="INSERT INTO Log (Username,U_ID,Page,Action,Time) VALUES ('$Username','$UID','$Page','Add fine for Incident_ID= $Incident_ID','$currentDateTime' );";
            $result5 = mysqli_query($conn, $sql5);
            $logFile = '../Log/file.log';
            $handler = new StreamHandler($logFile, Logger::DEBUG);
            $logger->pushHandler($handler);
            $logger->info('Submit Fine in Fine.php', array('username' => $Username));

            echo '<h1 style="color: green;">Adding successful</h1>';
            echo "<script>alert('Submit successful')</script>";

        }
        echo "<script>location.href='/coursework2/Public/Fine.php'</script>";
    }

}

?>


</body>
</html>