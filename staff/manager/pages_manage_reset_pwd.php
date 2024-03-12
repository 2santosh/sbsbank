<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$staff_id = $_SESSION['staff_id'];

// Handle approval action
if (isset($_POST['updateStatus'])) {
  $id = intval($_POST['id']);
  $status = $_POST['status'];
  $update_query = "UPDATE iB_password_resets SET status = ? WHERE id = ?";
  $update_stmt = $mysqli->prepare($update_query);
  $update_stmt->bind_param('si', $status, $id);
  if ($update_stmt->execute()) {
    $info = "Status updated successfully";
  } else {
    $err = "Error updating status";
  }
}

// Handle delete action
if (isset($_GET['ClearReset'])) {
  $id = intval($_GET['ClearReset']);
  $delete_query = "DELETE FROM iB_password_resets WHERE id = ?";
  $delete_stmt = $mysqli->prepare($delete_query);
  $delete_stmt->bind_param('i', $id);
  if ($delete_stmt->execute()) {
    $info = "Password Reset Request Deleted";
  } else {
    $err = "Error deleting password reset request";
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Reset Password Requests</title>
  <?php include("dist/_partials/head.php"); ?>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include("dist/_partials/nav.php"); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include("dist/_partials/manager.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Reset Password Requests</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Password Resets</a></li>
                <li class="breadcrumb-item active">Manage</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <table id="example1" class="table table-hover table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Email</th>
                      <th>Token</th>
                      <th>Status</th>
                      <th>Submitted At</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $position = "manager"; // Change this to the position you want to filter by
                    $ret = "SELECT * FROM iB_password_resets WHERE position = ?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('s', $position);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $cnt = 1;

                    while ($row = $res->fetch_object()) {
                      // Trim timestamp to DD/MM/YYY
                      $created_at = $row->created_at;
                      $status = $row->status;

                      // Skip displaying data if the position is "manager"
                      if ($row->position === "manager") {
                        continue;
                      }
                    ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row->email; ?></td>
                        <td><?php echo isset($row->token) ? $row->token : 'N/A'; ?></td>
                        <td><?php echo $status; ?></td>
                        <td><?php echo date("d-M-Y h:m:s ", strtotime($created_at)); ?></td>
                        <td>
                          <form method="post">
                            <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                            <select name="status">
                              <!-- <option>Take Action</option> -->
                              <option value="pending" <?php echo ($status == 'pending') ? 'selected' : ''; ?>>
                                Pending
                              </option>
                              <option value="approve" <?php echo ($status == 'approve') ? 'selected' : ''; ?>>
                                Approve
                              </option>
                              <option value="new" <?php echo ($status == 'success') ? 'selected' : ''; ?>>
                                successful
                              </option>
                            </select>
                            <button type="submit" name="updateStatus">Update Status</button>
                          </form>
                          <a class="btn btn-danger btn-sm" href="pages_manage_reset_pwd.php?ClearReset=<?php echo $row->id; ?>">
                            <i class="fas fa-trash"></i>
                            Delete
                          </a>
                        </td>
                      </tr>
                    <?php
                      $cnt = $cnt + 1;
                    }
                    ?>

                    <!-- Additional HTML for other data goes here -->

                  </tbody>

                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
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
  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- page script -->
  <script>
    $(function() {
      $("#example1").DataTable();
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
      });
    });
  </script>
</body>

</html>