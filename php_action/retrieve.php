<?php 

require_once 'db_connect.php';

$output = array('data' => array());

$sql = "SELECT * FROM members";
$query = $connect->query($sql);

$x = 1;
while ($row = $query->fetch_assoc()) {
	$active = '';
	if($row['active'] == 1) {
		$active = '<span class="badge badge-success">Active</span>';
	} else {
		$active = '<span class="badge badge-warning">Inactive</span>'; 
	}

	$actionButton = '
	<div class="dropdown">
		<button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Action
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item" data-toggle="modal" data-target="#editMemberModal" onclick="editMember('.$row['id'].')"> <i class="far fa-edit"></i> Edit</a>
			<a class="dropdown-item" data-toggle="modal" data-target="#removeMemberModal" onclick="removeMember('.$row['id'].')"> <i class="far fa-trash-alt"></i> Remove</a>			
		</div>
	</div>
		';

	$output['data'][] = array(
		$x,
		$row['name'],
		$row['email'],
		$row['contact'],
		$row['birthday'],
		$active,
		$actionButton
	);

	$x++;
}

// database connection close
$connect->close();

echo json_encode($output);