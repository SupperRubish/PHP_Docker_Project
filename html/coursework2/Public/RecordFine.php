<?php

ob_start(); // start output buffering
session_start();
require '../config/vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$logger = new Logger('my_logger');

$Page = "RecordFine.php";
if(!$_SESSION['islogin']==1){
            
    echo "<script>alert('Please login first!')</script>";
    echo "<script>location.href='./login.php'</script>";
    
    exit;
}


require("../config/db.inc.php");

$sql = "SELECT * FROM Offence;";
$result = mysqli_query($conn, $sql);

echo "<form class='fine-box' method='post'>";
echo "<h4>RecordIncident</h4>";
echo ' Vehicle_licence: <input class="text" name="Vehicle_licence">';
echo ' People_licence: <input class="text" name="People_licence">';

echo 'Date: <input type="date" class="text" name="time">';
echo 'Incident_Report: <input class="text" name="Incident_Report">';

echo "Offences: <select class='text' name='offences'>";
while($row=mysqli_fetch_assoc($result)){
    $description=$row['Offence_description'];
    $fID = $row['Offence_ID'];
    
    echo "<option value='$fID'>$description</option>";

}

echo '<input class="button" name="fine" type="submit" value="Record">';
echo "</select>";
echo "</form>";



if(isset($_POST['fine'])){
    if(empty($_POST['Vehicle_licence'])||empty($_POST['People_licence'])||empty($_POST['time'])||empty($_POST['offences'])||empty($_POST['Incident_Report'])){
        echo "<script>alert('Do not let input empty')</script>";

    }
    else{
        $Vehicle_licence= $_POST['Vehicle_licence'];
        $People_licence = $_POST['People_licence'];
        $Time = $_POST['time'];
        $OffencID = $_POST['offences'];
        $Incident_Report = $_POST['Incident_Report'];

        $sql1 = "SELECT * FROM People where People_licence='$People_licence'";
        $result1 = mysqli_query($conn, $sql1);
        $row1=mysqli_fetch_assoc($result1);
        $pid = $row1['People_ID'];
        $sql2 = "SELECT * FROM Vehicle where Vehicle_licence='$Vehicle_licence'";
        $result2 = mysqli_query($conn, $sql2);
        $row2=mysqli_fetch_assoc($result2);
        $vid = $row2['Vehicle_ID'];


        if(mysqli_num_rows($result1)==0 || mysqli_num_rows($result2)==0){
            echo "<script>alert('Please add new car or people firstly! Moving to AddNewCar Page New!')</script>";
            echo "<script>location.href='./addNewCar.php'</script>";
        }
//        $sql5 = "SELECT * FROM Incident order by Incident_ID DESC LIMIT 1";
//        $result5 = mysqli_query($conn, $sql5);
//        $row5=mysqli_fetch_assoc($result5);
//        $Incident_ID = $row5['Incident_ID']+1;

        $sql6="INSERT INTO Incident (Vehicle_ID,People_ID,Incident_date,Incident_Report,Offence_ID ) VALUES ($vid,'$pid','$Time','$Incident_Report',$OffencID);";
        $result6 = mysqli_query($conn,$sql6);
        if($result6==1){
            $Username = $_SESSION['username'];
            $UID=$_SESSION['userid'];
            $currentDateTime = date("Y-m-d H:i:s");
            $sql5="INSERT INTO Log (Username,U_ID,Page,Action,Time) VALUES ('$Username','$UID','$Page','Provide Fine and Point for people','$currentDateTime');";
            $result5 = mysqli_query($conn, $sql5);
            $logFile = '../Log/file.log';
            $handler = new StreamHandler($logFile, Logger::DEBUG);
            $logger->pushHandler($handler);
            $logger->info('Record accident in RecordFine.php', array('username' => $Username));
            echo " Vehicle_ID: $vid '<br>' People_ID: '$pid' '<br>' Time: '$Time' '<br>' Incident_Report: '$Incident_Report''<br>' OffencID: $OffencID";
            echo '<h1 style="color: green;">Adding fine successful</h1>';

        }
        else{
            echo '<h1 style="color: red;">Adding fine failed</h1>';

        }
    }

}
if(isset($_POST['select'])){
    $data = $_POST['n'];
    $sql1 = "select Offence_description,Incident.*,People.People_name,People.People_licence, Vehicle.Vehicle_licence, Fines.Fine_Amount,Fines.Fine_Points from Incident join People on Incident.People_ID=People.People_ID JOIN Vehicle on Vehicle.Vehicle_ID = Incident.Vehicle_ID left JOIN  Fines on  Fines.Incident_ID = Incident.Incident_ID join Offence on Offence.Offence_ID=Incident.Offence_ID where People.People_licence = '$data'";
    $result1=mysqli_query($conn,$sql1);
    $sql2 = "select Offence_description,Incident.*,People.People_name,People.People_licence, Vehicle.Vehicle_licence, Fines.Fine_Amount,Fines.Fine_Points from Incident join People on Incident.People_ID=People.People_ID JOIN Vehicle on Vehicle.Vehicle_ID = Incident.Vehicle_ID left JOIN  Fines on  Fines.Incident_ID = Incident.Incident_ID join Offence on Offence.Offence_ID=Incident.Offence_ID where Vehicle.Vehicle_licence = '$data'";
    $result2=mysqli_query($conn,$sql2);
    $num1 = mysqli_num_rows($result1);
    $num2 = mysqli_num_rows($result2);
    if(mysqli_num_rows($result1)>0){
        echo "<div class='a'>
        <table border='1' width='800' align='center'>
<tr><th>People_name</th><th>People_licence</th><th>Vehicle_licence</th><th>Vehicle_Date</th><th>Incident_Report</th><th>Offence_description</th><th>Incident_ID</th><th>Fine_Amount</th><th>Fine_Points</th></tr>";

        while ($row = mysqli_fetch_assoc($result1)){
            echo "<tr>";
            echo "<td>".$row['People_name']."</td>";
            echo "<td>".$row['People_licence']."</td>";
            echo "<td>".$row['Vehicle_licence']."</td>";
            echo "<td>".$row['Incident_Date']."</td>";
            echo "<td>".$row['Incident_Report']."</td>";
            echo "<td>".$row['Offence_description']."</td>";
            echo "<td>".$row['Incident_ID']."</td>";
            echo "<td>".$row['Fine_Amount']."</td>";
            echo "<td>".$row['Fine_Points']."</td>";

            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }
    if(mysqli_num_rows($result2)>0){
        echo "<div class='a'>
        <table border='1' width='800' align='center'>
        <tr><th>People_name</th><th>People_licence</th><th>Vehicle_licence</th><th>Incident_ID</th><th>Fine_Amount</th><th>Fine_Points</th></tr>";
        
        while ($row = mysqli_fetch_assoc($result2)){
            echo "<tr>";
            echo "<td>".$row['People_name']."</td>"; 
            echo "<td>".$row['People_licence']."</td>";
            echo "<td>".$row['Vehicle_licence']."</td>"; 
            echo "<td>".$row['Incident_ID']."</td>";
            echo "<td>".$row['Fine_Amount']."</td>";
            echo "<td>".$row['Fine_Points']."</td>";
        
            echo "</tr>";
        }
        echo "</table>"; 
        echo "</div>";
    }
    if($num1==0&&$num2==0){
        echo "<script>alert('No information')</script>";
    }
}
if(isset($_POST['selectall'])){
    $sql = "select Offence_description,Incident.*,People.People_name,People.People_licence, Vehicle.Vehicle_licence, Fines.Fine_Amount,Fines.Fine_Points from Incident join People on Incident.People_ID=People.People_ID JOIN Vehicle on Vehicle.Vehicle_ID = Incident.Vehicle_ID left JOIN  Fines on  Fines.Incident_ID = Incident.Incident_ID join Offence on Offence.Offence_ID=Incident.Offence_ID";
    $result=mysqli_query($conn,$sql);
    echo "<div class='a'>
<table border='1' width='800' align='center'>
<tr><th>People_name</th><th>People_licence</th><th>Vehicle_licence</th><th>Vehicle_Date</th><th>Incident_Report</th><th>Offence_description</th><th>Incident_ID</th><th>Fine_Amount</th><th>Fine_Points</th></tr>";

    while ($row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>".$row['People_name']."</td>";
        echo "<td>".$row['People_licence']."</td>";
        echo "<td>".$row['Vehicle_licence']."</td>";
        echo "<td>".$row['Incident_Date']."</td>";
        echo "<td>".$row['Incident_Report']."</td>";
        echo "<td>".$row['Offence_description']."</td>";
        echo "<td>".$row['Incident_ID']."</td>";
        echo "<td>".$row['Fine_Amount']."</td>";
        echo "<td>".$row['Fine_Points']."</td>";

        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
}

if(isset($_POST['change'])){
    $cid = $_POST['cid'];
    $sql = "SELECT * FROM Incident where Incident_ID='$cid'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
        if($_POST['model']=='People_licence'){
            $People_licence = $_POST['t'];
            $sql1 = "SELECT * FROM People where People_licence='$People_licence'";
            $result1 = mysqli_query($conn, $sql1);
            if(mysqli_num_rows($result1)>0){
                $row1=mysqli_fetch_assoc($result1);
                $userid = $row1['People_ID'];
                $cid = $_POST['cid'];
                $sql1 = "UPDATE Incident SET People_ID='$userid' WHERE Incident_ID='$cid';";
                $result1 = mysqli_query($conn, $sql1);
                echo "<script>alert('change successful ')</script>";
                echo "<script>location.href='/coursework2/Public/RecordFine.php'</script>";
            }
            else{
                echo "<script>alert('This people is no exist! ')</script>";
                echo "<script>location.href='/coursework2/Public/RecordFine.php'</script>";
            }


        }
        if($_POST['model']=='Vehicle_licence'){
            $Vehicle_licence = $_POST['t'];
            $sql1 = "SELECT * FROM Vehicle where Vehicle_licence='$Vehicle_licence'";
            $result1 = mysqli_query($conn, $sql1);
            if(mysqli_num_rows($result1)>0){
                $row1=mysqli_fetch_assoc($result1);
                $Vehicleid = $row1['Vehicle_ID'];
                $cid = $_POST['cid'];
                $sql1 = "UPDATE Incident SET Vehicle_ID='$Vehicleid' WHERE Incident_ID='$cid';";
                $result1 = mysqli_query($conn, $sql1);
                echo "<script>alert('change successful ')</script>";
                echo "<script>location.href='/coursework2/Public/RecordFine.php'</script>";
            }
            else{
                echo "<script>alert('This Vehicle is no exist! ')</script>";
                echo "<script>location.href='/coursework2/Public/RecordFine.php'</script>";
            }
        }
        if($_POST['model']=='Time'){
            $Time = $_POST['t2'];
            $cid = $_POST['cid'];
            $sql1 = "UPDATE Incident SET Incident_Date='$Time' WHERE Incident_ID=$cid;";
            $result1 = mysqli_query($conn, $sql1);
            echo "<script>alert('change successful $Time')</script>";
            echo "<script>location.href='/coursework2/Public/RecordFine.php'</script>";
        }
        if($_POST['model']=='Report'){
            $report = $_POST['t1'];
            $cid = $_POST['cid'];
            $sql1 = "UPDATE Incident SET Incident_Report='$report' WHERE Incident_ID=$cid;";
            $result1 = mysqli_query($conn, $sql1);
            echo "<script>alert('change successful')</script>";
            echo "<script>location.href='/coursework2/Public/RecordFine.php'</script>";
        }
        if($_POST['model']=='Offence'){
            $Offence = $_POST['t3'];
            $cid = $_POST['cid'];
            $sql1 = "UPDATE Incident SET Offence_ID='$Offence' WHERE Incident_ID=$cid;";
            $result1 = mysqli_query($conn, $sql1);
            echo "<script>alert('change successful')</script>";
            echo "<script>location.href='/coursework2/Public/RecordFine.php'</script>";
        }
    }
    else{
        echo "<script>alert('This Incident is no exist! ')</script>";
        echo "<script>location.href='/coursework2/Public/RecordFine.php'</script>";
    }


}


?>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="../css/RecordFine.css">
    </head>
    <style>
        body{
    display: flex;
    justify-content: center; /*在容器中央对齐弹性项目*/
    align-items: center;
}
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
    <form class='box' method='post'>
        People_licence or Vehicle_licence:<input name="n" type="text"><input name="select" type="submit" value="SELECT">
        <input name="selectall" type="submit" value="SELECTALL">
    </form>

    <form class='box2' method='post'>
        Incident ID:<input name="cid" type="text">
        <select id="t"  onchange="changes()" class='text' name='model'>
            <option value='People_licence'>People_licence</option>
            <option value='Vehicle_licence'>Vehicle_licence</option>
            <option value='Time'>Time</option>
            <option value='Report'>Report</option>
            <option value='Offence'>Offence</option>

        </select>
        content:
        <input id="t1" name="t1" type="text" style="display: none">
        <input id="t2" name="t2" type="date" style="display: none">
        <select id="t3"  name='t3' style="display: none">
            <?php
            $sql = "SELECT * FROM Offence;";
            $result = mysqli_query($conn, $sql);
            while($row=mysqli_fetch_assoc($result)){
                $description=$row['Offence_description'];
                $fID = $row['Offence_ID'];

                echo "<option value='$fID'>$description</option>";

            }
            ?>
        </select>
        <input name="change" type="submit" value="Modify">

    </form>
    <script>
        function hiddent1(){
            document.getElementById("t1").style.display = "none";
        }
        function hiddent2(){
            document.getElementById("t2").style.display = "none";
        }
        function hiddent3(){
            document.getElementById("t3").style.display = "none";
        }
        function  blockt1(){
            document.getElementById("t1").style.display = "block";
        }
        function  blockt2(){
            document.getElementById("t2").style.display = "block";
        }
        function  blockt3(){
            document.getElementById("t3").style.display = "block";
        }

        function changes(){
            var myselect=document.getElementById('t');
            var index=myselect.selectedIndex ;
            console.log(myselect.options[index].value);
            if(myselect.options[index].value=="Time"){
                hiddent1();
                hiddent3();
                blockt2();
            }
            if(myselect.options[index].value!="Time" && myselect.options[index].value!="Offence"){
                hiddent2();
                hiddent3();
                blockt1();
            }
            if(myselect.options[index].value=="Offence"){
                hiddent2();
                hiddent1();
                blockt3();
            }
        }

    </script>
    </body>
</html>