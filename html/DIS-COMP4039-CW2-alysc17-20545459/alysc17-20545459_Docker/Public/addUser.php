<?php
    ob_start(); // start output buffering
    session_start();
?>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="../css/addUser.css">
    </head>
    <body style="background-image: url(../images/3.jpg)">


    <script>
        //from lab8
        function Delete(ID) 
        {
           var conf = confirm("Are you sure?"); 
           if (conf == true) // if OK pressed
           {
              del="?delete="+ID; // add del parameter to URL
              this.document.location.href=del; // reload document
           }
        } 
    </script>


    <button class="back" onclick="javascrtpt:window.location.href='./login.php'">Back</button>
    <form method="post">
        Username: <input name="username">
        Password: <input name="password">
        <input name="add" type="submit" value="Add">
    </form>

    <button class="back" onclick="javascrtpt:window.location.href='./login.php'">Back</button>

    <?php
        $Page="addUser.php";
        require("../config/db.inc.php");

        if($_SESSION['identify']!=1){
            echo "<script>alert('You don't have permission')</script>";
            echo "<script>location.href='./login.php'</script>";
            exit;
        }

        if(isset($_GET['delete']) && $_GET['delete']!=""){
            $id=$_GET['delete'];
            $sql2 = "DELETE FROM Users WHERE UserID=$id;";
    
            // send query to database
            $result2 = mysqli_query($conn, $sql2);
            if($result2==1){
                echo "<script>alert('Delete user successful')</script>";
                $Username = $_SESSION['username'];
                $currentDateTime = date("Y-m-d H:i:s");
                $sql5="INSERT INTO Log (Username,Page,Action,Time) VALUES ('$Username','$Page','Delete User ID = $id','$currentDateTime');";
                $result5 = mysqli_query($conn, $sql5);
                // exit;
            }
            else{
                echo "Failure";

            }

        }




        if(isset($_POST["add"])){
            if(empty($_POST['username'])||empty($_POST['password'])){
                echo "<script>alert('Do not let input empty')</script>";
            }
            else{
                $u= $_POST["username"];
                $p=$_POST["password"];
                $sql="INSERT INTO Users (Username,Password) VALUES ('$u','$p');";
                $result = mysqli_query($conn, $sql);
                if($result==1){
                    echo "<script>alert('Add new user successful')</script>";
                    $Username = $_SESSION['username'];
                    $currentDateTime = date("Y-m-d H:i:s");
                    $sql5="INSERT INTO Log (Username,Page,Action,Time) VALUES ('$Username','$Page','Add new User $u','$currentDateTime');";
                    $result5 = mysqli_query($conn, $sql5);
                    // exit;
                }
                else{
                    echo "Failure";

                }
            }

        }
        $sql1="select * from Users";
        $result1 = mysqli_query($conn, $sql1);
        echo "<table border='1' width='800' align='center'>";  // start table
        echo "<tr><th>UserID</th><th>Username</th><th>Password</th><th>Identify</th><th>DELETE</th></tr>"; // table header
        while ($row = mysqli_fetch_assoc($result1)){
            echo "<tr>";
            echo "<td>".$row['UserID']."</td>"; 
            echo "<td>".$row['Username']."</td>";
            echo "<td>".$row['Password']."</td>"; 
            echo "<td>".$row['identity']."</td>";
            echo "<td><button onclick=Delete(".$row["UserID"].")>Delete</button></td>";

            echo "</tr>";
        }
        echo "</table>"; 




    ?>







    </body>
</html>