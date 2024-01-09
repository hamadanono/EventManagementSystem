<?php
include("config.php");

// Start or resume the session
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

$studentId = $_SESSION['student_id'];

// Check if the event_id and event_pwd are set
if (isset($_GET['event_id']) && is_numeric($_GET['event_id']) && isset($_GET['event_pwd'])) {
    $eventId = $_GET['event_id'];
    $eventPwd = $_GET['event_pwd'];

    // Verify the event password
    $stmt = mysqli_prepare($conn, "SELECT event_pwd FROM event WHERE event_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Check if the entered password matches the stored event password
        if ($eventPwd == $row['event_pwd']) {
            // Update the attendance status for the specified event and student
            $updateAttendance = mysqli_prepare($conn, "UPDATE attendee SET attendance_status = 'A' WHERE event_id = ? AND student_id = ?");
            mysqli_stmt_bind_param($updateAttendance, "is", $eventId, $studentId);

            // Execute the statement
            mysqli_stmt_execute($updateAttendance);

            // Close the statement
            mysqli_stmt_close($updateAttendance);

            $_SESSION['registration_status'] = 'attendance_success';
        } else {
            $_SESSION['registration_status'] = 'wrong_password';
        }
    } else {
        die('Error in SQL query: ' . mysqli_error($conn));
    }

    // Close the statement for password verification
    mysqli_stmt_close($stmt);
}

// Redirect back to the joined events page
header("Location: joined_event.php");
exit();
?>
