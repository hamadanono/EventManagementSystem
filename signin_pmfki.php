<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,  initial-scale=1.0">
        <title>Sign Up</title>
	    <link rel="stylesheet" href="css/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="container-row">
            <div class="signin-box">
                <form action="index.php" method="POST">
                    <table class="signin-table">
                        <h1>Sign In</h1>
                        <tr>
                            <th>Username</th>
                        </tr>
                        <tr>
                            <td><input type="text" name="student_id" required></td>
                        </tr>
                        <tr>
                            <th>Password</th>
                        </tr>
                        <tr>
                            <td><input type="password" name="student_pwd" required></td>
                        </tr>
                    </table>
                    <div>
                        <button class="button" type="submit"> Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <?php
        include ('config.php');

        

        $sql = "SELECT * FROM student WHERE student_id='$student_id'"
    ?>
</html>