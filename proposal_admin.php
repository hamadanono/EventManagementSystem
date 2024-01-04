<?php
include("config.php");

// Start or resume the session
session_start();

// Check if the user is not logged in, redirect to the login page
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: index.php");
//     exit();
// }

?>

<!DOCTYPE html>
<html>

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

<div class="header">
    <h1>Event Proposal</h1>
</div>

<?php include("navigation_admin.php"); ?>
<br>

<h2  align="center">List of Event Proposal</h2>

<div style="padding:0 10px;">
    <table border="1" width="100%" id="projectable">
        <tr>
            <th width="2%">No</th>
            <th width="20%">Name</th>
            <th width="12%">Date</th>
            <th width="10%">Time</th>
            <th width="12%">Venue</th>
            <th width="5%">Status</th>
            <th width="10%">Remark</th>
            <th width="5%">Action</th>
        </tr>
        <?php
            $sql = "SELECT * 
                    FROM event e";
                    
            $stmt = mysqli_prepare($conn, $sql);

            // Execute the statement
            mysqli_stmt_execute($stmt);

            // Get the result
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                $numrow=1;
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $numrow . "</td><td>". $row["event_name"] . "</td>";
                    $startDateFormat = date("d/m/Y", strtotime($row["event_startDate"]));
                    $endDateFormat = date("d/m/Y", strtotime($row["event_endDate"]));

                    if ($startDateFormat == $endDateFormat) {
                        // If start and end dates are the same, display only start date
                        echo '<td>' . $startDateFormat . '</td>';
                    } else {
                        // If start and end dates are different, display as "startDate - endDate"
                        echo '<td>' . $startDateFormat . ' - ' . $endDateFormat . '</td>';
                    }

                    // Display time in 12-hour format
                    $startTime12Hour = date("h:i A", strtotime($row["event_startTime"]));
                    $endTime12Hour = date("h:i A", strtotime($row["event_endTime"]));

                    echo '<td>' . $startTime12Hour . ' - ' . $endTime12Hour . '</td>';
                    echo '<td>' . $row["event_venue"] . '</td>';

                    $event_status = $row["event_status"];
                    if ($event_status == 'A' || $event_status == 'C') {
                        echo "<td>Approved</td>";
                    } else if ($event_status == 'P') {
                        echo "<td>Pending</td>";
                    } else if ($event_status == 'D') {
                        echo "<td>Declined</td>";
                    } else {
                        echo "<td>" . $row["event_status"] . "</td>";
                    }
                    
                    echo "<td>" . $row["event_adminRemark"] . "</td>";
                    echo '<td> <a href="proposal_admin_manage.php?id=' . $row["event_id"] . '">Manage</a>';
                    echo "</tr>" . "\n\t\t";
                    $numrow++;
                }
            } else {
                echo '<tr><td colspan="7">0 results</td></tr>';
            } 
            
            mysqli_close($conn);
        ?>
    </table>
</div>

<script>
</script>
</body>
</html>
