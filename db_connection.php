<?php

//this file is used for all db connections. This way we only need to change one value if anything changes, rather than several files

//opens connection
function openCon(){
	
	$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$db = "message_board";
	
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connection failed: %s\n". $conn->error);

	return $conn;
	
}

//closes connection
function CloseCon($conn){
	
	$conn->close();
}
