<?php
@session_start();
require_once 'db_connection.php';

//get user name and password
$sign_in_user_name = $_POST['sign_in_user_name'];
$sign_in_password = $_POST['sign_in_password'];

if(($sign_in_user_name == null) || ($sign_in_password == null)){
	//if user name or password is null, reload page
	echo "<div style='text-align:center;'><h4 style='color: red !important;'>User Name or Password Invalid</h4></div>";
	include 'index.php';
	
} else {

	//set sign in password to hashed value for comparison
	$sign_in_password = sha1($sign_in_password);
	
	$conn = OpenCon();
	$sql = "SELECT ID, user_name, user_password, user_email FROM users";
	$result = $conn->query($sql);

	$has_user_and_password = "false";

	if ($result->num_rows > 0) {
		// output data of each row
		
		while($row = $result->fetch_assoc()) {
			
			//check if user name and password are correct, and create session vars for ID, user name, email address
			if(($row['user_name'] == $sign_in_user_name) && ($row['user_password'] == $sign_in_password)){
				$has_user_and_password = "true";
				$_SESSION['session_user_id'] = $row['ID'];
				$_SESSION['session_user_name'] = $row['user_name'];
				$_SESSION['session_user_email'] = $row['user_email'];
			}
		} 	
	}
	
	CloseCon($conn);

	if($has_user_and_password == "true"){
		//redirect to message board if user and password are correct
		header('Location: index.php');
		
	} else {
		//redirect to login page if user or password are incorrect
		echo "<div style='text-align:center;'><h4 style='color: red !important;'>User Name or Password Invalid</h4></div>";
		include 'index.php';
	}
}

?>