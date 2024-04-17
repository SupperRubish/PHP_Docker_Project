<?php
    ob_start(); // start output buffering
    session_start();
?>
<html>
<head>
<link rel="stylesheet"  href="../css/index.css"/>
</head>
<style>
.log{
    width: 200px;
    height: 100px;
    position: absolute;
    left: 0px;
    top: 0px;
    bottom: 700px;
    right: 30px;
    margin: auto;
    background-color: rgba(0,0,0,0.4);
    color: #ffffff;
}
.cen .bb{
    position: relative;
    background-color: rgba(0,0,0,0.4);
	border:2px solid #008cba;
    border-radius:8px;
    font-size: 18px;
    color: #ffffff;
    padding: 10px 20px;
    margin: 4px 2px;
    text-align: center;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
    text-decoration: none;
    overflow: hidden;
    width: 19%;
    height: 500px;
        }

 
.cen button:hover {
  background-color:  #8FBC8F  ;
}
button:hover {
    background-color:  #30e6dd  ;
  }

.cen{
    position: absolute;
        left: 30px;
        top: 20%;
        bottom: 0;
        right: 0;
        margin: auto;
}
.butt{
    width: 100px;
    height: 100px;
    position: absolute;
    left: 1400px;
    top: 0px;
    bottom: 700px;
    right: 0;
    margin: auto;

}
.f{
    width: 200px;
    height: 100px;
    position: absolute;
    left: 0px;
    top: 0px;
    bottom: 700px;
    right: 500px;
    margin: auto;
    background-color: rgba(0,0,0,0.4);
    color: #ffffff;
}
.addPage{
    width: 200px;
    height: 100px;
    position: absolute;
    left: 0px;
    top: 0px;
    bottom: 700px;
    right: 1400px;
    margin: auto;
    background-color: rgba(0,0,0,0.4);
    color: #ffffff;
}


body{
    background-image:url(../images/3.jpg);
}

</style>
<meta charset="utf-8">
<title></title>

</head>
<body> 
<script>
        // A JavaScript function to confirm delete
        function addPage() 
        {
            window.location.href='./addUser.php';
        } 

        function FinePage()
        {
            window.location.href='./Fine.php';
        }

        function LogPage(){
            window.location.href='./RecordLog.php';
        }
    </script>
<?php
        if(!$_SESSION['islogin']==1){
            
            echo "<script>alert('Please login first!')</script>";
            echo "<script>location.href='./login.php'</script>";
            
            exit;
        }
        $ss=$_SESSION['userid'];
        $user=$_SESSION['username'];
        echo "<script>alert('Welcome $user,,,,$ss')</script>";
        if(isset($_POST['logout'])){
            
            session_destroy();
            echo "<script>location.href='./login.php'</script>";
        }

        if($_SESSION['identify']==1){
            echo "<button class='f' onclick='FinePage()'>Fine</button>";
            echo "<button class='addPage' onclick='addPage()'>AddUser</button>";
            echo "<button class='log' onclick='LogPage()'>Log</button>";
            
        }
?>

<div class="cen">
    <div1><button class="bb" onclick="javascrtpt:window.location.href='./ModifyPassword.php'">Modify your password</button></div1>
    <div1><button class="bb" onclick="javascrtpt:window.location.href='./SelectDataByNameOrNumber.php'">Select People</button></div1>
    <div1><button class="bb" onclick="javascrtpt:window.location.href='./selectCarByCid.php'">SelectCarByPlate</button></div1>
    <div1><button class="bb" onclick="javascrtpt:window.location.href='./addNewCar.php'">AddNewCar</button></div1>
    <div1><button class="bb" onclick="javascrtpt:window.location.href='./RecordFine.php'">RecordIncident</button></div1>

    
</div>
<form  method="post">
<input class="butt" type="submit" name="logout" value="logout">
</form>

</body>
</html>
