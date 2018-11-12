<?php
@session_start();
require_once 'db_connection.php';

//get user name and comment
$comment_input = $_POST['comment_input'];
$user_name = $_SESSION['session_user_name'];

if(strlen($comment_input) < 1){ //do not post comment if there is no content
	
} else { //post comment
	//get user ID
	$conn = OpenCon();
	$sql = "SELECT ID, user_name FROM users";
	$result = $conn->query($sql);

	$user_ID = null;

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			//if user_name in DB is equl to stored user name then set user_ID to the ID held in the DB, else $user_id remains null
			if($row['user_name'] == $user_name){
				$user_ID = $row['ID'];
			}
		} 
		CloseCon($conn);
	}
		
	if($user_ID == null){
		//user ID can't be found, index.php reloads to login page
	} else {
	//user ID is defined
	//add comment to DB
		$conn = OpenCon();
	
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		
		$sql = 'INSERT INTO messages '.
		  '(users_id, message) '.
		  'VALUES ( "' . $user_ID . '", "' . $comment_input . '" )';
		  
		if ($conn->query($sql) === TRUE) {
		   //echo "New record created successfully";
		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		//close DB connection
		CloseCon($conn);
	}	
}

header('Location: index.php');

?>