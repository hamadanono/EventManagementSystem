<?php
    include('config.php');
	session_start();

    $sql = "SELECT * FROM event WHERE event_status = 'F'";
    $result = $conn->query($sql);

    if(!isset($_SESSION['pmfki_id'])){
		header("location: index.php");
		exit();
	}
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,  initial-scale=1.0">
        <title>Student - Event Board</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="image/png" href="/WebProject/src/icon.png">
	    <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300&display=swap">
    </head>
    <body>
        <div class="header-row">
            <div class="header-main">
                <img src="/WebProject/src/icon.png" alt="Website Logo">
                <h2>
                    <span>FKI</span>
                    <span>EVENT</span>
                    <span>MANAGEMENT</span>
                </h2>
                <table class="header-nav">
                    <tr>
                        <?php include ('navigation_pmfki.php') ?>
                    </tr>
                </table>
            </div>
        </div>

        <div class="table-list">        
            <h1>Events Report</h1>
            <div class="eventboard-row">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    $numrow = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="event-board-div">';
                        echo '<table class="table-event-board">';
                        echo '<tr>';
                        echo '<th rowspan="6"><img src="uploads/poster/' . $row["event_poster"] . '" alt="Event Poster" class="event-poster"></th>';
                        echo '<td><h2>' . $row["event_name"] . '</h2></td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td>' . $row["event_posterDesc"] . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        $startDateFormat = date("d/m/Y", strtotime($row["event_startDate"]));
                        $endDateFormat = date("d/m/Y", strtotime($row["event_endDate"]));
                    
                        if ($startDateFormat == $endDateFormat) {
                            echo '<td>' . '<b>Date : </b>' . $startDateFormat . '</td>';
                        } else {
                            echo '<td>' . '<b>Date : </b>' . $startDateFormat . ' - ' . $endDateFormat . '</td>';
                        }
                        echo '</tr>';
                        echo '<tr>';    
                        $startTime12Hour = date("h:i A", strtotime($row["event_startTime"]));
                        $endTime12Hour = date("h:i A", strtotime($row["event_endTime"]));
                        echo '<td>' . '<b>Time : </b>' . $startTime12Hour . ' - ' . $endTime12Hour . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td>' . '<b>Venue : </b>' . $row["event_venue"] . '</td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<td><button class="normal-btn" onclick="location.href=\'report_view.php?id='.$row["event_id"].'\'">View More</button></td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '</div>';
                        $numrow++;
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