<?php 
    include('connect.php');
    session_start();
    error_reporting(0);
  
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
            $errorMsg = "กรุณาใส่ชื่อของคุณ";
        } else if (empty($StaffPassword)) {
            $errorMsg = "กรุณาใส่รหัสผ่านของคุณ";
        } else if (empty($StaffTel)) {
            $errorMsg = "กรุณาใส่เบอร์โทรศัพท์ของคุณ";
        } else if (empty($StaffEmail)) {
            $errorMsg = "กรุณาใส่อีเมลของคุณ";
        } else {
            $query = "SELECT * FROM tbl_staff WHERE StaffName = '$StaffName'  LIMIT 1";
            $result = mysqli_query($conn, $query); 
            $row = mysqli_fetch_array($result);
            if($row["StaffName"] === $StaffName) {
                $errorMsg =  "ชื่อพนักงานซ้ำ กรุณาใส่ใหม่";
            }
            else {
            $sql = "INSERT INTO tbl_staff(StaffName, StaffPassword, StaffTel, StaffEmail, DepartId) VALUES ('$StaffName', '$StaffPassword', '$StaffTel', '$StaffEmail', '$DepartId')";
            if ($conn->query($sql) === TRUE){
                $insertMsg = "Insert Successfully...";
                header("refresh:1;Staffshow.php");
            }
                else {echo "Error updating record: " . $conn->error;}
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
                  <a href="main.php" class="navbar-brand">หน้าหลัก</a>
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
                                            <a class="dropdown-item" href="Staffedit.php?update_id=<?php echo $staff["StaffId"];?>">แก้ไขข้อมูลส่วนตัว</a>
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
            <div class="container">
                <div class="form-group text-center">
                    <div class="row">
                        <td style="width: 20%;"><label for="Name" class="col-sm-3 control-label">ชื่อ</label></td>
                        <div class="col-sm-7">
                        <td style="width: 70%;"><input type="text" name="txt_Name" class="form-control" placeholder="กรุณาใส่ชื่อของคุณ..."></td>
                        </div>
                    </div>
                </div>
            
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Password" class="col-sm-3 control-label">รหัสผ่าน</label></td>
                        <div class="col-sm-7">
                            <td><input type="Password" name="txt_Password" class="form-control" placeholder="กรุณาใส่รหัสผ่านของคุณ..."></td>
                        </div>
                    </div>
                </div>
        
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Tel" class="col-sm-3 control-label">เบอร์โทร</label></td>
                        <div class="col-sm-7">
                            <td><input type="text" name="txt_Tel" class="form-control" placeholder="กรุณาใส่เบอร์โทรศัพท์ของคุณ..."></td>
                        </div>
                    </div>
                </div>
            </tr>

            <tr>
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Mail" class="col-sm-3 control-label">อีเมล</label></td>
                        <div class="col-sm-7">
                            <td><input type="text" name="txt_Mail" class="form-control" placeholder="กรุณาใส่อีเมลของคุณ..."></td>
                        </div>
                    </div>
                </div>
            
                <div class="form-group text-center">
                    <div class="row">
                        <td><label class="col-sm-3 control-label">ชื่อแผนก</label></td>
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
            
                <div class="form-group text-center">
                    <div class="col-md-12 mt-3">
                        <input type="submit" name="btn_insert" class="btn btn-success" value="เพิ่มข้อมูล">
                        <a href="Staffshow.php" class="btn btn-danger">กลับ</a>
                    </div>
                </div>
            </div>
        </form>
    

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>