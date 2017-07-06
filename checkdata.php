<html>
<head>
	<title></title>
	<?php
      session_start();

      $link = mysqli_connect("127.0.0.1", "root", "", "maps");
      $username = mysqli_real_escape_string($link,$_POST["username"]);
      $username = stripslashes($username);


      

      if(!$link){
            echo "error";
      }
      else{

             
      
      	$query = "SELECT * FROM user_info WHERE username = '".$username."' ";
      	$sql = mysqli_query($link,$query);
      	$rows = mysqli_num_rows($sql);

            if (!preg_match("/^[a-zA-Z ]*$/",$username)) {

                echo "Only letters and white space allowed"; 


             }
      	else if($rows>0){
                  echo "Unavaliable";
                  $_SESSION["avaliable"] = false;

             }
            else{
                  echo "Avaliable";
                  $_SESSION["avaliable"] = true;

             }
      
   }




	?>
</head>
<body>

</body>
</html>