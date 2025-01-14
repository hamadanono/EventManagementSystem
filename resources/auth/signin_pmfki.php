<?php
    include('../utils.php');
    customHeader('PMFKI Sign In', '../../public/css/style.css', '../../public/icon/icon.png');
?>

    <body>
        <script src="../../public/js/script.js"></script>

        <?php
            popUp('signin_pmfki.php');
        ?>

        <div class="container-row">
            <img src="../../public/icon//icon.png" alt="Logo">
            <h2>FKI Event Management</h2>
            <div class="signin-box">
                <h1>Sign In</h1>
                <p>< PMFKI ></p>
                <form action="signin_pmfki.php" method="POST">
                    <table class="signin-table">
                        <tr>
                            <th><label for="pmfki_id">PMFKI ID</label></th>
                        </tr>
                        <tr>
                            <td><input type="text" name="pmfki_id" required></td>
                        </tr>
                        <tr>
                            <th><label for="pmfki_pwd">Password</label></th>
                        </tr>
                        <tr>
                            <td><input type="password" name="pmfki_pwd" required></td>
                        </tr>
                    </table>
                    <div class="signin-button">
                        <button class="button" type="submit"> Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </body>

    <?php
        include ('../config.php');

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $pmfki_id = strtoupper(trim($_POST['pmfki_id']));
            $pmfki_pwd = trim($_POST['pmfki_pwd']);

            $sql = "SELECT * FROM pmfki WHERE pmfki_id='$pmfki_id'";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                if(password_verify($pmfki_pwd, $row['pmfki_pwd'])){
                    session_start();
                    $_SESSION['pmfki_id'] = $pmfki_id;
                    header("location: ../pmfki/proposal/proposal_pmfki.php");
                    exit();
                }
                else{
                    echo '<script>popup_page_stay("Username or Password is incorrect")</script>';
                } 
            }
            else{
                echo '<script>popup_page_stay("Username or Password is incorrect")</script>';
            } 
        }
        $conn -> close();
    ?>
</html>