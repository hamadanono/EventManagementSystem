<?php
    include('../../config.php');
    include('../../utils.php');

    session_start();
    validateSession('student_id', '../../index.php');

    if (isset($_GET['id'])) {
        $feedback_id = $_GET['id'];
        $sql = "SELECT f.*, e.event_name FROM feedback f
                JOIN event e ON f.event_id = e.event_id
                WHERE f.feedback_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $_GET["id"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $ret_event_name = $row["event_name"];
            $ret_rating = $row["rating"];
            $ret_comment = $row["comment"];
        }
    }

    customHeader('Student Feedback', '../../../public/css/style.css', '../../../public/icon/icon.png');
?>

    <body onload="auto_open_popup('popup_form')">
        <?php
            studentNavigation();
            popUpSuccess('feedback.php')
        ?>

        <div id="popup_form" class="popup-form">
            <div class="popup-content">
                <form action="feedback_edit.php" method="POST">
                <input type="text" id="feedback_id" name="feedback_id" value="<?= htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8') ?>" hidden>
                    <h2>Update Feedback</h2>
                    <table class="popup_table">
                        <tr>
                            <th>Event Name</th>
                            <td class="fill">:</td>
                            <td><?php echo htmlspecialchars($ret_event_name, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <th>Rating</th>
                            <td class="fill">:</td>
                            <td>
                                <input type="radio" name="rating" value="1" 
                                    <?php if ($ret_rating == 1) { echo "checked"; } ?>>1
                                <input type="radio" name="rating" value="2" 
                                    <?php if ($ret_rating == 2) { echo "checked"; } ?>>2
                                <input type="radio" name="rating" value="3" 
                                    <?php if ($ret_rating == 3) { echo "checked"; } ?>>3
                                <input type="radio" name="rating" value="4" 
                                    <?php if ($ret_rating == 4) { echo "checked"; } ?>>4
                                <input type="radio" name="rating" value="5" 
                                    <?php if ($ret_rating == 5) { echo "checked"; } ?>>5
                            </td>
                        </tr>
                        <tr>
                            <th>Comment</th>
                            <td class="fill">:</td>
                            <td><textarea rows="6" name="comment"><?php echo"$ret_comment"?></textarea></td>
                        </tr>
                    </table>
                    <br>
                    <button class="normal-btn" type="button" value="" onclick="location.href='feedback.php'">Back</button>
                    <button class="accept-btn" type="submit" name="confirm">Confirm</button>
                </form>
            </div>
        </div>
            
        <div class="table-list">
            <h1>My Feedback</h1>
            <table border="1" width="100%" class="event-list-table">
                <tr>
                    <th width="2%">No</th>
                    <th width="10%">Attended Event Name</th>
                    <th width="1%">Rating</th>
                    <th width="10%">Comment</th>
                    <th width="5%">Action</th>
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
                            $feedback_id = $row["feedback_id"];
                            echo "<tr>";
                            echo "<td>" . $numrow . "</td><td>". $row["event_name"] . "</td>";
                            echo "<td>" . $row["rating"] . "/5</td>";
                            echo "<td>" . $row["comment"] . "</td>";
                            echo '<td>';
                            echo '<button class="accept-btn" onclick="location.href=\'feedback_edit.php?id=' . $row["feedback_id"] . '\'">Update</button>';
                            echo '<button class="decline-btn" onclick="location.href=\'feedback_delete.php?id=' . $row["feedback_id"] . '\'">Delete</button>';
                            echo '</td>';
                            echo "</tr>" . "\n\t\t";
                            $numrow++;
                        }
                    } else {
                        echo '<tr><td colspan="7">0 results</td></tr>';
                    }
                ?>
            </table>
        </div>
    </body>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $student_id = $_SESSION["student_id"];
            $feedback_id = isset($_POST['feedback_id']) ? $_POST['feedback_id'] : '';
            $rating = isset($_POST["rating"]) ? trim($_POST["rating"]) : '';
            $comment = isset($_POST["comment"]) ? trim($_POST["comment"]) : '';

            if (!empty($rating) && !empty($comment)) {
                // Sanitize user inputs
                $rating = filter_var($rating, FILTER_SANITIZE_NUMBER_INT);
                $comment = filter_var($comment, FILTER_SANITIZE_STRING);

                if (isset($_POST["confirm"])) {
                    // Use prepared statements to update the database
                    $sql = "UPDATE feedback SET rating = ?, comment = ? WHERE feedback_id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "isi", $rating, $comment, $feedback_id);
                    
                    $status = executeQuery($conn, $sql);
                    if ($status) {
                        echo '<script>auto_popup_message("Feedback has been updated");</script>';
                    } else {
                        echo '<script>auto_popup_message("There was an error updating your feedback");</script>';
                    }

                    mysqli_stmt_close($stmt);
                }
            } else {
                echo '<script>auto_popup_message("Please fill in all required fields.");</script>';
            }
        }
    ?>
</html>