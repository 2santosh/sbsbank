<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
//register new account
if (isset($_POST['create_staff_account'])) {
    //Register Staff
    $name = $_POST['name'];
    $staff_number = $_POST['staff_number'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate phone number format
    if (!preg_match('/^9[78]\d{8}$/', $phone)) {
        $err = "Phone number must start with 97 or 98 and be 10 digits long.";
    } else {
        // Validate password strength
        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password)) {
            $err = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.";
        } else {
            $password = sha1(md5($password));
            $sex  = $_POST['sex'];
            $staff_position = $_POST['position'];

            $profile_pic  = $_FILES["profile_pic"]["name"];
            move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "./../img/" . $_FILES["profile_pic"]["name"]);

            // Check if staff number or email already exists
            $check_query = "SELECT * FROM iB_staff WHERE staff_number = ? OR email = ?";
            $check_stmt = $mysqli->prepare($check_query);
            $check_stmt->bind_param('ss', $staff_number, $email);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                $err = "Staff number or email already exists";
            } else {
                // Check if email already exists in the database
                $check_email_query = "SELECT * FROM iB_staff WHERE email = ?";
                $check_email_stmt = $mysqli->prepare($check_email_query);
                $check_email_stmt->bind_param('s', $email);
                $check_email_stmt->execute();
                $check_email_result = $check_email_stmt->get_result();

                if ($check_email_result->num_rows > 0) {
                    $err = "Email already exists";
                } else {
                    // Check if phone number already exists in the database
                    $check_phone_query = "SELECT * FROM iB_staff WHERE phone = ?";
                    $check_phone_stmt = $mysqli->prepare($check_phone_query);
                    $check_phone_stmt->bind_param('s', $phone);
                    $check_phone_stmt->execute();
                    $check_phone_result = $check_phone_stmt->get_result();

                    if ($check_phone_result->num_rows > 0) {
                        $err = "Phone number already exists";
                    } else {
                        // Insert data into the database
                        $query = "INSERT INTO iB_staff (name, staff_number, phone, email, password, sex, profile_pic, staff_position) VALUES (?, ?,?,?,?,?,?,?)";
                        $stmt = $mysqli->prepare($query);
                        // Bind parameters
                        $stmt->bind_param('ssssssss', $name, $staff_number, $phone, $email, $password, $sex, $profile_pic, $staff_position);
                        $stmt->execute();

                        // Check if insertion was successful
                        if ($stmt->affected_rows == 1) {
                            $success = "Staff Account Created";
                        } else {
                            $err = "Please Try Again Or Try Later";
                        }
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html><!-- Log on to codeastro.com for more projects! -->
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
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Create Staff Account</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="add_staff.php">iBanking Staff</a></li>
                                <li class="breadcrumb-item active">Add</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-purple">
                                <div class="card-header">
                                    <h3 class="card-title">Fill All Fields</h3>
                                </div>
                                <!-- form start -->
                                <form method="post" enctype="multipart/form-data" role="form">
                                <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputEmail1">Staff Name</label>
                                                <input type="text" name="name" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword">Staff Number</label>
                                                <?php
                                                //PHP function to generate random passenger number
                                                $length = 4;
                                                $_staffNumber =  substr(str_shuffle('0123456789'), 1, $length);
                                                ?>
                                                <input type="text" readonly name="staff_number" value="iBank-STAFF-<?php echo $_staffNumber; ?>" class="form-control" id="exampleInputPassword">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputEmail1">Staff Phone Number</label>
                                                <input type="text" name="phone" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Staff Gender</label>
                                                <select class="form-control" name="sex">
                                                    <option>Select Gender</option>
                                                    <option>Female</option>
                                                    <option>Male</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputEmail1">Staff Email</label>
                                                <input type="email" name="email" required class="form-control" id="exampleInputEmail1">
                                            </div>
                           
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Staff Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="password" required class="form-control" id="exampleInputPassword1">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                        
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Staff Position</label>
                                                <select class="form-control" name="position">
                                                    <option>Select Position</option>
                                                    <option>Manager</option>
                                                    <option>Loan</option>
                                                    <option>Cash</option>
                                                    <option>CSD</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile">Staff Profile Picture</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="profile_pic" class="custom-file-input" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" name="create_staff_account" class="btn btn-success">Add Staff</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
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
    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#togglePassword").click(function() {
                var passwordField = $("#exampleInputPassword1");
                var passwordFieldType = passwordField.attr("type");
                if (passwordFieldType === "password") {
                    passwordField.attr("type", "text");
                    $(this).html('<i class="fas fa-eye-slash"></i>');
                } else {
                    passwordField.attr("type", "password");
                    $(this).html('<i class="fas fa-eye"></i>');
                }
            });
        });
    </script>

</body>

</html>
