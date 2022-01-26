
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

    $staff =  $_SESSION['StaffName'];
    $sql = "SELECT* FROM tbl_staff WHERE StaffName = '$staff'";
    $result = $conn->query($sql);
    $data = array();
        while($row = $result->fetch_assoc()) 
        {
            $data[] = $row;  
        }
        foreach($data as $key => $staff){      
            $StaffId = $staff["StaffId"];
        }

    if (isset($_REQUEST['Received_id'])) {
        
            $id = $_REQUEST['Received_id'];
            $sql ="SELECT * FROM tbl_orderdetail WHERE $id = OrderId";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $Orderde)
            {
                $MedId = $Orderde["MedId"];
                $sqli ="SELECT * FROM tbl_med WHERE $MedId = MedId";
                $result = $conn->query($sqli);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $med){}

                $OrderId = $Orderde["OrderId"];
                $sql ="SELECT * FROM tbl_Order WHERE $OrderId = OrderId";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $Order){

                $DealerId = $Order["DealerId"];
                $sql ="SELECT * FROM tbl_dealer WHERE $DealerId = DealerId";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $Dealer){}
            
                }
        }

        
    }

    if (isset($_REQUEST['btn_received'])) {
        $i = 0;
        $orderid = $_REQUEST['txt_OrderId'];
        $sql ="SELECT * FROM tbl_orderdetail WHERE $orderid = OrderId";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) {
            $data[] = $row;   
        }
        foreach($data as $key => $Orderde)
        {
            
            $MedId = $Orderde["MedId"];
            $sqli ="SELECT * FROM tbl_med WHERE $MedId = MedId";
            $result = $conn->query($sqli);
            $data = array();
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                }
                foreach($data as $key => $med){

            $OrderId = $Orderde["OrderId"];
            $sql ="SELECT * FROM tbl_Order WHERE $OrderId = OrderId";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                }
                foreach($data as $key => $Order){

            $DealerId = $Order["DealerId"];
            $sql ="SELECT * FROM tbl_dealer WHERE $DealerId = DealerId";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                }
                foreach($data as $key => $Dealer){

                }
        
            }
        }
    }

        $OrderId = $_REQUEST['txt_OrderId'];
        date_default_timezone_set("Asia/Bangkok");
        $RecTime = date("Y-m-d h:i:sa");
        $RecDeli = $_REQUEST['txt_delivery'];
        $OrderStatus = "Received";
        $LotStatus = "Avialable";

         if (empty($OrderId)) {
            $errorMsg = "Please Enter Lot Id";
        } else if (empty($staff)) {
            $errorMsg = "Please Enter Received Name";
        }  else if (empty($RecDeli)) {
            $errorMsg = "กรุณาใสชื่อคนของ";
        }  else 

                if (!isset($errorMsg)) {

                    $sql = "INSERT INTO tbl_received(OrderId,StaffId,RecDate,RecDeli) VALUES ('$OrderId',  '$StaffId', '$RecTime', '$RecDeli')";
                    if ($conn->query($sql) === TRUE) {   
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }

                    $sql = "SELECT* FROM tbl_orderdetail WHERE OrderId=$orderid";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                    $data[] = $row;  
                    }
                    foreach($data as $key => $orderdetailid){
                    
                    }

                    $sql = "UPDATE tbl_order SET OrderStatus = 'Received' WHERE $OrderId=OrderId";
                    if ($conn->query($sql) === TRUE) {
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }

                    $orderid = $Orderde['OrderId'];
                    $sql = "SELECT* FROM tbl_orderdetail WHERE OrderId=$orderid";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                    $data[] = $row;  
                    }
                    foreach($data as $key => $orderdetailid){
                        
                        $MedId = $orderdetailid["MedId"];
                        $sqli ="SELECT * FROM tbl_med WHERE $MedId = MedId";
                        $result = $conn->query($sqli);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                        }
                        foreach($data as $key => $med){

                        $query = "SELECT RecId FROM tbl_received ORDER BY RecId DESC LIMIT 1";
                        $result = mysqli_query($conn, $query); 
                        $row = mysqli_fetch_array($result);
                        $RecId = $row["RecId"];

                        $Medexp = $med["MedExp"];

                        $MedQty = $orderdetailid["Qty"];
                        $MedTotal = $med["MedTotal"];
                        $MedSum = $MedQty + $MedTotal;
                        $MfdDate = $_REQUEST["mfd".$i];
                        $ExpDate = $_REQUEST["exd".$i];
                        $Reserve = 0;
                        $datemfd=date_create($MfdDate);
                        $dateexp=date_create($ExpDate);
                        $diff=date_diff($datemfd,$dateexp);
                        // echo $diff->format('%R%a');
                        
                        if($diff->format('%R%a')<=$Medexp)
                        {
                            $errorMsg ="กรุณาใส่วันหมดอายุให้มากกว่า ". $Medexp ;

                            $sql = "DELETE FROM tbl_received where RecId = '".$RecId."'";
                            if($conn->query($sql) == TRUE){}
                            else{}

                            $sql = "UPDATE tbl_order SET OrderStatus = 'Ordering' WHERE $OrderId=OrderId";
                            if ($conn->query($sql) === TRUE) {
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }
                            header("refresh:2;CheckOrder.php");
                        }else
                            if(!isset($errorMsg)) 
                            {
                                $sql = "INSERT INTO tbl_lot(Qty, MedId, LotStatus, Mfd, Exd, Reserve) VALUES ('$MedQty', '$MedId','$LotStatus','$MfdDate','$ExpDate','$Reserve')";
                                if ($conn->query($sql) === TRUE) { 
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }
            
                                $query = "SELECT LotId FROM tbl_lot ORDER BY LotId DESC LIMIT 1";
                                $result = mysqli_query($conn, $query); 
                                $row = mysqli_fetch_array($result);
                                $LotId = $row["LotId"];
        
                                $Qty = $orderdetailid["Qty"];
                                $sql = "INSERT INTO tbl_receiveddetail(RecId, LotId, MedId, Qty, Mfd, Exd) VALUES ('$RecId', '$LotId', '$MedId', '$Qty', '$MfdDate', '$ExpDate')";$i++;
                                if ($conn->query($sql) === TRUE) { 
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }

                                $sql = "UPDATE tbl_med SET MedTotal = '$MedSum' WHERE $MedId=MedId";
                                if ($conn->query($sql) === TRUE) {
                                    $insertMsg = "Insert Successfully...";
                                    header("refresh:1;lot.php");
                                } else {
                                  echo "Error updating record: " . $conn->error;
                                }
                                
                            }
                        }
                    }
                    
                }
                
        } //catch (PDOException $e) {
             //echo $e->getMessage();
                    
            

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
         if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>

    

        <form method="post" class="form-horizontal mt-5" name="myform">

        <div class="container">
            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">รายการ </label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_OrderId" class="form-control" value="<?php echo $Orderde["OrderId"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">วันที่สั่ง</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_OrderDate" class="form-control" value="<?php echo $Order["OrderDate"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">ชื่อตัวแทนจำหน่าย</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_DealerName" class="form-control" value="<?php echo $Dealer["DealerName"]; ?>" readonly>
                    </div>
                </div>
            </div>
            
            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">ที่อยู่ตัวแทนจำหน่าย</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_OrderDate" class="form-control" value="<?php echo $Dealer["DealerAddress"]; ?>" readonly>
                    </div>
                </div>
            </div>
         
            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">ชื่อคนส่งของ</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_delivery" class="form-control"  placeholder="กรุณาใส่ชื่อคนส่งของ..">
                    </div>
                </div>
            </div>

          
            <?php
                $i = 0;
                $orderid = $Orderde['OrderId'];
                $sql = "SELECT* FROM tbl_orderdetail WHERE OrderId=$orderid";
                $result = $conn->query($sql);
                $data = array();
                while($row = $result->fetch_assoc()) {
                $data[] = $row;  
                }
                foreach($data as $key => $orderdetailid){

                    $MedId = $orderdetailid["MedId"];
                    $sqli ="SELECT * FROM tbl_med WHERE $MedId = MedId";
                    $result = $conn->query($sqli);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                    }
                    
                    foreach($data as $key => $med){
                        
                   
            ?>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Name" class="col-sm-3 control-label">รูป</label>
                        <div class="col-sm-7">
                        <div> <?php echo '<img style = "width:325px;height:325px"  src="upload/'. $med["MedPath"]; ?>"> </div> 
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Name" class="col-sm-3 control-label">ชื่อยา</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_MedName" class="form-control" value="<?php echo $med["MedName"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine pack" class="col-sm-3 control-label">จำนวนต่อหีบห่อ</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["MedPack"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">ราคาต่อหีบห่อ</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedPrice" class="form-control" value="<?php echo $med["MedPrice"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">จำนวน</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Qty" class="form-control" value="<?php echo $orderdetailid["Qty"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">ราคา</label>
                    <div class="col-sm-7">
                        <input type="text" name="Price" class="form-control" value="<?php echo $orderdetailid["Price"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">วันผลิต</label>
                    <div class="col-sm-1">
                    <input type="date"  name="mfd<?php echo $i;?>"
                                        value="<?php echo date('Y-m-j'); ?>" required 
                                        min="2021-3-22" max="2030-12-31">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">วันหมดอายุ</label>
                    <div class="col-sm-1">
                    <input type="date"  name="exd<?php echo $i;?>"
                                        value="<?php echo date('Y-m-j'); ?>" required
                                        min="2021-3-22" max="2030-12-31">
                    </div>
                </div>
            </div>

            <?php
                $i++;}}
            ?>

            
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_received" class="btn btn-success" value="รับ">
                    <a href="CheckOrder.php" class="btn btn-danger">กลับ</a>
                </div>
            </div>
        </div>
            
        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>
