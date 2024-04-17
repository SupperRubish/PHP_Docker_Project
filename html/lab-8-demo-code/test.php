<html>

<title>the test </title>
<body>
<h1> Form Test</h1>
<form method="post">
    Enter you name:<input type="text" name="yourname">
    <input type="submit" value="Say Hello">
</form>

<?php
if (isset($_POST['yourname']))
    echo "Hello <strong>".$_POST['yourname']."</strong>>"

?>


</body>
</html>