<?php
    include('../utils.php');
    authHeader('Admin Sign In', '../../public/css/style.css', '../../public/icon/icon.png');
?>

<body>
    <script src="../../public/js/script.js"></script>
    
    <?php
        popUp('signin_admin.php');
    ?>
   
    <div class="container-row">
        <img src="../../public/icon/icon.png" alt="Logo">
        <h2>FKI Event Management</h2>
        <div class="signin-box">
            <h1>Sign In</h1>
            <p>< Admin ></p>
            <form action="signin_admin.php" method="POST">
                <table class="signin-table">
                    <tr>
                        <th><label for="admin_id">Admin ID</label></th>
                    </tr>
                    <tr>
                        <td><input type="text" name="admin_id" required></td>
                    </tr>
                    <tr>
                        <th><label for="pwd">Password</label></th>
                    </tr>
                    <tr>
                        <td><input type="password" name="pwd" required></td>
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
    include('../config.php');
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $admin_id = strtoupper(trim($_POST['admin_id']));
        $pwd = trim($_POST['pwd']);
        
        $sql = "SELECT * FROM fki_admin WHERE admin_id='$admin_id' AND pwd='$pwd'";
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) > 0){
            session_start();
            $_SESSION['admin_id'] = $admin_id;
            header("location: ../admin/proposal/proposal_admin.php");
            exit();
        }
        else{
            echo '<script>popup_page_stay("Username or Password is incorrect")</script>';
        } 
    }
    $conn -> close();
?>
</html>
