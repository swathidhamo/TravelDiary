<html>
<head>
	<title>Login page</title>
  <script src='https://www.google.com/recaptcha/api.js'></script>
	<?php

     session_start();
     session_destroy();

     $link = mysqli_connect("127.0.0.1", "root", "", "maps");
     require_once "recaptchalib.php";
     session_start();    

     if(!$link){
      echo "Could not connect";
      echo mysqli_error($link);
     }
     else{
      echo "Sucesssfully connected";

      if(isset($_POST["login"])){

      	if(isset($_POST["username"])){

      	  	$username = mysqli_real_escape_string($link,$_POST["username"]);
            $username = stripslashes($username);
            $_SESSION["username"] = $username;
      	 }

      	if(isset($_POST["password"])){

      		  $password = mysqli_real_escape_string($link,$_POST["password"]);
            $password = stripslashes($password);
            
        	}



        $secret = "6Le_iScUAAAAADkT6a-7dPnEBjWKhmMls2tOxJql";
 
      // empty response
     /*   $response = null;
 
      // check secret key
         $reCaptcha = new ReCaptcha($secret);

          if ($_POST["g-recaptcha-response"]) {
          $response = $reCaptcha->verifyResponse(
          $_SERVER["REMOTE_ADDR"],
          $_POST["g-recaptcha-response"]
        );
      }*/


        $password_hash = hash('md5',$password);
        $query = "SELECT * FROM user_info WHERE username = '".$username."' AND password = '".$password_hash."'";
        $sql = mysqli_query($link,$query);       
        $rows = mysqli_num_rows($sql);
        if($rows==1){//&&$response != null&&$response->success){
             $_SESSION["username"] = $username;
            echo "  Sucessfully logged in";
          //  echo $_SESSION["username"];
           
            header("Location: gitcode.php");

        }
        else{
            echo "  Invalid username or password";
        }


      	
      }

     }








	?>


</head>
<style type="text/css">
   .login{
     border: 2px solid black;
     border-radius: 6px 6px 6px 6px;
     padding: 15px 15px 15px 15px;
     margin right: 400px;
     margin-top: 210px;
     margin-left: 310px;
     width: 450px;
     font-size: 20px;
   }

   body {
    font: 13px/20px "Lucida Grande", Tahoma, Verdana, sans-serif;
    color: #404040;
    background: #0ca3d2;

   }
   
  </style>
<body>
  <div class = "login">
  <form method = "POST" >
    <p>Username: <input type = "text" name = "username" placeholder = 'Enter the username'></p>
    <p>Password: <input type = "text" name = "password" placeholder = "Enter the password"></p>
    <input type = "submit" name = "login" value = "Login">
    <div class="g-recaptcha" data-sitekey="6Le_iScUAAAAAD2UsWWJ0fxKT2LtXk-MXNxR6JXS"></div>
  </form>
  <a href = "register.php">Click here to register</a>
</div>
</body>
</html>