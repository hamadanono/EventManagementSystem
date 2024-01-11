<?PHP
session_start();
include('config.php');

//variables
$id="";
$event_id = "";
$rating = "";
$comment = "";

//this block is called when button Submit is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //values for add or edit
    $event_id = $_POST["event_name"];
    $rating = $_POST["rating"];
    $comment =  trim($_POST["comment"]);

    $sql = "INSERT INTO feedback (rating, comment, event_id, student_id) 
    VALUES ('" . $rating . "', '". $comment . "', '" . $event_id . "', $_SESSION['student_id'])"; /* change TEST to: , ".$_SESSION["student_id"]."*/

    $status = insertTo_DBTable($conn, $sql);
    if ($status) {
        // Display a popup message
        echo "<script>alert('Feedback Added Successfully!');</script>";
        // Redirect to the profile page after successful update
        echo "<script>window.location.href='feedback.php?id=$event_id';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to Add Feedback!');</script>";
        // Redirect to the profile page after unsuccessful update
        echo "<script>window.location.href='feedback.php?id=$event_id';</script>";
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
