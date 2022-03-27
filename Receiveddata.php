
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
        $RecTime = date("d")."-".date("m")."-".(date("Y")+543);  
        $RecDeli = $_REQUEST['txt_delivery'];
        $OrderStatus = "Received";
        $LotStatus = "สามารถใช้งานได้";

         if (empty($OrderId)) {
            $errorMsg = "Please Enter Lot Id";
        } else if (empty($staff)) {
            $errorMsg = "Please Enter Received Name";
        }  else if (empty($RecDeli)) {
            $errorMsg = "กรุณาใสชื่อคนส่งของ";
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

                    $sql = "UPDATE tbl_order SET OrderStatus = 'รับสำเร็จ' WHERE $OrderId=OrderId";
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

                        $medpack = $med["MedPack"];
                        $medqty = $orderdetailid["Qty"];
                        $medsum = $medpack * $medqty;

                        // $MedQty = $orderdetailid["Qty"];
                        // $MedTotal = $med["MedTotal"];
                        // $MedSum = $MedQty * $MedTotal;

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

                            $sql = "UPDATE tbl_order SET OrderStatus = 'สั่งซื้อ' WHERE $OrderId=OrderId";
                            if ($conn->query($sql) === TRUE) {
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }
                            header("refresh:2;CheckOrder.php");
                        }else
                            if(!isset($errorMsg)) 
                            {
                                $sql = "INSERT INTO tbl_lot(Qty, MedId, LotStatus, Mfd, Exd, Reserve) VALUES ('$medsum', '$MedId','$LotStatus','$MfdDate','$ExpDate','$Reserve')";
                                if ($conn->query($sql) === TRUE) { 
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }
            
                                $query = "SELECT LotId FROM tbl_lot ORDER BY LotId DESC LIMIT 1";
                                $result = mysqli_query($conn, $query); 
                                $row = mysqli_fetch_array($result);
                                $LotId = $row["LotId"];
        
                                $Qty = $orderdetailid["Qty"];
                                $sql = "INSERT INTO tbl_receiveddetail(RecId, LotId, MedId, Qty, Mfd, Exd) VALUES ('$RecId', '$LotId', '$MedId', '$medsum', '$MfdDate', '$ExpDate')";$i++;
                                if ($conn->query($sql) === TRUE) { 
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }

                                $sql = "UPDATE tbl_med SET MedTotal = '$medsum' WHERE $MedId=MedId";
                                if ($conn->query($sql) === TRUE) {
                                  
                                } else {
                                  echo "Error updating record: " . $conn->error;
                                }
                                $insertMsg = "เพิ่มข้อมูลสำเร็จ...";
                                header("refresh:1;lot.php");
                            }
                        }
                    }
                    
                }
                
        } //catch (PDOException $e) {
             //echo $e->getMessage();
                    
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
    <link rel="stylesheet" href="js/datepicker.css">
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

    <div class="container-sm">
        <table class="table table-bordered">
            <div style='margin-bottom: 15px;'>
                    <h2>รับยา<h2>
            </div>
                <form method="post" class="form-horizontal mt-5" name="myform">

            <!-- <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="invoice-details">
                    <address>
                        <?php 
                            // echo "ใบสั่งซื้อที่ : " .$Orderde["OrderId"] . "<br>";
                            // echo "ตัวแทนจำหน่าย : " .$Dealer["DealerName"] . "<br>";
                            // echo "ที่อยู่ : " .$Dealer["DealerAddress"] . "<br>";
                            // echo "เบอร์โทรศัพท์ : ". $Dealer["DealerPhone"] . "<br>";
                            // echo "วันที่สั่ง ". $Order["OrderDate"] . "<br>";
                        ?>
                    </address>
                </div>
            </div> -->

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

                <thead>
                    <tr>
                        <th>รูป</th>
                        <th>ชื่อยา</th>
                        <th>จำนวนต่อหีบห่อ</th>
                        <th>ราตาต่อหีบห่อ</th>
                        <th>จำนวน</th>
                        <th>ราคา</th>    
                        <th>วันผลิต</td>
                        <th>วันหมดอายุ</td>            
                    </tr>
                </thead>
            
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

                <tr>        
                    <td><?php echo '<img src="upload/'.$med['MedPath'].'" height = "80" widht = "80"/>';?></td>
                    <td><?php echo $med["MedName"]; ?></td>
                    <td><?php echo $med["MedPack"]; ?></td>
                    <td><?php echo $med["MedPrice"]; ?></td>
                    <td><?php echo $orderdetailid["Qty"]; ?></td>
                    <td><?php echo $orderdetailid["Price"]; ?></td>
                    <td><input type="text" name="mfd<?php echo $i;?>" id="testdate5" value="<?php echo date("d")."-".date("m")."-".(date("Y")+543); ?>" style="width:100px;"></td>
                    <td><input type="text" name="exd<?php echo $i;?>" id="testdate6" value="<?php echo date("d")."-".date("m")."-".(date("Y")+543); ?>" style="width:100px;"></td>

                    <!-- <td><input type="date"  name="mfd<?php echo $i;?>"
                                            value="<?php echo date('Y-m-j'); ?>" required 
                                            min="2021-3-22" max="2030-12-31"></td>
                    <td><input type="date"  name="exd<?php echo $i;?>"
                                            value="<?php echo date('Y-m-j'); ?>" required
                                            min="2021-3-22" max="2030-12-31"></td> -->

                                            
                </tr>

                <?php
                    $i++;}}
                ?>
        </table>
    </div>

                <!-- <div class="form-group text-center">
                    <div class="row">
                        <label for="Medicine Price" class="col-sm-3 control-label">ชื่อคนส่งของ</label>
                        <div class="col-sm-3">
                            <input type="text" name="txt_delivery" class="form-control"  placeholder="กรุณาใส่ชื่อคนส่งของ..">
                        </div>
                    </div>
                </div>  -->
                      
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

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>  
    <script src="js/datepicker.js"></script>
    <script type="text/javascript">   
    $(function(){
        
        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
        
        // กรณีใช้แบบ inline
    /*  $("#testdate4").datetimepicker({
            timepicker:false,
            format:'d-m-Y',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000            
            lang:'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            inline:true  
        });    */   
        
        
        // กรณีใช้แบบ input
        $("#testdate5").datetimepicker({
            timepicker:false,
            format:'d-m-Y',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000            
            lang:'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            onSelectDate:function(dp,$input){
                var yearT=new Date(dp).getFullYear();  
                var yearTH=yearT+543;
                var fulldate=$input.val();
                var fulldateTH=fulldate.replace(yearT,yearTH);
                $input.val(fulldateTH);
            },
        });       
        // กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
        $("#testdate5").on("mouseenter mouseleave",function(e){
            var dateValue=$(this).val();
            if(dateValue!=""){
                    var arr_date=dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
                    // ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
                    //  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0 
                    if(e.type=="mouseenter"){
                        var yearT=arr_date[2]-543;
                    }       
                    if(e.type=="mouseleave"){
                        var yearT=parseInt(arr_date[2])+543;
                    }   
                    dateValue=dateValue.replace(arr_date[2],yearT);
                    $(this).val(dateValue);                                                 
            }       
        });

        $("#testdate6").datetimepicker({
            timepicker:false,
            format:'d-m-Y',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000            
            lang:'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            onSelectDate:function(dp,$input){
                var yearT=new Date(dp).getFullYear();  
                var yearTH=yearT+543;
                var fulldate=$input.val();
                var fulldateTH=fulldate.replace(yearT,yearTH);
                $input.val(fulldateTH);
            },
        });       
        // กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
        $("#testdate6").on("mouseenter mouseleave",function(e){
            var dateValue=$(this).val();
            if(dateValue!=""){
                    var arr_date=dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
                    // ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
                    //  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0 
                    if(e.type=="mouseenter"){
                        var yearT=arr_date[2]-543;
                    }       
                    if(e.type=="mouseleave"){
                        var yearT=parseInt(arr_date[2])+543;
                    }   
                    dateValue=dateValue.replace(arr_date[2],yearT);
                    $(this).val(dateValue);                                                 
            }       
        });
        
        
    });
    </script>


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