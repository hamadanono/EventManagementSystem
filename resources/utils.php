<?php
    function validateSession($sessionKey, $redirectUrl) {
        if (!isset($_SESSION[$sessionKey])) {
            header("Location: $redirectUrl");
            exit();
        }
    }

    function getEventStatusLabel($status) {
        switch ($status) {
            case 'A':
                return 'ACTIVE';
            case 'C':
                return 'CLOSED';
            case 'F':
                return 'FINISHED';
            case 'P':
                return 'PENDING';
            default:
                return 'UNKNOWN';
        }
    }
?>