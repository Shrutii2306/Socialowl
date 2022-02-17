<?php

    session_start();

    $error = "";  
    $suc = $_GET['suc'];
    if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";  
        
        session_destroy();
        
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: home.php");
        
    }

    if (array_key_exists("submit", $_POST)) {
        
        $link = mysqli_connect("localhost", "root", "", "SocialZ");
        
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }
        
        
        if (!$_POST['username']) {
            
            $error .= "An username is required<br>";
            
        } 
        
        if (!$_POST['password']) {
            
            $error .= "A password is required<br>";
            
        } 
        
        if ($error != "") {
            
            $error = "<p>Required :</p>".$error;
            
        } else
        {   $query = "SELECT * FROM users WHERE username = '".mysqli_real_escape_string($link, $_POST['username'])."'";
                
                    $result = mysqli_query($link, $query);
                
                    $row = mysqli_fetch_array($result);
                
                    if (isset($row)) {
                        
                        
                        
                        if ($_POST['password'] == $row['pass']) {
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if (isset($_POST['stayLoggedIn']) AND $_POST['stayLoggedIn'] == '1') {

                                setcookie("id", $row['id'], time() + 60*60*24*365);

                            } 

                            header("Location: home.php");
                                
                        } else {
                            
                            $error = "That email/password combination could not be found.";
                            
                        }
                        
                    }
                    else
                    {
                        
                        $error = "That email/password combination could not be found.";
                        
                    }
                    
                }
            
        }                                      
        
        
    

?>
            
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SocialOwl - Login</title>
        <link rel = "icon" href ="img/logo1.png" type = "image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="bootstrap-5/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="jquerymain.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>

        <link href="Stylesheet.css" rel="stylesheet">
        
    </head>
    <body>  
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #5DB0FF">
             
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
          <a class="nav-link " aria-current="page" href="index.html">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  active" href="Login.php">Login</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="Register.php">Sign Up</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="Team.html">Team</a>
        </li> 
      </ul>
       
    </div>
      </div>
  </div>
</nav>
        
    <div class="reg">
        <div id="error"><?php if ($error!="") {
          echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';}
          elseif($suc!= ""){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert" >'.$success.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button></div>';

        } 
           ?></div>
        <div class="card bg-dark text-white border-light" style="margin-top:4rem;box-shadow: 7px 10px #e5e8ea;">
  <img src="img/card.png" class="card-img" alt="...">
  <div class="card-img-overlay">
                
                
                <form method="post">
                    <h1 class="heading" style="
                margin-top: 7rem; margin-bottom:6rem;text-shadow: 1px 1px #e5e8ea;">Login</h1>
                   <div style="margin-bottom:4rem;margin-left:3rem;margin-right:3rem">   
                    <div class="row">
                        <div class="col">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" placeholder="Username"  name="username" id="username">
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" placeholder="Password"  id="password" name="password">
                        </div>
                      </div>    
                    </div>
                    <div class="mb-3">
                        <div class="checkbox">
    
                            <label>
    
                                <input type="checkbox" name="stayLoggedIn" value=1> Stay logged in
            
                            </label>
        
                        </div>
                    </div>   
                    <div style="float:left;margin-top:3rem;margin-left:-3rem">
                        <button type="Submit" class="btn btn-primary" style="float:left"><a href="Register.php">New user? Register</a></button>
                    </div>
                    <div class="but">
                        <button type="submit" class="btn btn-primary" name="submit">Login</button>
                    </div>
                </form>
            
            </div>
        </div>
        </div> 
        <script src="bootstrap-5/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script type="text/javascript">
  function FetchDept(id){
    $('#course').html('');
    $('#year').html('<option>Select Year</option>');
    $.ajax({
      type:'post',
      url: 'ajaxdata.php',
      data : { dept_id : id},
      success : function(data){
         $('#course').html(data);
      }

    })
  }

  function FetchYear(id){ 
    $('#year').html('');
    $.ajax({
      type:'post',
      url: 'ajaxdata.php',
      data : { course_id : id},
      success : function(data){
         $('#year').html(data);
      }

    })
  }
</script>

      </body>
    </html>