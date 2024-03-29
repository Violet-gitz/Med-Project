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

    if (isset($_REQUEST['Cancel_id'])) 
    {
        $withid = $_REQUEST['Cancel_id'];

        $sql = "UPDATE tbl_withdraw SET WithStatus = 'Cancel' WHERE WithId = $withid";
        if ($conn->query($sql) === TRUE) {     
        } else {
          echo "Error updating record: " . $conn->error;
        }
        
        $sql = "SELECT * FROM tbl_withdraw WHERE WithId = '$withid'";
        $result = $conn->query($sql);
        $data = array();
            while($row = $result->fetch_assoc()) 
            {
                $data[] = $row;  
            }
            foreach($data as $key => $withdraw)
            {      

                $withdrawId = $withdraw["WithId"];
                $sql = "SELECT * FROM tbl_withdrawdetail WHERE WithId = '$withid'";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) 
                    {
                        $data[] = $row;  
                    }
                    foreach($data as $key => $withdrawdetail)
                    {   
                        $lotid = $withdrawdetail["LotId"];
                        $sql = "SELECT * FROM tbl_lot WHERE LotId = '$lotid'";
                        $result = $conn->query($sql);
                        $data = array();
                            while($row = $result->fetch_assoc()) 
                            {
                                $data[] = $row;  
                            }
                            foreach($data as $key => $lot)
                            {
                                $withqty = $withdrawdetail["Qty"];
                                $Reserve = $lot["Reserve"];
                                $sum = $Reserve - $withqty;

                                $sql = "UPDATE tbl_lot SET Reserve = '$sum' WHERE LotId = $lotid";
                                if ($conn->query($sql) === TRUE) {     
                                } else {
                                  echo "Error updating record: " . $conn->error;
                                }

                            }

                    }
            }
    }

    if (isset($_REQUEST['submit'])) 
    {
        $search = $_REQUEST['textsearch'];      
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

            <div id="navbar1" class="collapse navbar-collapse" style="justify-content: end;">
                <div class="dropdown">

                    <div id="navbar1" class="collapse navbar-collapse">
                        <ul class="navbar-nav ms-auto">

                            <button class="btn btn-info  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            ><?php echo $_SESSION['StaffName'] ?>
                            </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                    <form method="POSt" action="Staffedit.php">
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
<div class="container">


<div class="container-sm">
    <div class="row mb-5">
            <div class="col-md-4 ms-auto " style="text-align: end;">
                <form action="ApproveSearch.php" method="post">
                    <input type="text" name="textsearch" placeholder = "ค้นหา">
                    <input type="submit" name="submit" value="ค้นหา">
                </form>
            </div>
    </div>
    <form method = "POST" action = "Exportapprove.php" style='display: flex;justify-content: end;'>
        <select name="Year" class='mr-2'>
            <option value="2565">2565</option>
            <option value="2566">2566</option>
            <option value="2567">2567</option>
            <option value="2568">2568</option>
        </select> 
        <select name="Month" class='mr-2' >
            <option value="01-">มกราคม</option>
            <option value="02-">กุมภาพันธ์</option>
            <option value="03-">มีนาคม</option>
            <option value="04-">เมษายน</option>
            <option value="05-">พฤษภาคม</option>
            <option value="06-">มิถุนายน</option>
            <option value="07-">กรกฎาคม</option>
            <option value="08-">สิงหาคม</option>
            <option value="09-">กันยายน</option>
            <option value="10-">ตุลาคม</option>
            <option value="11-">พฤศจิกายน</option>
            <option value="12-">ธันวาคม</option>
        </select>
        <button type = "submit" value = "<?php echo $with["WithId"]; ?>" name = "Report" class="btn btn-primary mr-2">รายงาน</button>
    </form>
 
    <table class="table table-striped" style="width:1500px; margin-left:-200px ; margin-top: 4rem;">
         <div style='margin-bottom: 15px;'>
         <h2>รายการขออนุมัติ</h2>
           </div>
            <thead >
            <tr>
            <th>รหัสการเบิก</th>
                <th>ชื่อพนักงาน</th>
                <th>จำนวน</th>
                <th>สถานะ</th>
                <th>วันที่เบิก</th>
                <th>อนุมัติ</th>
                <th>รายงาน</th>
                <th>ยกเลิก</th>        
            </tr>
        <tbody>
            <?php 
                    $sql = "SELECT * FROM tbl_withdraw WHERE WithId  LIKE '%{$search}%' || WithDate  LIKE '%{$search}%' || WithStatus  LIKE '%{$search}%'";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $with){

                        $staffid = $with["StaffId"];
                        $sql = "SELECT * FROM tbl_staff WHERE StaffId = $staffid";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $staff){
                            $withstatus = $with["WithStatus"];
                        // $OrderStatus = $order["OrderStatus"];
                       
                        
            ?>

                    <tr>
                        <td><?php echo $with["WithId"]; ?></td>
                        <td><?php echo $staff["StaffName"]; ?></td>
                        <td><?php echo $with["Qtysum"]; ?></td>
                        <td><?php echo $with["WithStatus"]; ?></td>
                        <td><?php echo $with["WithDate"]; ?></td>
                    <td>
                            <form method = "POST" action = "Approvedetaill.php?">
                                <button type = "submit" value = "<?php echo $with["WithId"]; ?>" name = "Approve" class = "btn btn-success"
                                    <?php
                                        if($withstatus == "อนุมัติสำเร็จ")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                        else if($withstatus == "ยกเลิก")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                       
                                    ?>
                                    >อนุมัติ
                                </button>
                            </form>
                    </td>
                    
                    <td>
                        <form method = "POST" action = "Reportwithdraw.php">
                            <button type = "submit" value = "<?php echo $with["WithId"]; ?>" name = "Report" class="btn btn-primary">รายงาน</button>
                            <input type ="hidden" name = "valueid" value = "<?php echo $with["WithId"]; ?>">
                        </form>
                    </td>

                    <td>
                            <form method = "POST" action = "Approve.php">
                                <button type = "submit" value = "<?php echo $with["WithId"]; ?>" name = "Cancel_id" class="btn btn-danger"
                                    <?php
                                        if($withstatus == "อนุมัติสำเร็จ")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                        else if($withstatus == "ยกเลิก")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                    ?>
                                    >ยกเลิก
                                </button>
                            </form>
                        </td>
                    
                  
                </tr>

                <?php } } ?>
            
            
        </tbody>
    </table>
</div>
<td>
    
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