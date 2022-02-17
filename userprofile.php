<?php

    session_start();
    $success = "";
    $error = "";
    $x = "aa";
    $uid = $_GET['uid'];
    if (array_key_exists("id", $_COOKIE) && $_COOKIE ['id']) {
        
        $_SESSION['id'] = $_COOKIE['id'];
        
    }

    if (array_key_exists("id", $_SESSION)) {
              
      $link = mysqli_connect("localhost", "root", "", "SocialZ");
        
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }
        if (array_key_exists("submit-comment", $_POST)) {
        
        $link = mysqli_connect("localhost", "root", "", "SocialZ");
        
            if (mysqli_connect_error()) {
            
                die ("Database Connection Error");
                
            }
           
            if(!$_POST['comment'])
            {
                  $error = "<p>The comment is empty!</p>";
                  
             }
            else
            {
                $query = "INSERT INTO comments(comment,from_id,post_id) VALUES ('".$_POST['comment']."','".$_SESSION['id']."','".$_POST['submit-comment']."')";
                 if (!mysqli_query($link, $query)) 
                 {
                     $error = "<p>Please try again later.</p>";
                 }
                else
                {
                    $success = "<p>Posted successfully!</p>";
                    header("");
                }
                     
            }
        }
        
        if(isset( $_POST['request']))
        {
            
            if($_POST['request']=="Cancel")
            {   
                $temp = "SELECT * from requests where from_id = '".$_SESSION['id']."' and to_id='".$uid."'";
                $rt = $link->query($temp);
	            if ($rt->num_rows > 0 )
                {
                    $error= "Already Sent!!";
                }
                else
                {
                    $query = "INSERT INTO requests(from_id,to_id) values('".$_SESSION['id']."','".$uid."')";
                    if (!mysqli_query($link, $query)) 
                    {
                        $error = "<p>Please try again later.</p>";
                    }
                    else
                    {
                        $success = "<p>Sent successfully!</p>";  
                        header(""); 
                    }
                }
            }
            elseif($_POST['request']=="Connect")
            {
                $query = " DELETE FROM requests WHERE (from_id='".$_SESSION['id']."' AND to_id = '".$uid."') OR (to_id='".$_SESSION['id']."' AND from_id = '".$uid."')";
                if (!mysqli_query($link, $query)) 
                {
                    $error = "<p>Please try again later.</p>";
                }
                else
                {
                    $q1 = "DELETE From friends where u_id='".$_SESSION['id']."' and u_id='".$uid."'";
                    if (mysqli_query($link, $q1)) 
                    {
                        $q2 = "DELETE From friends where u_id='".$uid."' and u_id='".$_SESSION['id']."'";
                        if (mysqli_query($link, $q2)) 
                        {
                            $success = "<p>Disconnected from this user!</p>";  
                            header("");  
                        }                     
                        else
                        $error = "<p>Please try again later.</p>";
                    }
                    else
                    $error = "<p>Please try again later.</p>"; 
                    
                }
            }
            elseif($_POST['request']=="Connected")
            {
                $query = "UPDATE requests SET flag='1' WHERE to_id='".$_SESSION['id']."' and from_id='".$uid."'";
                if (!mysqli_query($link, $query)) 
                {
                    $error = "<p>Please try again later.</p>"; 
                }
                else
                {
                    $q1 = "INSERT into friends(u_id,friend_id) values('".$_SESSION['id']."','".$uid."')";
                    if (mysqli_query($link, $q1)) 
                    {
                        $q2 = "INSERT into friends(u_id,friend_id) values('".$uid."','".$_SESSION['id']."')";
                        if (mysqli_query($link, $q2)) 
                        {   
                            $success = "<p>Accepted successfully!</p>";  
                            header("");
                            
                        }
                        else
                            $error = "<p>Please try again later.</p>"; 
                        
                    }
                    else
                    $error = "<p>Please try again later.</p>"; 
                    
                }
            }

        
        }

        if(array_key_exists("like", $_POST))
        {
            echo "nnnnnn";
            $query = "SELECT * from likes  where liked_by ='".$_SESSION['id']."' and post_id = '".$_POST['like']."'";
            $result = $link->query($query);
            if ($result->num_rows == 0 ) {
            
                $q1 = "INSERT INTO likes(liked_by,post_id) VALUES('".$_SESSION['id']."','".$_POST['like']."')";
                $q2 = "UPDATE posts SET likes = (likes+1) where post_id ='".$_POST['like']."'";
                if ((!mysqli_query($link, $q1)) || (!mysqli_query($link, $q2)) ) 
                {
                    $error = "<p>Please try again later.</p>";
                }
                else
                {       
                        //header("Location: home.php");
                }
                
            }
            else
            {
                $q1 = "DELETE from likes where liked_by='".$_SESSION['id']."' and post_id='".$_POST['like']."'";
                $q2 = "UPDATE posts SET likes = (likes-1) where post_id ='".$_POST['like']."'";
                if ((!mysqli_query($link, $q1)) || (!mysqli_query($link, $q2)) ) 
                {
                    $error = "<p>Please try again later.</p>";
                }
                else
                {       
                        //header("Location: home.php");
                }
            }
        }
        //$eg = $_SESSION['id'];
        $query = "SELECT * FROM users WHERE id = '" .$uid. "' LIMIT 1";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        $fname = $row['fname'];
        $lname = $row['lname'];
        $img = $row['img'];
        
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
        if(!$row['dob']){
            $dob = "";
        }
        else{
            $dob = $row['dob'];
        }
        if(!$row['city']){
            $x = "";
            $city = "";
        }
        
        else{
            $x = $row['city'];
             $q5 = "SELECT city FROM city WHERE id = '" .$x. "' LIMIT 1";
        $result = mysqli_query($link, $q5);
        $r5 = mysqli_fetch_array($result);
        $city = $r5['city'];
        }
        if(!$row['bck_img']){
            $bgimg = "";
        }
        
        else{
            $bgimg = $row['bck_img'];
        }
        if(!$row['state']){
            $s = "";
            $state = "";
        }
        else{
            $s = $row['state'];
            $q4 = "SELECT state FROM state WHERE id = '" .$s. "' LIMIT 1";
        $result = mysqli_query($link, $q4);
        $r4 = mysqli_fetch_array($result);
        $state = $r4['state'];
        }
        if(!$row['phno']){
            $phno = "";
        }
        else{
            $phno = $row['phno'];
        }
        $q1 = "SELECT dept_name FROM department WHERE id = '" .$d. "' LIMIT 1";
        $result = mysqli_query($link, $q1);
        $r1 = mysqli_fetch_array($result);
        $dept = $r1['dept_name'];
        $q2 = "SELECT course_name FROM course WHERE id = '" .$c. "' LIMIT 1";
        $result = mysqli_query($link, $q2);
        $r2 = mysqli_fetch_array($result);
        $course = $r2['course_name'];
        $q3 = "SELECT year FROM year WHERE id = '" .$y. "' LIMIT 1";
        $result = mysqli_query($link, $q3);
        $r3 = mysqli_fetch_array($result);
        $year = $r3['year'];
        
       
        
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
<link href="StyleSheet.css" rel="stylesheet">
        <link href="bootstrap-5/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>
        <link href="StyleSheet.css" rel="stylesheet">
        <title>SocialOwl - <?php
                    echo $fname." ".$lname; ?></title>
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
            <a class="nav-link" aria-current="page" href="search.php">Find People</a>
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

        <div class="profile" style=" width:auto;min-height:80rem;overflow:hidden;background-color:white;margin-left:10%;margin-right:10%;margin-top:4rem;border-radius:8px;margin-bottom:2rem;word-wrap: break-word;">
        <div style="margin-left:auto;margin-right:auto;width:15rem">
        <?php 
            if($error!=""){
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" >'.$error.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
            elseif($success!=""){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$success.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }
        ?>
        </div>
            <div class="background" style="background-color:black;color:white;height:15rem;border-radius:8px;z-index:-1">
               <?php
                if ($bgimg!=""){
                echo "<img src=".$bgimg." style='height:14.3rem;width:49.8rem;margin:5px;border-radius:5px;z-index:-1;'>";}
                ?> 
            </div>
            <div class="profile-div" style="height:180px;width:180px;background-image:linear-gradient(white, gray);margin-left:5%;margin-top:-5rem;border-radius:8px;z-index:100;position:absolute">
                <?php
                
                echo "<img src=".$img." style='height:170px;width:170px;margin:5px;border-radius:5px;'>";
                ?>
            </div>
            
            <div>
                <div style="margin-left:3rem;font-size:30px;margin-top:15%;word-wrap: break-word;">
                    <?php
                    echo $fname." ".$lname."<br>";  
                    
                    echo $course.", ".$dept.", year: ".$year;
                    ?>
                </div>
            <div class="about-div" style="margin-left:10%;margin-top:4%;width:20rem;word-wrap: break-word;float:left;margin-right:-25rem;">
                <p><strong>About:</strong></p>
                <p style="color:gray;margin-left:4%"><?php echo "<em>" .$about ."</em>" ?></p>
                <p><strong>Goals:</strong></p>
                <p style="color:gray;margin-left:4%"><?php echo "<em>" .$goals ."</em>" ?></p>
                <p><strong>Interests:</strong></p>
                <p style="color:gray;margin-left:4%"><?php echo "<em>" .$interest1."<br>".$interest2."<br>".$interest3."<br>".$interest4."<br>".$interest5."<br></em>" ?></p>
                
            </div>
            
            <div style="background-color:black;width:2px;height:22rem;margin-left:27rem;margin-top:4%;float:left">
            </div>
            
            <div class="info-div" style="float:left;margin-top:4%;width:17rem;word-wrap: break-word;margin-left:2rem;"> 
                <p><strong>Contact Details:</strong></p>
                <p>Username:<span style="color:gray;margin-left:4%"><?php echo "<em>" .$username ."</em>" ?></span></p>
                <p>Email:<span style="color:gray;margin-left:4%"><?php echo "<em>" .$email ."</em>" ?></span></p>
                <p>Date-of-Birth:<span style="color:gray;margin-left:4%"><?php echo "<em>" .$dob ."</em>" ?></span></p>
                <p>City:<span style="color:gray;margin-left:4%"><?php echo "<em>" .$city ."</em>" ?></span></p>
                 <p>State:<span style="color:gray;margin-left:4%"><?php echo "<em>" .$state ."</em>" ?></span></p>
                <p>Phone number:<span style="color:gray;margin-left:4%"><?php echo "<em>" .$phno ."</em>" ?></span></p>
                <form method="post">
                <?php
                    include 'config.php';
                    $query = "SELECT * from requests where (from_id='".$_SESSION['id']."' and to_id='".$uid."') or (to_id='".$_SESSION['id']."' and from_id='".$uid."')";
                    $result = $db->query($query);
	                if ($result->num_rows > 0 )
                    {
                        while($row =$result->fetch_assoc()) 
                        {
                            if($row['flag'] == 0 && $row['from_id'] == $_SESSION['id'])   
                            {
                                echo '<input class="btn " type="submit" id="request" style="margin-left:0rem"  onclick="connect(this.id)" value="Cancel" name="request"></input>'; 
                            }

                            if($row['flag'] == 0 && $row['to_id'] == $_SESSION['id'])   
                            {
                                echo '<input class="btn " type="submit" id="request" style="margin-left:0rem"  onclick="connect(this.id)" value="Accept" name="request"></input>'; 
                            }
                        
                            if($row['flag'] == 1)   
                            {
                                echo '<input class="btn " type="submit" id="request" style="margin-left:0rem;background-color:green"  onclick="connect(this.id)" value="Connected" name="request"></input>'; 
                            }
                            
                           
                        }
                    }
                    else
                    {
                        echo '<input class="btn " type="submit" id="request" style="margin-left:0rem"  onclick="connect(this.id)" value="Connect" name="request"></input>';
                    }
                    
                ?>
                </form>
            </div>
            </div>
            <div style="background-color:#F7F7F7;margin-top:25rem;margin-left:2%;margin-right:2%;padding:2rem;overflow:hidden">
                <div style="width:50rem">
                <span style="font-size:30px;float:left;margin-bottom:3rem">Posts:</span>
                </div>
                <div style="float:left">
                <?php
                    $link = mysqli_connect("localhost", "root", "", "SocialZ");
        
                    if (mysqli_connect_error()) {
            
                    die ("Database Connection Error");
                
                    }
                $qp = "SELECT * FROM posts WHERE user_id =".$uid." ORDER BY date DESC";
                $rp = $link->query($qp);
                if ($rp->num_rows > 0 ) {
                while ($row = $rp->fetch_assoc()){
                $q1 = "SELECT * from users where id='".$row['user_id']."'";
                $r1 = mysqli_query($link, $q1);
                $sub_row = mysqli_fetch_array($r1);
                echo "<div style='background-color:white;  ;float:left;border-radius:7px;margin-right:1rem;margin-left:8rem;margin-bottom:2rem;border-color:#e5e8ea;border-style: solid;padding:2rem;border-width:1px;box-shadow: 2px 4px #e5e8ea;'>";
                    echo "<div style='margin-bottom:2rem'>";
                        echo "<img src='".$sub_row['img']."'height=50px width=50px style='float:left;border-radius:50%;border-color:black;border-width:1px;border-style: solid;'>";
                        echo "<div style='float:left;margin-left:1rem;margin-top:5px;'>";
                            echo "<a href='userprofile.php?uid=".$row['user_id']."' style='color:darkblue'>".$sub_row['fname']." ".$sub_row['lname']."</a>";
                            echo "<div style='font-size:10px;color:gray'>".$sub_row['username']."<br></div></div>";
                        echo "</div>";
                        echo "<div style='font-size:18px;float:left;width:100%;margin-top:1.5rem;'>";
                            echo $row['caption'];
                            echo "<div style='float:right;font-size:12px;color:gray'>".$row['date']."</div>";
                            if($row['img_post'] != "")
                            {
                            echo "<img src='".$row['img_post']."' height=280px width=280px; style='margin-left:8%;margin-right:8%;margin-top:1rem'>";
                        }   
                    echo "</div>";
                    echo "<div style='text-align:center;'>";
                            echo '<form method="post">';
                                echo $row['likes'];
                                echo "<button type='submit'  class='submit-button'  name='like' value='".$row['post_id']."' style='margin-left:auto;margin-right:auto'><img src='img/like.png' style='width:30px;margin-left:auto;margin-right:auto'></button>";
                            echo "</form>";   
                            echo "</div>";
                    echo "<form method='post'>";

                            echo "<div class='row' style='margin-top:2rem;width:auto;background-color:#EDEDED;border-radius:4px;overflow:hidden'>";
                                echo "<div style='margin-top:1rem;margin-bottom:1rem'>";
                                    echo "<div class='col'>"; 
                                    echo "<input type='text' name='comment' id='comment' placeholder='Add a comment...' class='form-control' style='width:14rem'>";
                                    echo "</div>";

                                    echo "<div class='col'>";
                                    echo "<button type='submit' name='submit-comment' class='btn ' style='margin-left:1rem;font-size:12px;float:right;margin-top:-2rem'  value='".$row['post_id']."'>Comment</button>";

                                    echo "</div>";

                                echo "</div>";

                                    echo "<div class='show-comments' style='font-size:15px;margin:1rem;word-wrap: break-word;max-height:6rem;overflow:scroll;'>";
                                        $query_c = "SELECT * FROM comments WHERE post_id = '".$row['post_id']."'";
                                        $fetch_c = $link->query($query_c);
                                        if ($fetch_c->num_rows > 0 ) {
                                            while ($row_c = $fetch_c->fetch_assoc()){
                                                $comment_from = "SELECT username from users where id='".$row_c['from_id']."'";
                                                $commentor = mysqli_query($link, $comment_from);
                                                $from = mysqli_fetch_array($commentor);
                                                echo "<span style='font-weight:bold'>".$from['username']."</span>";
                                                echo " ".$row_c['comment']."<br>";
                                            }
                                        }
                                    echo "</div>";

                                echo "</div>";

                        echo "</form>";
                echo "</div>";
            }
            }
            else{
                
                echo "<div style='margin-top:4rem;margin-bottom:4rem;margin-left:13rem;font-size:25px;'>No Post Yet!</div>";
            }
                ?>
            </div>
            </div>
        </div>
        <script src="bootstrap-5/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script type="text/javascript">
            function myFunction() {
                var x = document.getElementById("bgpicture");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
                var y = document.getElementById("upload");
                if (y.style.display === "none") {
                    y.style.display = "block";
                } else {
                    y.style.display = "none";
                }
            }

            function connect(id){
 let element = document.getElementById(id);
 if (element.value=="Connect") 
 	{
         element.value = "Cancel";
         $.ajax
         ({
            type:'post',
            url: 'userprofile.php',
            data : { to_id : id},
            
        })
     }
else if(element.value=="Accept")
{
    element.value = "Connected";
         $.ajax
         ({
            type:'post',
            url: 'userprofile.php',
            data : { to_id : id},
            
        })
}
else if(element.value=="Connected")
{
    element.value = "Connect";
         $.ajax
         ({
            type:'post',
            url: 'userprofile.php',
            data : { to_id : id},
            
        })
}
else
 	element.value = "Connect";
}


        </script>

      </body>
    </html>