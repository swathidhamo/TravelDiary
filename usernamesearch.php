<html>
<head>
	<title>Comments</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <?php
      
      $link = mysqli_connect("127.0.0.1", "root", "", "maps");
      session_start();
      if(isset($_POST["submit"]) && !empty($_SESSION["username"])){
        $name = $_POST["search_name"];
         $query = "SELECT id,title, entry,lat,lng,username,status,time,votes FROM entry WHERE username = '$name' ";
         $result = mysqli_query($link,$query);
         if($result){
          while($data = mysqli_fetch_assoc($result)){
            echo   "<p class = 'info'>Entry by :  ".$data["username"]."</p><p class = 'info'>   Title: ".
            $data["title"]."  At: ".$data["time"]. "  "."</p><p id = 'contents'>   "
             .$data["entry"]."<p class = 'info'><a href = 'comments.php?id_comments=".$data["id"]."'>Comments  </a>".
             " Votes: ".$data["votes"]."  ".
            "<a name  = 'vote'href='comments.php?id_vote=".$data["id"]."'>Upvote</a></p></p>";
          }
         }
      }


      ?>
  <script type="text/javascript">

    function autoComplete(){

             
         var name = document.getElementById("search_name").value;
         document.getElementById("browsers").innerHTML = " ";
         var xmlhttps = new XMLHttpRequest();
         xmlhttps.open("POST", "search.php", true);
         var parameter = "username="+name;
         xmlhttps.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         xmlhttps.send(parameter);
         xmlhttps.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
                 
            
            }


        }
        nameuser="admin";
             var string = {};

                var request = new XMLHttpRequest();
         document.getElementById("content").innerHTML = " work now ";
         request.open('POST', 'search.json', true);
         request.onload = function () {

       // begin accessing JSON data here
         var json = JSON.parse(this.responseText);

            for(var k =0;k<json.length;k++){
                 var option = document.createElement("option");
                 option.value = json[k]["username"];
                 console.log(json[k]["username"]);
                 document.getElementById("browsers").appendChild(option);
              
              }
        
          }
 
       request.send();
         

         
  
     }





       
     window.onload = function(){
     document.getElementById("search_name").addEventListener("keyup",autoComplete);
     }

   





  </script>
	<style type="text/css">
      .box{
      	border: 2px solid green;
      	padding: 15px 15px 15px 15px;
      	margin:  35px 35px 35px 35px;
      }
       body{
      background: url("https://www.colourbox.de/preview/7214885-travel-doodles.jpg");
     }
  

       .info{
      border: 2px solid red;
      margin-right: 250px;
      margin-left: 40px;
      padding: 15px 30px 15px 15px;
      background-color: #5e82bc;
      border-radius: 3px 3px 3px 3px;
    }
    #contents{
      border: 2px solid blue;
      margin-right: 250px;
      margin-left: 40px;
      padding: 15px 30px 15px 15px;
      background-color: #5e82bc;
      border-radius: 3px 3px 3px 3px;
    }
     
	</style>
</head>

<body>
<form method = "POST">
  <div id  = "content"></div>
  <input type = "text" name = "search_name" id = "search_name" autocomplete = "off" list = "browsers">
  <datalist id = "browsers"></datalist>
   
   <input type = "submit" value = "Submit" name = "submit" id = "submit">
   
  </div>
   <a href = "gitcode.php">Back to the map</a>

</form>
</body>
</html>