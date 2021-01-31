<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP CRUD DATATABLES</title>

    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- datatables css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/r-2.2.7/datatables.min.css"/>
    <!-- custom css (if need more extra css adjustment) -->
    <link rel="stylesheet" href="custom/css/style.css">
    <!-- Bootstrap 4 cdn imports -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <!-- Datatables cdn import -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/r-2.2.7/datatables.min.js"></script>
    <!-- Fonts awesome import -->
    <script src="https://kit.fontawesome.com/4c82a35fd2.js" crossorigin="anonymous"></script>
    <!-- include custom index.js -->
    <script type="text/javascript" src="custom/js/index.js"></script>
    <!-- inputmask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"></script>

    <!-- mask contact input, easyly adaptable -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#contact").inputmask({
                mask: ["(99) 9999-9999", "(99) 99999-9999", ],
                keepStatic: true
            });
            $("#editContact").inputmask({
                mask: ["(99) 9999-9999", "(99) 99999-9999", ],
                keepStatic: true
            });
        });
    </script>
</head>
<body>


<nav class="navbar fixed-top navbar-dark bg-dark">
    <a class="navbar-brand" href="#">PHP CRUD <small>DataTables</small></a>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addMember" id="addMemberModalBtn">
        <i class="fas fa-plus"></i> Add Member
    </button>
</nav>

<div class="container">
    <div class="row">
        <div class="table-responsive">
            <br /> <br /> <br />
            <div class="messages"></div>
            <table class="table table-striped table-bordered table-hover" id="manageMemberTable">
                <thead class="thead-dark">
                <tr>
                    <th>N</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Birthday</th>
                    <th>Active</th>
                    <th>Option</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- add modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addMember">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="glyphicon glyphicon-plus-sign"></span>	Add Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form class="form-horizontal" action="php_action/create.php" method="POST" id="createMemberForm">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact" class="col-sm-2 control-label">Contact</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birthday" class="col-sm-2 control-label">Birthday</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Birthday">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="active" class="col-sm-2 control-label">Active</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="active" id="active">
                                <option value="">SELECT</option>
                                <option value="1">Activate</option>
                                <option value="2">Deactivate</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /add modal -->

<!-- remove modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeMemberModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="glyphicon glyphicon-trash"></span> Remove Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Do you really want to remove?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="removeBtn">Remove</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove modal -->

<!-- edit modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editMemberModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><span class="glyphicon glyphicon-edit"></span> Edit Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form class="form-horizontal" action="php_action/update.php" method="POST" id="updateMemberForm">

                <div class="modal-body">

                    <div class="form-group"> <!--/here the addclass has-error will appear -->
                        <label for="editName" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="editName" name="editName" placeholder="Name">
                            <!-- here the text will apper  -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editEmail" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="editEmail" name="editEmail" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editContact" class="col-sm-2 control-label">Contact</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="editContact" name="editContact" placeholder="Contact">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editBirthday" class="col-sm-2 control-label">Birthday</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="editBirthday" name="editBirthday" placeholder="Birthday">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editActive" class="col-sm-2 control-label">Active</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="editActive" id="editActive">
                                <option value="">SELECT</option>
                                <option value="1">Activate</option>
                                <option value="2">Deactivate</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer editMember">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /edit modal -->

<!-- Copyright -->
<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
    © 2021 Made By: <a class="text-dark" href="https://github.com/marciokriiger">Marcio Kriiger</a>
    <br />Feel free to use!
</div>

</body>
</html>
