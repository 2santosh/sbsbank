<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$staff_id = $_SESSION['staff_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loan_id = $_POST['loan_id'];
    $client_name = $_POST['client_name'];
    $status = $_POST['status'];

    // Insert the new loan into the database
    $insert_loan_query = "INSERT INTO loans (loan_id, client_name, status) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($insert_loan_query);
    $stmt->bind_param('iss', $loan_id, $client_name, $status);
    $stmt->execute();
    $stmt->close();

    if ($stmt) {
        $info = "Loan Added Successfully";
    } else {
        $err = "Failed to Add Loan";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Loans</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Manage Loans</div>
                    <div class="card-body">
                        <?php if(isset($info)): ?>
                            <div class="alert alert-success"><?php echo $info; ?></div>
                        <?php endif; ?>
                        <?php if(isset($err)): ?>
                            <div class="alert alert-danger"><?php echo $err; ?></div>
                        <?php endif; ?>
                        <form action="manage_loans.php" method="POST">
                            <div class="form-group">
                                <label for="loan_id">Loan ID</label>
                                <input type="text" class="form-control" id="loan_id" name="loan_id" placeholder="Enter Loan ID">
                            </div>
                            <div class="form-group">
                                <label for="client_name">Client Name</label>
                                <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Enter Client Name">
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Loan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
