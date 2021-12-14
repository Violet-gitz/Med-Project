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

    $staff =  $_SESSION['StaffName'];
    $sql = "SELECT* FROM tbl_staff WHERE StaffName = '$staff'";
    $result = $conn->query($sql);
    $data = array();
        while($row = $result->fetch_assoc()) 
        {
            $data[] = $row;  
        }
        foreach($data as $key => $staff){      

        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
                <div style='margin-right: 15px'>
                    <?php
                    include('slidebar.php');   
                    ?>
                </div>
                <div> 
                  <a href="main.php" class="navbar-brand">Home Page</a>
                </div>

                <div id="navbar1" class="collapse navbar-collapse" style='justify-content: end;'>
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">
                                
                                <button class="btn btn-info  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                ><?php echo $_SESSION['StaffName'] ?>
                                </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <form method="POST" action="Staffedit.php">
                                            <a class="dropdown-item" href="Staffedit.php?update_id=<?php echo $staff["StaffId"];?>">Edit</a>
                                            <input type="hidden" name ='update_id' value ="<?php echo $staff["StaffId"]; ?>">
                                        </from>

                                        <form method="POST" action="index.php">
                                            <a class="dropdown-item" href="index.php?logout='1'">Logout</a>
                                            <input type ="hidden" name ='logout' value ="1">
                                        </form>

                                    </div>                               
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav> 
    
    
</head>
<body>



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


    <center><table class="table table-sm" style ="width: 80%">
        <form method="post" class="form-horizontal mt-5">
        <thead>
            Infomation
        </thead>
        <tr>
            <div class="form-group text-center">
                <div class="row">
                    <td style="width: 20%;"><label for="Name" class="col-sm-3 control-label">Name</label></td>
                    <div class="col-sm-7">
                    <td style="width: 70%;"><input type="text" name="txt_Name" class="form-control" placeholder="Enter Name..."></td>
                    </div>
                </div>
            </div>
         </tr>

         <tr>
            <div class="form-group text-center">
                <div class="row">
                    <td><label for="Password" class="col-sm-3 control-label">Password</label></td>
                    <div class="col-sm-7">
                        <td><input type="Password" name="txt_Password" class="form-control" placeholder="Enter Password..."></td>
                    </div>
                </div>
            </div>
        </tr>

        <tr>
            <div class="form-group text-center">
                <div class="row">
                    <td><label for="Tel" class="col-sm-3 control-label">Telephone</label></td>
                    <div class="col-sm-7">
                        <td><input type="text" name="txt_Tel" class="form-control" placeholder="Enter Telephone..."></td>
                    </div>
                </div>
            </div>
        </tr>

        <tr>
            <div class="form-group text-center">
                <div class="row">
                    <td><label for="Mail" class="col-sm-3 control-label">Mail</label></td>
                    <div class="col-sm-7">
                        <td><input type="text" name="txt_Mail" class="form-control" placeholder="Enter Mail..."></td>
                    </div>
                </div>
            </div>
        </tr>
            
        <tr>
            <div class="form-group text-center">
                <div class="row">
                    <td><label class="col-sm-3 control-label">Department Name</label></td>
                        <div class="col-sm-1">
                            <td><select name="Seldepart">       
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
                            </select><br></td>
                        </div>
                </div>
            </div>
        </tr>

        </table>
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_insert" class="btn btn-success" value="Insert">
                    <a href="Staffshow.php" class="btn btn-danger">Back</a>
                </div>
            </div>

        </form></center>
    

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>