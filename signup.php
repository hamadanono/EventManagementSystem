<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,  initial-scale=1.0">
        <title>Sign Up</title>
        <link rel="icon" type="image/png" href="/IndividualProject/src/icon.png">
	    <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&family=Rubik:wght@300&display=swap">
    </head>

    <body>
        <div class="container-row">
            <div class="signup-box">
                <form action="signup.php" method="POST" enctype="multipart/form-data" id="signup-form"> 
                    <table width="100%" class="signup-table">
                        <h1>Sign Up</h1>
                        <tr>
                            <th>Full Name</th>
                            <td class="fill">:</td>
                            <td><textarea rows="1" id="student_name" required></textarea></td>
                        </tr>
                        <tr>
                            <th>Identity Card Number</th>
                            <td class="fill">:</td>
                            <td><textarea rows="1" id="student_ic" required></textarea></td>
                        </tr>
                        <tr>
                            <th>Matrics Number</th>
                            <td class="fill">:</td>
                            <td><textarea rows="1" id="student_id" required></textarea></td>
                        </tr>
                        <tr>
                            <th>E-mail</th>
                            <td class="fill">:</td>
                            <td><textarea rows="1" id="student_email" required></textarea></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td class="fill">:</td>
                            <td><textarea rows="1" id="student_phone" required></textarea></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td class="fill">:</td>
                            <td><textarea rows="4" id="student_address" required></textarea></td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td class="fill">:</td>
                            <td><textarea rows="1" id="student_pwd" required></textarea></td>
                        </tr>
                        <tr>
                            <th>Profile Picture</th>
                            <td class="fill">:</td>
                            <td><input type="file" name="student_profilePic" accept=".jpg, .jpeg, .png"></td>
                        </tr>
                    </table>
                    <br>
                    <button class="button" type="button" value="" onclick="location.href='signin.php'">Cancel</button>
                    <button class="button" type="submit">Sign Up</button>
                </form>
            </div>
        </div>

    </body>
</html>