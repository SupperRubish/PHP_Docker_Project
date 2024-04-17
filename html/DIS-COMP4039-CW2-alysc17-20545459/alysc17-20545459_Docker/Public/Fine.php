<?php
ob_start(); // start output buffering
session_start();
?>
<html>
<style>
            body{
            display: flex;
            justify-content: center; /*在容器中央对齐弹性项目*/
            align-items: center;
        }
        div{
            width: 1200px;
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

echo "<tr><th>Incident_ID</th><th>Vehicle_ID</th><th>People_ID</th><th>Incident_Report</th><th>Offence_ID</th><th>Offence_maxFine</th><th>Offence_maxPoints</th><th>Fines</th></tr>"; // table header
while ($row = mysqli_fetch_assoc($result1)){
    echo "<form method='post'>";
    $Inid = $row['Incident_ID'];
    echo "<tr>";
    echo "<td>".$row['Incident_ID']."</td>"; 
    echo "<td>".$row['Vehicle_ID']."</td>";
    echo "<td>".$row['People_ID']."</td>";
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
            $currentDateTime = date("Y-m-d H:i:s");
            $sql5="INSERT INTO Log (Username,Page,Action,Time) VALUES ('$Username','$Page','Add fine for Incident_ID= $Incident_ID','$currentDateTime' );";
            $result5 = mysqli_query($conn, $sql5);
            echo '<h1 style="color: green;">Adding successful</h1>';
            echo "<script>alert('Submit successful')</script>";

        }
        echo "<script>location.href='/DIS-COMP4039-CW2-alysc17-20545459/alysc17-20545459_Docker/Public/Fine.php'</script>";
    }

}

?>


</body>
</html>