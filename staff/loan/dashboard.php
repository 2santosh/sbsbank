<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$staff_id = $_SESSION['staff_id'];

// Clear notifications and alert user that they are cleared
if (isset($_GET['Clear_Notifications'])) {
  $id = intval($_GET['Clear_Notifications']);
  $adn = "DELETE FROM  iB_notifications  WHERE notification_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $info = "Notifications Cleared";
  } else {
    $err = "Try Again Later";
  }
}

// Queries to fetch loan-related data from the database
$result_loans = $mysqli->query("SELECT count(*) FROM loans")->fetch_assoc()['count(*)'];
$result_rateloans = $mysqli->query("SELECT count(*) FROM rateloans")->fetch_assoc()['count(*)'];
$result_loanpayments = $mysqli->query("SELECT count(*) FROM loanpayments")->fetch_assoc()['count(*)'];
$result_status = $mysqli->query("SELECT count(*) FROM loans WHERE status = 'pending'")->fetch_assoc()['count(*)'];
$result_loan_dues = $mysqli->query("SELECT SUM(due_amount) AS total_due FROM loanpayments")->fetch_assoc()['total_due'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("dist/_partials/head.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include("dist/_partials/nav.php"); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include("dist/_partials/loan.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Add content header here if needed -->
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row equal-height">
            <!-- Total Pending and New Loan Accounts -->
            <div class="col-md-3 mb-3">
              <div class="info-box bg-warning">
                <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Pending Loan Accounts</span>
                  <span class="info-box-number"><?php echo $result_status; ?></span>
                </div>
              </div>
            </div>

            <!-- Total Loans -->
            <div class="col-md-3 mb-3">
              <div class="info-box bg-info">
                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Loans</span>
                  <span class="info-box-number"><?php echo $result_loans; ?></span>
                </div>
              </div>
            </div>

            <!-- Total Rate Loans -->
            <div class="col-md-3 mb-3">
              <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fas fa-briefcase"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Rate Loans</span>
                  <span class="info-box-number"><?php echo $result_rateloans; ?></span>
                </div>
              </div>
            </div>

            <!-- Total Loan Payments -->
            <div class="col-md-3 mb-3">
              <div class="info-box bg-purple">
                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Loan Payments</span>
                  <span class="info-box-number"><?php echo $result_loanpayments; ?></span>
                </div>
              </div>
            </div>

            <!-- Total Loan Dues -->
            <div class="col-md-3 mb-3">
              <div class="info-box bg-warning">
                <span class="info-box-icon"><i class="fas fa-money-check-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Loan Dues</span>
                  <span class="info-box-number"><?php echo $result_loan_dues; ?></span>
                </div>
              </div>
            </div>
          </div>
          <!--/.row -->
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-hover m-0">
              <thead>
                <tr>
                  <th>Transaction Code</th>
                  <th>Account No.</th>
                  <th>Type</th>
                  <th>Amount</th>
                  <th>Acc. Owner</th>
                  <th>Timestamp</th>
                </tr>
              </thead>
              <tbody>
    <?php
    // SQL query to fetch both loan and loan payment records with a source column
    $sql = "(SELECT 'loan' AS source, loan_id AS id, name, loan_amount, status, tr_code, created_at AS date FROM loans)
    UNION ALL
    (SELECT 'payment' AS source, payment_id AS id, name, payment_amount AS loan_amount, tr_status, tr_code, payment_date AS date FROM loanpayments)
    ORDER BY date DESC LIMIT 10";



    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach ($result as $row) {
        // Determine the source of the row (loan or payment)
        $source = $row['source'];

        // Determine the type (loan or payment)
        $type = ($source === 'loan') ? 'Loan (' . ($row['tr_status'] ?? '') . ')' : 'Payment (' . ($row['tr_status'] ?? '') . ')';

        // Format the date
        $formatted_date = date("d-M-Y", strtotime($row['date']));

        // Output row data
        echo '<tr>';
        echo '<td>' . $row['tr_code'] . '</td>';
        echo '<td>' . ($source === 'loan' ? 'Loan ID: ' : 'Payment ID: ') . ($row['id'] ?? '') . '</td>';
        echo '<td>' . $type . '</td>';
        echo '<td>' . ($row['loan_amount'] ?? '') . '</td>';
        echo '<td>' . ($row['name'] ?? '') . '</td>';
        echo '<td>' . $formatted_date . '</td>';
        echo '</tr>';
    }
    ?>
</tbody>

            </table>
          </div>
          <!-- /.table-responsive -->
        </div>
        <!--/. container-fluid -->
      </section>

      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php include("dist/_partials/footer.php"); ?>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="dist/js/demo.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>

  <!-- PAGE SCRIPTS -->
  <script src="dist/js/pages/dashboard2.js"></script>

  <!-- Load Canvas JS -->
  <script src="plugins/canvasjs.min.js"></script>
  <!-- Load Few Charts -->
  <script>
    // JavaScript code for rendering charts
  </script>
</body>

</html>