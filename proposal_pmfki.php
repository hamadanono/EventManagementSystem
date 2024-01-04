<?php
include("config.php");

// Start or resume the session
session_start();

// Check if the user is not logged in, redirect to the login page
// if (!isset($_SESSION['pmfki_id'])) {
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

<?php include("navigation_pmfki.php"); ?>
<br>



<div style="padding:0 10px;">
    <div style="float: right; padding-bottom:10px;">
        <input type="button" value="Add New" onclick="show_AddEntry()">
    </div>
    <table border="1" width="100%" id="event-list-table">
        <tr>
        <thead>
        <th colspan="13">LIST OF PROPOSAL</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td width="2%">No</td>
            <td width="20%">Name</td>
            <td width="12%">Date</td>
            <td width="10%">Time</td>
            <td width="12%">Venue</td>
            <td width="5%">Status</td>
            <td width="10%">Remark</td>
            <td width="5%">Action</td>
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
                    echo '<td><button onclick="location.href=\'proposal_view.php?id=' . $row["event_id"] . '\'">View Details</button></td>';                    echo "</tr>" . "\n\t\t";
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

<div style="padding:0 10px; display: none;" id="addDiv">
    <br>
    <h3 align="center">Add Event Proposal</h3>
    <p align="center">Required field with mark*</p>

    <form method="POST" action="proposal_pmfki_action.php" enctype="multipart/form-data" id="myForm">
        <table border="1" id="myTable">
            <tr>
                <td>Event name*</td>
                <td width="1%">:</td>
                <td>
                    <textarea rows="2" name="name" cols="20" required></textarea>
                </td>
            </tr>
            <tr>
                <td>Synopsis</td>
                <td>:</td>
                <td>
                    <textarea rows="4" name="synopsis" cols="20"></textarea>
                </td>
            </tr>
            <tr>
                <td>Objective</td>
                <td>:</td>
                <td>
                    <textarea rows="4" name="objective" cols="20"></textarea>
                </td>
            </tr>
            <tr>
                <td>Impact</td>
                <td>:</td>
                <td>
                    <textarea rows="4" name="impact" cols="20"></textarea>
                </td>
            </tr>
            <tr>
                <td>Start Date</td>
                <td>:</td>
                <td>
                    <input type="date" name="startDate" placeholder="DD/MM/YYYY" >
                </td>
            </tr>
            <tr>
                <td>End Date</td>
                <td>:</td>
                <td>
                    <input type="date" name="endDate" placeholder="DD/MM/YYYY" >
                </td>
            </tr>
            <tr>
                <td>Start Time</td>
                <td>:</td>
                <td>
                    <input type="time" name="startTime" >
                </td>
            </tr>
            <tr>
                <td>End Time</td>
                <td>:</td>
                <td>
                    <input type="time" name="endTime" >
                </td>
            </tr>
            <tr>
                <td>Venue</td>
                <td>:</td>
                <td>
                    <textarea rows="2" name="venue" cols="20"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="right"> 
                <input type="reset" value="Reset" name="B2">
                <input type="submit" value="Submit" name="B1">                
                </td>
            </tr>
        </table>
    </form>
</div>

<script>
function show_AddEntry() {
    var x = document.getElementById("addDiv");
    x.style.display = "block";

    // Scroll page down
    x.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>
</body>
</html>
