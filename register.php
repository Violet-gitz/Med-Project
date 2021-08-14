<?php 
    session_start();
    include('Connect.php'); 
    include('errors.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="header">
        <h2>Register</h2>
    </div>

    <form action="register_db.php" method="POST">
        <?php include('errors.php'); ?>
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
            <label for="Name">Name</label>
            <input type="text" name="StaffName">
        </div>

        <div class="input-group">
            <label for="password_1">Password</label>
            <input type="password" name="StaffPassword">
        </div>
        
        <div class="input-group">
            <label for="Telephone">Telephone</label>
            <input type="text" name="StaffTel">
        </div>

        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="StaffEmail">
        </div>

        <div class="form-group text-center">
                <div class="row">
                    <label class="col-sm-3 control-label">Department Name</label>
                        <div class="col-sm-1">
                            <select name="Seldepart">       
                                <?php 
                                    $sql = 'SELECT * FROM tbl_department';
                                    $result = $conn->query($sql);
                                    $data = array();
                                    while($row = $result->fetch_assoc()) 
                                        {
                                            $data[] = $row;   
                                        }
                                        foreach($data as $key => $depart){                  
                                ?>
                                    <option value ="<?php echo $depart["DepartId"];?>"><?php echo $depart["DepartName"];?></option>
                                <?php } ?>      
                            </select><br>
                        </div>
                </div>
            </div>
        
       
       

        

        <div class="input-group">
            <button type="submit" name="reg_user" class="btn">Register</button>
        </div>
        <p>Already a member? <a href="login.php">Sign in</a></p>
    </form>

</body>
</html>