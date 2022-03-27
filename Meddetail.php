<?php 
     include('Connect.php'); 

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

    if (isset($_GET['delete_id'])) {
        $id = $_GET['delete_id'];


        //Delete an original record from db
        //$sql = 'DELETE FROM tbl_Med WHERE MedId' =.$id);
        $sql = "DELETE FROM tbl_med where MedId = '".$id."'";
        if($conn->query($sql) == TRUE){
          echo "<script type='text/javascript'>alert('ลบข้อมูลสำเร็จ');</script>";
        }else{
          echo "<script type='text/javascript'>alert('ลบข้อมูลไม่สำเร็จ');</script>";
        }
        header("refresh:1;Medshow.php");
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

</div><br>


    <div class="container-sm">
    
        <table class="table table-bordered">

            <tbody>
                <?php 
                    if (isset($_REQUEST['detail_id'])) {  
                        $id = $_REQUEST['detail_id'];
                        $sql ="SELECT tbl_med.MedId,tbl_med.TypeId,tbl_med.CateId,tbl_med.VolumnId,tbl_med.UnitId,tbl_med.MedName,tbl_med.MedPack,tbl_med.MedPrice,tbl_med.MedDes,tbl_med.MedIndi,tbl_med.MedExp,tbl_med.MedLow,tbl_med.MedTotal,tbl_med.MedPoint,tbl_med.MedPath,tbl_type.TypeName,tbl_cate.CateName,tbl_volumn.VolumnName,tbl_unit.UnitName
                        FROM tbl_med
                        INNER JOIN tbl_type ON tbl_type.TypeId = tbl_med.TypeId
                        INNER JOIN tbl_cate ON tbl_cate.CateId = tbl_med.CateId
                        INNER JOIN tbl_volumn ON tbl_volumn.VolumnId = tbl_med.VolumnId
                        INNER JOIN tbl_unit ON tbl_unit.UnitId = tbl_med.UnitId
                        WHERE tbl_med.MedId = '$id'";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $Med){               
                ?>
            
                    <tr>    
    <div class="product-item">
        <form action="Order.php" method="post">
            <div class="container">

                <div class="form-group text-center">
                    <div>
                        <div> <?php echo '<img style = "width:325px;height:325px"  src="upload/'. $Med["MedPath"]; ?>"> </div> 
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <label for="Tel" class="col-sm-3 control-label">รหัสยา</label>
                            <div class="col-sm-7">
                                <input type="text" name="txt_MedName" class="form-control" value="<?php echo $Med["MedId"]; ?>" readonly>
                        </div>
                    </div>
                </div>
            
                <div class="form-group text-center">
                    <div class="row">
                        <label for="Tel" class="col-sm-3 control-label">ชื่อยา</label>
                            <div class="col-sm-7">
                                <input type="text" name="txt_MedName" class="form-control" value="<?php echo $Med["MedName"]; ?>" readonly>
                        </div>
                    </div>
                </div>
                
                <div class="form-group text-center">
                    <div class="row">
                        <label for="Medicine Category" class="col-sm-3 control-label">รายละเอียดยา</label>
                        <div class="col-sm-7">
                            <textarea rows="4" cols="63" readonly><?php echo $Med["MedDes"]; ?></textarea>
                           
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <label for="Medicine Category" class="col-sm-3 control-label">ข้อบ่งชี้</label>
                        <div class="col-sm-7">
                            <textarea rows="4" cols="63" readonly><?php echo $Med["MedIndi"]; ?></textarea>
                           
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <label for="Medicine Category" class="col-sm-3 control-label">หมวดหมู่ยา</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_MedCate" class="form-control" value="<?php echo $Med["CateName"]; ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <label for="Medicine Volumn" class="col-sm-3 control-label">ปริมาณ</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_MedVolumn" class="form-control" value="<?php echo $Med["VolumnName"]; ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <label for="Medicine Unit" class="col-sm-3 control-label">หน่วย</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_MedUnit" class="form-control" value="<?php echo $Med["UnitName"]; ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <label for="Medicine pack" class="col-sm-3 control-label">จำนวนต่อหีบห่อ</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $Med["MedPack"]; ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <label for="Medicine pack" class="col-sm-3 control-label">ราคาต่อหีบห่อ</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $Med["MedPrice"]; ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="col-md-12 mt-3">
                        <a href = "Mededit.php?edit_id=<?php echo $Med["MedId"];?>" class = "btn btn-info">แก้ไขข้อมูล</a>
                        <a href="Medshow.php" class="btn btn-danger">กลับ</a> 
                    </div>
                </div>
            </div>
                            
            </div>                  
        </form>
    </div>
                    </tr>
                    <?php }} ?>

            </tbody>
        </table>
    </div>
    
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