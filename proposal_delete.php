<?php
    include('config.php');
	session_start();

    if(!isset($_SESSION['pmfki_id'])){
		header("location: index.php");
		exit();
	}

    // this action called when Delete link is clicked
    if (isset($_GET["id"]) && $_GET["id"] != "") {
        // Use prepared statement to prevent SQL injection
        $id = $_GET["id"];
        $sql = "DELETE FROM event WHERE event_id = ? ";
        
        // Prepare the statement
        $stmt = mysqli_prepare($conn, $sql);
    
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "i", $id);
    
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo '<script>';
            echo 'alert("Proposal Deleted Successfully!");';
            echo 'window.location.href = "proposal_pmfki.php";';
            echo '</script>';
        } else {
            echo '<script>';
            echo 'alert("Failed to Delete the Proposal!");';
            echo 'window.location.href = "proposal_pmfki.php";';
            echo '</script>';
        }
    
        // Close the statement
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($conn);
?>
