<?php
    include("config.php");
    
    // Start or resume the session
    session_start();
    
    // Check if the user is not logged in, redirect to the login page
    // if (!isset($_SESSION['student_id'])) {
    //     header("Location: index.php");
    //     exit();
    // }
    
    $currentDate = date("Y-m-d H:i:s"); 
    $studentId = "TEST"; 
    
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
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,  initial-scale=1.0">
        <title>FKI Event Management</title>
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
                        <td><a href="proposal_admin.php" class="active">Event Board</a></td>
                        <td><a href="">Joined Event</a></td>
                        <td><a href="">Feedback</a></td>
                        <td><a href="signout.php">Sign Out</a></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class = "eventboard-row">
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
                        echo '<td>' . $row["event_synopsis"] . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        $startDateFormat = date("d/m/Y", strtotime($row["event_startDate"]));
                        $endDateFormat = date("d/m/Y", strtotime($row["event_endDate"]));
                    
                        if ($startDateFormat == $endDateFormat) {
                            // If start and end dates are the same, display only start date
                            echo '<td>' .'<b>Date : </b>'. $startDateFormat . '</td>';
                        } else {
                            // If start and end dates are different, display as "startDate - endDate"
                            echo '<td>' . '<b>Date : </b>'.$startDateFormat . ' - ' . $endDateFormat . '</td>';
                        }
                        echo '</tr>';
                        echo '<tr>';
                        // Display time in 12-hour format
                        $startTime12Hour = date("h:i A", strtotime($row["event_startTime"]));
                        $endTime12Hour = date("h:i A", strtotime($row["event_endTime"]));
                        echo '<td>' . '<b>Time : </b>'.$startTime12Hour . ' - ' . $endTime12Hour . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td>' .'<b>Venue : </b>'. $row["event_venue"] . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td><button type="button" id="joinbutton" onclick="location.href=\'joinevent_action.php?id=' . $row["event_id"] . '\'">JOIN</button></td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '</div>';
                        $numrow++;
                    }
                } else {
                    echo '<tr><td colspan="6">0 results</td></tr>';
                }
            
                mysqli_close($conn);
            ?>
        </div>    
    </body>
</html>
