<?php
    include('../../config.php');
    include('../../utils.php');

    session_start();
    validateSession('admin_id', '../../index.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
        $event_id = $_POST['event_id'];

        $sql = "UPDATE event SET event_status = 'C', event_adminRemark = '', admin_id = '{$_SESSION["admin_id"]}' WHERE event_id = '$event_id'";
        $status = executeQuery($conn, $sql);

        if ($status) {
            echo "<script>alert('Proposal Approved Successfully!');</script>";
            echo "<script>window.location.href='proposal_admin_manage.php?id=$event_id';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to Approve Proposal!');</script>";
            echo "<script>window.location.href='proposal_admin_manage.php?id=$event_id';</script>";
        }
    }
