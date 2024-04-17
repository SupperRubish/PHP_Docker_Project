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
    <link rel="stylesheet" type="text/css" href="../css/ModifyPassword.css">
    </head>
    <body style="background-image: url(../images/3.jpg)">
    <?php
    $Page = "ModifyPassword.php";
        $oldErr=$newErr="";
        if(!$_SESSION['islogin']==1){
            echo "<script>alert('Please login first!')</script>";
            echo "<script>location.href='./login.php'</script>";
            exit;
        }
        $username=$_SESSION['username'];
//        echo "<script>alert('Welcome $username')</script>";
        

        require("../config/db.inc.php");

        if(isset($_POST['Modify'])){
            if(empty($_POST['old_password'])||empty($_POST['new_password'])||empty($_POST['new2_password'])){
                echo "<script>alert('Do not let input empty')</script>";
            }
            else{
                $old_password=$_POST['old_password'];
                $new_password=$_POST['new_password'];
                $repeat_password=$_POST['new2_password'];
                $username=$_SESSION['username'];
                $sql = "SELECT * FROM Users where Username='$username';";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                $row = mysqli_fetch_assoc($result);
                if($row['Password']!=$old_password){
                    $oldErr="old password is incorrect !";
                    // echo "old password is incorrect !";
                    // exit;
                }

                else{
                    if($new_password==$repeat_password){
                        $sql1 = "UPDATE Users SET Password='$new_password' WHERE Username='$username';";
                        $result1 = mysqli_query($conn, $sql1);
                        if($result1==1){
                            $Username = $_SESSION['username'];
                            $UID=$_SESSION['userid'];
                            $currentDateTime = date("Y-m-d H:i:s");
                            $sql5="INSERT INTO Log (Username,U_ID,Page,Action,Time) VALUES ('$Username','$UID','$Page','Modify password','$currentDateTime');";
                            $result5 = mysqli_query($conn, $sql5);
                            $logFile = '../Log/file.log';
                            $handler = new StreamHandler($logFile, Logger::DEBUG);
                            $logger->pushHandler($handler);
                            $logger->info('Modify Password in ModifyPassword.php', array('username' => $Username));
                            echo "<script>alert('Modify successful, please Log in again')</script>";
                            session_destroy();
                            echo "<script>location.href='./login.php'</script>";
                            // exit;
                        }
                        else{
                            echo "Failure";
                            exit;
                        }
                    }
                    else{
                        $newErr="Your new password is different with repeat password!";
                        // echo "Your new password is different with repeat password!";
                        // exit;
                    }
                }
            }



        }
    ?>

    <button class="back" onclick="javascrtpt:window.location.href='./login.php'">Back</button>
    <form class="modify-box" method="post">

        <h4>ModifyPassword</h4>
        <div class="input-box">Old_Password: <input  type="text" name="old_password"><span class="error">* <?php echo $oldErr;?></span></div><br>
        <div class="input-box">New_Password: <input type="password" name="new_password"></div><br>
        <div class="input-box">Repeat New_Password: <input type="password" name="new2_password"></div><br>
        <span class="error">* <?php echo $newErr;?></span>
        <!-- <li> <label> </label> <input type="checkbox" name="remember" value="yes">7 </li> -->
        <label> </label> <input class="button" type="submit" name="Modify" value="Modify"> </li>
    </form>

    



    </body>
</html>