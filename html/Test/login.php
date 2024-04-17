<?php
// 数据库连接信息
// $servername = "your_servername";
// $username = "your_username";
// $password = "your_password";
// $dbname = "your_dbname";

// 创建数据库连接
require("db.inc.php"); //找到这个文件，使用绝对路径
$conn = mysqli_connect($servername, $username, $password, $dbname);
if(mysqli_connect_errno()) 
{
   echo "Failed to connect to MySQL: ".mysqli_connect_error();
   die();
} 

// 检查是否提交了表单
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 获取提交的用户名和密码
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 防止 SQL 注入攻击
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // 查询数据库
    $sql = "SELECT * FROM Officer WHERE username='$username' AND password='$password'";
    $sql2 = "SELECT * FROM Admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);
    $result2 = $conn->query($sql2);

    // 验证用户名和密码
    if ($result->num_rows > 0) {
        // 用户名和密码匹配，登录成功
        // 在这里可以添加更多的逻辑，例如跳转到其他页面
        header('Location: people.php'); // 将用户重定向到欢迎页面
        exit();
    } // 重定向后结束脚本执行
    elseif ($result2->num_rows > 0) {
            // 用户名和密码匹配，登录成功
            // 在这里可以添加更多的逻辑，例如跳转到其他页面
            header('Location: config.php');// 将管理员重定向到欢迎页面
            exit(); // 重定向后结束脚本执行
    }
    else {
        // 登录失败
        echo 'Invalid username or password';
    }
}

// 关闭数据库连接
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./css/login.css" type="text/css"> 引入外部 CSS 文件
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        form {
            text-align: center;
        }

        label {
            display: center;
            margin-bottom: 8px;
        }

        input {
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <h2>Login</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
