<?php
    ob_start(); // start output buffering
    session_start();
    require '../config/vendor/autoload.php';
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;
    $logger = new Logger('my_logger');
?>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="../css/addUser.css">
    </head>
    <body style="background-image: url(../images/3.jpg)">

    <style>
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
        Permission: <select name="identify">
            <option value="1">administrator</option>
            <option value="0">ordinary</option>
        </select>
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
                $UID=$_SESSION['userid'];
                $currentDateTime = date("Y-m-d H:i:s");
                $sql5="INSERT INTO Log (Username,U_ID,Page,Action,Time) VALUES ('$Username','$UID','$Page','Delete User ID = $id','$currentDateTime');";
                $result5 = mysqli_query($conn, $sql5);
                $logFile = '../Log/file.log';
                $handler = new StreamHandler($logFile, Logger::DEBUG);
                $logger->pushHandler($handler);
                $logger->info('Delete a user account', array('username' => $Username));

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
                $per=$_POST['identify'];
                $sql="INSERT INTO Users (Username,Password,Identity) VALUES ('$u','$p','$per');";
                $result = mysqli_query($conn, $sql);
                if($result==1){
                    echo "<script>alert('Add new user successful')</script>";
                    $userid=$_SESSION['userid'];
                    $Username = $_SESSION['username'];
                    $currentDateTime = date("Y-m-d H:i:s");
                    $sql5="INSERT INTO Log (U_ID,Username,Page,Action,Time) VALUES ($userid,'$Username','$Page','Add new User $u','$currentDateTime');";
                    $result5 = mysqli_query($conn, $sql5);
                    $logFile = '../Log/file.log';
                    $handler = new StreamHandler($logFile, Logger::DEBUG);
                    $logger->pushHandler($handler);
                    $logger->info('Add new user in addUser.php', array('username' => $Username));

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
            if($row['identity']==1){
                echo "<td>".'Administrator'."</td>";
            }
            else{
                echo "<td>".'Ordinary'."</td>";
            }

            echo "<td><button onclick=Delete(".$row["UserID"].")>Delete</button></td>";

            echo "</tr>";
        }
        echo "</table>"; 




    ?>







    </body>
</html>