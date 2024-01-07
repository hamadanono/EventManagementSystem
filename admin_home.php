<?php
    include('config.php');
	session_start();

    if(!isset($_SESSION['admin_id'])){
		header("location: index.php");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,  initial-scale=1.0">
        <title>EKI Event Management</title>
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
                    <td><a href="proposal_admin.php">Proposal</a></td>
                    <td><a href="">Proposal</a></td>
                    <td><a href="">Proposal</a></td>
                    <td><a href="signout.php">Sign Out</a></td>
                </tr>
            </table>
        </div>
    </div>
    </body>
</html>