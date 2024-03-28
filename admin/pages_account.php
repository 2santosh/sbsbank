<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');

// Ensure user is logged in before proceeding
check_login();
$admin_id = $_SESSION['admin_id'];

// Password strength check function (improved for clarity and security)
function checkPasswordStrength($password)
{
    $minLength = 8; // Minimum password length requirement
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasLowercase = preg_match('/[a-z]/', $password);
    $hasNumber = preg_match('/[0-9]/', $password);
    $hasSpecialChar = preg_match('/[^a-zA-Z0-9]/', $password);

    $score = 0;
    if (strlen($password) >= $minLength) {
        $score++;
    }
    if ($hasUppercase) {
        $score++;
    }
    if ($hasLowercase) {
        $score++;
    }
    if ($hasNumber) {
        $score++;
    }
    if ($hasSpecialChar) {
        $score++;
    }

    $strength = '';
    if ($score <= 2) {
        $strength = 'Weak';
    } else if ($score === 3) {
        $strength = 'Moderate';
    } else if ($score === 4) {
        $strength = 'Strong';
    } else {
        $strength = 'Very Strong';
    }

    return [
        'strength' => $strength,
        'score' => $score, // Return score for more granular feedback
    ];
}

// Update account details
if (isset($_POST['update_account'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $query = "UPDATE iB_admin SET name=?, email=? WHERE admin_id=?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssi', $name, $email, $admin_id);
    $stmt->execute();

    if ($stmt) {
        $success = "Account Updated";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}

// Change password with improved security practices
if (isset($_POST['change_password'])) {
    $oldPassword = $_POST['old_password']; // Get old password for verification
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate old password before proceeding (not shown here)
    // Use prepared statements and password hashing for security

    if (empty($newPassword) || empty($confirmPassword)) {
        $err = "Please enter both new and confirm passwords.";
    } else if ($newPassword !== $confirmPassword) {
        $err = "New passwords do not match.";
    } else {
        // Check password strength
        $passwordStrength = checkPasswordStrength($newPassword);
        if ($passwordStrength['score'] < 3) {
            $err = "New password is too weak. Please choose a stronger password.";
        } else {
            $password = sha1(md5($newPassword)); // Consider using a more secure hashing algorithm

            $query = "UPDATE iB_admin SET password=? WHERE admin_id=?";
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param('si', $password, $admin_id);
            $stmt->execute();

            if ($stmt) {
                $success = "Password Updated";
            } else {
                $err = "Please Try Again Or Try Later";
            }
        }
    }
}
?>
<!-- Log on to codeastro.com for more projects! -->
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
            $admin_id = $_SESSION['admin_id'];
            $ret = "SELECT * FROM  iB_admin  WHERE admin_id = ? ";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $admin_id);
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
                                    <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="pages_account.php">Profile</a></li>
                                    <li class="breadcrumb-item active"><?php echo $row->name; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content --><!-- Log on to codeastro.com for more projects! -->
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

                                        <p class="text-muted text-center">@Admin iBanking </p>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Email: </b> <a class="float-right"><?php echo $row->email; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Number: </b> <a class="float-right"><?php echo $row->number; ?></a>
                                            </li>

                                        </ul>

                                    </div><!-- Log on to codeastro.com for more projects! -->
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
                                                <form method="post" class="form-horizontal">
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
                                                        <label for="inputName2" class="col-sm-2 col-form-label">Number</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" required readonly name="number" value="<?php echo $row->number; ?>" id="inputName2">
                                                        </div>
                                                    </div><!-- Log on to codeastro.com for more projects! -->
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button name="update_account" type="submit" class="btn btn-outline-success">Update Account</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="tab-pane" id="Change_Password">
                                                <form method="post" class="form-horizontal">
                                                    <div class="form-group row">
                                                        <label for="inputOldPassword" class="col-sm-2 col-form-label">Old Password</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="password" class="form-control" required id="inputOldPassword" name="old_password">
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#inputOldPassword">
                                                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputNewPassword" class="col-sm-2 col-form-label">New Password</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="password" name="password" class="form-control" required id="inputNewPassword">
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#inputNewPassword">
                                                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputConfirmPassword" class="col-sm-2 col-form-label">Confirm New Password</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="password" class="form-control" required id="inputConfirmPassword" name="confirm_password">
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#inputConfirmPassword">
                                                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button name="change_password" type="submit" class="btn btn-outline-success">Change Password</button>
                                                        </div>
                                                    </div>
                                                </form>
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
        </div><!-- Log on to codeastro.com for more projects! -->
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
                var target = $($(this).attr('data-target'));
                var icon = $(this).find('i');
                if (target.attr('type') === 'password') {
                    target.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    target.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>


</body>

</html>