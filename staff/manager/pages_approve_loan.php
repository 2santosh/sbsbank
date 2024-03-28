<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();

// Function to fetch loan details
function fetchLoanDetails($mysqli, $loan_id) {
    $fetch_loan_query = "SELECT l.loan_id, l.client_id, l.loan_amount, l.interest_rate, l.start_date, l.end_date, l.status, l.created_at,
                              c.name AS name, c.phone AS client_phone, c.email AS client_email, c.address AS client_address,
                              p.payment_id, p.loan_amount AS payment_amount, p.payment_date,
                              l.loan_document, l.loan_type, l.deposit_document
                              FROM loans l
                              INNER JOIN ib_clients c ON l.client_id = c.client_id
                              LEFT JOIN loanpayments p ON l.loan_id = p.loan_id
                              WHERE l.loan_id = ?
                              ORDER BY l.loan_id DESC";
    $stmt_fetch_loan = $mysqli->prepare($fetch_loan_query);
    $stmt_fetch_loan->bind_param('i', $loan_id);
    $stmt_fetch_loan->execute();
    $result_loan = $stmt_fetch_loan->get_result();
    return $result_loan->fetch_assoc();
}

if (isset($_GET['loan_id'])) {
    $loan_id = $_GET['loan_id'];

    // Fetch initial loan details
    $loan_data = fetchLoanDetails($mysqli, $loan_id);

    // Check if loan data exists
    if ($loan_data) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if the form was submitted
            if (isset($_POST['action'])) {
                $action = $_POST['action'];
                if ($action === "Approve" || $action === "Reject") { // Check for "Approve" or "Reject" action
                    // Update loan status
                    $update_loan_status_query = "UPDATE loans SET status = ? WHERE loan_id = ?";
                    $new_status = ($action === "Approve") ? "approved" : "rejected";
                    $stmt_update_loan_status = $mysqli->prepare($update_loan_status_query);
                    $stmt_update_loan_status->bind_param('si', $new_status, $loan_id);
                    $stmt_update_loan_status->execute();

                    // Fetch updated loan details
                    $loan_data = fetchLoanDetails($mysqli, $loan_id);

                    // Show message
                    $action_message = "Loan has been " . strtolower($action) . ".";
                }
            }
        }
    } else {
        // Handle the case where loan data is not found
        echo "Loan data not found.";
    }
} else {
    // Handle the case where loan_id is not set
    echo "Loan ID not provided.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <?php include("dist/_partials/head.php"); ?>
    <title>Approve or Reject Loan</title>
    <!-- Additional CSS or styles can be included here -->
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("dist/_partials/nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("dist/_partials/manager.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header with logged in user details (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Approve or Reject Loan</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="pages_manage_loans.php">Manage Loans</a></li>
                                <li class="breadcrumb-item active">Approve or Reject</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Display loan details here -->
                                    <h5 class="card-title">Loan Details</h5>
                                    <!-- Display loan details fetched from the database -->
                                    <p class="card-text">Loan ID: <?php echo $loan_data['loan_id']; ?><br>
                                    Client Name: <?php echo $loan_data['name']; ?><br>
                                    Contact: <?php echo $loan_data['client_phone']; ?><br>
                                    Email: <?php echo $loan_data['client_email']; ?><br>
                                    Interest Rate: <?php echo $loan_data['interest_rate']; ?><br>
                                    Start Date: <?php echo $loan_data['start_date']; ?><br>
                                    End Date: <?php echo $loan_data['end_date']; ?><br>
                                    Status: <?php echo $loan_data['status']; ?><br>
                                    Loan Amount (USD): <?php echo $loan_data['loan_amount']; ?><br>
                                    <?php if (!empty($loan_data['loan_document'])) : ?>
                                    <a href="<?php echo $loan_data['loan_document']; ?>" target="_blank" class="btn btn-primary">View Loan Document</a>
                                    <?php endif; ?>
                                    <?php if (!empty($loan_data['deposit_document'])) : ?>
                                    <a href="<?php echo $loan_data['deposit_document']; ?>" target="_blank" class="btn btn-primary">View Deposit Document</a>
                                    <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Loan approval/rejection form -->
                                    <h5 class="card-title">Loan Actions</h5>
                                    <?php if (isset($action_message)) : ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php echo $action_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    <form method="post">
                                        <input type="hidden" name="loan_id" value="<?php echo $loan_data['loan_id']; ?>">
                                        <!-- Add a dropdown or radio buttons for approval/rejection -->
                                        <div class="form-group">
                                            <label for="action">Select Action:</label>
                                            <select name="action" class="form-control">
                                            <option value="Pending">Pending</option>
                                                <option value="Approve">Approve</option>
                                                <option value="Reject">Reject</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success" name="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
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
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>
</html>
