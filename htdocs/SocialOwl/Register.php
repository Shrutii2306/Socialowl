<?php

    session_start();

    $error = "";  
    
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
        
        if (!$_POST['Fname'] || !$_POST['Lname'] || !$_POST['email'] || empty($_POST['year']) || !$_POST['password'] || !$_POST['about'] || !$_POST['goal'] || !$_FILES['profilepicture']) {
            
            $error .= "One or more fields are empty<br>";
            
        } 
        
         else {
            
            
            
                $query = "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'OR username = '".mysqli_real_escape_string($link, $_POST['username'])."' LIMIT 1";

                $res = mysqli_query($link, $query);

                if (mysqli_num_rows($res) > 0) {

                    $error = "That email address or username is taken.";

                } 
                
                else 
                {

                    $query = "INSERT INTO users (fname,lname, username,email, pass,goal,about,interest1,interest2,interest3,interest4,interest5,dept,course,year,img) VALUES ('".mysqli_real_escape_string($link, $_POST['Fname'])."','".mysqli_real_escape_string($link, $_POST['Lname'])."','".mysqli_real_escape_string($link, $_POST['username'])."','".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."','".mysqli_real_escape_string($link, $_POST['goal'])."','".mysqli_real_escape_string($link, $_POST['about'])."','".mysqli_real_escape_string($link, $_POST['interest1'])."','".mysqli_real_escape_string($link, $_POST['interest2'])."','".mysqli_real_escape_string($link, $_POST['interest3'])."','".mysqli_real_escape_string($link, $_POST['interest4'])."','".mysqli_real_escape_string($link, $_POST['interest5'])."','".mysqli_real_escape_string($link, $_POST['dept'])."','".mysqli_real_escape_string($link, $_POST['course'])."','".mysqli_real_escape_string($link, $_POST['year'])."','".$_FILES['profilepicture']."')";

                    if (!mysqli_query($link, $query)) {

                        $error = "<p>Could not sign you up - please try again later.</p>";

                    } 
                     else {

                        $query = "UPDATE users SET pass = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
                        
                        $id = mysqli_insert_id($link);
                        
                        mysqli_query($link, $query);

                        $_SESSION['id'] = $id;

                        if (isset($_POST['stayLoggedIn']) AND $_POST['stayLoggedIn'] == '1') {

                            setcookie("id", $id, time() + 60*60*24*365);

                        } 
                            
                        header("Location: home.php");

                    }

                } 
                
            }
    }
        
?>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SocialOwl - Register</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="bootstrap-5/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="jquerymain.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>

        <link href="Stylesheet.css" rel="stylesheet">
        
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
          <a class="nav-link " aria-current="page" href="index.html">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Login.php">Login</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link active" href="Register.php">Sign Up</a>
        </li>
          <li class="nav-item">
          <a class="nav-link" href="Team.html">Team</a>
        </li>
      </ul>
      
    </div>
      </div>
  </div>
</nav>
        <?php
        include_once 'config.php';
        $query = "SELECT * FROM department ";
        $result = $db->query($query);
        $query2 = "SELECT * FROM interests ";
        $result1 = $db->query($query2);
        $result2 = $db->query($query2);
        $result3 = $db->query($query2);
        $result4 = $db->query($query2);
        $result5 = $db->query($query2);
        ?>
        
    <div class="reg">
        <div id="error"><?php if ($error!="") {
    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    
} ?></div>
        <div class="card bg-dark text-white border-light" style="box-shadow: 7px 10px #e5e8ea;">
  <img src="img/card.png" class="card-img" alt="...">
  <div class="card-img-overlay">
                
                
                <form method="post" id="registerform" enctype="multipart/form-data">
                <h1 class="heading" style="
                margin-top: 7rem;margin-bottom:3rem; text-shadow: 1px 1px #e5e8ea;">Registration</h1>
                    <div class="row">
                        <div class="col">
                            <label for="Fname" class="form-label">First Name<span style="color:red">*</span></label>
                            <input type="text" class="form-control" placeholder="First name" aria-label="First name" id="Fname" name="Fname">
                        </div>
                        <div class="col">
                            <label for="Lname" class="form-label">Last Name<span style="color:red">*</span></label>
                            <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" id="Lname" name="Lname">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address<span style="color:red">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="example@email.com">
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="dept" class="form-label">Department<span style="color:red">*</span></label>
                            <select class="form-control" id="dept" name="dept" onchange="FetchDept(this.value)">
                                <option selected disabled>Select Department</option>
                                <?php
                                    if ($result->num_rows > 0 ) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value='.$row['id'].'>'.$row['dept_name'].'</option>';
                                    }
            }                       
          ?> 
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="course" class="form-label">Course<span style="color:red">*</span></label>
                            <select id="course" name="course"  class="form-control" onchange="FetchYear(this.value)">
                                <option selected disabled>Select Course</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="year" class="form-label">Year<span style="color:red">*</span></label>
                            <select id="year" name="year" class="form-control" >
                                <option selected disabled>Year</option>
                            </select>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="username" class="form-label">Username<span style="color:red">*</span></label>
                            <input type="text" class="form-control" placeholder="Username"  name="username" id="username">
                        </div>
                    
                        <div class="col">
                            <label for="password" class="form-label">Password<span style="color:red">*</span></label>
                            <input type="password" class="form-control" placeholder="Password"  id="password" name="password">
                        </div>
                        
                    </div>
                    <div class="mb-3">
                        <label for="about" class="form-label">About<span style="color:red">*</span></label>
                        <textarea class="form-control" name="about" id="about" rows="3" placeholder="Tell us something about yourself..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="goal" class="form-label">Goals<span style="color:red">*</span></label>
                        <textarea class="form-control" id="goal" name="goal" placeholder="We know you definitely have thought about it, why not share it with us?"rows="3"></textarea>
                    </div>
                    <div class="row">
                        Select Your Interests
                        <div class="col">
                            
                            <select   class="form-control" id="interest1" name="interest1">
                                <option selected disabled>Interest 1</option>
                                <?php
                                    if ($result1->num_rows > 0 ) {
                                    while ($row = $result1->fetch_assoc()) {
                                        echo '<option value='.$row['interest'].'>'.$row['interest'].'</option>';
                                    }
            }                       
          ?> 
                            </select>
                        </div>
                            <div class="col">
                            <select   class="form-control" id="interest2" name="interest2">
                                <option selected disabled>Interest 2</option>
                                <?php
                                    if ($result2->num_rows > 0 ) {
                                    while ($row = $result2->fetch_assoc()) {
                                        echo '<option value='.$row['interest'].'>'.$row['interest'].'</option>';
                                    }
            }                       
          ?> 
                            </select>
                        </div>
                                <div class="col">
                            <select   class="form-control" id="interest3" name="interest3" >
                                <option selected disabled>Interest 3</option>
                                <?php
                                    if ($result3->num_rows > 0 ) {
                                    while ($row = $result3->fetch_assoc()) {
                                        echo '<option value='.$row['interest'].'>'.$row['interest'].'</option>';
                                    }
            }                       
          ?> 
                            </select>
                        </div>
                                    <div class="col">
                            <select   class="form-control" id="interest4" name="interest4" >
                                <option selected disabled>Interest 4</option>
                                <?php
                                    if ($result4->num_rows > 0 ) {
                                    while ($row = $result4->fetch_assoc()) {
                                        echo '<option value='.$row['interest'].'>'.$row['interest'].'</option>';
                                    }
            }                       
          ?> 
                            </select>
                        </div>
                                        <div class="col">
                            <select   class="form-control" id="interest5" name="interest5" >
                                <option selected disabled>Interest 5</option>
                                <?php
                                    if ($result5->num_rows > 0 ) {
                                    while ($row = $result5->fetch_assoc()) {
                                        echo '<option value='.$row['interest'].'>'.$row['interest'].'</option>';
                                    }
            }                       
          ?> 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="profilepicture" class="form label">Add Profile Photo<span style="color:red">*</span></label>
                        <input type="file" id="profilepicture" name="profilepicture" class="form-control">
                    </div>
                    <span style="color:red;font-size:15px">Mandatory fields are marked wth *</span>
                    <div class="mb-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="stayLoggedIn" value=1> Stay logged in
                            </label>
                        </div>
                    </div>    
                    <div style="float:left;margin-top:3rem;margin-left:-3rem">
                        <button type="Submit" class="btn btn-primary " style="float:left"><a href="Login.php">Already Registered? Login</a></button>
                    </div>
                    <div class="but">
                        <button type="submit" class="btn btn-primary" name="submit">Next</button>
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