<?php
@session_start();
require_once 'db_connection.php';

//get values from POST and set them as variables
$create_user_name = $_POST['create_user_name'];
$submit_email = $_POST['submit_email'];
$create_password = $_POST['create_password'];
$confirm_password = $_POST['confirm_password'];

//add user to DB
if($create_password == $confirm_password){
	
	//check password length
	if((strlen($create_password) >= 8) && (strlen($create_password) <= 16)){
		
		//check user name length
		if((strlen($create_user_name) >= 6) && (strlen($create_user_name) <= 12)){
		
			//hash password
			$create_password = sha1($create_password);
		
			$conn = OpenCon();
			
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
			
			//set username and email as unique, until they are found not to be
			$unique_user_name = true;
			$unique_user_email = true;
			
			$conn = OpenCon();

			$sql = "SELECT user_name, user_email FROM users";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					if($row['user_name'] == $create_user_name){
						//set $unique_user_name to false
						$unique_user_name = false;
					}
					
					if($row['user_email'] == $submit_email){
						//set $unique_user_email to false
						$unique_user_email = false;
					}
				} 	
			}
			
			CloseCon($conn);
			
			if($unique_user_name && $unique_user_email){
				
				$conn = OpenCon();
				//if user name and email are unique add to DB
				$sql = 'INSERT INTO users '.
				  '(user_name, user_password, user_email) '.
				  'VALUES ( "' . $create_user_name . '", "' . $create_password . '",  "' . $submit_email . '" )';
				  
				if ($conn->query($sql) === TRUE) {
					//comment below was left in should future debugging be necessary
				   //echo "New record created successfully";
				} else {
				  echo "Error: " . $sql . "<br>" . $conn->error;
				}
				
				//close DB connection
				CloseCon($conn);
					
				//create session vars to hold user name and email
				$_SESSION['session_user_name'] = $create_user_name;
				$_SESSION['session_user_email'] = $submit_email;
				
				//get user ID based on user name and store ID as session var		
				$conn = OpenCon();
				$sql = "SELECT ID, user_name FROM users";
				$result = $conn->query($sql);

				$user_id = null;
				
				if ($result->num_rows > 0) {
					// output data of each row
					
					while($row = $result->fetch_assoc()) {

						if(($row['user_name'] == $create_user_name)){
							$user_id = $row['ID'];
						}
					}	
				}
				CloseCon($conn);
				
				//store user ID session var
				$_SESSION['session_user_id'] = $user_id;
				
			} else {
			//tell user that their user name or email are already taken
			echo "<div style='text-align:center;'><h4 style='color: red !important;'>User name or email have already been used</h4></div>";
		}		
			
		} else {
			//tell user that their user name length was improper
			echo "<div style='text-align:center;'><h4 style='color: red !important;'>User name must be 6-12 characters</h4></div>";
		}
		
	} else {
		//tell user that their password length was improper
		echo "<div style='text-align:center;'><h4 style='color: red !important;'>Password must be 8-16 characters</h4></div>";
	}
	
} else {
	//tell user that their password did not match
	echo "<div style='text-align:center;'><h4 style='color: red !important;'>Passwords do not match</h4></div>";
}

//index.php sends user to message board if values fit parameters, else sends user to login page
include 'index.php';
?>