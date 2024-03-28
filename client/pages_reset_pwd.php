<?php
session_start();
include('conf/config.php');

if (isset($_POST['reset_password'])) {
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

    // Check if the email, name, and phone match with existing data
    $checkData = mysqli_query($mysqli, "SELECT * FROM `ib_clients` WHERE `email` = '$email' AND `name` = '$name' AND `phone` = '$phone'") or exit(mysqli_error($mysqli));
    if (mysqli_num_rows($checkData) > 0) {
        // Data matches, proceed with password reset
        $row = mysqli_fetch_assoc($checkData);

        // Check if the email already exists in the database
        $checkEmail = mysqli_query($mysqli, "SELECT `status` FROM `ib_password_resets` WHERE `email` = '$email'") or exit(mysqli_error($mysqli));
        if (mysqli_num_rows($checkEmail) > 0) {
            // Email exists, check status
            $reset_status = mysqli_fetch_assoc($checkEmail)['status'];
            if ($reset_status == 'success') {
                // Status is 'success', allow insertion
                // Generate a reset token
                $reset_token = bin2hex(random_bytes(16));

                // Insert new password reset request with status 'pending'
                $query = "INSERT INTO ib_password_resets (email, reset_token, status, user) VALUES (?, ?, 'pending','client')";
                $stmt = $mysqli->prepare($query);
                // Bind parameters
                $stmt->bind_param('ss', $email, $reset_token);
                $stmt->execute();

                if ($stmt) {
                    // Set session variable 'email'
                    $_SESSION['email'] = $email;
                    // Redirect to the confirmation page
                    header("Location: pages_client_index.php");
                    exit();
                } else {
                    $err = "Password reset failed";
                }
            } else {
                // Status is not 'success', show error
                $err = "A pending password reset request already exists for this email. Please wait for confirmation.";
            }
        } else {
            // Email not found, allow insertion
            // Generate a reset token
            $reset_token = bin2hex(random_bytes(16));

            // Insert new password reset request with status 'pending'
            $query = "INSERT INTO ib_password_resets (email, reset_token, status, user) VALUES (?, ?, 'pending', 'client')";
            $stmt = $mysqli->prepare($query);
            // Bind parameters
            $stmt->bind_param('ss', $email, $reset_token);
            $stmt->execute();

            if ($stmt) {
                // Set session variable 'email'
                $_SESSION['email'] = $email;
                // Redirect to the confirmation page
                header("Location: pages_client_index.php");
                exit();
            } else {
                $err = "Password reset failed";
            }
        }
    } else {
        // Data does not match, show error
        $err = "Email, name, and phone do not match with existing data.";
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
    <?php include("dist/_partials/head.php"); ?>
    <?php include("header.php"); ?>

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
                        <a href="pages_client_index.php">Login</a>
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
