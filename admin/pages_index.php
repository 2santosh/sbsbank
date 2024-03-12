<?php
session_start();
include('conf/config.php'); //get configuration file

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = sha1(md5($_POST['password'])); //double encrypt to increase security
  $stmt = $mysqli->prepare("SELECT email, password, admin_id  FROM iB_admin  WHERE email=? AND password=?"); //sql to log in user
  $stmt->bind_param('ss', $email, $password); //bind fetched parameters
  $stmt->execute(); //execute bind
  $stmt->bind_result($email, $password, $admin_id); //bind result
  $rs = $stmt->fetch();
  $_SESSION['admin_id'] = $admin_id; //assaign session to admin id
  if ($rs) { //if its sucessfull
    header("location:pages_dashboard.php");
  } else {
    #echo "<script>alert('Access Denied Please Check Your Credentials');</script>";
    $err = "Access Denied Please Check Your Credentials";
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
    <?php include("dist/_partials/head.php"); ?>
    <?php include("header.php"); ?>
    <title>Login</title>
    <!-- Include necessary CSS/JS files -->
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
  </head>

  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <p><?php echo $auth->sys_name; ?></p>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Log In To Start Administrator Session</p>
          <form method="post">
            <div class="input-group mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
              <div class="input-group-append">
                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <div class="row"></div>
              <div class="col-8">
                <button type="submit" name="login" class="btn btn-danger btn-block">Log In as Admin</button>
              </div>
            </div>
          </form>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->

    <!-- Include necessary JavaScript files -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    <script>
      $(document).ready(function() {
        $("#togglePassword").click(function() {
          var passwordField = $("#password");
          var passwordFieldType = passwordField.attr("type");
          if (passwordFieldType == "password") {
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
  <?php include("footer.php"); ?>

  </html>
<?php
} // End of while loop
?>