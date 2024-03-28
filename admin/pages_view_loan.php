<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle loan payment
if (isset($_POST['pay_loan'])) {
    // Validate and sanitize input values
    $tr_code = $_POST['tr_code'];
    $loan_id = isset($_GET['loan_id']) ? intval($_GET['loan_id']) : 0;
    $loan_amount = $_POST['loan_amount'];
    $client_id = isset($_GET['client_id']) ? intval($_GET['client_id']) : 0;
    $client_name = $_POST['client_name'];
    $client_national_id = $_POST['client_national_id'];
    $transaction_amt = $_POST['transaction_amt'];

    // Check if $loan_id and $client_id are valid integers
    if ($loan_id <= 0 || $client_id <= 0) {
        // Handle invalid input (redirect or display an error message)
        echo "Invalid loan ID or client ID";
        exit(); // Exit the script to prevent further execution
    }

    // Insert loan payment transaction
    $query = "INSERT INTO loanpayments (loan_id, name, loan_amount, tr_code, client_id, borrower_national_id, payment_amt) VALUES (?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    // Bind parameters
    $stmt->bind_param('isdsidd', $loan_id, $client_name, $loan_amount, $tr_code, $client_id, $client_national_id, $transaction_amt);

    $stmt->execute();

    // Check for errors
    if ($stmt->error) {
        echo "Error: " . $stmt->error; // Output any errors that occurred during execution
    } else {
        // Check if transaction was successful
        if ($stmt->affected_rows > 0) {
            $success = "Loan payment successful";

            // Decrease loan amount by payment amount
            $new_loan_amount = $loan_amount - $transaction_amt;
            $update_query = "UPDATE loans SET loan_amount = ? WHERE loan_id = ?";
            $update_stmt = $mysqli->prepare($update_query);
            $update_stmt->bind_param('di', $new_loan_amount, $loan_id);
            $update_stmt->execute();

            if ($update_stmt->error) {
                echo "Error updating loan amount: " . $update_stmt->error;
            } else {
                $success .= " Loan amount updated.";
            }
        } else {
            $err = "Failed to process loan payment. Please try again later.";
        }
    }
}

// Handle loan update
if (isset($_POST['update'])) {
    // Validate and sanitize input values
    $new_loan_type = $_POST['loan_type'];
    $new_interest_rate = $_POST['interest_rate'];

    // Get loan_id from the URL parameter
    $loan_id = isset($_GET['loan_id']) ? intval($_GET['loan_id']) : 0;

    // Check if $loan_id is a valid integer
    if ($loan_id <= 0) {
        // Handle invalid input (redirect or display an error message)
        echo "Invalid loan ID";
        exit(); // Exit the script
    }

    // Prepare and execute query to update loan details
    $update_query = "UPDATE loans SET loan_type = ?, interest_rate = ? WHERE loan_id = ?";
    $update_stmt = $mysqli->prepare($update_query);
    $update_stmt->bind_param('sdi', $new_loan_type, $new_interest_rate, $loan_id);
    $update_stmt->execute();

    // Check for errors
    if ($update_stmt->error) {
        echo "Error updating loan details: " . $update_stmt->error;
    } else {
        // Check if update was successful
        if ($update_stmt->affected_rows > 0) {
            $success = "Loan details updated successfully";
        } else {
            $err = "Failed to update loan details. Please try again later.";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include("dist/_partials/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include("dist/_partials/nav.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include("dist/_partials/sidebar.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <?php
        // Get loan_id from the URL parameter
        $loan_id = isset($_GET['loan_id']) ? intval($_GET['loan_id']) : 0;

        // Check if $loan_id is a valid integer
        if ($loan_id <= 0) {
            // Handle invalid input (redirect or display an error message)
            echo "Invalid loan ID";
            exit(); // Exit the script
        }

        // Prepare and execute query to fetch loan details
        $ret_specific = "SELECT l.loan_id, l.client_id, l.loan_amount, l.interest_rate, l.start_date, l.end_date, l.status, l.created_at,
        c.name AS name, c.phone AS client_phone, c.email AS client_email, c.address AS client_address,
        p.payment_id, p.loan_amount AS payment_amount, p.payment_date,
        l.loan_document, l.loan_type, l.deposit_document,
        COALESCE(SUM(p.payment_amt), 0) AS total_payments_made, (l.loan_amount - COALESCE(SUM(p.payment_amt), 0)) AS pending_amount,
        DATEDIFF(l.due_date, NOW()) AS days_until_due, ROUND((l.loan_amount * (l.interest_rate / 100) * DATEDIFF(NOW(), l.start_date) / 365), 2) AS interest_accrued, (l.loan_amount + ROUND((l.loan_amount * (l.interest_rate / 100) * DATEDIFF(NOW(), l.start_date) / 365), 2)) AS total_amount_due,
        l.due_date
        FROM loans l
        LEFT JOIN loanpayments p ON l.loan_id = p.loan_id
        LEFT JOIN ib_clients c ON l.client_id = c.client_id
        GROUP BY l.loan_id";


        $stmt = $mysqli->prepare($ret_specific);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_object();

        // Check if a row is fetched
        if (!$row) {
            // Handle the case where no loan is found with the given ID
            echo "Loan not found";
            exit(); // Exit the script
        }
        ?>
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
                                <li class="breadcrumb-item"><a href="pages_loans.php">iBank Finances</a></li>
                                <li class="breadcrumb-item"><a href="pages_loans.php">Loans</a></li>
                                <li class="breadcrumb-item active"><?php echo $row->name; ?></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-purple">
                                <div class="card-header">
                                    <h3 class="card-title">Fill All Fields</h3>
                                </div>
                                <!-- form start -->
                                <form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputEmail1">Loan ID</label>
                                                <input type="text" readonly name="loan_id" value="<?php echo $row->loan_id; ?>" required class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Client ID</label>
                                                <input type="text" readonly name="client_id" value="<?php echo $row->client_id; ?>" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputEmail1">Client Name</label>
                                                <input type="text" readonly name="client_name" value="<?php echo $row->name; ?>" required class="form-control">
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputEmail1">Loan Amount</label>
                                                <input type="text" readonly name="loan_amount" value="<?php echo $row->loan_amount; ?>" required class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Transaction Code</label>
                                                <?php
                                                // Generate random transaction code
                                                $tr_code = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 10);
                                                ?>
                                                <input type="text" name="tr_code" readonly value="<?php echo $tr_code; ?>" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputEmail1">Client Phone</label>
                                                <input type="text" readonly name="client_phone" value="<?php echo $row->client_phone; ?>" required class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Client Email</label>
                                                <input type="email" readonly name="client_email" value="<?php echo $row->client_email; ?>" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="loanType">Loan Type</label>
                                                <select name="loan_type" id="loanType" class="form-control" required>
                                                    <?php
                                                    $loan_types_query = "SELECT * FROM rateloans";
                                                    $loan_types_result = $mysqli->query($loan_types_query);
                                                    if ($loan_types_result && $loan_types_result->num_rows > 0) {
                                                        while ($loan_type_row = $loan_types_result->fetch_assoc()) {
                                                            echo "<option value='" . $loan_type_row['loan_type'] . "'>" . $loan_type_row['loan_type'] . "</option>";
                                                        }
                                                    } else {
                                                        echo "<option value=''>No Loan Types Available</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputEmail1">Interest Rate</label>
                                                <input type="text" readonly name="interest_rate" value="<?php echo $row->interest_rate; ?>" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Start Date</label>
                                                <input type="text" readonly name="start_date" value="<?php echo $row->start_date; ?>" required class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">End Date</label>
                                                <input type="text" readonly name="end_date" value="<?php echo $row->end_date; ?>" required class="form-control">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Status</label>
                                                <input type="text" readonly name="status" value="<?php echo $row->status; ?>" required class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Payment Amount</label>
                                                <input type="text" readonly name="payment_amount" value="<?php echo $row->payment_amount; ?>" required class="form-control">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Due date</label>
                                                <input type="text" readonly name="payment_amount" value="<?php echo $row->due_date; ?>" required class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Total Payments</label>
                                                <input type="text" readonly name="payment_amount" value="<?php echo $row->total_payments_made; ?>" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">pending_amount</label>
                                                <input type="text" readonly name="payment_amount" value="<?php echo $row->pending_amount; ?>" required class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Days Until Due</label>
                                                <input type="text" readonly name="payment_amount" value="<?php echo $row->days_until_due; ?>" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">interest Accrued</label>
                                                <input type="text" readonly name="payment_amount" value="<?php echo $row->interest_accrued; ?>" required class="form-control">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputPassword1">Total Amount due</label>
                                                <input type="text" readonly name="payment_amount" value="<?php echo $row->total_amount_due; ?>" required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" name="update" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include("dist/_partials/footer.php"); ?>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>
