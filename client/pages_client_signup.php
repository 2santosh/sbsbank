<?php
session_start();
include('conf/config.php');

// Function to validate phone number format
function isValidPhoneNumber($phone) {
    // Check if phone number consists of 10 digits
    return preg_match('/^\d{10}$/', $phone);
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

//register new account
if (isset($_POST['create_account'])) {
  //Register  Client
  $name = $_POST['name'];
  $national_id = $_POST['national_id'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $password = sha1(md5($_POST['password']));
  $address  = $_POST['address'];

  // Validate phone number format
  if (!isValidPhoneNumber($phone)) {
    $err = "Invalid phone number. Phone number should be 10 digits.";
  } elseif (!isValidEmail($email)) {
    $err = "Invalid email address.";
  } elseif (!isPasswordStrong($_POST['password'])) {
    $err = "Password is not strong enough. It should contain at least 8 characters, including uppercase letters, lowercase letters, numbers, and special characters.";
  } else {
    //$profile_pic  = $_FILES["profile_pic"]["name"];
    //move_uploaded_file($_FILES["profile_pic"]["tmp_name"],"dist/img/".$_FILES["profile_pic"]["name"]);

    //Insert Captured information to a database table
    $query = "INSERT INTO iB_clients (name, national_id, phone, email, password, address) VALUES (?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    //bind paramaters
    $rc = $stmt->bind_param('ssssss', $name, $national_id, $phone, $email, $password, $address);
    $stmt->execute();

    //declare a varible which will be passed to alert function
    if ($stmt) {
      $success = "Account Created";
      header("location: pages_client_index.php");
    } else {
      $err = "Please Try Again Or Try Later";
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
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include("dist/_partials/head.php"); ?>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <p><?php echo $auth->sys_name; ?> - Sign Up</p>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign Up To Use Our IBanking System</p>

                <?php if(isset($err)){ ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    <?php echo $err; ?>
                </div>
                <?php } ?>

                <?php if(isset($success)){ ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    <?php echo $success; ?>
                </div>
                <?php } ?>

                <form method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="name" required class="form-control" placeholder="Client Full Name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" required name="national_id" class="form-control"
                            placeholder="National ID Number">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-tag"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="phone" required class="form-control"
                            placeholder="Client Phone Number">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="email" required class="form-control"
                            placeholder="Client Email Address">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="address" required class="form-control"
                            placeholder="Client Address">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-map-marker"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" required class="form-control"
                            placeholder="Password" id="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-default" id="showPassword">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" name="create_account" class="btn btn-success btn-block">Sign
                                Up</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-0">
                    <a href="pages_client_index.php" class="text-center">Login</a>
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

    <script>
        $(document).ready(function () {
            $('#showPassword').click(function () {
                var passwordField = $('#password');
                var passwordFieldType = passwordField.attr('type');
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $('#toggleIcon').removeClass('fas fa-eye').addClass('fas fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    $('#toggleIcon').removeClass('fas fa-eye-slash').addClass('fas fa-eye');
                }
            });
        });
    </script>
</body>

</html>
<?php
} ?>
