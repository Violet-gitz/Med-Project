<?php 
    session_start();
    include('Connect.php');
    
    $errors = array();

    if (isset($_POST['reg_user'])) {
        $Name = mysqli_real_escape_string($conn, $_POST['StaffName']);
        $Password = mysqli_real_escape_string($conn, $_POST['StaffPassword']);
        $Tel = mysqli_real_escape_string($conn, $_POST['StaffTel']);
        $Email = mysqli_real_escape_string($conn, $_POST['StaffEmail']);
        $Depart = mysqli_real_escape_string($conn, $_POST['Seldepart']);


        if (empty($Name)) {
            array_push($errors, "Name is required");
            $_SESSION['error'] = "Name is required";
        }

        if (empty($Password)) {
            array_push($errors, "Password is required");
            $_SESSION['error'] = "Password is required";
        }
    
        if (empty($Email)) {
            array_push($errors, "Email is required");
            $_SESSION['error'] = "Email is required";
        }
        

        $user_check_query = "SELECT * FROM tbl_staff WHERE StaffName = '$Name' OR StaffEmail = '$Email' LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) { // if user exists
            if ($result['StaffName'] === $Name) {
                array_push($errors, "Name already exists");
            }
            if ($result['StaffEmail'] === $Email) {
                array_push($errors, "Email already exists");
            }
        }

        if (count($errors) == 0) {
            //$password = md5($password_1);

            $sql = "INSERT INTO tbl_staff (StaffName, StaffPassword, StaffTel, StaffEmail, DepartId) VALUES ('$Name', '$Password', '$Tel','$Email','$Depart')";
            mysqli_query($conn, $sql);

            $_SESSION['StaffName'] = $Name;
            $_SESSION['success'] = "You are Register Success";
            header('location: index.php');
        } else {
            header("location: register.php");
        }
    }

?>
