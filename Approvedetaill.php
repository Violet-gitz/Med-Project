
<?php 
    include('Connect.php'); 
     
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

    if (isset($_REQUEST['Approve'])) {
                
            $withid = $_REQUEST['Approve'];
            $sql = "SELECT* FROM tbl_withdraw WHERE WithId=$withid";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
            $data[] = $row;  
            }
            foreach($data as $key => $With){
               
                $idwith = $With["WithId"];
                $sql ="SELECT * FROM tbl_withdrawdetail WHERE WithId = $idwith";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $withde){
                    }
    
                    $staffid = $With["StaffId"];
                    $sql = "SELECT * FROM tbl_staff WHERE StaffId = $staffid";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $Staff){}
        }
    }

    if (isset($_REQUEST['btn_approve'])) 
    {

        $WithId = $_REQUEST['txt_WithId'];

        $sql = "SELECT* FROM tbl_withdraw WHERE WithId=$WithId";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) {
        $data[] = $row;  
        }
        foreach($data as $key => $With){
        
            $idwith = $With["WithId"];
            $sql ="SELECT * FROM tbl_withdrawdetail WHERE WithId = $idwith";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                }
                foreach($data as $key => $withde)
                {
                    $lotid = $withde["LotId"];

                    $sql ="SELECT * FROM tbl_lot WHERE LotId = $lotid";
                    $result = $conn->query($sql);
                    $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $lot)
                        {
                            $lotqty = $lot["Qty"];
                            $withqty = $withde["Qty"];
                            $Reserve = $lot["Reserve"];
                            $sum = $Reserve - $withqty;
                            $qtysum = $lotqty - $withqty;

                            $sql = "UPDATE tbl_lot SET Qty = $qtysum , Reserve = $sum WHERE LotId = $lotid"; 
                            if ($conn->query($sql) === TRUE) { 
                            } else {
                            echo "Error updating record: " . $conn->error;
                            }
                        }

                    $MedId = $withde["MedId"];

                    $sql ="SELECT * FROM tbl_med WHERE MedId = $MedId";
                    $result = $conn->query($sql);
                    $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $med)
                        {
                            $Medqty = $med["MedTotal"];
                            $withqty = $withde["Qty"];
                            $Medsum = $Medqty - $withqty;

                            $sql = "UPDATE tbl_med SET MedTotal = $Medsum WHERE MedId = $MedId"; 
                            if ($conn->query($sql) === TRUE) { 
                            } else {
                            echo "Error updating record: " . $conn->error;
                            }
                        }
                }
                    $sql = "UPDATE tbl_withdraw SET WithStatus = 'อนุมัติสำเร็จ' WHERE WithId = $WithId"; 
                    if ($conn->query($sql) === TRUE) { 
                    } else {
                     echo "Error updating record: " . $conn->error;
                        }       
        } $insertMsg = "อนุมัติสำเร็จ...";
        header("refresh:1;Approve.php");
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
            <strong>ไม่สำเร็จ! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
         
    <?php 
        if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>สำเร็จ! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>

    <div class="container-xl">
        <table class="table table-bordered" style="width:1500px; margin-left:-200px ; margin-top: 4rem;">
            <div style='margin-bottom: 10px;'>
                    <h2>อนุมัติ<h2>
            </div>
                <form method="post" class="form-horizontal mt-5" name="myform">
                    
                <thead>
                    <tr>
                        <th>รูป</th>
                        <th style = "width:120px">รหัสการเบิก</th>
                        <th>ล็อตที่</td>
                        <th>คนขออนุมัติ</th>
                        <th>วันที่เบิก</th>
                        <th>จำนวนที่เบิก</th>
                        <th>สถานะ</th>
                        <th>ชื่อยา</th>   
                        <th>วันผลิต</td>          
                        <th>วันหมดอายุ</td>                                                
                    </tr>
                </thead>

            <?php
                $i = 0;
                $sql = "SELECT * FROM tbl_withdrawdetail WHERE WithId = $withid";
                $result = $conn->query($sql);
                $data = array();
                while($row = $result->fetch_assoc()) {
                $data[] = $row;  
                }
                foreach($data as $key => $withdetailid){

                    $MedId = $withdetailid["MedId"];
                    $sqli ="SELECT tbl_med.MedId,tbl_med.TypeId,tbl_med.CateId,tbl_med.VolumnId,tbl_med.UnitId,tbl_med.MedName,tbl_med.MedPack,tbl_med.MedPrice,tbl_med.MedDes,tbl_med.MedIndi,tbl_med.MedExp,tbl_med.MedLow,tbl_med.MedTotal,tbl_med.MedPoint,tbl_med.MedPath,tbl_type.TypeName,tbl_cate.CateName,tbl_volumn.VolumnName,tbl_unit.UnitName
                    FROM tbl_med
                    INNER JOIN tbl_type ON tbl_type.TypeId = tbl_med.TypeId
                    INNER JOIN tbl_cate ON tbl_cate.CateId = tbl_med.CateId
                    INNER JOIN tbl_volumn ON tbl_volumn.VolumnId = tbl_med.VolumnId
                    INNER JOIN tbl_unit ON tbl_unit.UnitId = tbl_med.UnitId
                    WHERE tbl_med.MedId = $MedId";
                    $result = $conn->query($sqli);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                    }
                    
                    foreach($data as $key => $med){   
            ?>

        <div class="container">

            <tr>
                <td><?php echo '<img style = "width:80px;height:80px"  src="upload/'. $med["MedPath"]; ?>"></td>

                <td><input type="text" name="txt_WithId" class="form-control" value="<?php echo $With["WithId"]; ?>" readonly></td>

                <td><?php echo $withdetailid["LotId"]; ?></td>

                <td><?php echo $Staff["StaffName"]; ?></td>

                <td><?php echo $With["WithDate"]; ?></td>

                <td><?php echo $withdetailid["Qty"]; ?></td>

                <td><?php echo $With["WithStatus"]; ?></td>

                <td><?php echo $med["MedName"]; ?></td>

                <td><?php echo $withdetailid["Mfd"]; ?></td>

                <td><?php echo $withdetailid["Exd"]; ?></td>
            </tr>
       

        <?php }}?>
        </table>
        <div class="form-group text-center">
            <div class="col-md-12 mt-3">
                <input type="submit" name="btn_approve" class="btn btn-success" value="อนุมัติ">
                <a href="Approve.php" class="btn btn-danger">กลับ</a>
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

