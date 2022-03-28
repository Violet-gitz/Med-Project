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


    if (isset($_REQUEST['edit_id'])) {
        try {
            $id = $_REQUEST['edit_id'];
            $sql ="SELECT * FROM tbl_med WHERE $id = MedId";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $med){}
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }
    
    if (isset($_REQUEST['btn_update'])) {
        $MedName = $_REQUEST['txt_MedName'];
        $MedDes = $_REQUEST['txt_MedDes'];
        $CateId = $_REQUEST['dropdownlist-MedCate'];
        $VolumnId = $_REQUEST['dropdownlist-MedVolumn'];
        $UnitId = $_REQUEST['dropdownlist-MedUnit'];
        $MedPack = $_REQUEST['txt_MedPack'];
        $MedPrice = $_REQUEST['txt_MedPrice'];
        $MedLow = $_REQUEST['txt_Medlow'];
        $MedTotal = $_REQUEST['txt_MedTotal'];
        $MedIndi = $_REQUEST['txt_MedIndi'];
        $MedPoint = $_REQUEST['txt_MedPoint'];
        $TypeId = $_REQUEST['txt_Medtype'];
        $MedExp = $_REQUEST['txt_MedExp'];
        $MedNoti = $_REQUEST['txt_MedNoti'];
        
        if (empty($MedName)) {
            $errorMsg = "กรุณาใส่ชื่อยา";
        }else if (empty($MedDes)) {
            $errorMsg = "กรุณาใส่รายละเอียดยา";
        }else if (empty($CateId)) {
            $errorMsg = "กรุณาเลือกหมวดหมู่";
        }else if (empty($VolumnId)) {
            $errorMsg = "กรุณาเลือกปริมาณ";
        }else if (empty($UnitId)) {
            $errorMsg = "กรุณาเลือกหน่วยยา";
        }else if (empty($MedPack)) {
            $errorMsg = "กรุณาใส่จำนวนต่อหนึ่งหีบห่อ";
        }else if (empty($MedPrice)) {
            $errorMsg = "กรุณาใส่ราคาต่อหีบห่อ";
        }else if (empty($MedIndi)) {
            $errorMsg = "กรุณาใส่ข้อบ่งชี้";
        }else if (empty($MedPoint)) {
            $errorMsg = "กรุณาใส่จุดสั่งซื้อ";
        }else if (empty($MedExp)) {
            $errorMsg = "กรุณาใส่จำนวนวันหมดอายุ";
        }else if (empty($TypeId)) {
            $errorMsg = "กรุณาเลือกประเภทยา";
        }else if (empty($MedNoti)) {
            $errorMsg = "กรุณาใส่วันที่ต้องการให้แจ้งเตือนก่อน";
        }else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE tbl_med SET MedName = :1name, CateId = :2name, VolumnId = :3name, UnitId = :4name, MedPack = :5name, MedPrice = :6name, MedTotal = :7name,  MedPoint = :8name, MedDes = :9name, MedLow = :10name, TypeId = :11name, MedIndi = :12name, MedExp = :13name, MedNoti = :14name WHERE MedId = :MedId");
                    $update_stmt->bindParam(':1name', $MedName);
                    $update_stmt->bindParam(':2name', $CateId);
                    $update_stmt->bindParam(':3name', $VolumnId);
                    $update_stmt->bindParam(':4name', $UnitId);
                    $update_stmt->bindParam(':5name', $MedPack);
                    $update_stmt->bindParam(':6name', $MedPrice);
                    $update_stmt->bindParam(':7name', $MedTotal);
                    $update_stmt->bindParam(':8name', $MedPoint); 
                    $update_stmt->bindParam(':9name', $MedDes); 
                    $update_stmt->bindParam(':10name', $MedLow);
                    $update_stmt->bindParam(':11name', $TypeId);
                    $update_stmt->bindParam(':12name', $MedIndi);
                    $update_stmt->bindParam(':13name', $MedExp);
                    $update_stmt->bindParam(':14name', $MedNoti);       
                    $update_stmt->bindParam(':MedId', $id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "แก้ไขข้อมูลสำเร็จ...";
                        header("refresh:1;Medshow.php");
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
        foreach($data as $key => $staff)
        {      

        }

    $sql = "SELECT * FROM tbl_med WHERE MedTotal <= MedPoint";
    $result1 = $conn->query($sql);
    $med1 = array();
    while($row = $result1->fetch_assoc()) 
        {
            $med1[] = $row;  
        }

        $sql = "SELECT * FROM tbl_lot WHERE LotStatus != 'เคลม' AND LotStatus != 'ตัดจำหน่าย' AND LotStatus != 'ไม่สามารถใช้งานได้'";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) 
            {
            $data[] = $row;   
            }
            $Alert = 0;
            foreach($data as $key => $lot)
            {
                $Medid = $lot["MedId"];
                $sql = "SELECT * FROM tbl_med WHERE $Medid = MedId";
                $result = $conn->query($sql);
                $data = array();
                while($row = $result->fetch_assoc()) 
                {
                $data[] = $row;   
                }
                foreach($data as $key => $Med)
                {

                    $mednotidate = $Med["MedNoti"];
                    date_default_timezone_set("Asia/Bangkok");
                    $datenow = date("d")."-".date("m")."-".(date("Y")+543);
                    $ExpDate = $lot["Exd"];
                    $datenow=date_create($datenow);
                    $dateexp=date_create($ExpDate);
                    $diff=date_diff($datenow,$dateexp);
                    if($diff->format('%R%a') <= $mednotidate)
                    {
                    $Alert++;
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

    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
                <div style='margin-right: 15px'>
                    <?php
                    include('slidebar.php');   
                    ?>
                </div>
                <div> 
                  <a href="main.php" class="navbar-brand">หน้าหลัก</a>
                  
                  <a herf="main.php"><i class="fa fa-bell" data-toggle="modal" data-target="#centralModalLg" style ="font-size: 36px; color: 
                        <?php
                        if((count($med1)+$Alert) > 0)
                            {
                                echo "red";
                            }
                        else 
                            {
                                echo "white";
                            }
                        ?> 
                        ; margin-left: 22em;" aria-hidden="true">  
                        <?php
                            if((count($med1)+$Alert) > 0)
                                {
                                    echo "<sup>".(count($med1)+$Alert)."</sup>";
                                }
                        
                        ?>
                        </i>
                    </a>                               
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

    <center><strong><h2>แก้ไขข้อมูลยา</h2></strong></center>
        <form method="post" class="form-horizontal mt-5">
            <div class="container">
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicinename" class="col-sm-3 control-label">ชื่อยา</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedName" class="form-control" value="<?php echo $med["MedName"]?>"></td>
                            </div>
                    </div>
                </div>
              
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicinedes" class="col-sm-3 control-label">รายละเอียด</label></td>
                            <div class="col-sm-7">
                                <td><textarea id="w3review" name="txt_MedDes" rows="4" cols="50"><?php echo $med["MedDes"]?></textarea></td>
                            </div>
                    </div>
                </div>
              
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicinedes" class="col-sm-3 control-label">ข้อบ่งชี้</label></td>
                            <div class="col-sm-7">
                                <td><textarea id="w3review" name="txt_MedIndi" rows="4" cols="50"><?php echo $med["MedIndi"]?></textarea></td>
                            </div>
                    </div>
                </div>
              
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicineprcie" class="col-sm-3 control-label">ราคาต่อหีบห่อ</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedPrice" class="form-control" value="<?php echo $med["MedPrice"]?>"></td>
                            </div>
                    </div>
                </div>
              
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicinepack" class="col-sm-3 control-label">จำนวนต่อหนึ่งหีบห่อ</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["MedPack"]?>"></td>
                            </div>
                    </div>
                </div>
               
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicinelow" class="col-sm-3 control-label">ขั้นต่ำในการซื้อ</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_Medlow" class="form-control" value="<?php echo $med["MedLow"]?>"></td>
                            </div>
                    </div>
                </div>
             
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicineprcie" class="col-sm-3 control-label">จุดสั่งซื้อ</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedPoint" class="form-control" value="<?php echo $med["MedPoint"]?>"></td>
                            </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicineprcie" class="col-sm-3 control-label">จำนวนวันหมดอายุ</label></td>
                            <div class="col-sm-7">
                                <td><input type="number" name="txt_MedExp" class="form-control" value="<?php echo $med["MedExp"]; ?>"></td>
                            </div>
                        </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicineprcie" class="col-sm-3 control-label">ตั้งจำนวนวันแจ้งเตือน</label></td>
                            <div class="col-sm-7">
                                <td><input type="number" name="txt_MedNoti" class="form-control" value="<?php echo $med["MedNoti"]; ?>"></td>
                            </div>
                        </div>
                </div>
              
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="MedTotal" class="col-sm-3 control-label">จำนวนยาคงเหลือ</label></td>
                            <div class="col-sm-7">
                                <td><input type="number" name="txt_MedTotal" class="form-control" value="<?php echo $med["MedTotal"]; ?>"></td>
                            </div>
                        </div>
                </div>

                        <div class="form-group text-center">
                            <div class="row">
                                <td><label class="col-sm-3 control-label">ประเภท</label></td>
                                    <div class="col-sm-1">
                                        <td><select name="txt_Medtype">       
                                            <?php 
                                                $sql = 'SELECT * FROM tbl_type';
                                                $result = $conn->query($sql);
                                                $data = array();
                                                while($row = $result->fetch_assoc()) 
                                                    {
                                                        $data[] = $row;   
                                                    }
                                                    foreach($data as $key => $type){                  
                                            ?>
                                                <option value ="<?php echo $type["TypeId"];?>"><?php echo $type["TypeName"];?></option>
                                            <?php } ?>      
                                        </select><br></td>
                                    </div>
                            </div>
                        </div>
                    
                        <div class="form-group text-center">
                            <div class="row">
                                <td><label class="col-sm-3 control-label">หมวดหมู่</label></td>
                                    <div class="col-sm-1">
                                        <td><select name="dropdownlist-MedCate">       
                                            <?php 
                                                $sql = 'SELECT * FROM tbl_cate';
                                                $result = $conn->query($sql);
                                                $data = array();
                                                while($row = $result->fetch_assoc()) 
                                                    {
                                                        $data[] = $row;   
                                                    }
                                                    foreach($data as $key => $cate){                  
                                            ?>
                                                <option value ="<?php echo $cate["CateId"];?>"><?php echo $cate["CateName"];?></option>
                                            <?php } ?>      
                                        </select><br></td>
                                    </div>
                            </div>
                        </div>
                    
                        <div class="form-group text-center">
                            <div class="row">
                                <td><label class="col-sm-3 control-label">จำนวนปริมาณ</label></td>
                                    <div class="col-sm-1">
                                        <td><select name="dropdownlist-MedVolumn">       
                                            <?php 
                                                $sql = 'SELECT * FROM tbl_volumn';
                                                $result = $conn->query($sql);
                                                $data = array();
                                                while($row = $result->fetch_assoc()) 
                                                    {
                                                        $data[] = $row;   
                                                    }
                                                    foreach($data as $key => $vol){                  
                                            ?>
                                                <option value ="<?php echo $vol["VolumnId"];?>"><?php echo $vol["VolumnName"];?></option>
                                            <?php } ?>      
                                        </select><br></td>
                                    </div>
                            </div>
                        </div>
                  
                        <div class="form-group text-center">
                            <div class="row">
                                <td><label class="col-sm-3 control-label">หน่วย</label></td>
                                    <div class="col-sm-1">
                                        <td><select name="dropdownlist-MedUnit">       
                                            <?php 
                                                $sql = 'SELECT * FROM tbl_unit';
                                                $result = $conn->query($sql);
                                                $data = array();
                                                while($row = $result->fetch_assoc()) 
                                                    {
                                                        $data[] = $row;   
                                                    }
                                                    foreach($data as $key => $unit){                  
                                            ?>
                                                <option value ="<?php echo $unit["UnitId"];?>"><?php echo $unit["UnitName"];?></option>
                                            <?php } ?>      
                                        </select><br></td>
                                    </div>
                            </div>
                        </div>

     

            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_update" class="btn btn-success" value="อัปเดต">
                    <a href="Medshow.php" class="btn btn-danger">กลับ</a>
                </div>
            </div>


        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>

    <div class="modal fade" id="centralModalLg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <!--Content-->
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header">
            <h4 class="modal-title w-100" id="myModalLabel">รายการแจ้งเตือน</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!--Body-->
          <?php
            $sql = "SELECT * FROM tbl_med";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) 
                {
                    $data[] = $row;  
                }
                foreach($data as $key => $med)
                {   
                    $MedPoint = $med["MedPoint"];  
                    $MedTotal = $med["MedTotal"];  
                    if($MedTotal <= $MedPoint)
                    {
                        echo $med['MedName']." : ต่ำกว่าจุดสั่งซื้อ<br>";
                    }
                }

                $sql = "SELECT * FROM tbl_lot WHERE LotStatus != 'เคลม' AND LotStatus != 'ตัดจำหน่าย' AND LotStatus != 'ไม่สามารถใช้งานได้'";
                $result = $conn->query($sql);
                $data = array();
                while($row = $result->fetch_assoc()) 
                {
                $data[] = $row;   
                }

                    foreach($data as $key => $lot)
                    {
                        $Medid = $lot["MedId"];
                        $sql = "SELECT * FROM tbl_med WHERE $Medid = MedId";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) 
                        {
                        $data[] = $row;   
                        }
                        foreach($data as $key => $Med)
                        {
        
                        $mednotidate = $Med["MedNoti"];
                        date_default_timezone_set("Asia/Bangkok");
                        $datenow = date("d")."-".date("m")."-".(date("Y")+543);
                        $ExpDate = $lot["Exd"];
                        $lot = $lot["LotId"];
                        $medname = $Med["MedName"];
                        $datenow=date_create($datenow);
                        $dateexp=date_create($ExpDate);
                        $diff=date_diff($datenow,$dateexp);
                        if($diff->format('%R%a') <= $mednotidate)
                        {
                        
                            echo $medname ." : ล็อคที่  ". $lot." กำลังจะหมดอายุภายในอีก  ".$diff->format("%a"). " วัน  <br>";
                        }
                    }
                }
            ?>
   
          <!--Footer-->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

          </div>
        </div>
        <!--/.Content-->
      </div>
    </div>

</body>
</html>