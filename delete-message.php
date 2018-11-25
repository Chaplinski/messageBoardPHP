<?php 
require_once 'db_connection.php';

//get value from query string and save as var
$message_id = $_GET['messageid'];

//pass var into delete SQL query

$conn = OpenCon();
$sql = "DELETE FROM messages WHERE ID = $message_id";
$result = $conn->query($sql);	
CloseCon($conn);

//redirect back to message board via to index.php
header('Location: index.php')


?>