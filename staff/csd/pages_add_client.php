<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['staff_id'];

// Function to validate phone number format
function isValidPhoneNumber($phone) {
    // Check if phone number consists of 10 digits
    return preg_match('/^\d{10}$/', $phone);
}

// Function to validate national ID format (assuming it's numeric)
function isValidNationalID($national_id) {
    // Check if national ID consists of 10 digits
    return preg_match('/^\d{10}$/', $national_id);
}

// Function to validate email address format
function isValidEmail($email) {
    // Check if email address is valid
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to check if password is strong
function isPasswordStrong($password) {
    // Define criteria for a strong password
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password); // Anything that is not alphanumeric

    // Check if all criteria are met
    if($uppercase && $lowercase && $number && $specialChars && strlen($password) >= 8) {
        return true;
    } else {
        return false;
    }
}

// Register new account
if (isset($_POST['create_staff_account'])) {
    // Register Client
    $name = $_POST['name'];
    $national_id = $_POST['national_id'];
    $client_number = $_POST['client_number'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = sha1(md5($_POST['password']));
    $address  = $_POST['address'];

    $profile_pic  = $_FILES["profile_pic"]["name"];
    move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "../../img/" . $_FILES["profile_pic"]["name"]);

    // Check if client number, email, phone, or national ID already exists
    $check_query = "SELECT * FROM iB_clients WHERE client_number = ? OR email = ? OR phone = ? OR national_id = ?";
    $check_stmt = $mysqli->prepare($check_query);
    $check_stmt->bind_param('ssss', $client_number, $email, $phone, $national_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $err = "Client number, email, phone, or national ID already exists";
    } elseif (!isValidPhoneNumber($phone)) {
        $err = "Invalid phone number. Phone number should be 10 digits.";
    } elseif (!isValidNationalID($national_id)) {
        $err = "Invalid national ID. National ID should be 10 digits.";
    } elseif (!isValidEmail($email)) {
        $err = "Invalid email address.";
    } elseif (!isPasswordStrong($_POST['password'])) {
        $err = "Password is not strong enough. It should contain at least 8 characters, including uppercase letters, lowercase letters, numbers, and special characters.";
    } else {
        // Insert data into the database
        $query = "INSERT INTO iB_clients (name, national_id, client_number, phone, email, password, address, profile_pic) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        // Bind parameters
        $stmt->bind_param('ssssssss', $name, $national_id, $client_number, $phone, $email, $password, $address, $profile_pic);
        $stmt->execute();

        // Check if insertion was successful
        if ($stmt->affected_rows == 1) {
            $success = "Client Account Created";
            header("location: pages_open_client_acc.php?client_number=$client_number&client_id=$stmt->insert_id");
        } else {
            $err = "Please Try Again Or Try Later";
        }
    }
}
?>


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
        <?php include("dist/_partials/csd.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2"><!-- Log on to codeastro.com for more projects! -->
                        <div class="col-sm-6">
                            <h1>Create Client Account</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="pages_add_client.php">iBanking Clients</a></li>
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
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Client Name</label>
                                                <input type="text" name="name" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputPassword1">Client Number</label>
                                                <?php
                                                //PHP function to generate random passenger number
                                                $length = 4;
                                                $_Number =  substr(str_shuffle('0123456789'), 1, $length);
                                                ?>
                                                <input type="text" readonly name="client_number" value="iBank-CLIENT-<?php echo $_Number; ?>" class="form-control" id="exampleInputPassword1">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Contact</label>
                                                <input type="text" name="phone" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputPassword1">National ID No.</label>
                                                <input type="text" name="national_id" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Email</label>
                                                <input type="email" name="email" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputPassword1">Password</label>
                                                <input type="password" name="password" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Address</label>
                                                <input type="text" name="address" required class="form-control" id="exampleInputEmail1">
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputFile">Client Profile Picture</label>
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
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" name="create_staff_account" class="btn btn-success">Add Client</button>
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
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>