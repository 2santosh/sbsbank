<?php
session_start();
include('cash/conf/config.php'); // Include configuration file

// Check if the user is logged in
if (!isset($_SESSION['staff_id'])) {
    // Redirect to login page or display an error message
    header("location: pages_staff_login.php");
    exit();
}

// Retrieve the role of the logged-in user
$staff_id = $_SESSION['staff_id'];

// Query to get the role of the logged-in user
$stmt = $mysqli->prepare("SELECT staff_position FROM ib_staff WHERE staff_id = ?");
$stmt->bind_param('s', $staff_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($staff_position);
    $stmt->fetch();
    $stmt->close();

    // Perform actions based on the role
    switch ($staff_position) {
        case 'Manager':
            // Redirect to manager dashboard or include manager-specific content
            header("location: manager/dashboard.php");
            exit();
            break;
        case 'CSD':
            // Redirect to customer service department page or include csd-specific content
            header("location: csd/dashboard.php");
            exit();
            break;
        case 'Loan':
            // Redirect to loan department page or include loan-specific content
            header("location: loan/dashboard.php");
            exit();
            break;
        case 'Cash':
            // Redirect to cash department page or include cash-specific content
            header("location: cash/dashboard.php");
            exit();
            break;
        default:
            // Redirect to a default page or display an error message
            $err = 'Not Found';
            exit();
            break;
    }
} else {
    // Unable to retrieve user role, redirect to an error page or display an error message
    $err = 'Not Found';
    exit();
}

