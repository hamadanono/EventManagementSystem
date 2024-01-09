<?php
    include("config.php");
    
    // Start or resume the session
    session_start();
    
    //Check if the user is not logged in, redirect to the login page
    if (!isset($_SESSION['student_id'])) {
        header("Location: index.php");
        exit();
    }
    
    $currentDate = date("Y-m-d H:i:s"); 
    $studentId = $_SESSION['student_id'];; 
    
    $sql = "SELECT e.* 
            FROM event e
            LEFT JOIN attendee a ON e.event_id = a.event_id AND a.student_id = ?
            WHERE e.event_status='A' 
            AND e.event_startDate > ?
            AND a.attendee_id IS NULL
            ORDER BY e.event_startDate ASC";    
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $studentId, $currentDate);
    
    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Get the result
    $result = mysqli_stmt_get_result($stmt);
    
    // Check for errors
    if (!$result) {
        die('Error in SQL query: ' . mysqli_error($conn));
    }
    // Handle join event action
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['join_event'])) {
        $eventIdToJoin = $_POST['event_id_to_join'];

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
                // Redirect to avoid form resubmission
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            } else {
                $_SESSION['registration_status'] = 'failure';
            }

            // Close the statement
            mysqli_stmt_close($insertAttendee);
        }

        // Close the statement for checking joined status
        mysqli_stmt_close($checkJoined);
    }

    // Check and display the registration status prompt
    if (isset($_SESSION['registration_status'])) {
        switch ($_SESSION['registration_status']) {
            case 'success':
                echo '<script>alert("Registration Successful!");</script>';
                break;
            case 'failure':
                echo '<script>alert("Registration Failed. Please try again.");</script>';
                break;
            case 'already_joined':
                echo '<script>alert("You have already joined this event.");</script>';
                break;
        }
        // Unset the session variable
        unset($_SESSION['registration_status']);
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,  initial-scale=1.0">
        <title>Student - Event Board</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="image/png" href="/WebProject/src/icon.png">
	    <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300&display=swap">
    </head>
    <body>
        <div class="header-row">
            <div class="header-main">
                <img src="/WebProject/src/icon.png" alt="Website Logo">
                <h2>
                    <span>FKI</span>
                    <span>EVENT</span>
                    <span>MANAGEMENT</span>
                </h2>
                <table class="header-nav">
                    <tr>
                        <td><a href="eventboard.php" class="active">Event Board</a></td>
                        <td><a href="joined_event.php">Joined Event</a></td>
                        <td><a href="">Feedback</a></td>
                        <td><a href="signout.php">Sign Out</a></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="table-list">        
            <h1>Available Events</h1>
            <div class="eventboard-row">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    $numrow = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="event-board-div">';
                        echo '<table class="table-event-board">';
                        echo '<tr>';
                        echo '<th rowspan="6"><img src="uploads/poster/' . $row["event_poster"] . '" alt="Event Poster" class="event-poster"></th>';
                        echo '<td><h2>' . $row["event_name"] . '</h2></td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td>' . $row["event_posterDesc"] . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        $startDateFormat = date("d/m/Y", strtotime($row["event_startDate"]));
                        $endDateFormat = date("d/m/Y", strtotime($row["event_endDate"]));
                    
                        if ($startDateFormat == $endDateFormat) {
                            echo '<td>' . '<b>Date : </b>' . $startDateFormat . '</td>';
                        } else {
                            echo '<td>' . '<b>Date : </b>' . $startDateFormat . ' - ' . $endDateFormat . '</td>';
                        }
                        echo '</tr>';
                        echo '<tr>';    
                        $startTime12Hour = date("h:i A", strtotime($row["event_startTime"]));
                        $endTime12Hour = date("h:i A", strtotime($row["event_endTime"]));
                        echo '<td>' . '<b>Time : </b>' . $startTime12Hour . ' - ' . $endTime12Hour . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td>' . '<b>Venue : </b>' . $row["event_venue"] . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                            // Add a form for the "JOIN EVENT" button
                            echo '<form method="post" action="eventboard.php">';
                            echo '<input type="hidden" name="event_id_to_join" value="' . $row['event_id'] . '">';
                            echo '<td><button type="submit" name="join_event" id="joinbutton">JOIN</button></td>';
                            echo '</form>';
                        echo '</tr>';
                        echo '</table>';
                        echo '</div>';
                        $numrow++;
                    }
                } else {
                    echo '<tr><td colspan="6" class="no-event">There Are No Available Event Right Now</td></tr>';
                }
            
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </body>
</html>