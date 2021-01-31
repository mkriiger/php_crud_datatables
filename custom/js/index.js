// global the manage member table 
var manageMemberTable;

$(document).ready(function() {
	manageMemberTable = $("#manageMemberTable").DataTable({
		"ajax": "php_action/retrieve.php",
		responsive: true,
		columnDefs: [{ 
			orderable: false, targets: 6 
		}]
	});

	$("#addMemberModalBtn").on('click', function() {
		// reset the form 
		$("#createMemberForm")[0].reset();
		// remove the error 
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$(".text-danger").remove();
		// empty the message div
		$(".messages").html("");

		// submit form
		$("#createMemberForm").unbind('submit').bind('submit', function() {

			$(".text-danger").remove();

			var form = $(this);

			// validation
			var name = $("#name").val();
			var email = $("#email").val();
			var contact = $("#contact").val();
			contact = contact.replace(/\D+/g, '');//eliminates special caracters to validate size
			var birthday = $("#birthday").val();
			var active = $("#active").val();

			if(name == "") {
				$("#name").closest('.form-group').addClass('has-error');
				$("#name").after('<p class="text-danger">The Name field is required</p>');
			} else {
				$("#name").closest('.form-group').removeClass('has-error');
				$("#name").closest('.form-group').addClass('has-success');				
			}

			if(email == "") {
				$("#email").closest('.form-group').addClass('has-error');
				$("#email").after('<p class="text-danger">The Email field is required</p>');
			} else if (!validateEmail(email)){
				email = "";
				$("#email").closest('.form-group').addClass('has-error');
				$("#email").after('<p class="text-danger">You have entered an invalid email address</p>');
			} else {				
				$("#email").closest('.form-group').removeClass('has-error');
				$("#email").closest('.form-group').addClass('has-success');				
			}

			if(contact == "") {
				$("#contact").closest('.form-group').addClass('has-error');
				$("#contact").after('<p class="text-danger">The Contact field is required</p>');
			}else if(contact.length < 10){								
				contact = "";
				$("#contact").closest('.form-group').addClass('has-error');
				$("#contact").after('<p class="text-danger">The contact number must have at least 10 digits</p>');				
			} else {				
				$("#contact").closest('.form-group').removeClass('has-error');
				$("#contact").closest('.form-group').addClass('has-success');				
			}

			if(birthday == "") {
				$("#birthday").closest('.form-group').addClass('has-error');
				$("#birthday").after('<p class="text-danger">The Birthday field is required</p>');
			} else {
				$("#birthday").closest('.form-group').removeClass('has-error');
				$("#birthday").closest('.form-group').addClass('has-success');				
			}

			if(active == "") {
				$("#active").closest('.form-group').addClass('has-error');
				$("#active").after('<p class="text-danger">The Active field is required</p>');
			} else {
				$("#active").closest('.form-group').removeClass('has-error');
				$("#active").closest('.form-group').addClass('has-success');				
			}

			if(name && email && contact && birthday && active) {
				//submit the form to server
				$.ajax({
					url : form.attr('action'),
					type : form.attr('method'),
					data : form.serialize(),
					dataType : 'json',
					success:function(response) {

						// remove the error 
						$(".form-group").removeClass('has-error').removeClass('has-success');

						if(response.success == true) {
							$(".messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <i class="fas fa-check-circle"></i> </strong>'+response.messages+
							'</div>');

							// reset the form
							$("#createMemberForm")[0].reset();		

							// reload the datatables
							manageMemberTable.ajax.reload(null, false);
							// this function is built in function of datatables;
							
							// close the modal
							$('#addMember').modal('hide');
						} else {
							$(".messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <i class="fas fa-exclamation"></i></span> </strong>'+response.messages+
							'</div>');
						}  // /else
					} // success  
				}); // ajax submit
				closeAlert(); 				
			} /// if
			
			return false;
		}); // /submit form for create member
	}); // /add modal

});

function removeMember(id = null) {
	if(id) {
		// click on remove button
		$("#removeBtn").unbind('click').bind('click', function() {
			$.ajax({
				url: 'php_action/remove.php',
				type: 'post',
				data: {member_id : id},
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {						
						$(".messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <i class="fas fa-check-circle"></i> </strong>'+response.messages+
							'</div>');

						// refresh the table
						manageMemberTable.ajax.reload(null, false);

						// close the modal
						$("#removeMemberModal").modal('hide');

					} else {
						$(".messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <i class="fas fa-exclamation"></i></span> </strong>'+response.messages+
							'</div>');
					}
				}
			});
			closeAlert();
		}); // click remove btn
	} else {
		alert('Error: Refresh the page again');
	}
}

function editMember(id = null) {
	if(id) {
		// remove the error 
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$(".text-danger").remove();
		// empty the message div
		$(".messages").html("");

		// remove the id
		$("#member_id").remove();

		// fetch the member data
		$.ajax({
			url: 'php_action/getSelectedMember.php',
			type: 'post',
			data: {member_id : id},
			dataType: 'json',
			success:function(response) {
				$("#editName").val(response.name);

				$("#editEmail").val(response.email);

				$("#editContact").val(response.contact);

				$("#editBirthday").val(response.birthday);

				$("#editActive").val(response.active);	

				// member id 
				$(".editMember").append('<input type="hidden" name="member_id" id="member_id" value="'+response.id+'"/>');

				// here update the member data
				$("#updateMemberForm").unbind('submit').bind('submit', function() {
					// remove error messages
					$(".text-danger").remove();

					var form = $(this);

					// validation
					var editName = $("#editName").val();
					var editEmail = $("#editEmail").val();
					var editContact = $("#editContact").val();
					var editBirthday = $("#editBirthday").val();
					var editActive = $("#editActive").val();

					if(editName == "") {
						$("#editName").closest('.form-group').addClass('has-error');
						$("#editName").after('<p class="text-danger">The Name field is required</p>');
					} else {
						$("#editName").closest('.form-group').removeClass('has-error');
						$("#editName").closest('.form-group').addClass('has-success');				
					}

					if(editEmail == "") {
						$("#editEmail").closest('.form-group').addClass('has-error');
						$("#editEmail").after('<p class="text-danger">The Email field is required</p>');
					} else {
						$("#editEmail").closest('.form-group').removeClass('has-error');
						$("#editEmail").closest('.form-group').addClass('has-success');				
					}

					if(editContact == "") {
						$("#editContact").closest('.form-group').addClass('has-error');
						$("#editContact").after('<p class="text-danger">The Contact field is required</p>');
					} else {
						$("#editContact").closest('.form-group').removeClass('has-error');
						$("#editContact").closest('.form-group').addClass('has-success');				
					}

					if(editBirthday == "") {
						$("#editBirthday").closest('.form-group').addClass('has-error');
						$("#editBirthday").after('<p class="text-danger">The Birthday field is required</p>');
					} else {
						$("#editBirthday").closest('.form-group').removeClass('has-error');
						$("#editBirthday").closest('.form-group').addClass('has-success');				
					}

					if(editActive == "") {
						$("#editActive").closest('.form-group').addClass('has-error');
						$("#editActive").after('<p class="text-danger">The Active field is required</p>');
					} else {
						$("#editActive").closest('.form-group').removeClass('has-error');
						$("#editActive").closest('.form-group').addClass('has-success');				
					}

					if(editName && editEmail && editContact && editBirthday && editActive) {						
						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {
								if(response.success == true) {
									$(".messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  '<strong> <i class="fas fa-check-circle"></i> </strong>'+response.messages+
									'</div>');

									// reload the datatables
									manageMemberTable.ajax.reload(null, false);
									// this function is built in function of datatables;
									
									// remove the error 
									$(".form-group").removeClass('has-success').removeClass('has-error');
									$(".text-danger").remove();
									
									// close the modal
									$('#editMemberModal').modal('hide');
								} else {
									$(".messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  '<strong> <i class="fas fa-exclamation"></i></span> </strong>'+response.messages+
									'</div>')
								}
							} // /success
						}); // /ajax
						closeAlert();
					} // /if					
					return false;
				});

			} // /success
		}); // /fetch selected member info

	} else {
		alert("Error : Refresh the page again");
	}
}
// auto close alerts
function closeAlert() {
	setTimeout(() => { 
		$(".messages").html("");
	}, 5000); // 5 seconds
}
function validateEmail(mail) {
	if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail)){
    	return (true)
	} else {
		return (false)
	}   
}