<?php
// Include database connection script (assuming it's in a separate file named 'db_connect.php')
include('conf/config.php');

// Get the loan type from the query parameter
$loan_type = $_GET['loan_type'];

if ($loan_type) {
  // Prepare a query to select interest rate based on loan type
  $query = "SELECT interest_rate FROM rateloans WHERE loan_type = ?";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('s', $loan_type);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $interest_rate = $row['interest_rate'];
    echo $interest_rate; // Send the interest rate back to the AJAX request
  } else {
    echo "0"; // Return 0 if no interest rate found for the loan type
  }
} else {
  echo "0"; // Return 0 if no loan type parameter is provided
}

$mysqli->close();
?>
