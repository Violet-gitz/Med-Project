
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
        $staff = $_REQUEST['RecName'];
        date_default_timezone_set("Asia/Bangkok");
        $RecTime = date("Y-m-d h:i:sa");
        $RecDeli = $_REQUEST['txt_delivery'];
        $OrderStatus = "Received";
        $LotStatus = "Avialable";

         if (empty($Claimid)) {
            $errorMsg = "Please Enter Lot Id";
        } else if (empty($staff)) {
            $errorMsg = "Please Enter Received Name";
        }  else if (empty($RecDeli)) {
            $errorMsg = "Please Enter Received Delivery";
        }  else 

                if (!isset($errorMsg)) {

                    $sql = "INSERT INTO tbl_recclaim(ClaimId,StaffId,RecClaimName,RecClaimdate) VALUES ('$Claimid',  '$staff', '$RecTime', '$RecDeli')";
                    if ($conn->query($sql) === TRUE) {   
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }

                    // $sql = "SELECT* FROM tbl_orderdetail WHERE OrderId=$orderid";
                    // $result = $conn->query($sql);
                    // $data = array();
                    // while($row = $result->fetch_assoc()) {
                    // $data[] = $row;  
                    // }
                    // foreach($data as $key => $orderdetailid){
                    
                    // }
                  
                    $sql = "UPDATE tbl_claim SET ClaimStatus = 'Received' WHERE ClaimId = $Claimid";
                    if ($conn->query($sql) === TRUE) {
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }

                    $query = "SELECT RecClaimid FROM tbl_recclaim ORDER BY RecClaimid DESC LIMIT 1";
                    $result = mysqli_query($conn, $query); 
                    $row = mysqli_fetch_array($result);
                    $RecClaimid = $row["RecClaimid"];

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
                        
                        if($diff->format('%R%a')<=30)
                        {
                            $errorMsg ="Error,Please enter a new expiration date. ";
                        }else
                            if(!isset($errorMsg)) 
                            {
                                $sql = "INSERT INTO tbl_lot(Qty, MedId,LotStatus,RecClaimid,Mfd,Exd) VALUES ('$MedQty', '$MedId','$LotStatus','$RecClaimid','$MfdDate','$ExpDate')";
                                if ($conn->query($sql) === TRUE) { 
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }

                                // $sql = "UPDATE tbl_lot SET LotStatus = 'Avialable',RecClaimid = $RecClaimid  WHERE LotId = $LotId";
                                // if ($conn->query($sql) === TRUE) { 
                                // } else {
                                //     echo "Error updating record: " . $conn->error;
                                // }

                                // $sql = "UPDATE tbl_receiveddetail SET Mfd = $MfdDate,Exd = $ExpDate  WHERE LotId = $LotId and MedId = $MedId";
                                // if ($conn->query($sql) === TRUE) { 
                                // } else {
                                //     echo "Error updating record: " . $conn->error;
                                // }
                                // $query = "SELECT LotId FROM tbl_lot ORDER BY LotId DESC LIMIT 1";
                                // $result = mysqli_query($conn, $query); 
                                // $row = mysqli_fetch_array($result);
                                // $LotId = $row["LotId"];
        
                                // $Qty = $orderdetailid["Qty"];
                                // $sql = "INSERT INTO tbl_receiveddetail(RecId, LotId, MedId, Qty, Mfd, Exd) VALUES ('$RecId', '$LotId', '$MedId', '$Qty', '$MfdDate', '$ExpDate')";
                                // if ($conn->query($sql) === TRUE) { 
                                // } else {
                                //     echo "Error updating record: " . $conn->error;
                                // }

                                $sql = "UPDATE tbl_med SET MedTotal = '$MedSum' WHERE $MedId=MedId";
                                if ($conn->query($sql) === TRUE) {
                                    
                                } else {
                                  echo "Error updating record: " . $conn->error;
                                }
                            }
                    
                    }
                    $updateMsg = "Record update successfully...";
                    header("refresh:1;main.php");
                }

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
            <h1 class="navbar-brand">Received Data</h1>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link"><?php echo $_SESSION['StaffName'] ?></a>                
                        </li> 

                        <li class ="nav-itm">
                            <a  onload="startTime()"></a>
                            <div id="time"></div>
                        </li> 
                        
                        <li class="nav-item">
                            <td><a href="index.php?logout='1'" class ="btn btn-warning">Logout</a></td>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

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

    

        <form method="post" class="form-horizontal mt-5" name="myform">

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Order Claim</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_ClaimId" class="form-control" value="<?php echo $Claim["ClaimId"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Order Claim Date</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_ClaimDate" class="form-control" value="<?php echo $Claim["ClaimDate"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Dealer Name</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_DealerName" class="form-control" value="<?php echo $Dealer["DealerName"]; ?>" readonly>
                    </div>
                </div>
            </div>
            
            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Dealer Address</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_DealerAddress" class="form-control" value="<?php echo $Dealer["DealerAddress"]; ?>" readonly>
                    </div>
                </div>
            </div>
        
            

            <div class="form-group text-center">
                <div class="row">
                    <label class="col-sm-3 control-label">Received Name</label>
                        <div class="col-sm-1">
                            <select name="RecName">       
                                <?php 
                                    $sql = 'SELECT * FROM tbl_staff';
                                    $result = $conn->query($sql);
                                    $data = array();
                                    while($row = $result->fetch_assoc()) 
                                        {
                                            $data[] = $row;   
                                        }
                                        foreach($data as $key => $staff){                  
                                ?>
                                    <option value ="<?php echo $staff["StaffId"];?>"><?php echo $staff["StaffName"];?></option>
                                <?php } ?>      
                            </select><br>
                        </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">Delivery name</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_delivery" class="form-control"  placeholder="Please enter delivery name..">
                    </div>
                </div>
            </div>

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

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Name" class="col-sm-3 control-label">Pictures</label>
                        <div class="col-sm-7">
                        <div> <?php echo '<img style = "width:325px;height:325px"  src="upload/'. $med["MedPath"]; ?>"> </div> 
                    </div>
                </div>
            </div>


            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Name" class="col-sm-3 control-label">Medicine</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_MedName" class="form-control" value="<?php echo $med["MedName"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine pack" class="col-sm-3 control-label">Unit/Pack</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["MedPack"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">Price/Pack</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedPrice" class="form-control" value="<?php echo $med["MedPrice"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">Quantity</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Qty" class="form-control" value="<?php echo $Claim["Qty"]; ?>" readonly>
                    </div>
                </div>
            </div>


            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">MFD Date</label>
                    <div class="col-sm-1">
                    <input type="date"  name="mfd1"
                                        value="<?php echo date('Y-m-j'); ?>" required 
                                        min="2021-3-22" max="2030-12-31">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">EXP Date</label>
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
                    <input type="submit" name="btn_receivedclaim" class="btn btn-success" value="Received">
                    <a href="CheckClaim.php" class="btn btn-danger">Back</a>
                </div>
            </div>

            
        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>
