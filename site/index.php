<?php
@session_start();
require_once 'db_connection.php';

//if user is logged in take them to the message board, otherwise have them log in
if(isset($_SESSION['session_user_name'])){
	include 'message-board.php';
} else {
	include 'login.php';
}


?>