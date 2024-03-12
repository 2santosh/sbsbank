<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
if (isset($_GET['fireLoan'])) {
  $id = intval($_GET['fireLoan']);
  $adn = "DELETE FROM  loans  WHERE loan_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $info = "iBanking Loan Account Deleted";
  } else {
    $err = "Try Again Later";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <?php include("dist/_partials/head.php"); ?>
    <title>Loans</title>
</head>
<body class="hold-transition sidebar-mini">
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
              <h1>Manage Loans</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="pages_manage_clients.php">iBank Loans</a></li>
                <li class="breadcrumb-item active">Give Loans</li>
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
              <div class="card-header">
                <h3 class="card-title">Select any action option to manage your clients</h3>
              </div>
              <div class="card-body" style="max-height: 500px; overflow-y: auto;">
                <table id="example1" class="table table-hover table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Loan ID</th>
                      <th>Client Name</th>
                      <th>Original Loan Amount</th>
              
                      <th>Start Date</th>
                      <th>Due Date</th>
         
                      <th>Pending Amount</th>
                      <th>Days Until Due</th>

                      <th>Total Amount Due</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Fetch data from the query
                    $sql = "SELECT l.loan_id, l.name, l.loan_amount AS original_loan_amount,
                    l.interest_rate, l.start_date, l.due_date,
                    COALESCE(SUM(p.payment_amt), 0) AS total_payments_made,
                    l.loan_amount - COALESCE(SUM(p.payment_amt), 0) AS pending_amount,
                    DATEDIFF(l.due_date, NOW()) AS days_until_due,
                    ROUND(l.loan_amount * (l.interest_rate / 100) * DATEDIFF(NOW(), l.start_date) / 365, 2) AS interest_accrued,
                    (l.loan_amount + ROUND(l.loan_amount * (l.interest_rate / 100) * DATEDIFF(NOW(), l.start_date) / 365, 2)) AS total_amount_due 
                    FROM Loans l 
                    LEFT JOIN LoanPayments p ON l.loan_id = p.loan_id 
                    GROUP BY l.loan_id;
                    ";
                    $result = $mysqli->query($sql);
                    $cnt = 1;
                    while ($row = $result->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row['loan_id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['original_loan_amount']; ?></td>
                        <td><?php echo $row['start_date']; ?></td>
                        <td><?php echo $row['due_date']; ?></td>

                        <td><?php echo $row['pending_amount']; ?></td>
                        <td><?php echo $row['days_until_due']; ?></td>

                        <td><?php echo $row['total_amount_due']; ?></td>
                        <td>
                          <!-- Action buttons -->
                          <a class="btn btn-success btn-sm" href="pages_view_loan.php?loan_id=<?php echo $row['loan_id']; ?>">
                            <i class="fas fa-cogs"></i> Manage
                          </a>
                          <a class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $row['loan_id']; ?>">
                            <i class="fas fa-trash"></i> Delete
                          </a>
                        </td>
                      </tr>
                    <?php $cnt = $cnt + 1;
                    } ?>
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

$(document).ready(function() {
    // Add click event listener to delete buttons
    $('.delete-btn').click(function(e) {
        e.preventDefault(); // Prevent the default action of the anchor tag

        // Get the loan ID from the data-id attribute
        var loanId = $(this).data('id');

        // Confirm the deletion
        if (confirm('Are you sure you want to delete this loan?')) {
            // Send an AJAX request to delete_loan.php
            $.ajax({
                url: 'pages_delete_loan.php',
                method: 'POST',
                data: { loan_id: loanId },
                success: function(response) {
                    // If deletion is successful, remove the corresponding row from the table
                    if (response === 'success') {
                        // Find the parent tr of the delete button and remove it
                        $(e.target).closest('tr').remove();
                    } else {
                        alert('Failed to delete the loan. Please try again later.');
                    }
                }
            });
        }
    });
});

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
