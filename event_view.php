<?php
include("config.php");

// Start or resume the session
session_start();

// Check if the user is not logged in, redirect to the login page
// if (!isset($_SESSION['student_id'])) {
//     header("Location: index.php");
//     exit();
// }



?>

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

<?php include("navigation_pmfki.php"); ?>

<h2>View Event Details</h2>

<?php
    

    if(isset($_GET["id"]) && $_GET["id"] != ""){
        $sql = "SELECT e.*, p.pmfki_name, a.name
        FROM event e
        LEFT JOIN pmfki p ON e.pmfki_id = p.pmfki_id
        LEFT JOIN fki_admin a ON e.admin_id = a.admin_id
        WHERE e.event_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $_GET["id"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $event_id = $row["event_id"];
            $event_name = $row["event_name"];
            $event_synopsis = $row["event_synopsis"];
            $event_objective = $row["event_objective"];
            $event_impact = $row["event_impact"];
            $event_posterDesc = $row["event_posterDesc"];
            $event_startDate = $row["event_startDate"];
            $event_endDate = $row["event_endDate"];
            $event_startTime = $row["event_startTime"];
            $event_endTime = $row["event_endTime"];
            $event_venue = $row["event_venue"];
            $event_poster = $row["event_poster"];
            $event_pwd = $row["event_pwd"];
            $event_status = $row["event_status"];
            $admin_name = $row["name"];
            $pmfki_name = $row["pmfki_name"];
        }
       
    }

?>

<main>
<div class="row">
            <div class="col-left"> 
                <br>
                <img src="uploads/poster/<?php echo $event_poster; ?>" alt="poster img" class="view-event-poster">
            </div>

            <br><br>
            <div class="col-right"> 
                <br>
            <table class="update-event-table" >
            <tr>
                <th>Event Name</th>
                <td><b>:</b></td>
                <td><?php echo $event_name; ?></td>
            </tr>
            <tbody>
            <tr>
                <th>Synopsis</th>
                <td><b>:</b></td>
                <td><?php echo $event_synopsis; ?></td>
            </tr>
            <tr>
                <th>Objective</th>
                <td><b>:</b></td>
                <td><?php echo $event_objective; ?></td>
            </tr>
            <tr>
                <th>Impact</th>
                <td><b>:</b></td>
                <td><?php echo $event_impact; ?></td>
            </tr>
            <tr>
                <th>Poster Description</th>
                <td><b>:</b></td>
                <td><?php echo $event_posterDesc; ?></td>
            </tr>
            <tr>
            <th>Date</th>
            <td><b>:</b></td>
            <td>
                <?php
                $formattedStartDate = date("d/m/Y", strtotime($event_startDate));
                $formattedEndDate = date("d/m/Y", strtotime($event_endDate));

                if ($formattedStartDate == $formattedEndDate) {
                    echo $formattedStartDate;
                } else {
                    echo $formattedStartDate . " - " . $formattedEndDate;
                }
                ?>
            </td>
            </tr>
            <tr>
                <th>Time</th>
                <td><b>:</b></td>
                <td>
                    <?php
                    $formattedStartTime = date("h:i A", strtotime($event_startTime));
                    $formattedEndTime = date("h:i A", strtotime($event_endTime));

                    echo $formattedStartTime . " - " . $formattedEndTime;
                    ?>
                </td>
            </tr>
            <tr>
                <th>Venue</th>
                <td><b>:</b></td>
                <td><?php echo $event_venue; ?></td>
            </tr>
            <tr>
                <th>Event Password</th>
                <td><b>:</b></td>
                <td><?php echo $event_pwd; ?></td>
            </tr>
            <tr>
                <th>Event status</th>
                <td><b>:</b></td>
                <td>
                    <?php
                    // Assuming $event_status contains the status (A or C)
                    if ($event_status == 'A') {
                        echo 'ACTIVE';
                    } elseif ($event_status == 'C') {
                        echo 'CLOSED';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th>Submitted By</th>
                <td><b>:</b></td>
                <td><?php echo $pmfki_name; ?></td>
            </tr>
            <tr>
                <th>Approved By</th>
                <td><b>:</b></td>
                <td><?php echo $admin_name; ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <button id="update-button" onclick="window.location.href='event_update.php?id=<?php echo $event_id; ?>'">Update</button> 
                    <button type="button" id="delete-button" onclick="if(confirm('Delete the event?')) { window.location.href = 'event_delete.php?id=<?php echo $event_id; ?>'; }">Delete</button>
                </td>
            </tr>
            </tbody>
            </table>
			</div>
            </div>
</div>
</main>

<footer>
    <br><small><i> </i></small>
</footer>
</body>

</html>
