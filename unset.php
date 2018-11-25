<?php
@session_start();

//unset all session variables, effectively logging user out
session_destroy();

header('Location: index.php');
?>