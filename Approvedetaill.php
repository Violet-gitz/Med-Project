
<?php 
     include('Connect.php'); 
     

    session_start();
    error_reporting(0);
    
    
    if (!isset($_SESSION['StaffName'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['StaffName']);
        header('location: login.php');
    }

    if (isset($_REQUEST['Approve'])) {
                
            $withid = $_REQUEST['Approve'];
            $sql = "SELECT* FROM tbl_withdraw WHERE WithId=$withid";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
            $data[] = $row;  
            }
            foreach($data as $key => $With){
            
            
                $idwith = $With["WithId"];
                $sql ="SELECT * FROM tbl_withdrawdetail WHERE WithId = $idwith";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $withde){
                    }
    
                    $staffid = $With["StaffId"];
                    $sql = "SELECT * FROM tbl_staff WHERE StaffId = $staffid";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $Staff){}
        }
    }

    if (isset($_REQUEST['btn_approve'])) {

        $WithId = $_REQUEST['txt_WithId'];

        $sql = "SELECT* FROM tbl_withdraw WHERE WithId=$WithId";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) {
        $data[] = $row;  
        }
        foreach($data as $key => $With){
        
            $idwith = $With["WithId"];
            $sql ="SELECT * FROM tbl_withdrawdetail WHERE WithId = $idwith";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                }
                foreach($data as $key => $withde)
                {
                    $lotid = $withde["LotId"];

                    $sql ="SELECT * FROM tbl_lot WHERE LotId = $lotid";
                    $result = $conn->query($sql);
                    $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $lot)
                        {
                            $lotqty = $lot["Qty"];
                            $withqty = $withde["Qty"];
                            $Reserve = $lot["Reserve"];
                            $sum = $Reserve - $withqty;
                            $qtysum = $lotqty - $withqty;

                            $sql = "UPDATE tbl_lot SET Qty = $qtysum , Reserve = $sum WHERE LotId = $lotid"; 
                            if ($conn->query($sql) === TRUE) { 
                            } else {
                            echo "Error updating record: " . $conn->error;
                            }
                        
                        }

                    $MedId = $withde["MedId"];

                    $sql ="SELECT * FROM tbl_med WHERE MedId = $MedId";
                    $result = $conn->query($sql);
                    $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $med)
                        {
                            $Medqty = $med["MedTotal"];
                            $withqty = $withde["Qty"];
                            $Medsum = $Medqty - $withqty;

                            $sql = "UPDATE tbl_med SET MedTotal = $Medsum WHERE MedId = $MedId"; 
                            if ($conn->query($sql) === TRUE) { 
                            } else {
                            echo "Error updating record: " . $conn->error;
                            }
                        }

                }

                    $sql = "UPDATE tbl_withdraw SET WithStatus = 'Approved' WHERE WithId = $WithId"; 
                    if ($conn->query($sql) === TRUE) { 
                    } else {
                     echo "Error updating record: " . $conn->error;
    }
    header("refresh:1;Approve.php");
    }
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

<form method="post" class="form-horizontal mt-5" name="myform">

    <?php
        $i = 0;
        $sql = "SELECT * FROM tbl_withdrawdetail WHERE WithId = $withid";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) {
        $data[] = $row;  
        }
        foreach($data as $key => $withdetailid){

            $MedId = $withdetailid["MedId"];
            $sqli ="SELECT tbl_med.MedId,tbl_med.TypeId,tbl_med.CateId,tbl_med.VolumnId,tbl_med.UnitId,tbl_med.MedName,tbl_med.MedPack,tbl_med.MedPrice,tbl_med.MedDes,tbl_med.MedIndi,tbl_med.MedExp,tbl_med.MedLow,tbl_med.MedTotal,tbl_med.MedPoint,tbl_med.MedPath,tbl_type.TypeName,tbl_cate.CateName,tbl_volumn.VolumnName,tbl_unit.UnitName
            FROM tbl_med
            INNER JOIN tbl_type ON tbl_type.TypeId = tbl_med.TypeId
            INNER JOIN tbl_cate ON tbl_cate.CateId = tbl_med.CateId
            INNER JOIN tbl_volumn ON tbl_volumn.VolumnId = tbl_med.VolumnId
            INNER JOIN tbl_unit ON tbl_unit.UnitId = tbl_med.UnitId
            WHERE tbl_med.MedId = $MedId";
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
            <label for="Tel" class="col-sm-3 control-label">Withdraw Id</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_WithId" class="form-control" value="<?php echo $With["WithId"]; ?>" readonly>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="row">
            <label for="Tel" class="col-sm-3 control-label">Withdraw Date</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_WithDate" class="form-control" value="<?php echo $With["WithDate"]; ?>" readonly>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="row">
            <label for="Tel" class="col-sm-3 control-label">Withdraw Name</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_StaffName" class="form-control" value="<?php echo $Staff["StaffName"]; ?>" readonly>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="row">
            <label for="Tel" class="col-sm-3 control-label">Quantity</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_Qty" class="form-control" value="<?php echo $With["Qtysum"]; ?>" readonly>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="row">
            <label for="Tel" class="col-sm-3 control-label">Status</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_Status" class="form-control" value="<?php echo $With["WithStatus"]; ?>" readonly>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="row">
            <label for="Medicine Name" class="col-sm-3 control-label">Lot Id</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_MedName" class="form-control" value="<?php echo $withdetailid["LotId"]; ?>" readonly>
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
            <label for="Medicine pack" class="col-sm-3 control-label">Description</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["MedDes"]; ?>" readonly>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="row">
            <label for="Medicine pack" class="col-sm-3 control-label">Type</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["TypeName"]; ?>" readonly>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="row">
            <label for="Medicine pack" class="col-sm-3 control-label">Category</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["CateName"]; ?>" readonly>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="row">
            <label for="Medicine pack" class="col-sm-3 control-label">Volumn</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["VolumnName"]; ?>" readonly>
             </div>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="row">
            <label for="Medicine pack" class="col-sm-3 control-label">Unit</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["UnitName"]; ?>" readonly>
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
            <label for="Medicine Price" class="col-sm-3 control-label">Quantity</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_Qty" class="form-control" value="<?php echo $withdetailid["Qty"]; ?>" readonly>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="row">
             <label for="Medicine Price" class="col-sm-3 control-label">Manufactured Date</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_Qty" class="form-control" value="<?php echo $withdetailid["Mfd"]; ?>" readonly>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="row">
            <label for="Medicine Price" class="col-sm-3 control-label">Expiration Date</label>
                <div class="col-sm-7">
                    <input type="text" name="txt_Qty" class="form-control" value="<?php echo $withdetailid["Exd"]; ?>" readonly>
            </div>
        </div>
    </div>

        <?php }}?>

        <div class="form-group text-center">
            <div class="col-md-12 mt-3">
                <input type="submit" name="btn_approve" class="btn btn-success" value="Approve">
                <a href="Approve.php" class="btn btn-danger">Back</a>
            </div>
        </div>
    </div>

    </div>
                
</form>

<script src="js/slim.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>

