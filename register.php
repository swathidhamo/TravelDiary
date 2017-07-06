<html>
<head>
	<title>Registration Page</title>
   <script src='https://www.google.com/recaptcha/api.js'></script>


 

<?php
     session_start();
    $link = mysqli_connect("127.0.0.1", "root", "", "maps");
     require_once "recaptchalib.php";

   if(isset($_POST["create"]) && $_SESSION["avaliable"]){
    	if(isset($_POST["username"])){

    		$username = mysqli_real_escape_string($link,$_POST["username"]);
        $username  = stripslashes($username);    	

    	 }

    	if(isset($_POST["password"])){

    		$password = mysqli_real_escape_string($link,$_POST["password"]);
        $password = stripslashes($password);    		

       }

      if(isset($_POST["name"])){

        $name = mysqli_real_escape_string($link,$_POST["name"]);
        $name = stripslashes($name);

       }
         
        $hash = getPasswordHash($password); 


         $secret = "6Le_iScUAAAAADkT6a-7dPnEBjWKhmMls2tOxJql";
 
        // empty response
         $response = null;
 
        // check secret key
          $reCaptcha = new ReCaptcha($secret);

         if ($_POST["g-recaptcha-response"]) {
          $response = $reCaptcha->verifyResponse(
          $_SERVER["REMOTE_ADDR"],
          $_POST["g-recaptcha-response"]
        );
      }


        if($response != null&&$response->success){
        $sql = "INSERT INTO user_info (username, password,name) VALUES (?, ?,?)";
        $query = mysqli_prepare($link,$sql);
        mysqli_stmt_bind_param($query,"sss",$username,$hash,$name);
        $result = mysqli_stmt_execute($query);
      }
    
    	if($result ){
    		header("Location: login.php");
    	}
    	else{
    		echo mysqli_error($link);
    	}

     }

// calculate the hash from a salt and a password
    function getPasswordHash( $password )
 {
    return ( hash( 'md5', $password ) );
  }


// get a new hash for a password



	?>


   <script type="text/javascript">

     window.onload = function(){
      var name = document.getElementById("username");
      name.addEventListener("keyup",username_check);
    
    }

  function username_check(){
    var username = document.getElementById("username").value;

  

    var xml = new XMLHttpRequest(); 
    var parameters = "username="+username;
    xml.open("POST","checkdata.php",true);
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.onreadystatechange = function() {
    if(xml.readyState == 4 && xml.status == 200) {
     document.getElementById('usernameStatus').innerHTML=xml.responseText+"<br />";

       }
     }


    xml.send(parameters);
  } 
</script>
  <style type="text/css">
   .login{

     border: 2px solid black;
     border-radius: 6px 6px 6px 6px;
     padding: 15px 15px 15px 15px;
     margin right: 400px;
     margin-top: 210px;
     margin-left: 310px;
     width: 600px;
     font-size: 20px;
   
   }

   body {
    font: 13px/20px "Lucida Grande", Tahoma, Verdana, sans-serif;
    color: #404040;
    background: #0ca3d2;

   }
   #usernameStatus{
    font: 5px/20px;
   }
   



  </style>
  
</head>

<body>
  <div class = "login">
  <form method = "POST">
      <p> Username: <input type = "text" name = "username" id = "username">
        <span id = "usernameStatus"></span></p>
      <p> Password: <input type = "text" name = "password"></p>
      <p> Name: <input type = "text" name = "name"></p>
    <p><input type = "submit" name = "create" value="Register"></p> 
     <div class="g-recaptcha" data-sitekey="6Le_iScUAAAAAD2UsWWJ0fxKT2LtXk-MXNxR6JXS"></div>
  </form>
</div>



</body>
</html>