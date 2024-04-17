<?php
    ob_start(); // start output buffering
    session_start();
?>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="../css/addNewCar.css">
    </head>
    <style>
        body{
    display: flex;
    justify-content: center; /*在容器中央对齐弹性项目*/
    align-items: center;
    background-image:url(../images/3.jpg);
}
        .People-Car{
            justify-content: center; /*在容器中央对齐弹性项目*/
            align-items: center;
            overflow: scroll;
        }
    </style>
    <body style="background-image: url(../images/3.jpg)">

    <script>
        // A JavaScript function to confirm delete
        function Delete(ID) 
        {
           var conf = confirm("Are you sure?"); 
           if (conf == true) // if OK pressed
           {
              del="?delete="+ID; // add del parameter to URL
              this.document.location.href=del; // reload document
           }
        }
        
        function hidden(){
            document.getElementById("f").style.display = "none";
            document.getElementById("p").style.display = "none";
        }
    </script>



    <form id="f" method="post" class="add-box">
        <h4>Add New Car</h4>
        <!-- Vehicle_ID: <input class="text" name="Vehicle_ID"> -->
        <label style="color: white">Vehicle_type</label>: <input class="text" name="Vehicle_type">
        <label style="color: white">Vehicle_colour</label>: <input class="text" name="Vehicle_colour">
        <label style="color: white">Vehicle_licence</label>: <input class="text" name=" Vehicle_licence">
        <label style="color: white">People_licence</label>: <input class="text" name=" People_licence"><br>
        <input class="button" name="check" type="submit" value="CHECK">
    </form>
    <div class="People-Car" id="p" style="width: 600px;height: 600px">
        <?php
        require("../config/db.inc.php");
        $sql="SELECT People_name,People_licence,Vehicle_licence FROM People a JOIN Ownership b on a.People_ID=b.People_ID JOIN Vehicle c  ON b.Vehicle_ID = c.Vehicle_ID order by People_name";
        $result = mysqli_query($conn,$sql);
        echo "<table border='1' width='800' align='center'>";  // start table
        echo "<tr><th>People_name</th><th>People_licence</th><th>Vehicle_licence</th></tr>"; // table header
        while ($row = mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>".$row['People_name']."</td>";
            echo "<td>".$row['People_licence']."</td>";
            echo "<td>".$row['Vehicle_licence']."</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </div>

    <button class="back" onclick="javascrtpt:window.location.href='./login.php'">Back</button>

    <?php

        require("../config/db.inc.php");

        if(!$_SESSION['islogin']==1){
            echo "<script>alert('Please login first!')</script>";
            echo "<script>location.href='./login.php'</script>";
            exit;
        }
        $Page="addNewCar.php";

        if(isset($_POST['check'])){
            if(empty($_POST['Vehicle_type'])||empty($_POST['Vehicle_colour'])||empty($_POST['Vehicle_licence'])||empty($_POST['People_licence'])){
                echo "<script>alert('Do not let input empty')</script>";
            }
            else{
                // $_SESSION['Vehicle_ID']=$_POST['Vehicle_ID'];
                $_SESSION['Vehicle_type']=$_POST['Vehicle_type'];
                $_SESSION['Vehicle_colour']=$_POST['Vehicle_colour'];
                $_SESSION['Vehicle_licence']=$_POST['Vehicle_licence'];
                $_SESSION['People_licence'] = $_POST['People_licence'];
                $pld = $_POST['People_licence'];
                $sql="select * from People where People_licence = '$pld'";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                if($num>0){

                    // $Vehicle_ID=$_SESSION['VehicleID'];
                    $Vehicle_type=$_SESSION['Vehicle_type'];
                    $Vehicle_colour=$_SESSION['Vehicle_colour'];
                    $Vehicle_licence=$_SESSION['Vehicle_licence'];
                    $People_licence=$_SESSION['People_licence'];
                    $sql="select * from Vehicle where Vehicle_licence='$Vehicle_licence'";
                    $result = mysqli_query($conn,$sql);
                    $num = mysqli_num_rows($result);
                    if($num>0){
                        echo "<script>alert('This license plate already exists')</script>";
                    }
                    else{
                        echo "<br>";
                        echo 'This people is in database, Please click "ADDCAR" to confirm the addition.';
                        echo "<br>";
                        echo "Vehicle_type: $Vehicle_type <br> Vehicle_colour: $Vehicle_colour <br>  Vehicle_licence: $Vehicle_licence <br>  People_licence: $People_licence";
                        echo "<br>";
                        echo '<form method="post"><input class="button" name="ADDCAR" type="submit" value="ADDCAR"></form>';

                    }


                }
                else{
                    $Vehicle_type=$_SESSION['Vehicle_type'];
                    $Vehicle_colour=$_SESSION['Vehicle_colour'];
                    $Vehicle_licence=$_SESSION['Vehicle_licence'];
                    $People_licence=$_SESSION['People_licence'];
                    echo "<br>";
                    echo '<script>hidden();</script>';
                    echo "<h3 style='color: red'>Sorry, This person is not in the database, you should provide some information about this person, then this Vehicle information can add successfully</h3>";
                    echo "<br><br>";
                    echo "Vehicle_type: $Vehicle_type <br> Vehicle_colour: $Vehicle_colour <br>  Vehicle_licence: $Vehicle_licence <br>  People_licence: $People_licence";
                    echo "<br>";
                    echo ' <form method="post" class="add-box">
                Name: <input class="text" name="Name">
                Address: <input class="text" name="Address">
                LicenseNumber: <input class="text" name="LicenseNumber"><br>
                <input class="button" name="ADDALL" type="submit" value="ADDALL">
            </form>';
                }
            }
        }

        if(isset($_POST['ADDCAR'])){
            $Vehicle_type=$_SESSION['Vehicle_type'];
            $Vehicle_colour=$_SESSION['Vehicle_colour'];
            $Vehicle_licence=$_SESSION['Vehicle_licence'];
            $People_licence=$_SESSION['People_licence'];
            $sql1="select Vehicle_ID from Vehicle order by Vehicle_ID DESC LIMIT 1 ";
            $result1 = mysqli_query($conn, $sql1);
            $row1=mysqli_fetch_assoc($result1);


            $sql2="INSERT INTO Vehicle (Vehicle_type,Vehicle_colour,Vehicle_licence) VALUES ('$Vehicle_type','$Vehicle_colour','$Vehicle_licence');";
            $result2 = mysqli_query($conn, $sql2);
            $VehicleID= mysqli_insert_id($conn);

            $sql3="select People_ID from People where People_licence='$People_licence';";
            $result3 = mysqli_query($conn, $sql3);
            $row3=mysqli_fetch_assoc($result3);
            $People_ID=$row3['People_ID'];

            $sql4="INSERT INTO Ownership (Vehicle_ID,People_ID) VALUES ('$VehicleID',$People_ID);";
            $result4 = mysqli_query($conn, $sql4);

            if($result2==1&&$result4==1){
                echo "<h1 style='color: green;'>Adding successful</h1>";
                $Username = $_SESSION['username'];
                $currentDateTime = date("Y-m-d H:i:s");
                $sql5="INSERT INTO Log (Username,Page,Action,Time) VALUES ('$Username','$Page','Add new car $Vehicle_licence for $People_licence','$currentDateTime');";
                $result5 = mysqli_query($conn, $sql5);
                // exit;
            }
            else{
                echo "Failure";
                
            }
        }
        if(isset($_POST['ADDALL'])){
            if(empty($_POST['Name'])||empty($_POST['Address'])||empty($_POST['LicenseNumber'])){
                echo "<h3 style='color: red'>Do not let input empty, try again! </h3>";
            }
            else{
                $Vehicle_type=$_SESSION['Vehicle_type'];
                $Vehicle_colour=$_SESSION['Vehicle_colour'];
                $Vehicle_licence=$_SESSION['Vehicle_licence'];
                $People_licence=$_SESSION['People_licence'];

                $Name = $_POST['Name'];
                $Address = $_POST['Address'];
                $LicenseNumber = $_POST['LicenseNumber'];


//                $sql1 = "select People_ID from People order by People_ID DESC LIMIT 1";
//                $result1 = mysqli_query($conn, $sql1);
//                $row = mysqli_fetch_assoc($result1);
//                $id = $row['People_ID']+1;
                $sql2 ="INSERT INTO People (People_name,People_address,People_licence) VALUES ('$Name','$Address','$LicenseNumber');";
                try{
                    $result2 = mysqli_query($conn, $sql2);
                    $people_id = mysqli_insert_id($conn);
                    if($result2==1){
                        echo "Person add successfully";
                        echo "<br>";
                        echo "'$Vehicle_licence' is '$Name''s car , in process of adding...";

                        $sql4="INSERT INTO Vehicle (Vehicle_type,Vehicle_colour,Vehicle_licence) VALUES ('$Vehicle_type','$Vehicle_colour','$Vehicle_licence');";
                        $result4 = mysqli_query($conn, $sql4);
                        $vehicle_id = mysqli_insert_id($conn);

                        $sql5="INSERT INTO Ownership (Vehicle_ID,People_ID) VALUES ('$vehicle_id','$people_id');";
                        $result5 = mysqli_query($conn, $sql5);
                        if($result4==1&&$result5==1){
                            echo '<h1 style="color: green;">Adding successful</h1>';
                            $Username = $_SESSION['username'];
                            $currentDateTime = date("Y-m-d H:i:s");
                            $sql5="INSERT INTO Log (Username,Page,Action,Time) VALUES ('$Username','$Page','Add new car $Vehicle_licence for $People_licence','$currentDateTime');";
                            $result5 = mysqli_query($conn, $sql5);
                        }
                    }
                }catch (Exception $e){
                    echo '<h1 style="color: red;">Adding false</h1>';
                }
            }


        }
        


    ?>







    </body>
</html>