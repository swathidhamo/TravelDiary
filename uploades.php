<html>
<head>
  <title>Editing page</title>
  <?php

    $link = mysqli_connect("127.0.0.1", "root", "", "maps");
    session_start();

    
    if(!empty($_SESSION["image_id"]) || !empty($_SESSION["username"])){
     
     $id = $_SESSION["image_id"];

     if(isset($_POST["submit"])){



    $image = $_FILES['image']['tmp_name'];
    
    
            
      $img = file_get_contents($image);
     
     $query_edit = "UPDATE entry SET image  = ? WHERE id = '" .$id. "' ";
      $edit = mysqli_prepare($link,$query_edit);
      mysqli_stmt_bind_param($edit, "s",$img);
      $result = mysqli_stmt_execute($edit);
    
    

     if($result){
      echo "uploaded";
        }
      }
     }
   //  header("Location: forum.php");
     $query_fetch = "SELECT image,id,title FROM entry WHERE image IS NOT NULL  ";
     $sql_fetch = mysqli_query($link,$query_fetch);
     if($sql_fetch){
       while($result=mysqli_fetch_assoc($sql_fetch)){
        $image_encoded = base64_encode($result["image"]);
        echo $result["id"]."  Image for ".$result["title"]."  is"."<p><img src='data:image/jpeg;base64,$image_encoded'/></p>";
       }
     


   }


   else{
    header("Location: login.php");
   }






  ?>

  <style type="text/css">
  
   body {
    font: 13px/20px "Lucida Grande", Tahoma, Verdana, sans-serif;
    color: #404040;
    background: #0ca3d2;

   }
   img{
    width: 50px;
    height: 50px;
   }


  </style>
</head>
<body>
 <form method = "POST" enctype="multipart/form-data" >
       <input type="file" name="image" />     
       <input type= "submit" name = "submit" id = "submit" value = "Upload">
      
   </form>
   <a href = "logout.php" class = "link">Logout</a>

</body>
</html>