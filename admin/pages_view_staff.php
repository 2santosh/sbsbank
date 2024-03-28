<?php

session_start();

include('conf/config.php');

include('conf/checklogin.php');

check_login();

$admin_id = $_SESSION['admin_id'];

// Function to validate password strength
function validatePassword($password)
{
    // Define password criteria
    $minLength = 8;
    $uppercaseRegex = '/[A-Z]/';
    $lowercaseRegex = '/[a-z]/';
    $digitRegex = '/\d/';

    // Check if password meets all criteria
    if (
        strlen($password) < $minLength ||
        !preg_match($uppercaseRegex, $password) ||
        !preg_match($lowercaseRegex, $password) ||
        !preg_match($digitRegex, $password)
    ) {
        return false;
    }

    return true;
}

// Update logged in user account
if (isset($_POST['update_staff_account'])) {
    // Register Staff
    $name = $_POST['name'];
    $staff_number = $_GET['staff_number'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $sex = $_POST['sex'];

    $profile_pic = $_FILES["profile_pic"]["name"];
    move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "./../img/" . $_FILES["profile_pic"]["name"]);

    // Check if email is unique
    $check_query = "SELECT * FROM iB_staff WHERE email=? AND staff_number != ?";
    $check_stmt = $mysqli->prepare($check_query);
    $check_stmt->bind_param('ss', $email, $staff_number);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $err = "Email already exists";
    } else {
        // Update user account information
        $query = "UPDATE iB_staff SET name=?, phone=?, email=?, sex=?, profile_pic=? WHERE staff_number=?";
        $stmt = $mysqli->prepare($query);
        // Bind parameters
        $rc = $stmt->bind_param('ssssss', $name, $phone, $email, $sex, $profile_pic, $staff_number);
        $stmt->execute();

        // Check if update was successful
        if ($stmt) {
            $success = "Staff Account Updated";
        } else {
            $err = "Please Try Again Or Try Later";
        }
    }
}

// Change password
if (isset($_POST['change_staff_password'])) {
    // Validate new password
    if (!validatePassword($_POST['password'])) {
        $err = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.";
    } elseif ($_POST['password'] !== $_POST['confirm_password']) {
        $err = "New Password and Confirm New Password do not match";
    } elseif ($_POST['password'] === $_POST['old_password']) {
        $err = "New Password cannot be the same as Old Password";
    } else {
        $password = sha1(md5($_POST['password']));
        $staff_number = $_GET['staff_number'];
        // Update password in the database
        $query = "UPDATE iB_staff SET password=? WHERE staff_number=?";
        $stmt = $mysqli->prepare($query);
        // Bind parameters
        $rc = $stmt->bind_param('ss', $password, $staff_number);
        $stmt->execute();
        // Check if update was successful
        if ($stmt) {
            $success = "Staff Password Updated";
        } else {
            $err = "Please Try Again Or Try Later";
        }
    }
}

?>

<!DOCTYPE html>
<html>

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<?php include("dist/_partials/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("dist/_partials/nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("dist/_partials/sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header with logged in user details (Page header) -->
            <?php
            $staff_number = $_GET['staff_number'];
            $ret = "SELECT * FROM  iB_staff  WHERE staff_number = ? ";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('s', $staff_number);
            $stmt->execute(); //ok
            $res = $stmt->get_result();
            while ($row = $res->fetch_object()) {
                //set automatically logged in user default image if they have not updated their pics
                if ($row->profile_pic == '') {
                    $profile_picture_url = "./../img/user_icon.png";
                } else {
                    $profile_picture_url = "./../img/" . $row->profile_pic;
                }
            ?>
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1><?php echo $row->name; ?> Profile</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="manage_staff.php">iBanking Staffs</a></li>
                                    <li class="breadcrumb-item"><a href="manage_staff.php">Manage</a></li>
                                    <li class="breadcrumb-item active"><?php echo $row->name; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">
                                <!-- Profile Image -->
                                <div class="card card-purple card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="img-fluid" src="<?php echo $profile_picture_url; ?>" alt="User profile picture">
                                        </div>
                                        <h3 class="profile-username text-center"><?php echo $row->name; ?></h3>
                                        <p class="text-muted text-center">Staff @iBanking </p>
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item"><b>Email: </b> <a class="float-right"><?php echo $row->email; ?></a></li>
                                            <li class="list-group-item"><b>Phone: </b> <a class="float-right"><?php echo $row->phone; ?></a></li>
                                            <li class="list-group-item"><b>StaffNo: </b> <a class="float-right"><?php echo $row->staff_number; ?></a></li>
                                            <li class="list-group-item"><b>Gender: </b> <a class="float-right"><?php echo $row->sex; ?></a></li>
                                        </ul>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            <!-- /.col -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#update_Profile" data-toggle="tab">Update Profile</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#Change_Password" data-toggle="tab">Change Password</a></li>
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <!-- / Update Profile -->
                                            <div class="tab-pane active" id="update_Profile">
                                                <form method="post" enctype="multipart/form-data" class="form-horizontal">
                                                    <div class="form-group row">
                                                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="name" required class="form-control" value="<?php echo $row->name; ?>" id="inputName">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input type="email" name="email" required value="<?php echo $row->email; ?>" class="form-control" id="inputEmail">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2" class="col-sm-2 col-form-label">Contact</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" required readonly name="phone" value="<?php echo $row->phone; ?>" id="inputName2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2" class="col-sm-2 col-form-label">Profile Picture</label>
                                                        <div class="input-group col-sm-10">
                                                            <div class="custom-file">
                                                                <input type="file" name="profile_pic" class=" form-control custom-file-input" value="<?php echo $row->profile_picture_url;?>" id="exampleInputFile" onchange="showFileName(this)">
                                                                <label class="custom-file-label  col-form-label" for="exampleInputFile">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2" class="col-sm-2 col-form-label">Gender</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="sex">
                                                                <option>Male</option>
                                                                <option>Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button name="update_staff_account" type="submit" class="btn btn-outline-success">Update Account</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /Change Password -->
                                            <div class="tab-pane" id="Change_Password">
                                                <form method="post" class="form-horizontal">
                                                    <div class="form-group row">
                                                        <label for="inputName" class="col-sm-2 col-form-label">Old Password</label>
                                                        <div class="col-sm-10 input-group">
                                                            <input type="password" class="form-control" required id="inputName" name="old_password">
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="inputName"><i class="fas fa-eye"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">New Password</label>
                                                        <div class="col-sm-10 input-group">
                                                            <input type="password" name="password" class="form-control" required id="inputEmail">
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="inputEmail"><i class="fas fa-eye"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2" class="col-sm-2 col-form-label">Confirm</label>
                                                        <div class="col-sm-10 input-group">
                                                            <input type="password" class="form-control" required name="confirm_password" id="inputName2">
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="inputName2"><i class="fas fa-eye"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button type="submit" name="change_staff_password" class="btn btn-outline-success">Change Password</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            <?php } ?>
        </div>
        <!-- /.content-wrapper -->
        <?php include("dist/_partials/footer.php"); ?>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script>
        $(document).ready(function() {
            $('.toggle-password').click(function() {
                var target = $(this).closest('.input-group').find('input');
                var type = target.attr('type') === 'password' ? 'text' : 'password';
                target.attr('type', type);
                if (type === 'text') {
                    $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
        function showFileName(input) {
            const file = input.files[0]; // Get the uploaded file object
            const fileName = file.name; // Extract the filename
            const label = document.querySelector('.custom-file-label'); // Get the label element
            label.textContent = fileName; // Update the label text with filename
        }
    </script>
</body>
</html>
