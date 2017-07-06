<html>
<head>
	<title>Luncatic</title>
	<?php
    $link = mysqli_connect("127.0.0.1", "root", "", "maps");
    session_start();  
    


    if(!empty($_POST["latS"])){
      $latS = $_POST["latSE"];
    }
    if(!empty($_POST["lngS"])){
      $lngS = $_POST["lngSE"];
    }
    if(!empty($_POST["name"])){
      $user_name = $_POST["name"];
    }

    //$search = $_POST["name"];
    
    //$lat = $_SESSION["lat"];
    //$lng = $_SESSION["lng"];
     echo $latS;
     echo $lngS;
    $latend = $latS + 5.5;
    $latbgn = $latS - 5.5;
    $lngend = $lngS + 5.5;
    $lngbgn = $lngS - 5.5;
    // if($latS==undefined || $latS == null){
      //$query = "SELECT title, entry,lat,lng,username,status,time,votes FROM entry WHERE username = '$search' ";
    //}
    //else{
      //$query = "SELECT id,title, entry,lat,lng,username,status,time,votes FROM entry WHERE lat = '$latS'AND lng = '$lngS' ";
      $query = "SELECT id,title, entry,lat,lng,username,status,time,votes FROM entry WHERE (lat >'".$latbgn."' AND lat< '".$latend."')
       AND (lng>'".$lngbgn."' AND lng<'".$lngend."') ";
       if(isset($_POST["name"])){
             $query = "SELECT id,title, entry,lat,lng,username,status,time,votes FROM entry WHERE username = '".$user_name."' ";

       }

         if($_SESSION["sort_option"]=="sort_by_time"){
                 $query = "SELECT id,title, entry,lat,lng,username,status,time,votes FROM entry WHERE lat >=  '".$latbgn."' AND 
                lng <= '".$lngend."' AND lat <= '".$latend."' AND lng >='".$lngbgn."' ORDER BY time ASC ";   
       }

         if($_SESSION["sort_option"]=="sort_by_votes"){
                $query = "SELECT id,title, entry,lat,lng,username,status,time,votes FROM entry WHERE lat >= '".$latbgn."' AND 
               lng <= '".$lngend."' AND lat <= '".$latend."' AND lng >='".$lngbgn."' ORDER BY votes DESC ";   
       }
   //}
    //$query = "SELECT title, entry FROM entry WHERE id>='24'";
    $sql = mysqli_query($link,$query);

      if($sql){
        
        $emparray =  array();

        while($result = mysqli_fetch_assoc($sql)){
          
             $emparray[] = $result;
        
         
        }
   
    }
    $ther = json_encode($emparray);
    file_put_contents("result.json",$ther);
    
 ?>

</head>
<body>
</body>
</html>