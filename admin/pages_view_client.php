<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

// Function to validate phone number format
function isValidPhoneNumber($phone)
{
    // Check if phone number consists of 10 digits and starts with either 97 or 98
    return preg_match('/^(97|98)\d{8}$/', $phone);
}

// Function to validate email address format
function isValidEmail($email)
{
    // Check if email address is valid
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to check if password is strong
function isPasswordStrong($password)
{
    // Define criteria for a strong password
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password); // Anything that is not alphanumeric

    // Check if all criteria are met
    if ($uppercase && $lowercase && $number && $specialChars && strlen($password) >= 8) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['update_client_account'])) {
    // Update client
    $name = $_POST['name'];
    $national_id = $_POST['national_id'];
    $client_number = $_GET['client_number'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $profile_pic = $_FILES["profile_pic"]["name"];
    move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "./../img/" . $_FILES["profile_pic"]["name"]);

    // Check if phone number and email are unique
    $check_query = "SELECT * FROM iB_clients WHERE (phone = ? OR email = ?) AND client_number != ?";
    $check_stmt = $mysqli->prepare($check_query);
    $check_stmt->bind_param('sss', $phone, $email, $client_number);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $err = "Phone number or email already exists";
    } elseif (!isValidPhoneNumber($phone)) {
        $err = "Invalid phone number. Phone number should start with either 97 or 98 and be 10 digits.";
    } elseif (!isValidEmail($email)) {
        $err = "Invalid email address.";
    } else {
        // Update client information
        $query = "UPDATE iB_clients SET name=?, national_id=?, phone=?, email=?, address=?, profile_pic=? WHERE client_number = ?";
        $stmt = $mysqli->prepare($query);
        // Bind parameters
        $stmt->bind_param('sssssss', $name, $national_id, $phone, $email, $address, $profile_pic, $client_number);
        $stmt->execute();

        if ($stmt) {
            $success = "Client Account Updated";
        } else {
            $err = "Please Try Again Or Try Later";
        }
    }
}

// Change password
if (isset($_POST['change_client_password'])) {
    $old_password = sha1(md5($_POST['old_password'])); // Hash the old password
    $new_password = sha1(md5($_POST['new_password'])); // Hash the new password
    $confirm_password = sha1(md5($_POST['change_client_password'])); // Hash the confirm new password
    $client_number = $_GET['client_number'];

    // Check if old password matches the password in the database
    $check_password_query = "SELECT password FROM iB_clients WHERE client_number=?";
    $check_password_stmt = $mysqli->prepare($check_password_query);
    $check_password_stmt->bind_param('s', $client_number);
    $check_password_stmt->execute();
    $check_password_result = $check_password_stmt->get_result();
    $stored_password = $check_password_result->fetch_assoc()['password'];

    if ($old_password !== $stored_password) {
        $err = "Old password does not match.";
    } elseif ($new_password !== $confirm_password) {
        $err = "New password and confirm password do not match.";
    } elseif ($old_password === $new_password) {
        $err = "New password cannot be the same as old password.";
    } else {
        // Update client password
        $query = "UPDATE iB_clients SET password=? WHERE client_number=?";
        $stmt = $mysqli->prepare($query);
        // Bind parameters
        $stmt->bind_param('ss', $new_password, $client_number);
        $stmt->execute();

        if ($stmt) {
            $success = "Client Password Updated";
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
            $client_number = $_GET['client_number'];
            $ret = "SELECT * FROM  iB_clients  WHERE client_number = ? ";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('s', $client_number);
            $stmt->execute(); //ok
            $res = $stmt->get_result();
            while ($row = $res->fetch_object()) {
                //set automatically logged in user default image if they have not updated their pics
                if ($row->profile_pic == '') {
                    $profile_picture = "

                        <img class='img-fluid'
                        src='./../img/user_icon.png'
                        alt='User profile picture'>

                        ";
                } else {
                    $profile_picture = "

                        <img class=' img-fluid'
                        src='./../img/$row->profile_pic'
                        alt='User profile picture'>

                        ";
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
                                    <li class="breadcrumb-item"><a href="manage_clients.php">iBanking Clients</a></li>
                                    <li class="breadcrumb-item"><a href="manage_clients.php">Manage</a></li>
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
                                            <?php echo $profile_picture; ?>
                                        </div>

                                        <h3 class="profile-username text-center"><?php echo $row->name; ?></h3>

                                        <p class="text-muted text-center">Client @iBanking </p>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>ID No.: </b> <a class="float-right"><?php echo $row->national_id; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email: </b> <a class="float-right"><?php echo $row->email; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Phone: </b> <a class="float-right"><?php echo $row->phone; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>ClientNo: </b> <a class="float-right"><?php echo $row->client_number; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Address: </b> <a class="float-right"><?php echo $row->address; ?></a>
                                            </li>

                                        </ul>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->

                                <!-- About Me Box 
                    <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Education</strong>

                        <p class="text-muted">
                        B.S. in Computer Science from the University of Tennessee at Knoxville
                        </p>

                        <hr>

                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                        <p class="text-muted">Malibu, California</p>

                        <hr>

                        <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                        <p class="text-muted">
                        <span class="tag tag-danger">UI Design</span>
                        <span class="tag tag-success">Coding</span>
                        <span class="tag tag-info">Javascript</span>
                        <span class="tag tag-warning">PHP</span>
                        <span class="tag tag-primary">Node.js</span>
                        </p>

                        <hr>

                        <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                    </div>
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
                                                            <input type="text" class="form-control" required name="phone" value="<?php echo $row->phone; ?>" id="inputName2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2" class="col-sm-2 col-form-label">National ID Number</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" required readonly name="national_id" value="<?php echo $row->national_id; ?>" id="inputName2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2" class="col-sm-2 col-form-label">Address</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" required name="address" value="<?php echo $row->address; ?>" id="inputName2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2" class="col-sm-2 col-form-label">Profile Picture</label>
                                                        <div class="input-group col-sm-10">
                                                            <div class="custom-file">
                                                                <input type="file" name="profile_pic" class=" form-control custom-file-input" id="exampleInputFile">
                                                                <label class="custom-file-label  col-form-label" for="exampleInputFile">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button name="update_client_account" type="submit" class="btn btn-outline-success">Update Account</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- /Change Password -->
                                            <!-- /Change Password -->
                                            <div class="tab-pane" id="Change_Password">
                                                <form method="post" class="form-horizontal">
                                                    <div class="form-group row">
                                                        <label for="inputOldPassword" class="col-sm-2 col-form-label">Old Password</label>
                                                        <div class="col-sm-10 input-group">
                                                            <input type="password" class="form-control" required id="inputOldPassword" name="old_password">
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="inputOldPassword"><i class="fas fa-eye"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputNewPassword" class="col-sm-2 col-form-label">New Password</label>
                                                        <div class="col-sm-10 input-group">
                                                            <input type="password" name="newpassword" class="form-control" required id="inputNewPassword">
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="inputNewPassword"><i class="fas fa-eye"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputConfirmPassword" class="col-sm-2 col-form-label">Confirm</label>
                                                        <div class="col-sm-10 input-group">
                                                            <input type="password" class="form-control" required id="inputConfirmPassword">
                                                            <div class="input-group-append">
                                                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="inputConfirmPassword"><i class="fas fa-eye"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button type="submit" name="change_client_password" class="btn btn-outline-success">Change Password</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.nav-tabs-custom -->
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
    </script>
</body>

</html>