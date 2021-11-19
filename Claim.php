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

    if (isset($_REQUEST['Claim'])) {
        
            $id = $_REQUEST['Claim'];
            $sql = 'SELECT * FROM tbl_receiveddetail WHERE LotId ='.$id;;
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $Recde)
            {

                $idmed = $Recde["MedId"];
                $sql ="SELECT * FROM tbl_med WHERE MedId = $idmed";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $med){

                $idrec = $Recde["RecId"];
                $sql ="SELECT * FROM tbl_received WHERE RecId = $idrec";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $Rec){

                    $idorder = $Rec["OrderId"];
                    $sql ="SELECT * FROM tbl_order WHERE OrderId = $idorder";
                    $result = $conn->query($sql);
                    $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $Order){
        
                            $dealerid = $Order["DealerId"];
                            $sql ="SELECT * FROM tbl_dealer WHERE $dealerid = DealerId";
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
        }
    }

    if (isset($_REQUEST['btn-Claim'])) {

        $idlot = $_REQUEST['txt_Lot'];
        $sql ="SELECT * FROM tbl_receiveddetail WHERE LotId = $idlot";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) {
            $data[] = $row;   
        }
        foreach($data as $key => $Recde)

        {
            $idmed = $Recde["MedId"];
            $sql ="SELECT * FROM tbl_med WHERE $idmed = MedId";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                }
                foreach($data as $key => $med){

                    $idrec = $Recde["RecId"];
                    $sql ="SELECT * FROM tbl_order WHERE $idorder = OrderId";
                    $result = $conn->query($sql);
                    $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $Rec){
        

                $idorder = $Rec["OrderId"];
                $sql ="SELECT * FROM tbl_order WHERE $idorder = OrderId";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $Order){
    
                        $dealerid = $Order["DealerId"];
                        $sql ="SELECT * FROM tbl_dealer WHERE $dealerid = DealerId";
                        $result = $conn->query($sql);
                        $data = array();
                            while($row = $result->fetch_assoc()) {
                                $data[] = $row;   
                            }
                            foreach($data as $key => $Dealer){}
                        
                }
            }
        }
        }
        date_default_timezone_set("Asia/Bangkok");
        $ClaimDate = date("Y-m-d h:i:sa");
        $StaffId = $_REQUEST['selstaff'];
        $Qty = $_REQUEST['txt_Total'];
        $DealerId = $Order["DealerId"];
        $Reason = $_REQUEST['txt_Reason'];
        $Total = $med["MedTotal"];
        $Medqty = $Recde["Qty"];
        
        
        $result = $Total-$Qty;

        $Totalrec = $Recde["Qty"];
        $sum = $Totalrec-$Qty;
        
        $status = "Claim";
        
        if (empty($Reason)) {
            $errorMsg = "Please Enter Reason";
        }  else {
            
                if (!isset($errorMsg)) {
                    
                    $sql = "INSERT INTO tbl_claim(LotId, StaffId, DealerId, MedId, Qty, Reason, ClaimDate, ClaimStatus) VALUES ('$idlot', '$StaffId', '$DealerId', '$idmed', '$Qty', '$Reason', '$ClaimDate', '$status')";
                    if ($conn->query($sql) === TRUE) {
                        
                    } else {
                      echo "Error updating record: " . $conn->error;
                    }

                    $sql = "UPDATE tbl_med set MedTotal = '$result' WHERE $idmed=MedId";
                    if ($conn->query($sql) === TRUE) {
                        
                    } else {
                      echo "Error updating record: " . $conn->error;
                    }

                    $sql = "UPDATE tbl_lot set Qty = '$sum' WHERE $idlot =LotId";
                    if ($conn->query($sql) === TRUE) {
                        
                    } else {
                      echo "Error updating record: " . $conn->error;
                    }

                    $sql = "UPDATE tbl_lot set LotStatus = '$status' WHERE $idlot =LotId";
                    if ($conn->query($sql) === TRUE) {
                        
                    } else {
                      echo "Error updating record: " . $conn->error;
                    }

                    
                   
                }
            } 
            header("refresh:1;main.php");
        }
    
    
   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

        <!-- <script>
            
                function display_ct6() 
                    {
                        var x = new Date()
                        var ampm = x.getHours( ) >= 12 ? ' PM' : ' AM';
                        hours = x.getHours( ) % 12;
                        hours = hours ? hours : 12;
                        var x1=x.getMonth() + 1+ "/" + x.getDate() + "/" + x.getFullYear(); 
                        x1 = x1 + " - " +  hours + ":" +  x.getMinutes() + ":" +  x.getSeconds() + ":" + ampm;
                        document.getElementById('Time').value = x1;
                        display_c6();
                        }
                        function display_c6(){
                        var refresh=1000; // Refresh rate in milli seconds
                        mytime=setTimeout('display_ct6()',refresh)
                    }
                    display_c6()

        </script> -->
    
    
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

    
    
        <form method="post" class="form-horizontal mt-5" name="myform">

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Lot</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_Lot" class="form-control" value="<?php echo $Recde["LotId"]; ?>" readonly>
                    </div>
                </div>
            </div>
        
            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Medicine</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_MedName" class="form-control" value="<?php echo $med["MedName"]; ?>" readonly>
                    </div>
                </div>
            </div>
            

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Category" class="col-sm-3 control-label">Category</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedCate" class="form-control" value="<?php echo $med["MedCate"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Volumn" class="col-sm-3 control-label">Volumn</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedVolumn" class="form-control" value="<?php echo $med["MedVolumn"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Unit" class="col-sm-3 control-label">Unit</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedUnit" class="form-control" value="<?php echo $med["MedUnit"]; ?>" readonly>
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
                    <label for="Medicine Price" class="col-sm-3 control-label">Total/Pack</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Total" class="form-control" value="<?php echo $Recde["Qty"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">Dealer Name</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Name" class="form-control" value="<?php echo $Dealer["DealerName"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">Dealer Address</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Address" class="form-control" value="<?php echo $Dealer["DealerAddress"]; ?>" readonly>
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

            <div class="form-group text-center">
                <div class="row">
                    <label for="Reason" class="col-sm-3 control-label">Reason</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Reason" class="form-control" value="">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn-Claim" class="btn btn-success" value="Claim">
                    <a href="Lot.php" class="btn btn-danger">Back</a>
                </div>
            </div>

            

        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>