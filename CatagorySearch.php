<?php
        include('connect.php');
        session_start();

        if (isset($_REQUEST['btn-Order'])) 
        {
            date_default_timezone_set("Asia/Bangkok");
            $OrderDate = date("d")."-".date("m")."-".(date("Y")+543);
            $OrderStatus = "Ordering";
            $OrderPrice = $_REQUEST['total'];
            $OrderTotal = ($OrderPrice * 0.07)+$OrderPrice;
            $DealerId = $_REQUEST['selDealer'];
            $StaffName = $_SESSION['StaffName'];
            
                if (empty($_SESSION['cart']))
                {
                $errorMsg = "Please Select Medicine";
                header("refresh:1;Medshow.php");
                }else 
                    if (!isset($errorMsg)) 
                    {
                        $sql = "INSERT INTO tbl_order(OrderDate, OrderStatus, OrderPrice, OrderTotal, DealerId, StaffName ) VALUES ('$OrderDate', '$OrderStatus', '$OrderPrice','$OrderTotal', '$DealerId', '$StaffName')";
                        if ($conn->query($sql) === TRUE) {} 
                        else {echo "Error updating record: " . $conn->error;}

                        foreach($_SESSION['cart'] as $MedId=>$Quantity)
                            {
                                $query = "SELECT OrderId FROM tbl_order ORDER BY OrderId DESC LIMIT 1";
                                $result = mysqli_query($conn, $query); 
                                $row = mysqli_fetch_array($result);
                                $OrderId = $row["OrderId"];

                                $sql ="SELECT * FROM tbl_med WHERE $MedId = MedId";
                                $result = $conn->query($sql);
                                $data = array();
                                while($row = $result->fetch_assoc()) 
                                {
                                    $data[] = $row;       
                                }
                                foreach($data as $key => $Med)
                                {
                                    $Medsum = $Quantity*$Med["MedPrice"];
                                    $sql = "INSERT INTO tbl_orderdetail(OrderId, MedId, Qty, Price) VALUES ('$OrderId', '$MedId', '$Quantity','$Medsum')";
                                    if ($conn->query($sql) === TRUE) {unset($_SESSION['cart']);} 
                                    else {echo "Error updating record: " . $conn->error;}
                                }
                            }
                            header("refresh:1;main.php");
                    }
        }

        if (isset($_REQUEST['submit'])) {
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
                        ; margin-left: 19em;" aria-hidden="true">  
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
                                
                            <li class="nav-item">
                                    <td><a href="Shipping.php" class ="btn btn-success">ตะกร้า</a></td>
                                </li>

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

<div class="container-sm">
    <div class="row mb-5">
            <div class="col-md-4 ms-auto " style="text-align: end;">
                <form action="CatagorySearch.php" method="post">
                    <input type="text" name="textsearch" placeholder = "ค้นหา">
                    <input type="submit" name="submit" value="ค้นหา">
                </form>
            </div>
    </div>


        <?php
            include('slidebar.php');
        ?>
    
    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    
    <?php 
         if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>

       
    <div class="container-sm">
    <h2>หน้ารายการสั่งซื้อ</h2>
    <table class="table table-striped" style="width:1500px; margin-left:-200px ; margin-top: 4rem;">
        <thead>
            <tr>
            <th>รูปภาพ</th>
                <th style="width:20%">ชื่อยา</th>
                <th style="width:15%">ประเภท</th>
                <th style="width:18%">หมวดหมู่</th>
                <th style="width:10%">ปริมาณ</th>
                <th style="width:15%">จำนวนต่อ(กล่อง)</th>
                <th style="width:15%">จำนวน(กล่อง)</th>
                <th>ซื้อสินค้า</th>              
            </tr>
        </thead>

        <tbody>
            <?php       
                    $sumReserve = 0; 
                               
                    $sql = "SELECT tbl_med.MedId,tbl_med.TypeId,tbl_med.CateId,tbl_med.VolumnId,tbl_med.UnitId,tbl_med.MedName,tbl_med.MedPack,tbl_med.MedPrice,tbl_med.MedDes,tbl_med.MedIndi,tbl_med.MedLow,tbl_med.MedTotal,tbl_med.MedPoint,tbl_med.MedPath,tbl_type.TypeName,tbl_cate.CateName,tbl_volumn.VolumnName,tbl_unit.UnitName
                    FROM tbl_med
                    INNER JOIN tbl_type ON tbl_type.TypeId = tbl_med.TypeId
                    INNER JOIN tbl_cate ON tbl_cate.CateId = tbl_med.CateId
                    INNER JOIN tbl_volumn ON tbl_volumn.VolumnId = tbl_med.VolumnId
                    INNER JOIN tbl_unit ON tbl_unit.UnitId = tbl_med.UnitId
                    WHERE MedName LIKE '%{$search}%' OR TypeName LIKE '%{$search}%' OR CateName LIKE '%{$search}%' OR VolumnName LIKE '%{$search}%' OR UnitName LIKE '%{$search}%'";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $Med){
            ?>
                <tr>
                    <form action = "Order.php" method="post">
                    <td><?php echo '<img src="upload/'.$Med['MedPath'].'" height = "80" widht = "80"/>';?></td>
                    <td><?php echo $Med["MedName"]; ?></td>
                    <td><?php echo $Med["TypeName"]; ?></td>
                    <td><?php echo $Med["CateName"]; ?></td>
                    <td><?php echo $Med["VolumnName"]; ?></td>
                    <td><?php echo $Med["MedPack"] ." ". $Med["UnitName"]; ?></td>
                    <td><input type="number" name="quantity" min="<?php echo $Med["MedLow"]; ?>" max="1000" value= "<?php echo $Med["MedLow"]; ?>"></p></td>
                                <input type ="hidden" name = "MedId" value = "<?php echo $Med["MedId"];?>">
                                <input type ="hidden" name = "act" value = "add">

                                <td><input type="submit" class = "btn btn-info" value = "เพิ่มสินค้า"> </td>
                    </form>
                </tr>

                <?php } ?>
            
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