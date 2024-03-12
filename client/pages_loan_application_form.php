<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

// Processing loan application submission
if (isset($_POST['submit'])) {
    // Handle form data
    $client_id = $_GET['client_id'];
    $client_name = $_POST['client_name'];
    $loan_amount = $_POST['loan_amount'];
    $loan_type = $_POST['loan_type'];
    // Assuming interest rate is fetched from database based on selected loan type
    $interest_rate = getInterestRate($loan_type); // Call function to get interest rate
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = 'Pending'; // Assuming status starts as pending
    $created_at = date('Y-m-d H:i:s');
    $loan_document = $_FILES['loan_document']['name'];
    $deposit_document = $_FILES['deposit_document']['name'];
    // Add other form fields as needed

    // Upload loan document
    $loan_document_path = "./../uploads/" . basename($_FILES['loan_document']['name']);
    if (!move_uploaded_file($_FILES['loan_document']['tmp_name'], $loan_document_path)) {
        echo "Error uploading loan document.";
        exit;
    }

    // Upload deposit document
    $deposit_document_path = "./../uploads/" . basename($_FILES['deposit_document']['name']);
    if (!move_uploaded_file($_FILES['deposit_document']['tmp_name'], $deposit_document_path)) {
        echo "Error uploading deposit document.";
        exit;
    }

    // Insert loan application data into the database
    $insert_query = "INSERT INTO loans (client_id, name, loan_amount, interest_rate, start_date, end_date, status, created_at, loan_document, loan_type, deposit_document) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($insert_query);
    $stmt->bind_param('issssssssss', $client_id, $client_name, $loan_amount, $interest_rate, $start_date, $end_date, $status, $created_at, $loan_document, $loan_type, $deposit_document);
    if ($stmt->execute()) {
        echo "Loan application submitted successfully.";
    } else {
        echo "Error submitting loan application.";
    }
    $stmt->close();
}

// Function to get interest rate based on loan type
function getInterestRate($loanType)
{
    include('conf/config.php'); // Include database connection
    // Query the database to fetch the interest rate based on the loan type
    $query = "SELECT interest_rate FROM rateloans WHERE loan_type = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $loanType);
    $stmt->execute();
    $stmt->bind_result($interestRate);
    $stmt->fetch();
    $stmt->close();
    return $interestRate;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <?php include("dist/_partials/head.php"); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
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
                            <h1>Apply for Loan</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="manage_clients.php">Manage Clients</a></li>
                                <li class="breadcrumb-item active">Apply for Loan</li>
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
                                <form method="post" enctype="multipart/form-data" role="form">
                                    <div class="card-body">
                                        <!-- Client Details -->
                                        <?php
                                        $client_id = $_GET['client_id'];
                                        $ret = "SELECT * FROM iB_clients WHERE client_id = ?";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->bind_param('i', $client_id);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        if ($res->num_rows > 0) {
                                            $row = $res->fetch_assoc();
                                        ?>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="client_name">Client Name</label>
                                                    <input type="text" name="client_name" readonly value="<?php echo $row['name']; ?>" class="form-control" id="client_name">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="client_number">Client Number</label>
                                                    <input type="text" name="client_number" readonly value="<?php echo $row['client_number']; ?>" class="form-control" id="client_number">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="client_phone">Client Phone Number</label>
                                                    <input type="text" name="client_phone" readonly value="<?php echo $row['phone']; ?>" class="form-control" id="client_phone">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="client_national_id">Client National ID No.</label>
                                                    <input type="text" name="client_national_id" readonly value="<?php echo $row['national_id']; ?>" class="form-control" id="client_national_id">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="client_email">Client Email</label>
                                                    <input type="email" name="client_email" readonly value="<?php echo $row['email']; ?>" class="form-control" id="client_email">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="client_adr">Client Address</label>
                                                    <input type="text" name="client_adr" readonly value="<?php echo $row['address']; ?>" class="form-control" id="client_adr">
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <!-- Loan Details -->
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="loan_type">Loan Type</label>
                                                <select class="form-control" id="loan_type_select" onchange="getLoanTypeRates(this.value)">
                                                    <option>Select Any Loan Type</option>
                                                    <?php
                                                    // Fetch all loan types from the database
                                                    $query = "SELECT DISTINCT loan_type FROM rateloans ORDER BY loan_type"; // Assuming 'rateloans' is your table
                                                    $stmt = $mysqli->prepare($query);
                                                    $stmt->execute();
                                                    $result = $stmt->get_result();

                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['loan_type'] . "'>" . $row['loan_type'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="interest_rate">Interest Rate (%)</label>
                                                <input type="text" name="interest_rate" readonly required class="form-control" id="interest_rate">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="start_date">Start Date</label>
                                                <input type="date" name="start_date" required class="form-control" id="start_date">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="end_date">End Date</label>
                                                <input type="date" name="end_date" required class="form-control" id="end_date">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="loan_document">Loan Document</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="loan_document" class="custom-file-input" id="loan_document">
                                                        <label class="custom-file-label" for="loan_document">Choose file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="">Upload</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="deposit_document">Deposit Document</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="deposit_document" class="custom-file-input" id="deposit_document">
                                                        <label class="custom-file-label" for="deposit_document">Choose file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="">Upload</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="loan_amount">Loan Amount</label>
                                                <input type="number" name="loan_amount" required class="form-control" id="loan_amount">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-success">Apply</button>
                                    </div>
                                    <script>
                                        function getLoanTypeRates(loanType) {
                                            if (loanType !== "") {
                                                // Use AJAX to fetch interest rate for the selected loan type
                                                var xhttp = new XMLHttpRequest();
                                                xhttp.onreadystatechange = function() {
                                                    if (this.readyState === 4 && this.status === 200) {
                                                        // Update the interest rate field with the response
                                                        document.getElementById("interest_rate").value = this.responseText;
                                                    }
                                                };
                                                xhttp.open("GET", "get_interest_rate.php?loan_type=" + loanType, true);
                                                xhttp.send();
                                            } else {
                                                // Clear the interest rate field if no loan type is selected
                                                document.getElementById("interest_rate").value = "";
                                            }
                                        }
                                    </script>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div><!-- /.container-fluid -->
                    </div>
                </div>
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
    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script>
        // Initialize custom file input
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
    </script>

</body>

</html>