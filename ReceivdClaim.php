
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
            $staffid = $staff["StaffId"];
        }

    if (isset($_REQUEST['Claim_id'])) {
        
            $id = $_REQUEST['Claim_id'];
            $sql ="SELECT * FROM tbl_claim WHERE ClaimId = $id";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $Claim)
            {
                $MedId = $Claim["MedId"];
                $sqli ="SELECT * FROM tbl_med WHERE MedId = $MedId";
                $result = $conn->query($sqli);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $med){}


                $DealerId = $Claim["DealerId"];
                $sql ="SELECT * FROM tbl_dealer WHERE $DealerId = DealerId";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $Dealer){}
            
                }
        }

    if (isset($_REQUEST['btn_receivedclaim'])) {
    
        $Claimid = $_REQUEST['txt_ClaimId'];
        $sql ="SELECT * FROM tbl_claim WHERE ClaimId = $Claimid";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) {
            $data[] = $row;   
        }
        foreach($data as $key => $Claim)
        {
            
            $MedId = $Claim["MedId"];
            $sqli ="SELECT * FROM tbl_med WHERE $MedId = MedId";
            $result = $conn->query($sqli);
            $data = array();
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                }
                foreach($data as $key => $med){


            $DealerId = $Claim["DealerId"];
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

        $Claimid = $_REQUEST['txt_ClaimId'];
        date_default_timezone_set("Asia/Bangkok");
        $RecTime = date("Y-m-d h:i:sa");
        $RecDeli = $_REQUEST['txt_delivery'];
        $OrderStatus = "Received";
        $LotStatus = "Avialable";

         if (empty($Claimid)) {
            $errorMsg = "Please Enter Lot Id";
        }else if (empty($RecDeli)) {
            $errorMsg = "กรุณาใส่ชื่อคนส่งของ";
        }else 

                if (!isset($errorMsg)) {

                    $sql = "INSERT INTO tbl_recclaim(ClaimId,StaffId,RecClaimName,RecClaimdate) VALUES ('$Claimid',  '$staffid', '$RecTime', '$RecDeli')";
                    if ($conn->query($sql) === TRUE) {   
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }          
                  
                    $sql = "UPDATE tbl_claim SET ClaimStatus = 'Received' WHERE ClaimId = $Claimid";
                    if ($conn->query($sql) === TRUE) {
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }

                    $query = "SELECT RecClaimid FROM tbl_recclaim ORDER BY RecClaimid DESC LIMIT 1";
                    $result = mysqli_query($conn, $query); 
                    $row = mysqli_fetch_array($result);
                    $RecClaimid = $row["RecClaimid"];

                        $Medexp = $med["MedExp"];
                        $Reserve = '0';
                        $LotId = $Claim["LotId"];
                        $MedQty = $Claim["Qty"];
                        $MedTotal = $med["MedTotal"];
                        $MedSum = $MedQty + $MedTotal;
                        $MfdDate = $_REQUEST["mfd1"];
                        $ExpDate = $_REQUEST["exd1"];
                        $datemfd=date_create($MfdDate);
                        $dateexp=date_create($ExpDate);
                        $diff=date_diff($datemfd,$dateexp);
                        // echo $diff->format('%R%a');
                        
                        if($diff->format('%R%a')<=$Medexp)
                        {
                            $errorMsg ="กรุณาใส่วันหมดอายุให้มากกว่า ". $Medexp;

                            $sql = "DELETE FROM tbl_recclaim where RecClaimid = '".$RecClaimid."'";
                            if($conn->query($sql) == TRUE){}
                            else{}

                            $sql = "UPDATE tbl_claim SET ClaimStatus = 'Claim' WHERE $Claimid=Claimid";
                            if ($conn->query($sql) === TRUE) {
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }
                            header("refresh:2;CheckClaim.php");
                        }else
                            if(!isset($errorMsg)) 
                            {
                                $sql = "INSERT INTO tbl_lot(Qty, MedId,LotStatus,RecClaimid,Mfd,Exd,Reserve) VALUES ('$MedQty','$MedId','$LotStatus','$RecClaimid','$MfdDate','$ExpDate','$Reserve')";
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
       
        <?php
                    $MedId = $Claim["MedId"];
                    $sqli ="SELECT * FROM tbl_med WHERE $MedId = MedId";
                    $result = $conn->query($sqli);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                    }
                    
                    foreach($data as $key => $med){
                        
                   
            ?>

        <div class="container">    
            
            <div class="form-group text-center">
                    <div class="row">
                        <label for="Medicine Name" class="col-sm-3 control-label"></label>
                            <div class="col-sm-7">
                            <div> <?php echo '<img style = "width:325px;height:325px"  src="upload/'. $med["MedPath"]; ?>"> </div> 
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">รายการเคลม</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_ClaimId" class="form-control" value="<?php echo $Claim["ClaimId"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">วันที่เคลม</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_ClaimDate" class="form-control" value="<?php echo $Claim["ClaimDate"]; ?>" readonly>
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
                            <input type="text" name="txt_DealerAddress" class="form-control" value="<?php echo $Dealer["DealerAddress"]; ?>" readonly>
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
                    <label for="Medicine pack" class="col-sm-3 control-label">จำนวนต่อหนึ่งหีบห่อ</label>
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
                        <input type="text" name="txt_Qty" class="form-control" value="<?php echo $Claim["Qty"]; ?>" readonly>
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


            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">วันผลิต</label>
                    <div class="col-sm-1">
                    <input type="date"  name="mfd1"
                                        value="<?php echo date('Y-m-j'); ?>" required 
                                        min="2021-3-22" max="2030-12-31">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">วันหมดอายุ</label>
                    <div class="col-sm-1">
                    <input type="date"  name="exd1"
                                        value="<?php echo date('Y-m-j'); ?>" required
                                        min="2021-3-22" max="2030-12-31">
                    </div>
                </div>
            </div>

            <?php
                }
            ?>

            
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_receivedclaim" class="btn btn-success" value="รัย">
                    <a href="CheckClaim.php" class="btn btn-danger">กลับ</a>
                </div>
            </div>
        </div>
            
        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>
