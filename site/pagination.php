<?php
	
	//get page number from query string
	if (isset($_GET['pageno'])) {
		$pageno = $_GET['pageno'];
	} else {
		$pageno = 1;
	}
	
	//sets number of records per page
	$no_of_records_per_page = 10;
	$offset = ($pageno-1) * $no_of_records_per_page;

	
	$conn = OpenCon();
	// Check connection
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();
	}

	//get total number of messages
	$total_pages_sql = "SELECT COUNT(*) FROM messages";
	$result = mysqli_query($conn,$total_pages_sql);
	$total_rows = mysqli_fetch_array($result)[0];
	//set total number of pages by dividing total rows in table by $no_of_records_per_page 
	$total_pages = ceil($total_rows / $no_of_records_per_page);

	//INNER JOIN get user and message info
	$sql = "SELECT users.ID AS userID, users.user_name AS user_name, users.user_email AS user_email, messages.ID AS messagesID,
		messages.message AS message FROM users INNER JOIN messages ON users.ID = messages.users_id ORDER BY messagesID DESC LIMIT " . $offset . "," . $no_of_records_per_page . ";";
	$res_data = mysqli_query($conn,$sql);
	
	if (!$res_data) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
	
	$this_page_row_count = mysqli_num_rows($result);

	while($row = mysqli_fetch_array($res_data)){
	
	//loops for every row in messages table
		echo '<form role="form" class="form-horizontal form-groups-bordered" method="post" action="delete-message.php?messageid=' . $row['messagesID'] . '">
		
		<tr>
			
			<td><span style="font-size:2em; color:black;">' . $row['user_name'] . '</span><br><span style="font-size:1.2em; color:black;">' . $row['user_email'] . '</span></td>
			
			<td><h5><span style="color:black; font-size:1.2em;">' . $row['message'] . '</span></h5></td>
			<td>';

				if(($row['userID'] == $_SESSION['session_user_id']) || $_SESSION['session_user_id'] == 1){
					echo '<button type="submit" class="btn btn-red">Delete</button>';
				}
				
			echo '</td>
		</tr></form>';
		
		} 
		
		mysqli_close($conn);
    ?>
	
	<!-- create buttons that take user between pages -->
    <ul class="pagination">
        <li><a href="?pageno=1">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>