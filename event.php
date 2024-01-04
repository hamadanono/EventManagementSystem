<?php
include("config.php");

// Start or resume the session
session_start();

// Check if the user is not logged in, redirect to the login page
// if (!isset($_SESSION['student_id'])) {
//     header("Location: index.php");
//     exit();
// }

// Use prepared statement to avoid SQL injection
$sql = "SELECT * FROM event WHERE event_status=? OR event_status=?";
$stmt = mysqli_prepare($conn, $sql);

// Check if preparation was successful
if ($stmt) {
    // Bind the parameters
    $event_status_A = 'A';
    $event_status_C = 'C';
    mysqli_stmt_bind_param($stmt, "ss", $event_status_A, $event_status_C);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Use $result as needed

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Handle the case where preparation failed
    echo "Error in preparing statement: " . mysqli_error($conn);
}



?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <header>
    <img class="banner" src="img/banner.png">
    </header>
</head>
<body>

<?php include("navigation_pmfki.php"); ?>

<br>

<div style="padding:0 10px;">
    <table border="1" width="100%" id="event-list-table">
    <thead>
    <tr>
        <th colspan="13">LIST OF EVENTS</th>
    </tr>
    </thead> 
    <tbody>
        <tr class="">
            <td width="1%">No</td>
            <td width="25%">Event Name</td>
            <td width="15%">Date</td>
            <td width="10%">Time</td>
            <td width="25%">Venue</td>
            <td width="10%">Status</td>
            <td width="10%">Action</td>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            $numrow = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $numrow . "</td><td>" . $row["event_name"] . "</td><td>";

                $startDateFormat = date("d/m/Y", strtotime($row["event_startDate"]));
                $endDateFormat = date("d/m/Y", strtotime($row["event_endDate"]));

                if ($startDateFormat == $endDateFormat) {
                    echo $startDateFormat;
                } else {
                    echo $startDateFormat . " - " . $endDateFormat;
                }

                echo "</td><td>" . date("h:i A", strtotime($row["event_startTime"])) . " - " . date("h:i A", strtotime($row["event_endTime"])) . "</td><td>" . $row["event_venue"] . "</td>";

                echo '<td class="';
    
                if ($row["event_status"] == 'A') {
                    echo 'status-active">ACTIVE';
                } elseif ($row["event_status"] == 'C') {
                    echo 'status-closed">CLOSED';
                }

                echo "</td>";              
                echo '<td> <button id="View-details-button" onclick="location.href=\'event_view.php?id=' . $row["event_id"] . '\'">View Details</button></td>';
                echo "</tr>" . "\n\t\t";
                $numrow++;
            }
        } else {
            echo '<tr><td colspan="7">0 results</td></tr>';
        }

        mysqli_close($conn);
        ?>
    </tbody>
    </table>
    
    
</div>    
<footer>
    <br><small><i> </i></small>
</footer>


</body>
</html>
