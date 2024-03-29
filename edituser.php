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


    if (isset($_REQUEST['update_id'])) {
        try {
            $id = $_REQUEST['update_id'];
            $sql ="SELECT * FROM tbl_staff WHERE $id = StaffId";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $staff){}
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $Name = $_REQUEST['txt_Name'];
        $Telephone = $_REQUEST['txt_Telephone'];
        $Email = $_REQUEST['txt_Email'];
        $DepartName = $_REQUEST['Seldepart'];
        

        if (empty($Name)) {
            $errorMsg = "กรุณาใส่ชื่อ";
        }  else if (empty($Telephone)) {
            $errorMsg = "กรุณาใส่เบอร์โทร";
        }  else if (empty($Email)) {
            $errorMsg = "กรุณาใส่เมลล์";
        }  else if (empty($DepartName)) {
            $errorMsg = "กรุณาใส่ชื่อแผนก";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE tbl_staff SET StaffName = :1name, StaffTel = :2name, StaffEmail = :3name, DepartId = :4name WHERE StaffId = :StaffId");
                    $update_stmt->bindParam(':1name', $Name);
                    $update_stmt->bindParam(':2name', $Telephone);
                    $update_stmt->bindParam(':3name', $Email);
                    $update_stmt->bindParam(':4name', $DepartName);
                    $update_stmt->bindParam(':StaffId', $id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "เพิ่มข้อมูลสำเร็จ...";
                        header("refresh:1;Staffshow.php");
                    }
                }
            } catch(PDOException $e) {
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
                    include('slidebaruser.php');   
                    ?>
                </div>
                <div> 
                  <a href="Mainuser.php" class="navbar-brand">หน้าหลัก</a>
                </div>

                <!-- <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button> -->
                <div id="navbar1" class="collapse navbar-collapse" style='justify-content: end;'>
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">

                                <button class="btn btn-info  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                ><?php echo $_SESSION['StaffName'] ?>
                                </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <form method="POST" action="edituser.php">
                                            <a class="dropdown-item" href="edituser.php?update_id=<?php echo $staff["StaffId"];?>">แก้ไขข้อมูลส่วนตัว</a>
                                            <input type="hidden" name ='update_id' value ="<?php echo $staff["StaffId"]; ?>">
                                        </from>

                                        <form method="POST" action="index.php">
                                            <a class="dropdown-item" href="index.php?logout='1'">ออกจากระบบ</a>
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
            <strong>ผิดพลาด! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>สำเร็จ! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>

    <center><strong><h2>แก้ไขมูลพนักงาน</h2></strong></center>
        <form method="post" class="form-horizontal mt-5">
        <div class="container">

            <div class="form-group text-center">
                <div class="row">
                    <label for="Name" class="col-sm-3 control-label">ชื่อ</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Name" class="form-control" value="<?php echo $staff["StaffName"]; ?>">
                    </div>
                </div>
            </div>

            
            <div class="form-group text-center">
                <div class="row">
                    <label for="Telephone" class="col-sm-3 control-label">เบอร์โทรศัพท์</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Telephone" class="form-control" value="<?php echo $staff["StaffTel"]; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Email" class="col-sm-3 control-label">อีเมล</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Email" class="form-control" value="<?php echo $staff["StaffEmail"]; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label class="col-sm-3 control-label">แผนก</label>
                        <div class="col-sm-1">
                            <select name="Seldepart">       
                                <?php 
                                    $sql = 'SELECT * FROM tbl_department WHERE DepartId != 1';
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
                    <input type="submit" name="btn_update" class="btn btn-success" value="อัปเดต">
                    <a href="Mainuser.php" class="btn btn-danger">กลับ</a>
                </div>
            </div>
        </div>

        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>