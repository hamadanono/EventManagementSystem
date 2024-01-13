<?php
session_start();
include('config.php');

// This block is called when the "Submit Feedback" button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Values for add or edit
    $event_id = $_POST["event_id_to_feedback"];
    $rating = $_POST["rating"];
    $comment = trim($_POST["comment"]);
    
    // Check if $_SESSION['student_id'] is set
    if (isset($_SESSION['student_id'])) {
        $student_id = $_SESSION['student_id'];

        $sql = "INSERT INTO feedback (rating, comment, event_id, student_id) 
                VALUES ('$rating', '$comment', '$event_id', '$student_id')";

        $status = insertTo_DBTable($conn, $sql);
        if ($status) {
            // Display a popup message
            echo "<script>alert('Feedback Added Successfully!');</script>";
        } else {
            echo "<script>alert('Failed to Add Feedback!');</script>";
        }
        // Redirect back to the event page or wherever you want
        echo "<script>window.location.href='joined_event.php';</script>";
        exit();
    } else {
        // Handle the case where $_SESSION['student_id'] is not set
        echo "<script>alert('Error: Student ID not set.');</script>";
        // Redirect or handle accordingly
    }
}

// Close DB connection
mysqli_close($conn);

// Function to insert data into the database table
function insertTo_DBTable($conn, $sql) {
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo "Error: " . $sql . " : " . mysqli_error($conn) . "<br>";
        return false;
    }
}
?>
