<?php
session_start();
include('manager/conf/config.php');

if (isset($_POST['reset_password'])) {
    // Prevent posting blank value for email
    $error = 0;
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = mysqli_real_escape_string($mysqli, trim($_POST['email']));
    } else {
        $error = 1;
        $err = "Enter Your Email";
    }
    // Validate email format
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $err = 'Invalid Email';
    }
    // Additional fields: name and phone
    $name = isset($_POST['name']) ? mysqli_real_escape_string($mysqli, trim($_POST['name'])) : '';
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($mysqli, trim($_POST['phone'])) : '';

    // Check if the email already exists in the database
    $checkEmail = mysqli_query($mysqli, "SELECT `email` FROM `ib_password_resets` WHERE `email` = '" . $_POST['email'] . "'") or exit(mysqli_error($mysqli));
    if (mysqli_num_rows($checkEmail) > 0) {
        // Email already exists, provide feedback to the user
        $err = "A pending password reset request already exists for this email. Please wait for confirmation.";
    } else {
        // Generate a reset token
        $reset_token = bin2hex(random_bytes(16));

        // Insert new password reset request with status 'pending' at a specific position
        $query = "INSERT INTO ib_password_resets (email, reset_token, status, position) 
                  SELECT ?, ?, 'pending', COALESCE(MAX(position), 0) + 1 
                  FROM ib_password_resets";
        $stmt = $mysqli->prepare($query);
        // Bind parameters
        $stmt->bind_param('ss', $email, $reset_token);
        $stmt->execute();

        if ($stmt) {
            // Set session variable 'email'
            $_SESSION['email'] = $email;
            // Redirect to the confirmation page
            header("Location: pages_staff_index.php");
            exit();
        } else {
            $err = "Password reset failed";
        }
    }
}

/* Persist System Settings On Brand */
$ret = "SELECT * FROM `iB_SystemSettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); // OK
$res = $stmt->get_result();

while ($auth = $res->fetch_object()) {
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <title>Login</title>
        <link rel="stylesheet" href="manager/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="manager/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="manager/dist/css/adminlte.min.css">
        <?php include("header.php"); ?>
    </head>

    <body class="hold-transition login-page">
        <div class="login-box">

            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

                    <form method="POST">
                        <div class="input-group mb-3">
                            <input type="email" required name="email" class="form-control" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Additional fields: name and phone -->
                        <div class="input-group mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="phone" class="form-control" placeholder="Phone">
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" name="reset_password" class="btn btn-success btn-block">Request new password</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <p class="mt-3 mb-1">
                        <a href="pages_staff_index.php">Login</a>
                    </p>

                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>

    </body>
    <?php include("footer.php"); ?>

    </html>
<?php
} ?>