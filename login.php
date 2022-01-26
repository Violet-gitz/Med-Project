<?php
    session_start();
    include('Connect.php'); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าล็อคอิน</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="header">
        <h2>ล็อคอิน</h2>
    </div>

    <form action="login_db.php" method="post">
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <h3>
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <div class="input-group">
            <label for="username">ชื่อผู้ใช้</label>
            <input type="text" name="StaffName">
        </div>
        <div class="input-group">
            <label for="password">รหัสผ่าน</label>
            <input type="password" name="StaffPassword">
        </div>
        <div class="input-group">
            <button type="submit" name="login_user" class="btn">เข้าสู่ระบบ</button>
        </div>
        <p>สมัครสมาชิก <a href="register.php">Sign Up</a></p>
    </form>

</body>
</html>