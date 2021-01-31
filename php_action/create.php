<?php 

require_once 'db_connect.php';

//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());

	$name = $_POST['name'];
	$email = $_POST['email'];
	$contact =  preg_replace('/[^a-z0-9]/i', '', $_POST['contact']);//remove mask to input
	$birthday = $_POST['birthday'];
	$active = $_POST['active'];

	$sql = "INSERT INTO members (name, contact, email, birthday, active) VALUES ('$name', '$contact', '$email', '$birthday', '$active')";
	$query = $connect->query($sql);

	if($query === TRUE) {			
		$validator['success'] = true;
		$validator['messages'] = "Successfully Added";		
	} else {		
		$validator['success'] = false;
		$validator['messages'] = "Error while adding the member information";
	}

	// close the database connection
	$connect->close();

	echo json_encode($validator);

}