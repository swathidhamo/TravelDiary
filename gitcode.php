<html>
<head>
	 
	<title>Maps</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <?php
   session_start();
   $link = mysqli_connect("127.0.0.1", "root", "", "maps");
  // echo "<div class = 'page_header'><div class = 'jumbotron' ><h1>Travel Diaries</h1>Welcome to your account  "
   //.$_SESSION["username"]." </div></div>";
   if(empty($_SESSION["username"])){
    header("Location: login.php");
   }
   else{
   echo  "<input type = 'text' id = 'uname' name = 'uname' value = ".$_SESSION['username'].">";
  
      $_POST["uname"] = $_SESSION["username"];
     if($_POST["submit"] || !empty($_POST["submit"])){
        if(isset($_POST["status"])){
          $status = $_POST["status"];
        }
       
        
        if(isset($_POST["entry"])){
           $entry  = $_POST["entry"];
           $entry = mysqli_real_escape_string($link,$entry);
           $entry = stripslashes($entry);
        } 
        if(isset($_POST["title"])){
           $title  = $_POST["title"];
           $title = mysqli_real_escape_string($link,$title);
           $title = stripslashes($title);
        } 
         $lat = $_SESSION["lat"];
         $lng = $_SESSION["lng"];

      
         
           $username  = $_SESSION["username"];
           date_default_timezone_set("Asia/Kolkata");
           $createdate= date('Y-m-d H:i:s');
           $votes = 0;
         $query = "INSERT INTO entry (username, entry, title, lat, lng,status,time,votes) VALUES 
         (?,?,?,'$lat','$lng',?,'$createdate',?)";
         $create_entry =  mysqli_prepare($link,$query);
         mysqli_stmt_bind_param($create_entry,"sssii",$username,$entry,$title,$status,$votes);

         $sql = mysqli_stmt_execute($create_entry);
       
        if($sql){
          echo "Sucessfully updated";
      
       }
       else{
        echo "Not updated  ";
        echo mysqli_error($link);
       }
     }
    
    if(isset($_POST["sort_submit"])){
      if($_POST["sort"]==2){
        $_SESSION["sort_option"] = "sort_by_time";
      }
      else if($_POST["sort"] ==1){
        $_SESSION["sort_option"] = "sort_by_votes";
      }
      
    }
    else{
      $_SESSION["sort_option"] = "no";
        }
     if(isset($_POST["upload_image"]) && isset($_POST["image_id"]) ){
      $_SESSION["image_id"] = $_POST["image_id"];
      header("Location: uploades.php");
     }    
   
  
 
     }
  ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<style type="text/css">

  body{
    background: url("https://www.colourbox.de/preview/7214885-travel-doodles.jpg");
  }
	
	#maps{ 
      margin-left: 400px;
      width: 450px;
      height: 450px;
    }
    
    #entry{
    	display: none;
    }
    #uname{
      display: none;
    }
    textarea{
    	width: 800px;
    	height: 250px;
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
    .jumbotron{
       padding-left: 40px;
       padding-top: 30px;
       background: #4573bc;
    }
    #logout{
      margin-left: 1300px;
      border: 1.5px solid black;
      background-color: #cd0034;
    }

    
    
    </style>
       
    <script type="text/javascript">
    var markerIndex = 0;
    var i = 0;
    var latVar, lngVar;
    var parameter;
    var searchCall = false;
    //var marker;
    var nameuser = document.getElementById("uname").value
   
   
    function markerInfo(x,y){
    
       
       var xml = new XMLHttpRequest(); 
       var parameters = "lat="+x+"&lng="+y;
       xml.open("POST","data.php",true);
       xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
       xml.onreadystatechange = function() {
        if(xml.readyState == 4 && xml.status == 200) {
           document.getElementById('usernameStatus').innerHTML="sent data<br />";
         }
      }
        xml.send(parameters);
    } 

           function markerInfoSend(xe,ye){
          
        var search_name  = document.getElementById("search_name").value;     
        var xmlhttp = new XMLHttpRequest();
        console.log("soe");
         xmlhttp.open("POST", "display.php", true);
         var parameter = "latSE="+xe+"&lngSE="+ye;
         if(searchCall){
          parameter = "name="+search_name;
          console.log(search_name);
          searchCall = false;
         }
         else{
          console.log(xe + "   " + ye);
         }
         xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         xmlhttp.send(parameter);
         xmlhttp.onreadystatechange = function() {
          
          
            if (this.readyState == 4 && this.status == 200) {        
            }
        };
         //THERE IS A CHANGE HERE BETWEEN GET AND POST
         var request = new XMLHttpRequest();
         document.getElementById("content").innerHTML = " work now ";
         request.open('GET', 'result.json', true);
         request.onload = function () {
       // begin accessing JSON data here
         var data = JSON.parse(this.responseText);
         console.log(data.length);
         var content = document.getElementById("content");
  
         for(var k = 0; k<data.length;k++){
            if(data[k]["status"]==1){
              if(data[k]["username"]==nameuser){
                   content.innerHTML += 
                  "<p class = 'info'>Entry by :  "+data[k]["username"]+"</p><p class = 'info'>   Title: "+
                  data[k]["title"]+"  At: "+data[k]["time"]+ "  "+"</p><p id = 'contents'>  " 
                   +data[k]["entry"] +"<p class = 'info'><a href = 'comments.php?id_comments="+
                  data[k]["id"]+"'>Comments  </a>"+
                   " Votes: "+data[k]["votes"]+"  "+
                  "<a name  = 'vote'href='comments.php?id_vote="+data[k]["id"]+"'>Upvote</a></p></p>";
            
   
              }
              else{
                 content.innerHTML += "<p class = 'info'>That is a private entry by " + 
               data[k]["username"]+" </p>";
              }
            }
           else{
             content.innerHTML += 
            "<p class = 'info'>Entry by :  "+data[k]["username"]+"</p><p class = 'info'>   Title: "+
            data[k]["title"]+"  At: "+data[k]["time"]+ "  "+"</p><p id = 'contents'>   "
             +data[k]["entry"] +"<p class = 'info'><a href = 'comments.php?id_comments="+data[k]["id"]+"'>Comments  </a>"+
             " Votes: "+data[k]["votes"]+"  "+
            "<a name  = 'vote'href='comments.php?id_vote="+data[k]["id"]+"'>Upvote</a></p></p>";
        
             }
   
          }
    console.log(data[0]["title"]);
  
  
}
   
       request.send();
           console.log(document.getElementById("uname").value);
        $.getJSON("result.json", function(json) {
   // console.log(json); // this will show the info it in firebug console
});
          
}
     
    </script>
    <script type="text/javascript">
      var lngArray = [];
      var latArray = [];
      var multiple_entry = false;
         
    function myMap() {
  
      
       var myCenter = new google.maps.LatLng(61.5240, 105.3188);//set the centre for the map at first
       var mapCanvas = document.getElementById("maps");//to get the area where we will be setting up our map
       var mapProperties = {//to create a object that will store the properties of the map we are about to display
       	   center: myCenter, 
       	   zoom: 3, 
       	   mapTypeId: google.maps.MapTypeId.HYBRID
       	};
       var map = new google.maps.Map(mapCanvas, mapProperties);
       //to draw a map in area mapCanvas using the properties defined in mapproperties
          function placeMarker(location) {//to create a constructor that will define the marker that is created
            var marker = new google.maps.Marker({
            position: location, 
            map: map });
             marker.setMap(map);
             if(multiple_entry){
              marker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
              multiple_entry = false;
             }
           // marker.setIcon('http://www.traveldiariesapp.com/Content/Images/travel-diaries-logo-home.png');
            marker.addListener("click",function(){
              console.log("hi");
              searchCall = false;
              markerInfoSend(location.lat,location.lng);
              console.log(location.lat + " this is the lgn ");
              console.log(location.lng);
           
                
            });
              marker.addListener("dblclick",function(){
              console.log("create");
                marker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
                multiple_entry = true;
                latArray.push(location.lat);
                lngArray.push(location.lng);
                multiple_entry = true;
                placeMarker(location.lat,location.lng);
                markerInfo(location.lat,location.lng);

                $("#entry").show();

                localStorage.setItem("lat",JSON.stringify(latArray));
                localStorage.setItem("lng",JSON.stringify(lngArray));
                console.log(latArray);
                i++;
                localStorage.setItem("index",i);
                console.log("clicked!!!");
            
                
            });
    
          }

            
       
       google.maps.event.addListener(map, 'click', function(event) {
                 multiple_entry = false;
         placeMarker(event.latLng);
         //ANS HERE
         var lat = event.latLng.lat();
         var lng = event.latLng.lng();

         if(latArray!=null&&lngArray!=null){
         latArray.push(lat);
         lngArray.push(lng);
         }
         else{
          latArray = [];
          lngArray = [];
         }
       
         markerInfo(lat,lng);

         $("#entry").show();
        // $("#content").innerHTML = " ";
         localStorage.setItem("lat",JSON.stringify(latArray));
         localStorage.setItem("lng",JSON.stringify(lngArray));
         console.log(latArray);
         i++;
         localStorage.setItem("index",i);
         console.log("clicked!!!");
        });
    
      
       
        window.onload = function(){
         //document.getElementById("search_name").addEventListener("keyup",autoComplete);
        document.getElementById("search_button").addEventListener("click",function(){
          searchCall = true;
          markerInfoSend();
         });
        document.getElementById("search_name").addEventListener("keyup",function(){
           autoComplete();
           searchCall = true;
           markerInfoSend();
         });
        if(localStorage.getItem("index")!=null){
          latArray = JSON.parse(localStorage.getItem("lat"));
          lngArray = JSON.parse(localStorage.getItem("lng"));
        }
        else{
          latArray = [];
          lngArray = [];
        }
           i = localStorage.getItem("index");
           latIntro = JSON.parse(localStorage.getItem("lat"));         
           lngIntro = JSON.parse(localStorage.getItem("lng"));
         
  
        for(var j = 0;j<parseInt(localStorage.getItem("index"));j++){
          if(latIntro[j-1]==latIntro[j]){
             multiple_entry = true;
          }
          else{
            multiple_entry = false;
          }
        
         var locationMarker = {
          lat: parseFloat(latIntro[j]),
          lng: parseFloat(lngIntro[j])
      }
       placeMarker(locationMarker);
    }
  }
       
}
     
    
</script>

</head>
<body>
 
 <form method = "POST">
 	<a href = "entry.php"></a>
 
       <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Travel Journal</a>
    </div>
    <ul class="nav navbar-nav">
    <li><a href = "usernamesearch.php">Search by username</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
    <li><a href = "logout.php"><?php echo $_SESSION["username"]; ?></a></li>
      <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div>
</nav>

      
     
     
       
             
       <p>Sort By<select name = "sort">
      <option value = "2">Time</option>
      <option value = "1">Votes</option>
     </select></p>
     <input type = "submit" name = "sort_submit" value = "Sort">   
       <p><input type = "text" name = "image_id" placeholder = "id of the image">
      <input type="submit" name="upload_image" value = "upload"></p>
       <span id = 'logout'><a href='logout.php'>Logout</a></span>
  
  
  <div id = "maps"></div>
  
    <div id = "entry">
     <p>Title: <input type = "text" name = "title"></p>
     <span id = "usernameStatus"></span>
     <p>Entry: <textarea name = "entry"></textarea></p>
     <p>Private<select name = "status">
      <option value = "0">Public</option>
      <option value = "1">Private</option>
     </select></p>


     <input type = "submit" name = "submit" value = "Submit">
  </div>
  </form>
 <div id = "content"></div>


 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIEXY3Y8DysLQt5Se7ecaikiw6OUlxZJY&callback=myMap"></script>
</body>
</html>
