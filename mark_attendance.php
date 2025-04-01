<?php
session_start();
require 'php/connection.php';

// Check if user is logged in and has a valid role
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    echo "Unauthorized access!";
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$current_date = date("Y-m-d");

// Check if attendance is already marked for today
$check_query = "SELECT * FROM attendance WHERE user_id='$user_id' AND role='$role' AND attendance_date='$current_date'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    echo "Attendance already marked for today!";
} else {
    // Mark attendance as 'Present'
    $mark_query = "INSERT INTO attendance (user_id, role, attendance_date, status) VALUES ('$user_id', '$role', '$current_date', 'Present')";
    if (mysqli_query($conn, $mark_query)) {
        echo "Attendance marked successfully!";
    } else {
        echo "Error marking attendance: " . mysqli_error($conn);
    }
}
?>