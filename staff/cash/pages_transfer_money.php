<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$staff_id = $_SESSION['staff_id'];

if (isset($_POST['deposit'])) {
    $tr_code = $_POST['tr_code'];
    $account_id = $_GET['account_id'];
    $acc_name = $_POST['acc_name'];
    $account_number = $_GET['account_number'];
    $acc_type = $_POST['acc_type'];
    $tr_type = $_POST['tr_type'];
    $tr_status = $_POST['tr_status'];
    $client_id = $_GET['client_id'];
    $client_name = $_POST['client_name'];
    $client_national_id = $_POST['client_national_id'];
    $transaction_amt = $_POST['transaction_amt'];
    $client_phone = $_POST['client_phone'];

    //Few fields to hold funds transfers
    $receiving_acc_no = $_POST['receiving_acc_no'];
    $receiving_acc_name = $_POST['receiving_acc_name'];
    $receiving_acc_holder = $_POST['receiving_acc_holder'];

    // Notification
    $notification_details = "$client_name Has Transferred $$transaction_amt From Bank Account $account_number To Bank Account $receiving_acc_no";

    // Query to get the current balance of the sender's account
    $current_balance_query = "SELECT acc_amount FROM iB_bankaccounts WHERE account_id = ?";
    $balance_stmt = $mysqli->prepare($current_balance_query);
    $balance_stmt->bind_param('i', $account_id);
    $balance_stmt->execute();
    $balance_stmt->bind_result($current_balance);
    $balance_stmt->fetch();
    $balance_stmt->close();

    // Check if the current balance is sufficient for the transfer
    if ($transaction_amt > $current_balance) {
        $transaction_error = "You Do Not Have Sufficient Funds In Your Account For Transfer. Your Current Account Balance Is $$current_balance";
    } else {
        // Start transaction
        $mysqli->begin_transaction();

        try {
            // Deduct the transaction amount from the sender's account
            $update_sender_query = "UPDATE iB_bankaccounts SET acc_amount = acc_amount - ? WHERE account_id = ?";
            $update_sender_stmt = $mysqli->prepare($update_sender_query);
            $update_sender_stmt->bind_param('di', $transaction_amt, $account_id);
            $update_sender_stmt->execute();

            // Add the transaction amount to the receiver's account
            $update_receiver_query = "UPDATE iB_bankaccounts SET acc_amount = acc_amount + ? WHERE account_number = ?";
            $update_receiver_stmt = $mysqli->prepare($update_receiver_query);
            $update_receiver_stmt->bind_param('ds', $transaction_amt, $receiving_acc_no);
            $update_receiver_stmt->execute();

            // Update balance in transactions table for sender
            $update_balance_query_transaction_sender = "UPDATE iB_Transactions SET acc_amount = acc_amount - ? WHERE account_id = ?";
            $update_balance_stmt_transaction_sender = $mysqli->prepare($update_balance_query_transaction_sender);
            $update_balance_stmt_transaction_sender->bind_param('di', $transaction_amt, $account_id);
            $update_balance_stmt_transaction_sender->execute();

            // Update balance in transactions table for receiver
            $update_balance_query_transaction_receiver = "UPDATE iB_Transactions SET acc_amount = acc_amount + ? WHERE receiving_acc_no = ?";
            $update_balance_stmt_transaction_receiver = $mysqli->prepare($update_balance_query_transaction_receiver);
            $update_balance_stmt_transaction_receiver->bind_param('ds', $transaction_amt, $receiving_acc_no);
            $update_balance_stmt_transaction_receiver->execute();

            // Insert the transfer details into the transactions table
            $insert_transaction_query = "INSERT INTO iB_Transactions (tr_code, account_id, acc_name, account_number, acc_type, tr_type, tr_status, client_id, client_name, client_national_id, transaction_amt, client_phone, receiving_acc_no, receiving_acc_name, receiving_acc_holder) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $insert_transaction_stmt = $mysqli->prepare($insert_transaction_query);
            $insert_transaction_stmt->bind_param('sssssssssssssss', $tr_code, $account_id, $acc_name, $account_number, $acc_type, $tr_type, $tr_status, $client_id, $client_name, $client_national_id, $transaction_amt, $client_phone, $receiving_acc_no, $receiving_acc_name, $receiving_acc_holder);
            $insert_transaction_stmt->execute();

            // Insert the notification details
            $insert_notification_query = "INSERT INTO iB_notifications (notification_details) VALUES (?)";
            $insert_notification_stmt = $mysqli->prepare($insert_notification_query);
            $insert_notification_stmt->bind_param('s', $notification_details);
            $insert_notification_stmt->execute();

            // Commit transaction
            $mysqli->commit();
            
            $success = "Money Transferred";
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $mysqli->rollback();
            $err = "Please Try Again Or Try Later";
        }
    }
}
?>


<!-- Log on to codeastro.com for more projects! -->
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
        <?php include("dist/_partials/cash.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <?php
        $account_id = $_GET['account_id'];
        $ret = "SELECT * FROM  iB_bankAccounts WHERE account_id = ? ";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $account_id);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        $cnt = 1;
        while ($row = $res->fetch_object()) {
            //Indicate Account Balance 
            $result = "SELECT SUM(transaction_amt) FROM  iB_Transactions  WHERE account_id=?";
            $stmt = $mysqli->prepare($result);
            $stmt->bind_param('i', $account_id);
            $stmt->execute();
            $stmt->bind_result($amt);
            $stmt->fetch();
            $stmt->close();

        ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Transfer Money</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="pages_dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="pages_transfer_money.php">Finances</a></li>
                                    <li class="breadcrumb-item"><a href="pages_transfer_money.php">Transfer</a></li>
                                    <li class="breadcrumb-item active"><?php echo $row->acc_name; ?></li>
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

                                            <div class="row">
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">Client Name</label>
                                                    <input type="text" readonly name="client_name" value="<?php echo $row->client_name; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Client National ID No.</label>
                                                    <input type="text" readonly value="<?php echo $row->client_national_id; ?>" name="client_national_id" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">Client Phone Number</label>
                                                    <input type="text" readonly name="client_phone" value="<?php echo $row->client_phone; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">Account Name</label>
                                                    <input type="text" readonly name="acc_name" value="<?php echo $row->acc_name; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Account Number</label>
                                                    <input type="text" readonly value="<?php echo $row->account_number; ?>" name="account_number" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">Account Type | Category</label>
                                                    <input type="text" readonly name="acc_type" value="<?php echo $row->acc_type; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">Transaction Code</label>
                                                    <?php
                                                    //PHP function to generate random account number
                                                    $length = 20;
                                                    $_transcode =  substr(str_shuffle('0123456789QWERgfdsazxcvbnTYUIOqwertyuioplkjhmPASDFGHJKLMNBVCXZ'), 1, $length);
                                                    ?>
                                                    <input type="text" name="tr_code" readonly value="<?php echo $_transcode; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="exampleInputPassword1">Current Account Balance</label>
                                                    <?php
                                                    // Fetch the current account balance
                                                    $balance_query = "SELECT acc_amount FROM iB_bankAccounts WHERE account_id = ?";
                                                    $balance_stmt = $mysqli->prepare($balance_query);
                                                    $balance_stmt->bind_param('i', $account_id);                                                     $balance_stmt->execute();
                                                    $balance_stmt->bind_result($acc_balance);
                                                    $balance_stmt->fetch();
                                                    $balance_stmt->close();
                                                    ?>
                                                    <input type="text" readonly value="RS <?php echo $acc_balance; ?>" class="form-control" id="exampleInputEmail1">
                                                </div>

                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Amount Transferred($)</label>
                                                    <input type="text" name="transaction_amt" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Receiving Account Number</label>
                                                    <select name="receiving_acc_no" onChange="getiBankAccs(this.value);" required class="form-control">
                                                        <option>Select Receiving Account</option>
                                                        <?php
                                                        // Fetch all iB_Accs excluding the sender account
                                                        $ret = "SELECT * FROM  iB_bankAccounts WHERE account_id != ?";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->bind_param('i', $account_id);
                                                        $stmt->execute(); // Execute the prepared query
                                                        $res = $stmt->get_result(); // Get the result set from the prepared statement

                                                        // Loop through each row in the result set
                                                        while ($row = $res->fetch_object()) {
                                                        ?>
                                                            <option><?php echo $row->account_number; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Receiving Account Name</label>
                                                    <input type="text" name="receiving_acc_name" required class="form-control" id="ReceivingAcc">
                                                </div>
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Receiving Account Holder</label>
                                                    <input type="text" name="receiving_acc_holder" required class="form-control" id="AccountHolder">
                                                </div>

                                                <div class=" col-md-4 form-group" style="display:none">
                                                    <label for="exampleInputPassword1">Transaction Type</label>
                                                    <input type="text" name="tr_type" value="Transfer" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-4 form-group" style="display:none">
                                                    <label for="exampleInputPassword1">Transaction Status</label>
                                                    <input type="text" name="tr_status" value="Success " required class="form-control" id="exampleInputEmail1">
                                                </div>

                                            </div>

                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <button type="submit" name="deposit" class="btn btn-success">Transfer Funds</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
        <?php } ?>
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
    <script type="text/javascript">
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
    </script>
</body>

</html>