<?php
include("config.php");
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,  initial-scale=1.0">
        <title>Student - Feedback List</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="image/png" href="src/icon.png">
	    <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300&display=swap">
    </head>
    <body>

    <div class="header-row">
            <div class="header-main">
                <img src="src/icon.png" alt="Website Logo">
                <h2>
                    <span>FKI</span>
                    <span>EVENT</span>
                    <span>MANAGEMENT</span>
                </h2>
                <table class="header-nav">
                    <tr>
                        <?php include ('navigation_student.php') ?>
                    </tr>
                </table>
            </div>
        </div>

<h2  align="center">My Feedback</h2>

<div style="padding:0 10px;">
    <div style="float: right; padding-bottom:10px;">
        <input type="button" value="Add Feedback" onclick="show_AddEntry()">
    </div>
    <table border="1" width="100%" id="projectable">
        <tr>
            <th width="2%">No</th>
            <th width="20%">Attended Event Name</th>
            <th width="5%">Rating</th>
            <th width="10%">Comment</th>
        </tr>
        <?php
            $sql = "SELECT f.*, e.event_name
                    FROM feedback f
                    LEFT JOIN event e ON f.event_id = e.event_id
                    WHERE f.student_id=". $_SESSION["student_id"]; //WHERE student_id=". $_SESSION["student_id"];
                    
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $numrow=1;
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $numrow . "</td><td>". $row["event_name"] . "</td>";
                    echo "<td>" . $row["rating"] . "/5</td>";
                    echo "<td>" . $row["comment"] . "</td>";
                    echo "</tr>" . "\n\t\t";
                    $numrow++;
                }
            } else {
                echo '<tr><td colspan="7">0 results</td></tr>';
            } 
        ?>
    </table>
</div>

<div style="padding:0 10px; display: none;" id="addDiv">
    <br>
    <h3 align="center">Add Feedback</h3>
    <p align="center">Required field with mark*</p>

    <form method="POST" action="feedback_action.php" enctype="multipart/form-data" id="myForm">
        <table border="1" id="myTable">
            <tr>
                <td width="30%">Attended Event Name*</td>
                <td width="1%">:</td>
                <td>
                    <select size="1" name="event_name" required>
                        <?php
                            // Fetch event names based on the attendee table attendee_status 'A' without feedback
                            $sql = "SELECT e.event_id, e.event_name
                                    FROM event e
                                    JOIN attendee a ON e.event_id = a.event_id
                                    WHERE a.student_id = ? AND a.attendance_status = 'A' AND e.event_status = 'A'
                                    AND NOT EXISTS 
                                    (SELECT 1 FROM feedback f 
                                    WHERE f.event_id = e.event_id AND f.student_id = ?)";
                            //WHERE a.student_id = ". $_SESSION["student_id"...];
                            //WHERE ... f.student_id = ". $_SESSION["student_id"];
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);

                            if (mysqli_num_rows($result) > 0) {
                                echo '<option value="">&nbsp;</option>';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row["event_id"] . '">' . $row["event_name"] . '</option>';
                                }
                            } else {
                                echo '<option value="">Nothing to be reviewed yet</option>';
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
			<td>Rating*</td>
                <td>:</td>
                <td>
                    <input type="radio" name="rating" value="1" required>
                    <input type="radio" name="rating" value="2" required>
                    <input type="radio" name="rating" value="3" required>
                    <input type="radio" name="rating" value="4" required>
                    <input type="radio" name="rating" value="5" required>
                </td>
            </tr>
            <tr>
                <td>Comment</td>
                <td>:</td>
                <td>
                    <textarea rows="4" name="comment" cols="20"></textarea>
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
