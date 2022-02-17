<?php

    session_start();
    $success = "";

    if (array_key_exists("id", $_COOKIE) && $_COOKIE ['id']) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        
    }

    if (array_key_exists("id", $_SESSION)) {
              
      $link = mysqli_connect("localhost", "root", "", "SocialZ");
        
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }
        
        $eg = $_SESSION['id'];
        $query = "SELECT * FROM users WHERE id = '" .$eg. "' LIMIT 1";
                
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);
        $fname = $row['fname'];
        $lname = $row['lname'];
        $img = $row['img'];
    } else {
        
        header("Location: Login.php");
        
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <link href="bootstrap-5/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>
        <link href="StyleSheet.css" rel="stylesheet">
        <title>Feed</title>
        
    </head>
    <body>
     <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #5DB0FF">
             
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
            <a class="nav-link active" aria-current="page" href="home.php">Feed</a>
        </li>
          <li class="nav-item">
          <a class="nav-link " aria-current="page" href="MyProfile.html">My Profile</a>
        </li>
          <li class="nav-item">
          <a class="nav-link " href="Inbox.html">Inbox</a>
        </li>
          <li class="nav-item">
          <a class="nav-link " href="Store.html">Store</a>
        </li>
          <li class="nav-item">
          <a href ='login.php?logout=1'>
        <button class="btn btn-success" type="submit">Logout</button></a>
            
        </li>
      </ul>
      
    </div>
      </div>
  </div>
</nav>
        
        <div class="sidebar">
            <?php
                include 'config.php';
                      
            ?>
            <div class="profile-photo" style="background-image:url(img/profile-photo.png);
        height: 100px;
        width: 100px;margin-top:3rem;margin-left:3.5rem;border-radius:50%">
            </div>
            <?php
               echo $fname."-".$lname."-".$img;
                echo "Select img from users"
            ?>
        </div>

        <script src="bootstrap-5/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


      </body>
    </html>