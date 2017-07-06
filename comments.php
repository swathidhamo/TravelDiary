<html>
<head>
	<title>Comments</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<?php
      $link = mysqli_connect("127.0.0.1", "root", "", "maps");
      session_start();
         echo "<div class = 'page_header'><div class = 'jumbotron' ><h1>Travel Diaries</h1>Welcome to your account  "
         .$_SESSION["username"]."     </div></div>";

      $id = $_GET["id_comments"];

      if(isset($_POST["submit"])){
      	if(isset($_POST["comment_content"])){
      		$content = $_POST["comment_content"];
      	}

      	$name = $_SESSION["username"];

      	$query = "INSERT INTO comment (username, comments, entry) VALUES ('$name','$content','$id')";
        $sql = mysqli_query($link,$query);

        if($sql){
        	echo "Sucessfully added";
        }
        else{
        	echo mysqli_error($link);
        }

      }

      if(!empty($_GET["id_vote"]) ) {
        $id_vote = $_GET["id_vote"];
        $query_vote = "UPDATE entry SET votes = votes + 1 WHERE id = '$id_vote' ";
        $result_vote = mysqli_query($link,$query_vote);
        if($result_vote){
         echo "Voting sucessful";
         header("Location: gitcode.php");
    
        
        }
        else{
          echo "Voting unsucessful";
        }
      }  


        //now to display the existing comments
         $display = "SELECT comments, username FROM comment WHERE entry = '$id'";
         $result = mysqli_query($link,$display);

           while($row = mysqli_fetch_assoc($result)) {

        echo  "<div class = 'box'>".$row["username"]."   says that   ' ".$row["comments"]." '<br></div>";
         }



      

     











	?>
	<style type="text/css">
      .box{
      	border: 2px solid green;
      	padding: 15px 15px 15px 15px;
      	margin:  35px 35px 35px 35px;
        background-color: #5e82bc;
        margin-right: 250px;
        margin-left: 40px;
      }
      body{
        background: url("https://www.colourbox.de/preview/7214885-travel-doodles.jpg");
       }
      .jumbotron{
       padding-left: 40px;
       padding-top: 30px;
       background: #4573bc;
    }
       #logout{
       margin-left: 30px; 
       margin-top: 20px;
       border: 1.5px solid black;
       background-color: red;
    }
    input{
      margin-left: 40px;
      margin-top: 30px;
      margin-bottom: 30px;

    }
	</style>
</head>

<body>
<form method = "POST">
  <input type = "text" name = "comment_content">
   <input type = "submit" value = "Submit" name = "submit">
   <p><span id = 'logout'><a href='logout.php'>Logout</a></span></p>
   <p><a href = "gitcode.php">Back to the map</a></p>

</form>
</body>
</html>