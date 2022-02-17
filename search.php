<?php

    session_start();
    $success = "";
    $xxxx = "";
    if (array_key_exists("id", $_COOKIE) && $_COOKIE ['id']) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        
    }

    if (array_key_exists("id", $_SESSION)) {
              
      $link = mysqli_connect("localhost", "root", "", "SocialZ");
        
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }
       
        
        $query = "SELECT * FROM users WHERE id = '" .$_SESSION['id']. "' LIMIT 1";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        $fname = $row['fname'];
        $lname = $row['lname'];
        $username = $row['username'];  
        
    } else {
        
        header("Location: Login.php");
        
    }
?>
<!doctype html>
<html lang="en" style="background-image: linear-gradient(white, #A0DCF8) no-repeat">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <link href="bootstrap-5/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>
        <link href="StyleSheet.css" rel="stylesheet">
        <title>Find People - <?php echo $username?></title>
        <link rel = "icon" href ="img/logo1.png" type = "image/x-icon">
        <style>
                        /* width */
::-webkit-scrollbar {
  width: 10px;
    background-color: white;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #C2E9F2; 
  border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background:#75B7ED; 
}
        </style>
    </head>
    <body style="background-image: linear-gradient(white, #A0DCF8) no-repeat">
     <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #5DB0FF;">
             
    <div class="container-fluid">
    <div class="menuf">
      <a class="navbar-brand" href="#">
      <img src="img/logo1.png" alt="" class="logo" width="30" height="24">
    </a>
    <a class="navbar-brand" href="index.html">SocialOwl</a>
    </div>
     <div class="menu">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link active " aria-current="page" href="search.php">Find People</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="home.php">Feed</a>
        </li>
          <li class="nav-item">
          <a class="nav-link " aria-current="page" href="MyProfile.php">My Profile</a>
        </li>
          <li class="nav-item">
          <a class="nav-link " href="inbox.php">Inbox</a>
        </li>
          <li class="nav-item">
          <a class="nav-link " href="store.php">Store</a>
        </li>
          <li class="nav-item">
          <a href ='login.php?logout=1'>
        <button class="btn btn-success" type="submit" style="margin-left:0.5rem">Logout</button></a>
            
        </li>
      </ul>
      
    </div>
      </div>
  </div>
</nav>
        <div class="search-div" style=";overflow:hidden;min-height:40rem;background-color:white;margin-left:10%;margin-right:10%;margin-top:4rem;margin-bottom:1rem;border-radius:7px;">
        <form method="post">
                <div class="row">
                    <div class="col" style="margin-left:25%;">
                <input type="text" name="search" class="form-control" id="search" placeholder="Username...">
                  </div>      
                <div class="col" style="margin-right:10%">
                     <button type="submit" class="btn btn-primary" name="submit">Search</button>
                </div>
                </div>
            </form>
           <div >
                <?php
                if (array_key_exists("submit", $_POST)) {
        
        $link = mysqli_connect("localhost", "root", "", "SocialZ");
        
            if (mysqli_connect_error()) {
            
                die ("Database Connection Error");
                
            }
            if(isset($_POST['search']))
            {
                 $query = "SELECT * FROM users WHERE fname = '" .$_POST['search']. "' or
                 username = '" .$_POST['search']. "' ";
                $result = $link->query($query);
                  if ($result->num_rows > 0 ) {
                      while ($row = $result->fetch_assoc()) {
                          $img = $row['img'];
                        $q1 = "SELECT dept_name FROM department WHERE id = '" .$row['dept']. "' LIMIT 1";
                        $result1 = mysqli_query($link, $q1);
                        $r1 = mysqli_fetch_array($result1);
                        $dept = $r1['dept_name'];
                        $q2 = "SELECT course_name FROM course WHERE id = '" .$row['course']. "' LIMIT 1";
                        $result2 = mysqli_query($link, $q2);
                        $r2 = mysqli_fetch_array($result2);
                        $course = $r2['course_name'];
                        $q3 = "SELECT year FROM year WHERE id = '" .$row['year']. "' LIMIT 1";
                        $result3 = mysqli_query($link, $q3);
                        $r3 = mysqli_fetch_array($result3);
                        $year = $r3['year']; 
		 	            echo "<div style='background-color:#89CFF0;box-shadow: 4px 4px #e5e8ea;width:15rem;border-radius:2rem;padding:2rem;margin:2rem;line-height:3rem;float:left'>";
                        echo "<div class='profile-photo' style='height: 150px;width: 150px;margin-top:3rem;margin-left:2rem;border-radius:50%'>";
                        echo "<img src=".$img." width=120px height=120px style='border-radius:50%'>";
                        echo "</div>";
                        echo "Username: ".$row['username']."<br>Name: ".$row['fname']." ".$row['lname']."<br>Batch: ".$course.", ".$dept.", year: ".$year."<br><a href='userprofile.php?uid=".$row['id']."' style='color:darkblue'>View Profile</a>";
                        echo "</div>";
                         
		              }
	               }
                    else{

		              echo '<div style="margin-left:40%;margin-top:5rem">No User Found!</div>';
	               }
                
            }
            
            
        }
                ?>
           </div> 
        </div>
        <script src="bootstrap-5/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <script type="text/javascript">
           function fetchProfile(id){
              
                $.ajax({
                type:'post',
                url: 'ajaxdata.php',
                data : { username : id},
                success : function(data){
                
            }

            })
        } 
            
        </script>
      </body>
    </html>