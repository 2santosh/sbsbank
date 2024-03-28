<?php
session_start();
include('conf/config.php'); // Include configuration file

// Check if the login form is submitted
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = sha1(md5($_POST['password'])); // Double encryption for security

  // Query to check credentials
  $stmt = $mysqli->prepare("SELECT client_id, name FROM ib_clients WHERE email=? AND password=?");
  $stmt->bind_param('ss', $email, $password);
  $stmt->execute();
  $stmt->store_result();

  // Check if there's a match
  if ($stmt->num_rows > 0) {
    $stmt->bind_result($client_id, $name);
    $stmt->fetch();
    $stmt->close();

    // Insert login data into login_data table
    $role = 'client'; // Assuming the role is always 'client' for clients
    $ldate = date('Y-m-d H:i:s'); // Current datetime
    $insert_stmt = $mysqli->prepare("INSERT INTO login_data (login_id, name, datetime, role) VALUES (?, ?, ?, ?)");
    $insert_stmt->bind_param("ssss", $client_id, $name, $ldate, $role);

    // Execute insertion
    if ($insert_stmt->execute()) {
      // Check if a password reset request is pending or approved
      $reset_stmt = $mysqli->prepare("SELECT status FROM ib_password_resets WHERE email = ? ORDER BY created_at DESC LIMIT 1");
      $reset_stmt->bind_param('s', $email);
      $reset_stmt->execute();
      $reset_result = $reset_stmt->get_result();

      if ($reset_result->num_rows > 0) {
        $reset_data = $reset_result->fetch_assoc();
        if ($reset_data['status'] == 'approve') {
          $_SESSION['email'] = $email;
          $success="Reset your password";
          // Redirect to confirm_password page if reset status is 'approve'
          header("location: pages_confirm_password.php");
          exit();
        } elseif ($reset_data['status'] == 'pending') {
          // Set session variable
          $err = "Please, take some timer for the Approve for the reset password";
        } else {
          $_SESSION['client_id'] = $client_id;
          header("location: pages_dashboard.php");
          $success="Wellcome";
          exit();
        }
      } else {
        $_SESSION['client_id'] = $client_id;
        header("location: pages_dashboard.php");
        exit();     
     }
    }
  } else {
    // Check if a password reset request is pending or approved
    $reset_stmt = $mysqli->prepare("SELECT status FROM ib_password_resets WHERE email = ? ORDER BY created_at DESC LIMIT 1");
    $reset_stmt->bind_param('s', $email);
    $reset_stmt->execute();
    $reset_result = $reset_stmt->get_result();

    if ($reset_result->num_rows > 0) {
      $reset_data = $reset_result->fetch_assoc();
      if ($reset_data['status'] == 'approve') {
        $_SESSION['email'] = $email;
        // Redirect to confirm_password page if reset status is 'approve'
        header("location: pages_confirm_password.php");
        exit();
      } elseif ($reset_data['status'] == 'pending') {
        // Show message if reset status is 'pending'
        $err = "You have a pending password reset request. Please check your email for instructions.";
      }
    } else {
      // Show generic access denied message
      $err = "Access Denied. Please Check Your Credentials.";
    }
  }
}
// Retrieving system settings
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
  <?php include("header.php"); ?>

  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <p><?php echo $auth->sys_name; ?></p>
      </div><!-- Log on to codeastro.com for more projects! -->
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <?php
          // Check if password has been changed and display a message
          if (isset($_SESSION['password_changed']) && $_SESSION['password_changed']) {
            echo '<p class="text-success">Your password has been changed successfully. Please login with your new password.</p>';
            unset($_SESSION['password_changed']);
          }
          ?>
          <p class="login-box-msg">Log In To Start Client Session</p>

          <form method="post">
            <div class="input-group mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password" id="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <button type="button" class="btn btn-default" id="togglePassword">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="login" class="btn btn-success btn-block" >Log In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>


          <!-- /.social-auth-links -->

          <p class="mb-1">
            <a href="pages_reset_pwd.php">I forgot my password</a>
          </p>


          <p class="mb-0">
            <a href="pages_client_signup.php" class="text-center">Register a new account</a>
          </p><!-- Log on to codeastro.com for more projects! -->

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
    <!-- Toggle Password Visibility -->
    <script>
        $(document).ready(function() {
            $('#togglePassword').click(function() {
                var passwordField = $('#password');
                var passwordFieldType = passwordField.attr('type');
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>

  </body>
  <?php include("footer.php"); ?>

  </html>
<?php
} ?>
