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
        $Unit = $_REQUEST['Unit'];
        
        
        if (empty($Unit)) {
            $errorMsg = "กรุณาใส่ชื่อหน่วยนับ";
        }  else {
            $query = "SELECT * FROM tbl_unit WHERE UnitName = '$Unit'  LIMIT 1";
            $result = mysqli_query($conn, $query); 
            $row = mysqli_fetch_array($result);
            if($row["UnitName"] === $Unit) {
                $errorMsg =  "ชื่อหน่วยนับซ้ำ กรุณาใส่ใหม่";
            }
            else {
            $sql = "INSERT INTO tbl_unit(UnitName) VALUES ('$Unit')";
            if ($conn->query($sql) === TRUE){
                $insertMsg = "เพิ่มข้อมูลสำเร็จ...";
                header("refresh:1;Unitshow.php");
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
        foreach($data as $key => $staff)
        {      

        }

    $sql = "SELECT * FROM tbl_med WHERE MedTotal <= MedPoint";
    $result1 = $conn->query($sql);
    $med = array();
        while($row = $result1->fetch_assoc()) 
        {
            $med[] = $row;  
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
                        if((count($med)+$Alert) > 0)
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
                            if((count($med)+$Alert) > 0)
                                {
                                    echo "<sup>".(count($med)+$Alert)."</sup>";
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
         if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>สำเร็จ! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>

    <center><strong><h2>เพิ่มข้อมูลหน่วยนับ</h2></strong></center>
        <form method="post" class="form-horizontal mt-5">
            <div class="container">
                <div class="form-group text-center">
                    <div class="row">
                        <label for="DealerName" class="col-sm-3 control-label">ชื่อหน่วยนับ</label>
                        <div class="col-sm-7">
                            <input type="text" name="Unit" class="form-control" placeholder="กรุณาใส่ชื่อหน่วยนับ...">
                        </div>
                    </div>
                </div>
                
                <div class="form-group text-center">
                    <div class="col-md-12 mt-3">
                        <input type="submit" name="btn_insert" class="btn btn-success" value="เพิ่มข้อมูล">
                        <a href="Unitshow.php" class="btn btn-danger">กลับ</a>
                    </div>
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