<?php
    include 'resources/utils.php';
    customHeader('User Selection', 'public/css/style.css', 'public/icon/icon.png');
?>
    <body>
        <div class="container-row">
            <img src="public/icon/icon.png" alt="Logo">
            <h2>FKI Event Management</h2>
            <div class="signin-box">
                <h1>Select User</h1>
                <table class="signin-table">
                    <tr>
                        <td><button onclick="location.href='/resources/auth/signin_student.php'">Student</button></td>
                    </tr>
                    <tr>
                        <td><button onclick="location.href='/resources/auth/signin_pmfki.php'">PMFKI</button></td>
                    </tr>
                    <tr>
                        <td><button onclick="location.href='/resources/auth/signin_admin.php'">Admin</button></td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
