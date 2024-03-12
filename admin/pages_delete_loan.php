<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loan_id'])) {
    $loan_id = $_POST['loan_id'];

    // Prepare and execute the DELETE statement
    $stmt = $mysqli->prepare("DELETE FROM loans WHERE loan_id = ?");
    $stmt->bind_param("i", $loan_id);
    $stmt->execute();
    $stmt->close();

    // Check if the deletion was successful
    if ($stmt) {
        echo 'success'; // Return 'success' to the AJAX request if deletion was successful
    } else {
        echo 'error'; // Return 'error' if deletion failed
    }
} else {
    // If loan_id is not set or if the request method is not POST, return an error
    echo 'error';
}
?>
