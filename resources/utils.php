<?php
    function authHeader($title, $css, $icon){
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

    function getEventStatusLabel($status) {
        switch ($status) {
            case 'A': return 'ACTIVE';
            case 'C': return 'CLOSED';
            case 'F': return 'FINISHED';
            case 'P': return 'PENDING';
            default: return 'UNKNOWN';
        }
    }
?>