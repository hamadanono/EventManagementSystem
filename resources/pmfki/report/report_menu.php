<?php
    include '../../config.php';
    include '../../utils.php';

    session_start();
    validateSession('pmfki_id', '../../index.php');

    $sql = "SELECT * FROM event WHERE event_status = 'F'";
    $result = $conn->query($sql);

    customHeader('PMFKI Report', '../../../public/css/style.css', '../../../public/icon/icon.png');
?>

    <body>
        <?php
            pmfkiNavigation();
        ?>

        <div class="table-list">        
        <h1>Events Report</h1>
        <div class="eventboard-row">

        <?php
            if (mysqli_num_rows($result) > 0) {
                // Output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    // Format date
                    $startDateFormat = date("d/m/Y", strtotime($row["event_startDate"]));
                    $endDateFormat = date("d/m/Y", strtotime($row["event_endDate"]));

                    // Format time
                    $startTime12Hour = date("h:i A", strtotime($row["event_startTime"]));
                    $endTime12Hour = date("h:i A", strtotime($row["event_endTime"]));

                    echo '<div class="card">';
                    echo '<div class="image">';
                    echo '<img src="../../../public/storage/profile/' . $row["event_poster"] . '" alt="Event Poster" class="image-content">';
                    echo '</div>';
                    echo '<div class="details">';
                    echo '<div class="rowtitle">' . $row["event_name"] . '</div>';
                    echo '<div class="row scrollable">' . $row["event_posterDesc"] . '</div>';
                    echo '<div class="row">';
                    echo '<div class="column"><strong>Date</strong></div>';
                    echo '<div class="column">:</div>';
                    echo '<div class="column">' . $startDateFormat . ' - ' . $endDateFormat . '</div>';
                    echo '</div>';
                    
                    echo '<div class="row">';
                    echo '<div class="column"><strong>Time</strong></div>';
                    echo '<div class="column">:</div>';
                    echo '<div class="column">' . $startTime12Hour . ' - ' . $endTime12Hour . '</div>';
                    echo '</div>';
                    
                    echo '<div class="row">';
                    echo '<div class="column"><strong>Venue</strong></div>';
                    echo '<div class="column">:</div>';
                    echo '<div class="column">' . $row["event_venue"] . '</div>';
                    echo '</div>';
                    echo '<div class="row">';
                    echo '<td>';
                    echo '<button class="normal-btn-report" onclick="location.href=\'report_view.php?id='.$row["event_id"].'\'">View More</button>';
                    echo '</td>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                    } else {
                        echo '<p class="no-event">There Are No Available Event Report For Now</p>';
                    }
                
                    mysqli_close($conn);
        ?>
            </div>
        </div>
    </body>
</html>
