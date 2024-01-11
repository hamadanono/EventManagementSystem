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

    // Retrieve joined events for the current student
    $sql = "SELECT e.*, a.attendee_id, a.attendance_status
            FROM event e
            JOIN attendee a ON e.event_id = a.event_id
            WHERE a.student_id = ?
            ORDER BY e.event_startDate ASC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $studentId);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Check for errors
    if (!$result) {
        die('Error in SQL query: ' . mysqli_error($conn));
    }
    // Check and display the registration status prompt
    if (isset($_SESSION['registration_status'])) {
        switch ($_SESSION['registration_status']) {
            case 'attendance_success':
                echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.getElementById("attendance_success_popup").style.display = "flex";
                        });
                    </script>';
                break;

            // Existing cases...

            case 'wrong_password':
                echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.getElementById("wrong_password_popup").style.display = "flex";
                        });
                    </script>';
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
        <title>Student - Joined Events</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="image/png" href="/WebProject/src/icon.png">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300&display=swap">
    </head>

    <body>
        <script src="script/script.js"></script>

        <div id="unjoin_confirmation_popup" class="popup-container">
            <div class="popup-content">
                <p>Are you sure you want to unjoin this event?</p>
                <input type="hidden" id="event_id_to_unjoin" value="">
                <button class="normal-btn" onclick="cancelUnjoin()">Cancel</button>
                <button class="normal-btn" onclick="confirmUnjoinAction()">Confirm</button>
            </div>
        </div>

        <div id="attendance_password_popup" class="popup-container">
            <div class="popup-content">
                <label for="event_password">Event Password:</label>
                <input type="password" id="event_password" name="event_password" required>
                <input type="hidden" id="event_id_for_attendance" name="event_id_for_attendance" value="">
                <button class="normal-btn" onclick="submitAttendancePassword()">Submit</button>
            </div>
        </div>

        <div id="attendance_success_popup" class="popup-container">
            <div class="popup-content">
                <p>You've successfully recorded your attendance.</p>
                <button class="normal-btn" onclick="closeAttendanceSuccessPopup()">Close</button>
            </div>
        </div>

        <div id="wrong_password_popup" class="popup-container">
            <div class="popup-content">
                <p>Wrong event password. Please try again.</p>
                <button class="normal-btn" onclick="closeWrongPasswordPopup()">Close</button>
            </div>
        </div>

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
        <div class="table-list">
            <h1>Joined Events</h1>
            <table border="1" width="100%" class="event-list-table">
                <tr>
                    <th width="2%">No.</th>
                    <th width="30%">Event Name</th>
                    <th width="15%">Event Date</th>
                    <th width="10%">Event Time</th>
                    <th width="15%">Event Venue</th>
                    <th width="25%">Action</th>
                </tr>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $numrow = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $numrow . "</td>";
                        echo "<td>" . $row["event_name"] . "</td>";
                        echo "<td>" . date("d/m/Y", strtotime($row["event_startDate"])) . " - " . date("d/m/Y", strtotime($row["event_endDate"])) . "</td>";
                        echo "<td>" . date("h:i A", strtotime($row["event_startTime"])) . " - " . date("h:i A", strtotime($row["event_endTime"])) . "</td>";
                        echo "<td>" . $row["event_venue"] . "</td>";
                        echo '<td>';
                        echo '<button class="normal-btn" onclick="confirmUnjoin(' . $row["event_id"] . ')">Unjoin</button>';
                        echo '<button class="normal-btn" onclick="recordAttendance(' . $row["event_id"] . ')">Attendance</button>';
                        echo '<button class="normal-btn" onclick="giveFeedback(' . $row["event_id"] . ')">Feedback</button>';
                        echo '</td>';
                        echo "</tr>";
                        $numrow++;
                    }
                } else {
                    echo '<tr><td colspan="6">You have not joined any events yet.</td></tr>';
                }
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </body>
</html>
