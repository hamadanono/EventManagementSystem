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

// Check if the event_id is set and valid
if (isset($_GET['event_id']) && is_numeric($_GET['event_id'])) {
    $eventIdToJoin = $_GET['event_id'];

    // Check if the student has already joined the event
    $checkJoined = mysqli_prepare($conn, "SELECT * FROM attendee WHERE event_id = ? AND student_id = ?");
    mysqli_stmt_bind_param($checkJoined, "is", $eventIdToJoin, $studentId);
    mysqli_stmt_execute($checkJoined);
    $resultJoined = mysqli_stmt_get_result($checkJoined);

    if (mysqli_num_rows($resultJoined) > 0) {
        $_SESSION['registration_status'] = 'already_joined';
    } else {
        // Insert the attendee record for the logged-in user
        $insertAttendee = mysqli_prepare($conn, "INSERT INTO attendee (attendance_status, event_id, student_id) VALUES ('B', ?, ?)");
        mysqli_stmt_bind_param($insertAttendee, "is", $eventIdToJoin, $studentId);

        // Execute the statement
        if (mysqli_stmt_execute($insertAttendee)) {
            $_SESSION['registration_status'] = 'success';
            // Redirect back to the eventboard
            header("Location: eventboard.php");
            exit();
        } else {
            $_SESSION['registration_status'] = 'failure';
        }

        // Close the statement
        mysqli_stmt_close($insertAttendee);
    }

    // Close the statement for checking joined status
    mysqli_stmt_close($checkJoined);
} else {
    // Handle error or redirect to an error page
    echo "Error: Event ID is not valid.";
}

// Redirect back to the eventboard in case of any issues
header("Location: eventboard.php");
exit();
?>
