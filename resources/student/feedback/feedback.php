<?php
    include('../../config.php');
    include('../../utils.php');

    session_start();
    validateSession('student_id', '../../index.php');
    
    customHeader('Student Feedback', '../../../public/css/style.css', '../../../public/icon/icon.png');
?>

    <body>
        <?php
            studentNavigation();
        ?>
            
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
                    WHERE f.student_id= ?";
                    
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "s",$_SESSION["student_id"] );
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
</html>
