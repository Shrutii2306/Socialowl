<?php

    session_start();
    $success = "";
    $error = "";
   
    if (array_key_exists("id", $_COOKIE) && $_COOKIE ['id']) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        
    }

    if (array_key_exists("id", $_SESSION)) {
              
      $link = mysqli_connect("localhost", "root", "", "SocialZ");
        
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }

    if (array_key_exists("submit", $_POST)) {
        
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
                    $bgimg = $row['bck_img'];
                    $d = $row['dept'];
                    $c = $row['course'];
                    $y = $row['year'];
                    $about = $row['about'];
                    $goals = $row['goal'];
                    $interest1 = $row['interest1'];
                    $interest2 = $row['interest2'];
                    $interest3 = $row['interest3'];
                    $interest4 = $row['interest4'];
                    $interest5 = $row['interest5'];
                    $email = $row['email'];
                    $username = $row['username'];
                    $pass = $row['pass'];
                    $x = $row['city'];
                    $s = $row['state'];
                    $dob = $row['dob'];
                    $phno = $row['phno'];
                    
                    if($_FILES['profilepicture'])
                    {
                    $files= $_FILES['profilepicture'];
                    $filename = $files['name'];
                    $filetmp = $files['tmp_name'];
                    $fileext = explode('.',$filename);
                    $filecheck = strtolower(end($fileext));
                    $fileextstored = array('png','jpg','jpeg','jfif');
                        if(in_array($filecheck,$fileextstored))
                        {
                        $img = 'profilepic/'.$filename;
                        move_uploaded_file($filetmp,$img);
                        
                        }
                    }
        
                    if($_FILES['bgpicture'])
                    {
                    $files= $_FILES['bgpicture'];
                    $filename = $files['name'];
                    $filetmp = $files['tmp_name'];
                    $fileext = explode('.',$filename);
                    $filecheck = strtolower(end($fileext));
                    $fileextstored = array('png','jpg','jpeg','jfif');
                        if(in_array($filecheck,$fileextstored))
                        {
                        $bgimg = 'profilepic/'.$filename;
                        move_uploaded_file($filetmp,$bgimg);
                        
                        }
                    }
                    if($_POST['Fname'])
                    {
                        $fname = mysqli_real_escape_string($link,$_POST['Fname']);
                    }
                    if($_POST['Lname'])
                    {
                        $lname = mysqli_real_escape_string($link,$_POST['Lname']);
                    }
                    if($_POST['password'])
                    {
                        $pass = mysqli_real_escape_string($link,$_POST['password']);
                    }
                    if($_POST['goal'])
                    {
                        $goals = $_POST['goal'];
                    }
                    if($_POST['about'])
                    {
                        $about = $_POST['about'];
                    }
                    if($_POST['interest1'])
                    {
                        $interest1 = $_POST['interest1'];
                    }
                    if($_POST['interest2'])
                    {
                        $interest2 = $_POST['interest2'];
                    }
                    if($_POST['interest3'])
                    {
                        $interest3 = $_POST['interest3'];
                    }
                    if($_POST['interest3'])
                    {
                        $interest3 = $_POST['interest3'];
                    }
                    if($_POST['interest4'])
                    {
                        $interest4 = $_POST['interest4'];
                    }
                    if($_POST['interest5'])
                    {
                        $interest5 = $_POST['interest5'];
                    }
                    if($_POST['dept'])
                    {
                        $d = $_POST['dept'];
                    }
                    if($_POST['course'])
                    {
                        $c = $_POST['course'];
                    }
                    if($_POST['year'])
                    {
                        $y = $_POST['year'];
                    }
                    if($_POST['city'])
                    {
                        $x = $_POST['city'];
                    }
                    if($_POST['state'])
                    {
                        $s = $_POST['state'];
                    }
                    if($_POST['dob'])
                    {
                        $dob = $_POST['dob'];
                    }
                    if($_POST['phno'])
                    {
                        $phno = $_POST['phno'];
                    }
                    $query = "UPDATE `users` SET `fname`='".$fname."',`lname`='".$lname."',`pass`='".$pass."',`goal`='".$goals."',`about`='".$about."',`interest1`='".$interest1."',`interest2`='".$interest2."',`interest3`='".$interest3."',`interest4`='".$interest4."',`interest5`='".$interest5."',`dept`='".$d."',`course`='".$c."',`year`='".$y."',`img`='".$img."',`bck_img`='".$bgimg."',`city`='".$x."',`state`='".$s."' ,`dob`='".$dob."',`phno`='".$phno."' WHERE id = '".$eg."'";

                    if (!mysqli_query($link, $query)) {

                        $error = "<p>Could not update profile - please try again later!</p>";

                    } 
                     else {

                        
                        
                        $id = mysqli_insert_id($link);
                        
                        mysqli_query($link, $query);

                        $_SESSION['id'] = $id;

                        if (isset($_POST['stayLoggedIn']) AND $_POST['stayLoggedIn'] == '1') {

                            setcookie("id", $id, time() + 60*60*24*365);
                            
                        } 
                        $success = "<p>Profile updated successfully- please login again to continue!.</p>";    
                        header("Location:Login.php");

                    }

                } 
                
            }
    
        
?>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SocialOwl - Update your Profile</title>
        <link rel = "icon" href ="img/logo1.png" type = "image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="bootstrap-5/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="jquerymain.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>

        <link href="Stylesheet.css" rel="stylesheet">
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
    <body>  
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
              <input class="form-control" type="search" placeholder="Search" aria-label="Search" style="width:13rem;height:2rem;border-radius:1rem;margin-top:3px;">
              </li>
              <li class="nav-item">
      <button class="btn btn-outline-success" type="submit" style="margin-left:0.5rem;">Search</button>
              </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="home.php">Feed</a>
        </li>
          <li class="nav-item">
          <a class="nav-link  active" aria-current="page" href="MyProfile.php">My Profile</a>
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
        $query3 = "SELECT * FROM state ";
        $result6 = $db->query($query3);
        ?>
        
    <div class="reg">
        <div id="error"><?php if ($error!="") {
    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    
} 
        elseif ($success!="") {
    echo '<div class="alert alert-success" role="alert">'.$success.'</div>';
    
} ?></div>
        <div class="card bg-dark text-white border-light" style="box-shadow: 7px 10px #e5e8ea;margin-top:3rem;">
  <img src="img/card.png" class="card-img" alt="...">
  <div class="card-img-overlay">
                
                
                <form method="post" id="registerform" enctype="multipart/form-data">
                <h1 class="heading" style="
                margin-top: 7rem;margin-bottom:3rem; text-shadow: 1px 1px #e5e8ea;">Update your profile</h1>
                    <div class="row">
                        <div class="col">
                            <label for="Fname" class="form-label">First Name </label>
                            <input type="text" class="form-control" placeholder="First name" aria-label="First name" id="Fname" name="Fname">
                        </div>
                        <div class="col">
                            <label for="Lname" class="form-label">Last Name </label>
                            <input type="text" class="form-control" placeholder="Last name" aria-label="Last name" id="Lname" name="Lname">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="dept" class="form-label">Department </label>
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
                            <label for="course" class="form-label">Course </label>
                            <select id="course" name="course"  class="form-control" onchange="FetchYear(this.value)">
                                <option selected disabled>Select Course</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="year" class="form-label">Year </label>
                            <select id="year" name="year" class="form-control" >
                                <option selected disabled>Year</option>
                            </select>
                            
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col">
                            <label for="password" class="form-label">Password </label>
                            <input type="password" class="form-control" placeholder="Password"  id="password" name="password">
                        </div>
                        <div class="col">
                            <label for="dob" class="form-label">Date of Birth </label>
                            <input type="date" class="form-control" placeholder="Date of Birth"  id="dob" name="dob">
                        </div>
                        
                    </div>
                    <div class="mb-3">
                        <label for="about" class="form-label">About </label>
                        <textarea class="form-control" name="about" id="about" rows="3" placeholder="Tell us something about yourself..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="goal" class="form-label">Goals </label>
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
                    
                     <div class="row">
                        <div class="col">
                            <label for="state" class="form-label">State </label>
                            <select class="form-control" id="state" name="state" onchange="FetchState(this.value)">
                                <option selected disabled>Select State</option>
                                <?php
                                    if ($result6->num_rows > 0 ) {
                                    while ($row = $result6->fetch_assoc()) {
                                        echo '<option value='.$row['id'].'>'.$row['state'].'</option>';
                                    }
            }                       
          ?> 
                            </select>
                        </div>
                        <div class="col">
                            <label for="city" class="form-label">City </label>
                            <select id="city" name="city"  class="form-control">
                                <option selected disabled>Select city</option>
                            </select>
                        </div>
                         <div class="col">
                        <label for="phno" class="form label">Phone Number: </label>
                        <input type="text" id="phno" name="phno" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                    <div class="col">
                        <label for="profilepicture" class="form label">Add Profile Photo </label>
                        <input type="file" id="profilepicture" name="profilepicture" class="form-control">
                    </div>
                        <div class="col">
                        <label for="bgpicture" class="form label">Add Background Photo </label>
                        <input type="file" id="bgpicture" name="bgpicture" class="form-control">
                    </div>
                   
                    </div>
                    <div class="but">
                        <button type="submit" class="btn btn-primary" name="submit">Update Profile</button>
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
  function FetchState(id){
    $('#city').html('');
    
    $.ajax({
      type:'post',
      url: 'ajaxdata.php',
      data : { state_id : id},
      success : function(data){
         $('#city').html(data);
      }

    })
  }          
    
</script>

      </body>
    </html>