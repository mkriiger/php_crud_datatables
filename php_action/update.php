<?php 

require_once 'db_connect.php';

//if form is submitted
if($_POST) {	

	$validator = array('success' => false, 'messages' => array());

	$id = $_POST['member_id'];
	$name = $_POST['editName'];
	$email = $_POST['editEmail'];
	$contact = preg_replace('/[^a-z0-9]/i', '', $_POST['editContact']);//remove mask to input
	$birthday = $_POST['editBirthday'];
	$active = $_POST['editActive'];

	$sql = "UPDATE members SET name = '$name', contact = '$contact', email = '$email', birthday = '$birthday', active = '$active' WHERE id = $id";
	$query = $connect->query($sql);

	if($query === TRUE) {			
		$validator['success'] = true;
		$validator['messages'] = "Successfully edited";		
	} else {		
		$validator['success'] = false;
		$validator['messages'] = "Error while adding the member information";
	}

	// close the database connection
	$connect->close();

	echo json_encode($validator);

}