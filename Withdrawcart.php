<?php
        include('connect.php');
        error_reporting(0);
        session_start();
      
        $MedId = $_REQUEST['testMedId'];
        $act = $_REQUEST['act'];
        $Quantity = $_REQUEST['quantity'];
        $LotId = $_REQUEST['valueid'];
        if($act=='add' && !empty($MedId) && !empty($LotId))
        {
            if(isset($_SESSION['withdraw'][$LotId]))
            { 
                $_SESSION['withdraw'][$LotId][2]+=(int)$Quantity;   
            }
            else
            {
                $_SESSION['withdraw'][$LotId][0]=$LotId;   
                $_SESSION['withdraw'][$LotId][1]=(int)$MedId;   
                $_SESSION['withdraw'][$LotId][2]=(int)$Quantity;  
            }
        }
     
        else if($act=='remove' && !empty($MedId) && !empty($LotId))
        {
            unset($_SESSION['withdraw'][$LotId]);
        }
     
        /*if($act=='update')
        {
            $price_array = $_POST['MedPrice'];
            foreach($price_array as $MedId=>$MedPrice)
            {
                $_SESSION['cart'][$MedId]=$MedPrice;
            }
        }*/

        // print_r($_SESSION['withdraw']);
        // echo '<pre>';

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
                $StaffId = $staff["StaffId"];
            }
        
      
    if (isset($_REQUEST['btn_withdraw'])) {
        if(empty($_SESSION['withdraw']))
        {
            $errorMsg = "ไม่มีสินค้า";
        }
        else
        {
            $i = 0;   
            $Lotid = $_REQUEST['LotId'];
            $sql ="SELECT * FROM tbl_receiveddetail WHERE $Lotid = LotId";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $Lot){
        
                $idmed = $Lot["MedId"];
                $sql ="SELECT * FROM tbl_med WHERE $idmed = MedId";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $med){}
                }
            
            date_default_timezone_set("Asia/Bangkok");
            $WithDate = date("d")."-".date("m")."-".(date("Y")+543);
            $WithStatus = "รออนุมัติ";
            
            if (empty($StaffId)) {
                $errorMsg = "Please Enter StaffId";
            }  else 
                {
                    if (!isset($errorMsg))
                    {
                        $sql = "INSERT INTO tbl_withdraw(StaffId, WithDate, WithStatus) VALUES ('$StaffId', '$WithDate', '$WithStatus')";
                        if ($conn->query($sql) === TRUE) { 
                        } else {
                            echo "Error updating record: " . $conn->error;
                        }
                                $query = "SELECT WithId FROM tbl_withdraw ORDER BY WithId  DESC LIMIT 1";
                                $result = mysqli_query($conn, $query); 
                                $row = mysqli_fetch_array($result);
                                $WithId  = $row["WithId"];

                                foreach($_SESSION['withdraw'] as $value)
                                {
                                $sql = 'SELECT * FROM tbl_lot WHERE LotId ='.$value[0].' and MedId = '.$value[1];

                                $result = $conn->query($sql);
                                $data = array();
                                
                                while($row = $result->fetch_assoc()) 
                                {
                                    $data[] = $row;  
                                }
                                foreach($data as $key => $lot)
                                {     
                                    $lotreserve = $lot["Reserve"];
                                    $Quantity = $value[2];  
                                    $sumReserve = $lotreserve + $Quantity; 
                                    $MedId = $lot["MedId"];
                                    $LotId = $lot["LotId"];
                                    $Mfd = $lot["Mfd"];
                                    $Exd = $lot["Exd"];
                                    
                                    $sql = "INSERT INTO tbl_withdrawdetail(WithId, MedId, LotId, Qty, Mfd, Exd) VALUES ('$WithId', '$MedId', '$LotId', '$Quantity', '$Mfd', '$Exd')";
                                
                                    if ($conn->query($sql) === TRUE) { unset($_SESSION['withdraw']);
                                    } else {
                                        echo "Error updating record: " . $conn->error;
                                    }
                                    $sql = "UPDATE tbl_lot SET Reserve = '$sumReserve' WHERE LotId = '$LotId'";
                                    if ($conn->query($sql) === TRUE) { 
                                    } else {
                                        echo "Error updating record: " . $conn->error;
                                    }
                                        $qty += $value[2];
    
                                    $sql = "UPDATE tbl_withdraw SET Qtysum = $qty WHERE WithId = $WithId"; 
                                    if ($conn->query($sql) === TRUE) { 
                                    } else {
                                        echo "Error updating record: " . $conn->error;
                                    }  
                                }$insertMsg = "เพิ่มข้อมูลสำเร็จ...";
                                header("refresh:1;main.php");                          
                        }     
                    }
                }  
            }  
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
            include('slidebar.php');
        ?>
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

    <form name="frmcart" method="post">
      <table width="600" border="0" align="center" class="square">
        <tr>
          <td colspan="5" bgcolor="#CCCCCC">
          <b>ตะกร้าสินค้า</span></td>
        </tr>
        <tr>
          <td bgcolor="#EAEAEA">รายการ</td>
          <td align="center" bgcolor="#EAEAEA">จำนวน</td>
          <td align="center" bgcolor="#EAEAEA">ลบ</td>
        </tr>
    <?php
    $total=0;
    if(!empty($_SESSION['withdraw']))
    {
    //    echo count($_SESSION['withdraw']);
        
        foreach($_SESSION['withdraw'] as $value)
        // echo "lot".$value[0] . "MedId" .$value[1] . "qty" . $value[2] . "<br>";
        {
            $sql = 'SELECT* FROM tbl_Med WHERE MedId='.$value[1];
		    $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
            $data[] = $row;  
            }
            echo $row;
            foreach($data as $key => $Med){
            echo "<tr>";
         
            echo "<td width='334'>" . $Med["MedName"] . "</td>";
            echo "<td width='57' align='right'>";  
            // echo "<input type='number'name=".$Med["MedId"]."value=".$value[2]." size='2'/></td>";
            echo "<input type ='number' name='".$Med["MedId"]."' value='".$value[2]."'disabled size='2'></td>"; 
            
            echo "<td width='46' align='center'><a href='Withdrawcart.php?testMedId=".$value[1]."&act=remove&quantity=0&valueid=".$value[0]."'>ลบ</a></td>";
            echo "</tr>";
            }
            echo "<tr>";
        }
    }
            echo "</tr>";
    ?>
    <tr>
        <td><a href="Lot.php" class="btn btn-success">ล็อตยา</a></td>
    </tr>
    </table>
                   
                            <div class="form-group text-center">
                                <div class="col-md-12 mt-3">
                                    <input type="submit" name = "btn_withdraw"class = "btn btn-info" value = "เบิก">
                                    <input type ="hidden" name = "LotId" value = "<?php echo $LotId;?>">
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