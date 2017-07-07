<html>
<head>
	<title>Luncatic</title>
	<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "maps");
    session_start();  
   
    $username= $_POST["username"];

    $query = "SELECT DISTINCT username FROM user_info WHERE username LIKE '%$username%' ";
    
    $sql = mysqli_query($link,$query);

      if($sql){
        
        $emparray =  array();

        while($result = mysqli_fetch_assoc($sql)){
          
             $emparray[] = $result;
        
         
        }
   
    }
    $ther = json_encode($emparray);
    echo $ther;
    file_put_contents("search.json",$ther);
    
 ?>

</head>
<body>
</body>
</html>