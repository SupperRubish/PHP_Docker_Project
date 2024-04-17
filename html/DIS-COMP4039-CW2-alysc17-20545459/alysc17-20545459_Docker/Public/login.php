<?php
    ob_start(); // start output buffering
    session_start();
    ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<style>

</style>
<meta charset="utf-8">
<title>Login</title>

</head>
<body style="background-image: url(../images/3.jpg)">

<?php
if(isset($_SESSION['islogin'])){
    if($_SESSION['islogin']==1){
    $user=$_SESSION['username'];
    echo "<script>alert(' You have logged , Welcome $user')</script>";
    echo "<script>location.href='./index.php'</script>";
    exit;
}
}





$re="";
require("../config/db.inc.php");
$passwordErr=$usernameErr="";

if (isset($_POST['login'])) {
    $statue=0;
    if (empty($_POST["username"]))
    {
        $usernameErr = "Must be input username!";
        
        $statue+=1;
        
    }
    if(empty($_POST["password"]))
    {
        $passwordErr = "Must be input password!";

        $statue+=1;
    }
   



    $username = trim($_POST['username']);		
    $password = trim($_POST['password']);    
    

        // construct the SELECT query
    $sql = "SELECT * FROM Users where Username='$username';";

    // send query to database
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)==0){
        $re= "This username is not exist!";
    }
    else{
         $row = mysqli_fetch_assoc($result);
    if($password==$row["Password"]){
        $_SESSION['username'] = $username;
        $_SESSION['islogin'] = 1;
        $_SESSION['identify']=$row['identity'];
        $re= "login success!";
        echo "<script>alert('$re')</script>";
        echo "<script>location.href='./index.php'</script>";
        exit;
    }
    else{
        $re= "Your password is wrong!";
    }
    }
    if($statue>0){
        $re= "Please do not leave the input empty";
    }
    }
   
?>


<form class="login-box" method="post">

    <h4>login</h4>
    <div class="input-box">Username: <input  type="text" name="username"></div><br>
    <div class="input-box">Password: <input type="password" name="password"></div><br>
<!-- <li> <label> </label> <input type="checkbox" name="remember" value="yes">7 </li> -->
    <label> </label> <input class="button" type="submit" name="login" value="login">
    
</form>

<?php
echo "<script>alert('$re')</script>";
?>


</body>
</html>
