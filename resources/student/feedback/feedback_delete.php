<?php
    include('../../config.php');
    include('../../utils.php');

    session_start();
    validateSession('student_id', '../../index.php');

    if (isset($_GET['id'])) {
        $feedback_id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT) : '';
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

   <body>
        <?php
            studentNavigation();
            popUpSuccess('feedback.php')
        ?>

        <div id="popup_form" class="popup-form">
            <div class="popup-content">
                <p>Are you sure you want to delete this feedback?</p>
                <form action="feedback_delete.php" method="POST">
                    <input type="text" id="feedback_id" name="feedback_id" value="<?= htmlspecialchars($feedback_id) ?>" hidden>
                    <button class="normal-btn" type="button" onclick="location.href='feedback.php'">Cancel</button>
                    <button class="decline-btn" type="submit" name="confirm">Confirm</button>
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
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $feedback_id = $_POST['feedback_id'];
            
            if(isset($_POST["confirm"])){
                $delsql = "DELETE FROM feedback WHERE feedback_id = '$feedback_id'";
                $result = mysqli_query($conn, $delsql);
                if (mysqli_query($conn, $sql) && $result) {
                    echo '<script>auto_popup_message("Feedback has been deleted");</script>';
                }
                else{
                    echo '<script>auto_popup_message("There was an error deleting you feedback");</script>';
                }
                
            }
        }
    ?>
</html>
