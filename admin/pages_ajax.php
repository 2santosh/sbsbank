<?php
include('conf/pdoconfig.php');

// Handle retrieval of bank account rate based on account type
if (!empty($_POST["iBankAccountType"])) {
    $id = $_POST['iBankAccountType'];
    $stmt = $DB_con->prepare("SELECT * FROM iB_Acc_types WHERE  name = :id");
    $stmt->execute(array(':id' => $id));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['rate']);
    }
}

// Handle retrieval of bank account transferables name based on account number
if (!empty($_POST["iBankAccNumber"])) {
    $id = $_POST['iBankAccNumber'];
    $stmt = $DB_con->prepare("SELECT * FROM iB_bankAccounts WHERE  account_number= :id");
    $stmt->execute(array(':id' => $id));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['acc_name']);
    }
}

// Handle retrieval of bank account holder's name based on account number
if (!empty($_POST["iBankAccHolder"])) {
    $id = $_POST['iBankAccHolder'];
    $stmt = $DB_con->prepare("SELECT * FROM iB_bankAccounts WHERE  account_number= :id");
    $stmt->execute(array(':id' => $id));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo htmlentities($row['client_name']);
    }
}

// Handle insertion of loan data into the database
if (!empty($_POST["loan_amount"]) && !empty($_POST["loan_type"]) && !empty($_POST["interest_rate"]) && !empty($_POST["start_date"]) && !empty($_POST["end_date"])) {
    $loan_amount = $_POST["loan_amount"];
    $loan_type = $_POST["loan_type"];
    $interest_rate = $_POST["interest_rate"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    // Upload loan document
    $loan_document_path = ""; // Path to the uploaded loan document, if needed
    // Upload deposit document
    $deposit_document_path = ""; // Path to the uploaded deposit document, if needed

    // Prepare the SQL statement
    $stmt = $DB_con->prepare("INSERT INTO rateloans (loan_type, interest_rate, start_date, end_date, loan_amount, loan_document, deposit_document) VALUES (:loan_type, :interest_rate, :start_date, :end_date, :loan_amount, :loan_document, :deposit_document)");

    // Bind parameters
    $stmt->bindParam(':loan_amount', $loan_amount);
    $stmt->bindParam(':loan_type', $loan_type);
    $stmt->bindParam(':interest_rate', $interest_rate);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':loan_document', $loan_document_path);
    $stmt->bindParam(':deposit_document', $deposit_document_path);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Loan added successfully.";
    } else {
        echo "Error adding loan.";
    }
}

?>
