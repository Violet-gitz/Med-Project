<?php 
    session_start();
    include('Connect.php');

    $errors = array();

    if (isset($_POST['login_user'])) {
        $username = mysqli_real_escape_string($conn, $_POST['StaffName']);
        $password = mysqli_real_escape_string($conn, $_POST['StaffPassword']);

        if (empty($username)) {
            array_push($errors, "Username is required");
        }

        if (empty($password)) {
            array_push($errors, "Password is required");
        }

        if (count($errors) == 0) {
            //$password = md5($password_1);
            $query = "SELECT * FROM tbl_staff WHERE StaffName = '$username' AND StaffPassword = '$password' AND DepartId = '1'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 1) {
                $_SESSION['StaffName'] = $username;
                $_SESSION['StaffPassword'] = "Your are now logged in";
                header("location: main.php");
            } 
            else if  (mysqli_num_rows($result) == 0) {
            $query = "SELECT * FROM tbl_staff WHERE StaffName = '$username' AND StaffPassword = '$password' AND DepartId != '1'";
            $result = mysqli_query($conn, $query);
            
            if (mysqli_num_rows($result) == 1) {
                $_SESSION['StaffName'] = $username;
                $_SESSION['StaffPassword'] = "Your are now logged in";
                header("location: Mainuser.php");
            }else {
                array_push($errors, "Wrong Username or Password");
                $_SESSION['error'] = "Wrong Username or Password!";
                header("location: login.php");
            }
        } 
        else {
            array_push($errors, "Username & Password is required");
            $_SESSION['error'] = "Username & Password is required";
            header("location: login.php");
        }
    }
}

?>
