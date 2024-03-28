<?php
session_start();
include('manager/conf/config.php');

if (isset($_POST['confirm_reset_password'])) {
    /* Confirm Password */
    $error = 0;
    
    // Function to check if the password meets the complexity requirements
    function isPasswordStrong($password) {
        // At least 8 characters
        if (strlen($password) < 8) {
            return false;
        }
        // Contains at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
        // Contains at least one lowercase letter
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }
        // Contains at least one number
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }
        // Contains at least one special character
        if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
            return false;
        }
        return true;
    }
    
    if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
        $new_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['new_password']))));
        
        // Check if the password is strong
        if (!isPasswordStrong($_POST['new_password'])) {
            $error = 1;
            $err = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        }
    } else {
        $error = 1;
        $err = "New Password Cannot Be Empty";
    }
    
    if (isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
        $confirm_password = mysqli_real_escape_string($mysqli, trim(sha1(md5($_POST['confirm_password']))));
    } else {
        $error = 1;
        $err = "Confirmation Password Cannot Be Empty";
    }

    if (!$error) {
        // Check if the 'email' key is set in $_SESSION
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $sql = "SELECT * FROM  ib_staff  WHERE email = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                if ($new_password != $confirm_password) {
                    $err = "Password Does Not Match";
                } else {
                    $query = "UPDATE iB_staff SET password = ? WHERE email = ?";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param('ss', $new_password, $email);
                    $stmt->execute();
                    if ($stmt) {
                        // Update status in 'ib_password_reset' table
                        $update_query = "UPDATE ib_password_resets SET status = 'sucess' WHERE email = ?";

                        $update_stmt = $mysqli->prepare($update_query);
                        $update_stmt->bind_param('s', $email);
                        $update_stmt->execute();

                        // Redirect to dashboard
                        header("Location: pages_staff_index.php");
                        exit();
                    } else {
                        $err = "Please Try Again Or Try Later";
                    }
                }
            }
        } else {
            $error = 1;
            $err = "Session data not available. Please try again.";
        }
    }
}

/* Persisit System Settings On Brand */
$ret = "SELECT * FROM `iB_SystemSettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
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
                    <?php
                    $email  = $_SESSION['email'];
                    $ret = "SELECT * FROM  iB_staff  WHERE email = '$email'";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    while ($row = $res->fetch_object()) {
                    ?>
                        <p class="login-box-msg"> <b><?php echo $row->name; ?></b> Please Enter And Confirm Your Password</p>
                    <?php
                    } ?>
                    <form method="POST">
                        <div class="input-group mb-3">
                            <input type="password" required name="new_password" class="form-control" id="new_password" placeholder="New Password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" required name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye" id="toggleConfirmIcon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" name="confirm_reset_password" class="btn btn-success btn-block">Reset Password</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>


                    <p class="mt-3 mb-1">
                        <!--           <a href="pages_staff_index.php">Login</a>
 -->
                    </p>

                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="lugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>

        <script>
            // Get the password input and the toggle button for new password
            var newPasswordInput = document.getElementById("new_password");
            var toggleNewPasswordButton = document.getElementById("toggleNewPassword");
            var toggleNewPasswordIcon = document.getElementById("toggleIcon");

            // Add event listener to the toggle button for new password
            toggleNewPasswordButton.addEventListener("click", function() {
                if (newPasswordInput.type === "password") {
                    // Change input type to text
                    newPasswordInput.type = "text";
                    // Change button icon to hide icon
                    toggleNewPasswordIcon.classList.remove("fa-eye");
                    toggleNewPasswordIcon.classList.add("fa-eye-slash");
                } else {
                    // Change input type to password
                    newPasswordInput.type = "password";
                    // Change button icon to show icon
                    toggleNewPasswordIcon.classList.remove("fa-eye-slash");
                    toggleNewPasswordIcon.classList.add("fa-eye");
                }
            });

            // Get the confirmation password input and the toggle button for confirmation password
            var confirmInput = document.getElementById("confirm_password");
            var toggleConfirmButton = document.getElementById("toggleConfirmPassword");
            var toggleConfirmIcon = document.getElementById("toggleConfirmIcon");

            // Add event listener to the toggle button for confirmation password
            toggleConfirmButton.addEventListener("click", function() {
                if (confirmInput.type === "password") {
                    // Change input type to text
                    confirmInput.type = "text";
                    // Change button icon to hide icon
                    toggleConfirmIcon.classList.remove("fa-eye");
                    toggleConfirmIcon.classList.add("fa-eye-slash");
                } else {
                    // Change input type to password
                    confirmInput.type = "password";
                    // Change button icon to show icon
                    toggleConfirmIcon.classList.remove("fa-eye-slash");
                    toggleConfirmIcon.classList.add("fa-eye");
                }
            });
        </script>


    </body>
    <?php include("footer.php"); ?>

    </html>
<?php
} ?>