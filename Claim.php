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
                    $sql ="SELECT * FROM tbl_received WHERE $idrec = OrderId";
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
                    }}}
     
        date_default_timezone_set("Asia/Bangkok");
        $ClaimDate = date("Y-m-d h:i:sa");
        $Qty = $_REQUEST["txt_qty"];
        $DealerId = $_REQUEST["txt_derler"];
        $Reason = $_REQUEST['txt_reason'];
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
            $insertMsg = "Insert Successfully...";
            header("refresh:1;main.php");
        }
    }


    if (isset($_REQUEST['btn-Claiming'])) {

        $idlot = $_REQUEST['txt_Lot'];
        $sql ="SELECT * FROM tbl_lot WHERE LotId = $idlot";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) {
            $data[] = $row;   
        }
        foreach($data as $key => $lot)

        $recclaimid = $lot["RecClaimid"];
        $sql ="SELECT * FROM tbl_recclaim WHERE $recclaimid = RecClaimid";
        $result = $conn->query($sql);
        $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $recclaim){

        {
            $ClaimId = $recclaim["ClaimId"];
            $sql ="SELECT * FROM tbl_claim WHERE $ClaimId = ClaimId";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                }
                foreach($data as $key => $Claim){

                    $idmed = $Claim["MedId"];
                    $sql ="SELECT tbl_med.MedId,tbl_med.TypeId,tbl_med.CateId,tbl_med.VolumnId,tbl_med.UnitId,tbl_med.MedName,tbl_med.MedPack,tbl_med.MedPrice,tbl_med.MedDes,tbl_med.MedIndi,tbl_med.MedExp,tbl_med.MedLow,tbl_med.MedTotal,tbl_med.MedPoint,tbl_med.MedPath,tbl_type.TypeName,tbl_cate.CateName,tbl_volumn.VolumnName,tbl_unit.UnitName
                    FROM tbl_med
                    INNER JOIN tbl_type ON tbl_type.TypeId = tbl_med.TypeId
                    INNER JOIN tbl_cate ON tbl_cate.CateId = tbl_med.CateId
                    INNER JOIN tbl_volumn ON tbl_volumn.VolumnId = tbl_med.VolumnId
                    INNER JOIN tbl_unit ON tbl_unit.UnitId = tbl_med.UnitId
                    WHERE tbl_med.MedId = $idmed";
                    $result = $conn->query($sql);
                    $data = array();
                        while($row = $result->fetch_assoc()) 
                        {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $med){}
            }
        }
     
        date_default_timezone_set("Asia/Bangkok");
        $ClaimDate = date("Y-m-d h:i:sa");
        $Qty = $_REQUEST["txt_qty1"];
        $DealerId = $_REQUEST["txt_derler1"];
        $Reason = $_REQUEST['txt_reason1'];
        $Total = $med["MedTotal"];
        $Medqty = $Claim["Qty"];
                
        $result = $Total-$Qty;

        $Totalrec = $Claim["Qty"];
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
            $insertMsg = "Insert Successfully...";
            header("refresh:1;main.php");
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
                  <a href="main.php" class="navbar-brand">Home Page</a>
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
                                            <a class="dropdown-item" href="Staffedit.php?update_id=<?php echo $staff["StaffId"];?>">Edit</a>
                                            <input type="hidden" name ='update_id' value ="<?php echo $staff["StaffId"]; ?>">
                                        </from>

                                        <form method="POST" action="index.php">
                                            <a class="dropdown-item" href="index.php?logout='1'">Logout</a>
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


    <?php
         if (isset($_REQUEST['Claim'])) {
        
            $id = $_REQUEST['Claim'];
            $sql = 'SELECT * FROM tbl_lot WHERE LotId ='.$id;
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $lot)
            {
                $checkclaim = $lot["RecClaimid"];
                $medid = $lot["MedId"];

                $sqli ="SELECT tbl_med.MedId,tbl_med.TypeId,tbl_med.CateId,tbl_med.VolumnId,tbl_med.UnitId,tbl_med.MedName,tbl_med.MedPack,tbl_med.MedPrice,tbl_med.MedDes,tbl_med.MedIndi,tbl_med.MedExp,tbl_med.MedLow,tbl_med.MedTotal,tbl_med.MedPoint,tbl_med.MedPath,tbl_type.TypeName,tbl_cate.CateName,tbl_volumn.VolumnName,tbl_unit.UnitName
                FROM tbl_med
                INNER JOIN tbl_type ON tbl_type.TypeId = tbl_med.TypeId
                INNER JOIN tbl_cate ON tbl_cate.CateId = tbl_med.CateId
                INNER JOIN tbl_volumn ON tbl_volumn.VolumnId = tbl_med.VolumnId
                INNER JOIN tbl_unit ON tbl_unit.UnitId = tbl_med.UnitId
                WHERE tbl_med.MedId = $medid;";
                $result = $conn->query($sqli);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $med)
                    {

                     if(is_null($checkclaim))
                     {    
                         $sqli ="SELECT * FROM tbl_receiveddetail WHERE LotId = $id";
                         $result = $conn->query($sqli);
                         $data = array();
                             while($row = $result->fetch_assoc()) {
                                 $data[] = $row;   
                             }
                             foreach($data as $key => $recedetail)
                             {
                                 $recid = $recedetail["RecId"];
     
                                 $sql ="SELECT * FROM tbl_received WHERE RecId = $recid";
                                 $result = $conn->query($sql);
                                 $data = array();
                                     while($row = $result->fetch_assoc()) {
                                         $data[] = $row;   
                                     }
                                     foreach($data as $key => $rec)
                                     {
                                         
                                         $orderid = $rec["OrderId"];
                                         $sql ="SELECT * FROM tbl_order WHERE OrderId = $orderid";
                                         $result = $conn->query($sql);
                                         $data = array();
                                             while($row = $result->fetch_assoc()) {
                                                 $data[] = $row;   
                                             }
                                             foreach($data as $key => $Order)
                                             {
     
                                                 $DealerId = $Order["DealerId"];
                                                 $sql ="SELECT * FROM tbl_dealer WHERE $DealerId = DealerId";
                                                 $result = $conn->query($sql);
                                                 $data = array();
                                                     while($row = $result->fetch_assoc()) {
                                                         $data[] = $row;   
                                                     }
                                                     foreach($data as $key => $Dealer)
                                                     {

            echo '<form method="post" class="form-horizontal mt-5" name="myform">';
            echo '<input type="hidden" name="txt_derler" value="'.$Dealer["DealerId"].'">';
            
            echo '<div class="container">';
            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label"></label>';
            echo            '<div class="col-sm-7">';
            echo '<div><img style = "width:325px;height:325px"  src="upload/'. $med["MedPath"].'"</div>';
            echo            '</div>';
            echo    '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Lot</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_Lot" class="form-control" value="'.$lot["LotId"].'" readonly>';
            echo            '</div>';
            echo    '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Medicine</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_MedName" class="form-control" value="'.$med["MedName"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';
            
            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Type</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_Type" class="form-control" value="'.$med["TypeName"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';
            
            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Catagory</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_Cate" class="form-control" value="'.$med["CateName"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';
             
            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Volumn</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_vol" class="form-control" value="'.$med["VolumnName"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';   
            
            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Unit</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_unit" class="form-control" value="'.$med["UnitName"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';
 
            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Unit/Pack</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_unit" class="form-control" value="'.$med["MedPack"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Quantity</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_qty" class="form-control" value="'.$lot["Qty"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Dealer Name </label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Dealer["DealerName"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Dealer Address</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Dealer["DealerAddress"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Dealer Phone</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Dealer["DealerPhone"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Delivery name</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$rec["RecDeli"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Reason</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_reason" class="form-control" value="">';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">';
            echo    '<div class="col-md-12 mt-3">';
            echo        '<input type="submit" name="btn-Claim" class="btn btn-success" value="Claim">';    
            echo            '<a href="Lot.php" class="btn btn-danger">Back</a>';
            echo    '</div>';
            echo '</div>';

            echo '</div>';
            
            echo '</form>';
                                                    }                                    
                                            }   
                                    }
                            }
                    }

            else if(!empty($checkclaim))
            {
                $sql ="SELECT * FROM tbl_recclaim WHERE $checkclaim = RecClaimid";
                $result = $conn->query($sql);
                $data = array();
                while($row = $result->fetch_assoc()) {
                $data[] = $row;   
                }
                foreach($data as $key => $recclaim)
                {
                    $claimid = $recclaim["ClaimId"];
                    $sql ="SELECT * FROM tbl_claim WHERE $claimid = ClaimId";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                    }
                    foreach($data as $key => $claim)
                    {
                        $dealerid = $claim["DealerId"];

                        $sql ="SELECT * FROM tbl_dealer WHERE $dealerid = DealerId";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                        }
                        foreach($data as $key => $Dealer)
                        { 

            echo '<form method="post" class="form-horizontal mt-5" name="myform">';
            echo '<input type="hidden" name="txt_derler1" value="'.$Dealer["DealerId"].'">';
            
            echo '<div class="container">';
            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label"></label>';
            echo            '<div class="col-sm-7">';
            echo '<div><img style = "width:325px;height:325px"  src="upload/'. $med["MedPath"].'"</div>';
            echo            '</div>';
            echo    '</div>';

            echo '<div class="container">';
            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Lot</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_Lot" class="form-control" value="'.$lot["LotId"].'" readonly>';
            echo            '</div>';
            echo    '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Medicine</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_Med" class="form-control" value="'.$med["MedName"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';
            
            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Type</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_Type" class="form-control" value="'.$med["TypeName"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';
            
            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Catagory</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_Cate" class="form-control" value="'.$med["CateName"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';
            
            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Volumn</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_vol" class="form-control" value="'.$med["VolumnName"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';   
            
            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Unit</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_unit" class="form-control" value="'.$med["UnitName"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Unit/Pack</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_unit" class="form-control" value="'.$med["MedPack"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';
            
            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Quantity</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_qty1" class="form-control" value="'.$lot["Qty"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Dealer Name </label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Dealer["DealerName"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Dealer Address</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Dealer["DealerAddress"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Dealer Phone</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Dealer["DealerPhone"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Delivery name</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$recclaim["RecClaimdate"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Reason</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_reason1" class="form-control" value="">';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">';
            echo    '<div class="col-md-12 mt-3">';
            echo        '<input type="submit" name="btn-Claiming" class="btn btn-success" value="Claim">';    
            echo            '<a href="Lot.php" class="btn btn-danger">Back</a>';
            echo    '</div>';
            echo '</div>';

            echo '</div>';
            
            echo '</form>';
                        }
                    }
                }

            }
                        }
                    }
                }
    ?>

    

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>