<html>
<head>
	<title></title>
	<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "maps");
    session_start();  
    //session_destroy();
    //session_start(); 
    $lat = $_POST["lat"];
    $lng = $_POST["lng"];
   
    $_SESSION["lat"] =$lat;
    $_SESSION["lng"] = $lng;
 ?>

</head>
<body>
</body>
</html>