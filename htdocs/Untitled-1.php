






                    <input class="btn " type="submit" id="request" style="margin-left:0rem"  onclick="connect(this.id)" value="Connect" name="request"></input>




                    <?php
                    include 'config.php';
                    $query = "SELECT * from requests where (from_id='".$_SESSION['id']."' and to_id='".$uid."') or (to_id='".$_SESSION['id']."' and from_id='".$uid."')";
                    $result = $db->query($query);
	                if ($result->num_rows > 0 )
                    {
                        while($row =$result->fetch_assoc()) 
                        {
                            if($row['flag'] == 0 )   
                            {
                                echo '<input class="btn " type="submit" id="request" style="margin-left:0rem"  onclick="connect(this.id)" value="Cancel" name="request"></input>'; 
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




cccccccccccccccccccccccccccccccccccc
<?php
            
        
        $link = mysqli_connect("localhost", "root", "", "SocialZ");
        
            if (mysqli_connect_error()) {
            
                die ("Database Connection Error");
                
            }
            $qp = "SELECT * FROM posts ORDER BY post_id DESC";
            $rp = $link->query($qp);
            if ($rp->num_rows > 0 ) {
            while ($row = $rp->fetch_assoc()){
                $q1 = "SELECT * from users where id='".$row['user_id']."'";
                $r1 = mysqli_query($link, $q1);
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
                                echo "<img src='".$row['img_post']."' height=280px width=280px; style='margin-left:8%;margin-right:8%;margin-top:1rem'>";
                            }   
                            echo "</div>";

                            //echo "<form method='post' action=".<?php $_SERVER['PHP_SELF'].">";

                            echo "<div>";

                                echo "<div name='like' class='like' onclick='myfunction(this.id)' style='border-radius:50%;border-color:#5DB0FF;border-width:thin;margin-left:9rem;margin-top:2rem' value=0 id='".$row['post_id']."'><img src='img/like.png'  style='height:30px;width:30px'></div>";
                                echo $row['likes'];
                            echo "</div>";
                            //echo "</form>";
                            
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
        ?>