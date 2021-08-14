<?php 
    include('connect.php');
    session_start();

  
    if (!isset($_SESSION['StaffName'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['StaffName']);
        header('location: login.php');
    }


    if (isset($_REQUEST['btn_insert'])) {
        $StaffName = $_REQUEST['txt_Name'];
        $StaffPassword = $_REQUEST['txt_Password'];
        $StaffTel = $_REQUEST['txt_Tel'];
        $StaffEmail = $_REQUEST['txt_Mail'];
        $DepartId = $_REQUEST['Seldepart'];


        if (empty($StaffName)) {
            $errorMsg = "Please enter Name";
        } else if (empty($StaffPassword)) {
            $errorMsg = "please Enter Password";
        } else if (empty($StaffTel)) {
            $errorMsg = "please Enter Telephone";
        } else if (empty($StaffEmail)) {
            $errorMsg = "please Enter Mail";
        } else {
            try {
                if (!isset($errorMsg)) {
                    
                    $insert_stmt = $db->prepare("INSERT INTO tbl_staff(StaffName, StaffPassword, StaffTel, StaffEmail, DepartId) VALUES (:1name, :2name, :3name, :4name, :5name)");
                    $insert_stmt->bindParam(':1name', $StaffName);
                    $insert_stmt->bindParam(':2name', $StaffPassword);
                    $insert_stmt->bindParam(':3name', $StaffTel);
                    $insert_stmt->bindParam(':4name', $StaffEmail);
                    $insert_stmt->bindParam(':5name', $DepartId);
                    if ($insert_stmt->execute()) {
                        $insertMsg = "Insert Successfully...";
                        header("refresh:1;Staffshow.php");
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    
</head>
<body>

        <?php
            include('slidebar.php');
        ?>

        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
            <h1 class="navbar-brand">Staff Add+</h1>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link"><?php echo $_SESSION['StaffName'] ?></a>                
                        </li>  
                        
                        
                        <li class="nav-item">
                            <td><a href="index.php?logout='1'" class ="btn btn-warning">Logout</a></td>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

        


    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>


    
        <form method="post" class="form-horizontal mt-5">
            
        <div class="form-group text-center">
                <div class="row">
                    <label for="Name" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Name" class="form-control" placeholder="Enter Name...">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Password" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-7">
                        <input type="Password" name="txt_Password" class="form-control" placeholder="Enter Password...">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Telephone</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Tel" class="form-control" placeholder="Enter Telephone...">
                    </div>
                </div>
            </div>

            
            <div class="form-group text-center">
                <div class="row">
                    <label for="Mail" class="col-sm-3 control-label">Mail</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Mail" class="form-control" placeholder="Enter Mail...">
                    </div>
                </div>
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

            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_insert" class="btn btn-success" value="Insert">
                    <a href="Staffshow.php" class="btn btn-danger">Back</a>
                </div>
            </div>

          


        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>