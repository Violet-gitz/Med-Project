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

    if (isset($_REQUEST['withdraw'])) {
                
            $Lotid = $_REQUEST['withdraw'];
            $sql = "SELECT* FROM tbl_receiveddetail WHERE LotId=$Lotid";
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
                    foreach($data as $key => $med){
                    }
    
                $idrec = $Lot["RecId"];
                $sql ="SELECT * FROM tbl_received WHERE $idrec = RecId";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $rec){
                }
        }
    }

    if (isset($_REQUEST['btn_withdraw'])) {
        $i = 0;   
        $Lotid = $_REQUEST['txt_LotId'];
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
        $StaffId = $_REQUEST['selstaff'];
        date_default_timezone_set("Asia/Bangkok");
        $WithDate = date("Y-m-d h:i:sa");
        
        
         if (empty($StaffId)) {
            $errorMsg = "Please Enter StaffId";
        }  else {
                if (!isset($errorMsg)) {
                    
                    $sql = "INSERT INTO tbl_withdraw(StaffId, WithDate) VALUES ('$StaffId', '$WithDate')";
                    if ($conn->query($sql) === TRUE) { 
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                
                    $sql = "SELECT* FROM tbl_receiveddetail WHERE LotId=$Lotid";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                    $data[] = $row;  
                    }
                    foreach($data as $key => $Rec){

                    $query = "SELECT WithId FROM tbl_withdraw ORDER BY WithId  DESC LIMIT 1";
                    $result = mysqli_query($conn, $query); 
                    $row = mysqli_fetch_array($result);
                    $WithId  = $row["WithId"];

                        $MedId = $_REQUEST["MedId".$i];
                        $LotId = $Rec["LotId"];
                        $QTY = $_REQUEST["qty".$i];
                        $Mfd = $Rec["Mfd"];
                        $Exd = $Rec["Exd"];
                        
                        $sql = "INSERT INTO tbl_withdrawdetail(WithId, MedId, LotId, Qty, Mfd, Exd) VALUES ('$WithId', '$MedId', '$LotId', '$QTY', '$Mfd', '$Exd')";
                        $i++;
                       
                        if ($conn->query($sql) === TRUE) { 
                        } else {
                            echo "Error updating record: " . $conn->error;
                        }
                        // header("refresh:1;main.php");
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
    
    
</head>

<body>

        <?php
            include('slidebar.php');
        ?>


<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
            <h1 class="navbar-brand">Medicine Withdraw</h1>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link"><?php echo $_SESSION['StaffName'] ?></a>                
                        </li>  
                        
                        
                        <li class="nav-item">
                            <td><a href="index.php?logout='1'" class ="btn btn-warning">Logout</a></td>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


      


    
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

    
    
    
    <form method="post" class="form-horizontal mt-5" enctype="multipart/form-data">

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Lot Id</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_LotId" class="form-control" value="<?php echo $Lot["LotId"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Received Id</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_RedId" class="form-control" value="<?php echo $Lot["RecId"]; ?>" readonly>
                    </div>
                </div>
            </div>
        
            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Received Date</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_RecDate" class="form-control" value="<?php echo $rec["RecDate"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Received Name</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_RecName" class="form-control" value="<?php echo $rec["RecDeli"]; ?>" readonly>
                    </div>
                </div>
            </div>

            
            <div class="form-group text-center">
                        <div class="row">
                            <label class="col-sm-3 control-label">Staff</label>
                                <div class="col-sm-1">
                                    <select name="selstaff">       
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

                    <?php
                $i = 0;
                $Lotid = $Lot["LotId"];
                $sql = "SELECT* FROM tbl_orderdetail WHERE OrderId=$Lotid";
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
                        <input type="text" name="txt_Qty" class="form-control" value="<?php echo $orderdetailid["Qty"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">Quantity</label>
                    <div class="col-sm-7">
                        <input type="number" name="qty<?php echo $i; ?>" class="form-control" value="0" min = "0" max = "<?php echo $orderdetailid["Qty"]; ?>" >
                    </div>
                </div>
            </div>

            <input type ="hidden" name = "MedId<?php echo $i; ?>" value = "<?php echo $med["MedId"];?>">

            <?php
                $i++;}}
            ?>

            
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_withdraw" class="btn btn-success" value="Withdraw">
                    <a href="Lot.php" class="btn btn-danger">Back</a>
                </div>
            </div>

            
        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>