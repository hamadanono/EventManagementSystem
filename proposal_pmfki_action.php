<?PHP
session_start();
include('config.php');

//variables
$action="";
$id="";
$name =" ";
$startDate = "";
$endDate = "";
$startTime =" ";
$endTime =" ";
$venue = "";
$synopsis = "";
$objective =" ";
$impact =" ";

//this block is called when button Submit is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //values for add or edit
    $name = trim($_POST["name"]);
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $venue =  trim($_POST["venue"]);
    $synopsis = trim($_POST["synopsis"]);
    $objective = trim($_POST["objective"]);
    $impact = trim($_POST["impact"]);

    $sql = "INSERT INTO event (event_name, event_synopsis, event_objective, event_impact,
    event_startDate, event_endDate, event_startTime, event_endTime, event_venue, event_status) /*, pmfki_id*/
    VALUES ('" . $name . "', '". $synopsis . "', '" . $objective . "','" . $impact . "', '" . $startDate . "
    ', '". $endDate . "', '" . $startTime . "','" . $endTime . "', '" . $venue . "', 'P')"; /*, ".$_SESSION["pmfki_id"]."*/

    $status = insertTo_DBTable($conn, $sql);
    if ($status) {
        // Display a popup message
        echo "<script>alert('Proposal Added Successfully!');</script>";
        // Redirect to the profile page after successful update
        echo "<script>window.location.href='proposal_pmfki.php?id=$event_id';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to Add Proposal!');</script>";
        // Redirect to the profile page after unsuccessful update
        echo "<script>window.location.href='proposal_pmfki.php?id=$event_id';</script>";
    } 
}

//close db connection
mysqli_close($conn);

//Function to insert data to database table
function insertTo_DBTable($conn, $sql){
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo "Error: " . $sql . " : " . mysqli_error($conn) . "<br>";
        return false;
    }
}
?>
