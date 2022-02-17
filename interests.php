<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>"SocialOwl - Interests"</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="bootstrap-5/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script type="text/javascript" href="jquery.js"></script>
        <script type="text/javascript" href="chosen.jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>
        <link href="chosen.min.css">
        <link href="Stylesheet.css" rel="stylesheet">
        
    </head>
    <body style="background-image: linear-gradient(to bottom right, white, "#C4EBFC");">
        
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
          <a class="nav-link active" aria-current="page" href="index.html">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Login.php">Login</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link " href="Register.php">Sign Up</a>
        </li>
          <li class="nav-item">
          <a class="nav-link " href="Team.html">Team</a>
        </li>
      </ul>
      
    </div>
      </div>
  </div>
</nav>
        
        <?php
        include 'config.php';
        $query = "SELECT * FROM interests ";
        $result = $db->query($query);
        $result2 = $db->query($query);
        $result3 = $db->query($query);
        $result4 = $db->query($query);
        $result5 = $db->query($query);
        ?> 
        <div class="reg">
        <div class="card bg-dark text-white border-light" style="box-shadow: 7px 10px #e5e8ea;">
        <img src="img/card1.png" class="card-img" alt="...">
  <div class="card-img-overlay">
      
                <h1 class="heading" style="
                margin-top: 7rem;text-shadow: 1px 1px #e5e8ea;">Other Details</h1>
                <form method="post">
                    <div class="mb-3">
                        <label for="about" class="form-label">About</label>
                        <textarea class="form-control" name="about" id="about" rows="3" placeholder="Tell us something about yourself..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="goal" class="form-label">Goals</label>
                        <textarea class="form-control" id="goal" name="goal" placeholder="We know you definitely have thought about it, why not share it with us?"rows="3"></textarea>
                    </div>
                    <div class="row">
                        Select Your Interests<br>
                        <div class="col">
                            
                            <select   class="form-control" id="interest1" name="interest1">
                                <option selected disabled>Interest 1</option>
                                <?php
                                    if ($result->num_rows > 0 ) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value='.$row['id'].'>'.$row['interest'].'</option>';
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
                                        echo '<option value='.$row['id'].'>'.$row['interest'].'</option>';
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
                                        echo '<option value='.$row['id'].'>'.$row['interest'].'</option>';
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
                                        echo '<option value='.$row['id'].'>'.$row['interest'].'</option>';
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
                                        echo '<option value='.$row['id'].'>'.$row['interest'].'</option>';
                                    }
            }                       
          ?> 
                            </select>
                        </div>
                    </div>
                    <div style="float:left;margin-top:3rem;margin-left:-3rem">
                        <button type="Submit" class="btn btn-primary" style="float:left"><a href="Register.php">Previous</a></button>
                    </div>
                    <div class="but">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </form>
            </div>
        </div>
            </div>
        <script src="bootstrap-5/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script type="text/javascript">
  $(document).ready(function() {
  $("#interest").chosen();
});
            
</script>

      </body>
    </html>