<?php 
include_once 'config.php';

if (isset($_POST['dept_id'])) {
	$query = "SELECT * FROM course where dept_id=".$_POST['dept_id'];
	$result = $db->query($query);
	if ($result->num_rows > 0 ) {
			echo '<option value="">Select Course</option>';
		 while ($row = $result->fetch_assoc()) {
		 	echo '<option value='.$row['id'].'>'.$row['course_name'].'</option>';
		 }
	}else{

		echo '<option>No Course Found!</option>';
	}

}elseif (isset($_POST['course_id'])) {
	 

	$query = "SELECT * FROM year where course_id=".$_POST['course_id'];
	$result = $db->query($query);
	if ($result->num_rows > 0 ) {
			
		 while ($row = $result->fetch_assoc()) {
		 	echo '<option value='.$row['id'].'>'.$row['year'].'</option>';
		 }
	}else{

		echo '<option>No year Found!</option>';
	}

}
elseif (isset($_POST['state_id'])) {
	$query = "SELECT * FROM city where state_id=".$_POST['state_id'];
	$result = $db->query($query);
	if ($result->num_rows > 0 ) {
			
		 while ($row = $result->fetch_assoc()) {
		 	echo '<option value='.$row['id'].'>'.$row['city'].'</option>';
		 }
	}else{

		echo '<option>No city Found!</option>';
	}
}
elseif (isset($_POST['username'])) {
	$query = "SELECT * FROM users where username=".$_POST['username'];
	$result = $db->query($query);
	if ($result->num_rows > 0 ) {
			
		 while ($row = $result->fetch_assoc()) {
		 	echo 'Username = '.$row['username'].' Name = '.$row['fname'];
		 }
	}else{

		echo '<option>No user Found!';
	}
}


?>