<?php
    function customHeader($title, $css, $icon){
        echo'
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width,  initial-scale=1.0">
                <title>' . $title . '</title>
                <link rel="stylesheet" href="' . $css . '">
                <link rel="icon" type="image/png" href="' . $icon . '">
                <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300&display=swap">
            </head>
        ';
    }

    function adminNavigation() {
        echo '
            <div class="header-row">
                <div class="header-main">
                    <img src="../../../public/icon/icon.png" alt="Website Logo">
                    <h2>
                        <span>FKI</span>
                        <span>EVENT</span>
                        <span>MANAGEMENT</span>
                    </h2>
                    <table class="header-nav">
                        <tr>';
                        
                        include '../../navigation/navigation_admin.php';
                        
                        echo '
                        </tr>
                    </table>
                </div>
            </div>

            <script src="../../../public/js/script.js"></script>
        ';
    }

    function studentNavigation(){
        echo '
            <div class="header-row">
                <div class="header-main">
                    <img src="../../../public/icon/icon.png" alt="Website Logo">
                    <h2>
                        <span>FKI</span>
                        <span>EVENT</span>
                        <span>MANAGEMENT</span>
                    </h2>
                    <table class="header-nav">
                        <tr>';
                            include '../../navigation/navigation_student.php';
                        echo '</tr>
                    </table>
                </div>
            </div>

            <script src="../../../public/js/script.js"></script>
        ';
    }

    function pmfkiNavigation(){
        echo '
            <div class="header-row">
            <div class="header-main">
                <img src="src/icon.png" alt="Website Logo">
                <h2>
                    <span>FKI</span>
                    <span>EVENT</span>
                    <span>MANAGEMENT</span>
                </h2>
                <table class="header-nav">
                    <tr>';
                        include 'navigation_pmfki.php';
                    echo'</tr>
                </table>
            </div>
        </div>

        <script src="../../../public/js/script.js"></script>
        ';
    }


    function popUp($location) {
        echo '
            <div id="popup_page_stay" class="popup-container">
                <div class="popup-content">
                    <p id="popup_message_stay"></p>
                    <button class="button" onclick="location.href=\'' . $location . '\'">Close</button>
                </div>
            </div>
        ';
    }

    function popUpSuccess($location){
        echo'
            <div id="popup" class="popup-container">
                <div class="popup-content">
                    <p id="popup_message"></p>
                    <div>
                        <button class="button" onclick="location.href=\'' . $location . '\'">Close</button>
                    </div>
                </div>
            </div>
        ';
    }

    function validateSession($sessionKey, $redirectUrl) {
        if (!isset($_SESSION[$sessionKey])) {
            header("Location: $redirectUrl");
            exit();
        }
    }

    function executeQuery($conn, $sql) {
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            echo "Error: " . $sql . " : " . mysqli_error($conn) . "<br>";
            return false;
        }
    }

    function displayTableEventStatus($event_status) {
        if ($event_status == 'A' || $event_status == 'C') {
            echo "<td class=\"status-active\">Approved</td>";
        } elseif ($event_status == 'P') {
            echo "<td class=\"status-pending\">Pending</td>";
        } elseif ($event_status == 'D') {
            echo "<td class=\"status-closed\">Declined</td>";
        } else {
            echo "<td>" . htmlspecialchars($event_status) . "</td>";
        }
    }

    function displayEventStatus($event_status) {
        if ($event_status == 'A' || $event_status == 'C') {
            echo "<p class='stat-active'>Approved </p>";
        } elseif ($event_status == 'P') {
            echo "<p class='stat-pending'>Pending </p>";
        } elseif ($event_status == 'D') {
            echo "<p class='stat-closed'>Declined </p>";
        } else {
            echo "";
        }
    }

    function getEventStatusLabel($status) {
        if ($status == 'A' || $status == 'C') {
            echo "Approved";
        } elseif ($status == 'P') {
            echo "Pending";
        } elseif ($status == 'D') {
            echo "Declined";
        } else {
            echo "";
        }
    }
