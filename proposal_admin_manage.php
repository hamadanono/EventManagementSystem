<?php
include("config.php");

// Start or resume the session
session_start();

// Check if the user is not logged in, redirect to the login page
// if (!isset($_SESSION['admin_id'])) {
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

<div class="header">
    <h1>Event Proposal</h1>
</div>

<?php include("navigation_admin.php"); ?>
<br>

<h2  align="center">Proposal Details</h2>

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
            $event_startDate = $row["event_startDate"];
            $event_endDate = $row["event_endDate"];
            $event_startTime = $row["event_startTime"];
            $event_endTime = $row["event_endTime"];
            $event_venue = $row["event_venue"];
            $event_status = $row["event_status"];
            $event_adminRemark = $row["event_adminRemark"];
            $admin_name = $row["name"];
            $pmfki_name = $row["pmfki_name"];
        }
    }
?>

<main>
<div style="padding:0 10px;" id="addDiv">
    <div>
        <form action="proposal_status.php" method="post">
            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
            <br>
            <table border="1" width="100%" id="myTable" >
            <tr>
                <td width="18%x">Event Name</td>
                <td width="1%">:</td>
                <td><?php echo $event_name; ?></td>
            </tr>
            <tr>
                <td>Synopsis</td>
                <td>:</td>
                <td><?php echo $event_synopsis; ?></td>
            </tr>
            <tr>
                <td>Objective</td>
                <td>:</td>
                <td><?php echo $event_objective; ?></td>
            </tr>
            <tr>
                <td>Impact</td>
                <td>:</td>
                <td><?php echo $event_impact; ?></td>
            </tr>
            <tr>
            <td>Date</td>
            <td>:</td>
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
                <td>Time</td>
                <td>:</td>
                <td>
                    <?php
                    $formattedStartTime = date("h:i A", strtotime($event_startTime));
                    $formattedEndTime = date("h:i A", strtotime($event_endTime));

                    echo $formattedStartTime . " - " . $formattedEndTime;
                    ?>
                </td>
            </tr>
            <tr>
                <td>Venue</td>
                <td>:</td>
                <td><?php echo $event_venue; ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td>
                    <?php
                        if ($event_status == 'A' || $event_status == 'C') {
                            echo "Approved";
                        } else if ($event_status == 'P') {
                            echo "Pending";
                        } else if ($event_status == 'D') {
                            echo "Declined";
                        } else {
                            echo "";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Remark</td>
                <td>:</td>
                <td><?php echo $event_adminRemark; ?></td>
            </tr>
            <tr>
                <td>Submitted By</td>
                <td>:</td>
                <td><?php echo $pmfki_name; ?></td>
            </tr>
            <tr>
                <td>Approved/ Declined By</td>
                <td>:</td>
                <td><?php echo $admin_name; ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <button type="submit" name="approve" onclick="return confirm('Approve the proposal?')">Approve</button>
                    <button type="button" onclick="window.location.href = 'proposal_status_decline.php?id=<?php echo $event_id; ?>'">Decline</button>
                    <input type="button" name="back" value="Back" onclick="location.href='proposal_admin.php'">  
                </td>
            </tr>
            </table>
        </form>
    </div>
</div>
</main>

<footer>
    <br><small><i> </i></small>
</footer>
</body>

</html>
