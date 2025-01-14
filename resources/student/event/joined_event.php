<?php
    include('../../config.php');
    include('../../utils.php');

    session_start();
    validateSession('student_id', '../../index.php');


    session_start();
    validateSession('student_id', 'index.php');

    $studentId = $_SESSION['student_id'];

    $sql = "SELECT e.*, a.attendee_id, a.attendance_status
            FROM event e
            JOIN attendee a ON e.event_id = a.event_id
            WHERE a.student_id = ? 
                AND a.attendance_status != 'A'
                AND e.event_status = 'A'
                AND CONCAT(e.event_endDate, ' ', e.event_endTime) > NOW()
            ORDER BY e.event_startDate ASC";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $studentId);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        die('Error in SQL query: ' . mysqli_error($conn));
    }

    if (isset($_SESSION['registration_status'])) {
        switch ($_SESSION['registration_status']) {
            case 'attendance_success':
                echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.getElementById("attendance_success_popup").style.display = "flex";
                        });
                    </script>';
                break;

            case 'wrong_password':
                echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.getElementById("wrong_password_popup").style.display = "flex";
                        });
                    </script>';
                break;
        }
        unset($_SESSION['registration_status']);
    }

    $pastEventsSql = "SELECT e.*, a.attendee_id, a.attendance_status
            FROM event e
            JOIN attendee a ON e.event_id = a.event_id
            WHERE a.student_id = ? AND a.attendance_status = 'A'
            ORDER BY e.event_startDate ASC";

    $pastEventsStmt = mysqli_prepare($conn, $pastEventsSql);
    mysqli_stmt_bind_param($pastEventsStmt, "s", $studentId);

    mysqli_stmt_execute($pastEventsStmt);

    $pastEventsResult = mysqli_stmt_get_result($pastEventsStmt);

    if (!$pastEventsResult) {
        die('Error in SQL query: ' . mysqli_error($conn));
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['give_feedback'])) {
        $event_id_to_feedback = $_POST['event_id_to_feedback'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('feedback_popup').style.display = 'flex';
                });
            </script>";
    }

    function isFeedbackSubmitted($conn, $event_id, $student_id) {
        $sql = "SELECT * FROM feedback WHERE event_id = '$event_id' AND student_id = '$student_id'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return true;
        }

        return false; 
    }

    function isEventFinished($eventStatus) {
        return $eventStatus === 'F';
    }

    customHeader('Student Event', '../../../public/css/style.css', '../../../public/icon/icon.png');
?>

    <body>
        <?php
            studentNavigation();
            popUp('student_profile.php')
        ?>
        <div id="unjoin_confirmation_popup" class="popup-container">
            <div class="popup-content">
                <p>Are you sure you want to withdraw from this event?</p>
                <input type="hidden" id="event_id_to_unjoin" value="">
                <button class="normal-btn" onclick="cancelUnjoin()">Cancel</button>
                <button class="normal-btn" onclick="confirmUnjoinAction()">Confirm</button>
            </div>
        </div>

        <div id="attendance_password_popup" class="popup-container">
            <div class="popup-content">
                <p>Event Password:</p>
                <input type="password" id="event_password" name="event_password" placeholder="Event Pass"required>
                <br><br>
                <input type="hidden" id="event_id_for_attendance" name="event_id_for_attendance" value="">
                <button class="normal-btn" onclick="cancelAttendancePassword()">Cancel</button>
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

        <div id="feedback_popup" class="popup-container">
            <div class="popup-content">
                <form method="POST" action="feedback_action.php">
                    <h2 id="event_name_in_feedback"></h2>
                    <input type="hidden" name="event_id_to_feedback" id="event_id_to_feedback" value="">
                    <p>Rating:</p>
                    <input type="radio" name="rating" value="1" required>
                    <input type="radio" name="rating" value="2" required>
                    <input type="radio" name="rating" value="3" required>
                    <input type="radio" name="rating" value="4" required>
                    <input type="radio" name="rating" value="5" required>
                    <br><br>
                    <p>Comment:</p>
                    <textarea rows="8" name="comment" cols="50"></textarea>
                    <br><br>
                    <button class="normal-btn" onclick="cancelFeedback()">Cancel</button>
                    <button class="normal-btn" type="submit">Submit</button>
                </form>
            </div>
        </div>

        <div class="table-list">
            <h1>Future Events</h1>
            <table border="1" width="100%" class="event-list-table">
                <tr>
                    <th width="2%">No.</th>
                    <th width="30%">Event Name</th>
                    <th width="12%">Event Date</th>
                    <th width="12%">Event Time</th>
                    <th width="10%">Event Venue</th>
                    <th width="20%">Action</th>
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
                        echo "<td>";
                        echo "<button class='joined-event-btn' onclick='confirmUnjoin(" . $row["event_id"] . ")'>Withdraw</button>";
                        
                        if (!empty($row["event_pwd"])) {
                            echo "<button class='joined-event-btn' onclick='recordAttendance(" . $row["event_id"] . ")'>Check-In</button>";
                        } else {
                            echo "<button class='disabled-joined-event-btn' disabled>Check-In</button>";
                        }
                        
                        echo "</td>";
                        
                        echo "</tr>";
                        $numrow++;
                    }
                } else {
                    echo '<tr><td colspan="6">You have no upcoming future events.</td></tr>';
                }
                ?>
            </table>
        </div>

        <div class="table-list">
            <br>
            <h1>Attended Events</h1>
            <table border="1" width="100%" class="event-list-table">
                <tr>
                    <th width="2%">No.</th>
                    <th width="30%">Event Name</th>
                    <th width="15%">Event Date</th>
                    <th width="15%">Event Time</th>
                    <th width="15%">Event Venue</th>
                    <th width="15%">Feedback</th>
                </tr>
                <?php
                    if (mysqli_num_rows($pastEventsResult) > 0) {
                        $numrow = 1;
                        while ($row = mysqli_fetch_assoc($pastEventsResult)) {
                            echo "<tr>";
                            echo "<td>" . $numrow . "</td>";
                            echo "<td>" . $row["event_name"] . "</td>";
                            echo "<td>" . date("d/m/Y", strtotime($row["event_startDate"])) . " - " . date("d/m/Y", strtotime($row["event_endDate"])) . "</td>";
                            echo "<td>" . date("h:i A", strtotime($row["event_startTime"])) . " - " . date("h:i A", strtotime($row["event_endTime"])) . "</td>";
                            echo "<td>" . $row["event_venue"] . "</td>";
                            echo "<td>";
                                
                            $event_id = $row["event_id"];
                            $isFeedbackSubmitted = isFeedbackSubmitted($conn, $event_id, $studentId);
                            
                            $isEventFinished = isEventFinished($row["event_status"]);
                        
                            if ($isFeedbackSubmitted) {
                                echo "<button class='disabled-joined-event-btn' disabled>Submitted</button>";
                            } elseif (!$isFeedbackSubmitted && $isEventFinished) {
                                echo "<button class='disabled-joined-event-btn' disabled>Closed</button>";
                            } else {
                                echo "<button class='joined-event-btn' onclick='showFeedbackPopup(" . $event_id . ", \"" . $row["event_name"] . "\")'>Give Feedback</button>";
                            }
                        
                            echo "</td>";
                            echo "</tr>";
                            $numrow++;
                        }
                    } else {
                        echo "<tr><td colspan='6'>You have no attended event record.</td></tr>";
                    }
                    mysqli_close($conn);
                ?>
            </table>
        </div>
    </body>
</html>
