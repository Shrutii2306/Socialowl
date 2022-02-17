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
            
            if($_POST['caption'] && !empty($_FILES['photo']))
            {
                    
                    date_default_timezone_set('Asia/Kolkata');
                    $date = date('d-m-y h:i:s');
                    $post_img = "";
                    $files= $_FILES['photo'];
                    $filename = $files['name'];
                    $filetmp = $files['tmp_name'];
                    $fileext = explode('.',$filename);
                    $filecheck = strtolower(end($fileext));
                    $fileextstored = array('png','jpg','jpeg','jfif');
                        if(in_array($filecheck,$fileextstored))
                        {
                        $post_img = 'posts/'.$filename;
                        move_uploaded_file($filetmp,$post_img);
                        
                        }
                    if($post_img != "")
                    {   $date1 = date('Y/m/d');
                        
                        $query = "INSERT INTO posts(caption,img_post,user_id,date) VALUES ('".$_POST['caption']."','".$post_img."','".$_SESSION['id']."','".$date1."')";
                        
                    }
                    else
                    {   $date1 = date('Y/m/d');
                        
                        $query = "INSERT INTO posts(caption,user_id,date) VALUES ('".$_POST['caption']."','".$_SESSION['id']."','".$date1."')";
                    }
                    if (!mysqli_query($link, $query)) {

                        $error = "<p>Please try again later.</p>";

                    }
                    else{
                        
                        $success = "<p>Posted successfully!</p>";
                        header("Location: home.php");
                    }
                }
                
                
                else
                {
                    $error = "<p>The post is empty!</p>"; 
                }
            
            
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
                    header("Location: home.php");
                }
                     
            }
            
            
        }

        if(array_key_exists("accept", $_POST))
        {
            
            $query = "UPDATE requests SET flag='1' WHERE to_id='".$_SESSION['id']."' and from_id='".$_POST['accept']."'";

            if (!mysqli_query($link, $query)) 
            {
                $error = "<p>Please try again later.</p>"; 
            }
            else
            {
                $q1 = "INSERT into friends(u_id,friend_id) values('".$_SESSION['id']."','".$_POST['accept']."')";
                if (mysqli_query($link, $q1)) 
                {
                    $q2 = "INSERT into friends(u_id,friend_id) values('".$_POST['accept']."','".$_SESSION['id']."')";
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
            
        
        $eg = $_SESSION['id'];
        
        $query = "SELECT * FROM users WHERE id = '" .$eg. "' LIMIT 1";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        $fname = $row['fname'];
        $lname = $row['lname'];
        $username = $row['username'];
        $img = $row['img'];
        $d = $row['dept'];
        $c = $row['course'];
        $y = $row['year'];
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

        <link href="bootstrap-5/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>
        <link href="StyleSheet.css" rel="stylesheet">
        <title>Feed - <?php echo $username?></title>
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

@media screen and (min-width: 1024px) {

    .submit-button{
  border: 1px solid lightgray;
  display: table;
  position: relative;
  box-shadow: 1px 1px 5px lightgray;
  border-radius: 50%;
  cursor: pointer;
}
.submit-button:hover{
  box-shadow: 1px 1px 10px #5DB0FF;
}

 
    .xyz
    {
        width:10rem;overflow:hidden;word-wrap: break-word;align-content:center;
        background-color: #5DB0FF;
    }

    .sidebar
    {
        height:33rem;
        width:14rem;
     margin-top:2rem;   
    line-height: 2rem;font-size: 20px;
    font-weight: bold;
    color: black;
    background-color: #5DB0FF;
    border-radius: .3rem; 
    border: 1px;
    padding: 2rem;
    align-content:center;
    align-items: center;
    box-shadow: 4px 4px #e5e8ea;
    position:fixed
    }

    .profile-photo
    {
        width:100px ;height:100px;border-radius:50%;float:left;background-color:yellow;margin-left:18%;margin-right:15%;margin-bottom:-2rem;

    }
    .profile-photo-2
    {
        width:100px ;height:100px;border-radius:50%;float:left;

    }

    .right-bar
    {

        background-color:#cde3f2;height:33rem;width:28%;position:fixed;margin-top:2rem;
    border-radius: .3rem; 
    border: 1px;
    padding: 2rem;
    align-content:center;
    align-items: center;
    box-shadow: 4px 4px #e5e8ea;
    overflow:scroll;
    overflow-x:hidden;
    margin-left:1rem;
    margin-right:-2rem;
    }
}
@media screen and (min-width: 1152px ) {
    
    .submit-button{
  border: 1px solid lightgray;
  display: table;
  position: relative;
  box-shadow: 1px 1px 5px lightgray;
  border-radius: 50%;
  cursor: pointer;
}
.submit-button:hover{
  box-shadow: 1px 1px 10px #5DB0FF;
}

    .xyz
    {
        width:17rem;overflow:hidden;word-wrap: break-word;align-content:center;padding:2rem;
        
    }

    .sidebar
    {
        height:40rem;width:20rem;
    line-height: 2rem;font-size: 20px;
    font-weight: bold;
    color: black;
    background-color: #5DB0FF;
    border-radius: .3rem; 
    border: 1px;
    padding: 2rem;
    align-content:center;
    align-items: center;
    box-shadow: 4px 4px #e5e8ea;
    position:fixed
    }
    .profile-photo
    {
        width:150px ;height:150px;border-radius:50%;float:left;background-color:yellow;margin-left:15%;margin-right:15%;

    }
    .profile-photo-2
    {
        width:150px ;height:150px;border-radius:50%;float:left;

    }
    .right-bar
    {

        background-color:#cde3f2;height:40rem;width:28%;;position:fixed;margin-top:2rem;margin-right:2rem;
    border-radius: .3rem; 
    border: 1px;
    padding: 2rem;
    align-content:center;
    align-items: center;
    box-shadow: 4px 4px #e5e8ea;
    overflow:scroll;
    overflow-x:hidden;
    margin-left:2rem;
    margin-right:-2rem;

    }
}
    
        </style>
    </head>
    <body style="overflow-x:hidden">
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
            <a class="nav-link " aria-current="page" href="search.php">Find People</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="home.php">Feed</a>
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
     <div class="row" style="margin-top:3rem;">  
         <div class = "col-md-3" style="word-wrap: break-word"> 
        <div class="sidebar" >
    <div class="xyz" >
            <?php
                include 'config.php';
                      
            ?>
            <div class="profile-photo" >
             <?php
                
                echo "<img src=".$img." class='profile-photo-2'>";?>
            </div>
            <div class="name-head" style="text-align:center">
                <?php
                echo $fname." ".$lname."<br>";  
                ?>
            <span style="font-size:15px">
                <?php
                   echo $course.", ".$dept.", year: ".$year."<br>";
                ?>
            
                <a href="EditDetails.php">Edit Profile</a>
                </span>
            </div>
            </div> 
            </div>
</div>
<div class = "col-md-5" style="padding:2rem"> 
<div class="feed" style="width:100%;margin-left:1rem">
        <?php if ($error!="") {
           
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" >'.$error.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button></div>';
    
            } 
            elseif ($success!="") {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert" >'.$success.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button></div>';
    
            } ?>
        
        
        <div class="add-post-div" style="background-color:white; width:100% ;float:left;;border-radius:7px ;margin-bottom:2rem;border-color:#e5e8ea;border-style: solid;
  border-width:1px;box-shadow: 2px 4px #e5e8ea;padding:2rem">
            <span style="font-size:20px;font-weight:bold">Share what's on your mind!<br></span>
            <form method="post" enctype="multipart/form-data" style="font-size:15px">
                <label for="caption" class="form-label">Caption</label>
                <input type="text" name="caption" class="form-control" id="caption" placeholder="Write something here..." style="height:6rem">
                <label for="photo" class="form-label">Add a photo</label>
                <input type="file" name="photo" class="form-control" id="photo" >
                <button type="submit" name="submit" class="btn " style="margin-top:2rem;margin-left:8rem" >POST</button>
            </form>
        </div>
        
        <?php
        include 'config.php';
        $query = "SELECT distinct friend_id from friends where u_id='".$_SESSION['id']."'";
        $result = $db->query($query);
            if ($result->num_rows > 0 ) {
            while ($row1 = $result->fetch_assoc())
            {
             $qp = "SELECT * FROM posts where user_id = '".$row1['friend_id']."' ORDER BY post_id DESC ";
            $rp = $db->query($qp);
            if ($rp->num_rows > 0 ) {
            while ($row = $rp->fetch_assoc())
            {
                $q1 = "SELECT * from users where id='".$row['user_id']."'";
                $r1 = mysqli_query($db, $q1);
                $sub_row = mysqli_fetch_array($r1);
                
                echo "<div style='background-color:white;width:100%  ;float:left;border-radius:7px;margin-right:1rem ;margin-bottom:2rem;border-color:#e5e8ea;border-style: solid;padding:2rem;border-width:1px;box-shadow: 2px 4px #e5e8ea;'>";

                        echo "<div style='margin-bottom:2rem'>";

                            echo "<img src='".$sub_row['img']."'height=50px width=50px style='float:left;border-radius:50%;border-color:black;border-width:1px;border-style: solid;'>";

                            echo "<div style='float:left;margin-left:1rem;margin-top:5px;'>";
                            echo "<a href='userprofile.php?uid=".$row['user_id']."' style='color:darkblue'>".$sub_row['fname']." ".$sub_row['lname']."</a>";
                            echo "<div style='font-size:12px;color:gray'>".$sub_row['username']."<br></div></div>";

                        echo "</div>";

                        echo "<div style='font-size:18px;float:left;width:100%;margin-top:1.5rem;'>";
                            echo $row['caption'];
                            echo "<div style='float:right;font-size:12px;color:gray'>".$row['date']." ".$row['time']."</div>";
                            if($row['img_post'] != "")
                            {
                                echo "<img src='".$row['img_post']."' height=280px width=280px; style='margin-left:8%;margin-right:8%;margin-top:1rem;margin-bottom:1rem'>";
                            }   
                            echo "</div>";

                            echo "<div style='text-align:center;color:red;margin-top:10rem'>";
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

                                    echo "<div class='show-comments' style='font-size:15px;margin:1rem;word-wrap: break-word;max-height:6rem;overflow:scroll;overflow-x: hidden;'>";
                                        $query_c = "SELECT * FROM comments WHERE post_id = '".$row['post_id']."'";
                                        $fetch_c = $db->query($query_c);
                                        if ($fetch_c->num_rows > 0 ) {
                                            while ($row_c = $fetch_c->fetch_assoc()){
                                                $comment_from = "SELECT username from users where id='".$row_c['from_id']."'";
                                                $commentor = mysqli_query($db, $comment_from);
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
            }
        }

        ?>
        </div>
        </div>
        <div class="col-md" style="background-color:blackpadding:2rem">
            <div class="right-bar" >
                <h4 style="color:darkblue;margin-bottom:1rem">Pending Requests:</h4>
                <?php
                    include 'config.php';
                    $query = "SELECT * from requests where to_id='".$_SESSION['id']."' ";
                    $result = $db->query($query);
                    
	                if ($result->num_rows > 0 )
                    {
			             while ($row = $result->fetch_assoc()) 
                         {
                            $f=0;
                            if($row['flag']==0)
                            {
                                $q1 = "SELECT * from users where id='".$row['from_id']."' ";
                                $res1 = $db->query($q1);
                                if ($res1->num_rows > 0 )
                                {
                                    while ($r1 = $res1->fetch_assoc()) 
                                    {
                                        
                                            echo "<div class='row'>
                                            <div class='col'>
                                                <img src='".$r1['img']."' style='height:2.5rem;width:2.5rem;margin-left:0.5rem;margin-right:1rem;border-radius:50%'>".
                                                $r1['username']."
                                            </div>
                                            </div>
                                            <div class='row' style='margin-left:2.5rem'>
                                                <div class='col' style='margin-top:0.3rem'>
                                                    <a href='userprofile.php?uid=".$row['from_id']."' style='color:black;'>View Profile</a>
                                                </div>
                                                <div class='col'>
                                                    <form method='post'>
                                                        <button class='btn' type='submit' id='accept' style='margin-left:0rem'  value='".$row['from_id']."' title='".$row['from_id']."' name='accept'>Accept</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <hr>";
                                            
                                        }
                                } 
                            }
                            else
                            {
                                $f += 1;

                            }  
                         }
                         if($f!=0)
                         {
                                 echo "No new requests!<hr>";
                         }
                   }
                   else
                   {
                           echo "No new requests!<hr>";
                   }
                ?>
              <h4 style="color:darkblue;margin-bottom:1rem">Connections:</h4>
                <?php
                    include 'config.php';
                    $query = "SELECT * from requests where to_id='".$_SESSION['id']."' or from_id='".$_SESSION['id']."'";
                    $result = $db->query($query);
	                if ($result->num_rows > 0 )
                    {
			             while ($row = $result->fetch_assoc()) 
                         {
                            if($row['flag']==1 )
                            {
                                if($row['from_id']==$_SESSION['id'] )
                                 $user = $row['to_id'];
                                else
                                $user = $row['from_id'];
                               $q1 = "SELECT * from users where id='".$user."'  ";
                                $res1 = $db->query($q1);
                                if ($res1->num_rows > 0 )
                                {
                                    while ($r1 = $res1->fetch_assoc()) 
                                    {
                                        
                                            echo "<div class='row'>
                                            <div class='col'>
                                                <img src='".$r1['img']."' style='height:2.5rem;width:2.5rem;margin-left:0.5rem;margin-right:1rem;border-radius:50%'>".
                                                $r1['username']."
                                            </div>
                                            </div>
                                            <div class='row' style='margin-top:0.5rem'>
                                                
                                                <div class='col' >
                                                    <a href='tempinbox.php?to=".$user."' style='color:black;margin-left:1rem'>Message</a>
                                                </div>
                                                <div class='col' >
                                                    <a href='userprofile.php?uid=".$user."' style='color:black;'>View Profile</a>
                                                </div>
                                            </div>
                                            <hr>";
                                        }
                                }
                            }
                            
                         }
                         
                   }
                   else
                   {
                           echo "Empty here!<hr>";
                   }
                ?>  
            </div>
            </div>
        </div>
        </div>
        <script src="bootstrap-5/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script type="text/javascript">
            
          function myfunction(id){
              
            alert(id);
              $.ajax
              ({
                    type:'post',
                    url: 'home.php',
                    data : { post_id : id,
                            },
                })
          }
   
          function accept(id)
          {
              alert("vvvvv");
            let element = document.getElementById(id);
            alert(id);
            if (element.value=="Accept") 
                {   
                    $from = document.getElementById(id).title;
                    alert($from);
                    $.ajax
                    ({
                        type:'post',
                        url: 'home.php',
                        data : { to_id : id,
                                from : $from,
                                },
                        
                    })
                }
            //else 
                //element.value = "Connect";
          }
        </script>

      </body>
    </html>