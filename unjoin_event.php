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
    $eventIdToUnjoin = $_GET['event_id'];

    // Delete the attendee record for the specified event and student
    $deleteAttendee = mysqli_prepare($conn, "DELETE FROM attendee WHERE event_id = ? AND student_id = ?");
    mysqli_stmt_bind_param($deleteAttendee, "is", $eventIdToUnjoin, $studentId);

    // Execute the statement
    mysqli_stmt_execute($deleteAttendee);

    // Close the statement
    mysqli_stmt_close($deleteAttendee);
}

// Check if the event_id is set and valid
if (isset($_GET['event_id']) && is_numeric($_GET['event_id'])) {
    $eventId = $_GET['event_id'];

    // Retrieve the event name
    $stmt = mysqli_prepare($conn, "SELECT event_name FROM event WHERE event_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $eventId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $eventName);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Show the success message
    echo "You've successfully withdrawn from the event '" . $eventName . "'.";
} else {
    // Handle error or redirect to an error page
    echo "Error: Event ID is not valid.";
}

// Redirect back to the joined events page
header("Location: joined_event.php");
exit();
?>
