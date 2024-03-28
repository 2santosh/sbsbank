<?php
session_start();
include('cash/conf/config.php'); // Include configuration file

// Check if the login form is submitted
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = sha1(md5($_POST['password'])); // Double encryption for security

  // Query to check credentials
  $stmt = $mysqli->prepare("SELECT staff_id, name FROM ib_staff WHERE email=? AND password=?");
  $stmt->bind_param('ss', $email, $password);
  $stmt->execute();
  $stmt->store_result();

  // Check if there's a match
  if ($stmt->num_rows > 0) {
    $stmt->bind_result($staff_id, $name);
    $stmt->fetch();
    $stmt->close();

    // Insert login data into login_data table
    $role = 'client'; // Assuming the role is always 'client' for clients
    $ldate = date('Y-m-d H:i:s'); // Current datetime
    $insert_stmt = $mysqli->prepare("INSERT INTO login_data (login_id, name, datetime, role) VALUES (?, ?, ?, ?)");
    $insert_stmt->bind_param("ssss", $staff_id, $name, $ldate, $role);

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
          // Redirect to confirm_password page if reset status is 'approve'
          header("location: pages_confirm_password.php");
          exit();
        } elseif ($reset_data['status'] == 'pending') {
          // Set session variable
        } else {
          $_SESSION['staff_id'] = $staff_id;
          header("location: pages_check_role.php");
          exit();
        }
      } else {
        $_SESSION['staff_id'] = $staff_id;
        header("location: pages_check_role.php");
        exit();      }
    }
  } else {
  }
//     // Check if a password reset request is pending or approved
//     $reset_stmt = $mysqli->prepare("SELECT status FROM ib_password_resets WHERE email = ? ORDER BY created_at DESC LIMIT 1");
//     $reset_stmt->bind_param('s', $email);
//     $reset_stmt->execute();
//     $reset_result = $reset_stmt->get_result();

//     if ($reset_result->num_rows > 0) {
//       $reset_data = $reset_result->fetch_assoc();
//       if ($reset_data['status'] == 'approve') {
//         $_SESSION['email'] = $email;
//         // Redirect to confirm_password page if reset status is 'approve'
//         header("location: pages_confirm_password.php");
//         exit();
//       } elseif ($reset_data['status'] == 'pending') {
//         // Show message if reset status is 'pending'
//         $err = "You have a pending password reset request. Please check your email for instructions.";
//       }
//     } else {
//       $_SESSION['staff_id']=$staff_id;
//       header("location: pages_check_role.php");
//       exit();
//     }
//   }
// }
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
      <div class="login-logo">
        <p><?php echo $auth->sys_name; ?></p>
      </div>
      <div class="card">
        <div class="card-body login-card-body">
          <!-- Your login form code here -->
          <p class="login-box-msg">Log In To Start Staff Session</p>
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
              <input type="password" name="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
                <!-- Add the button here -->
                <button type="button" class="btn btn-default" id="showPasswordBtn">
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
                <button type="submit" name="login" class="btn btn-success btn-block">Log In</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
          <p class="mb-1">
            <a href="pages_reset_pwd.php">I forgot my password</a>
          </p>
        </div>
      </div>
    </div>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Include your custom JS if any -->
    <script src="dist/js/adminlte.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#showPasswordBtn').click(function() {
          var passwordField = $('input[name="password"]');
          var passwordFieldType = passwordField.attr('type');
          if (passwordFieldType == 'password') {
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
}
?>