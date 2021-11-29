
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
                    foreach($data as $key => $staff){}
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
                            $qtysum = $lotqty - $withqty;

                            $sql = "UPDATE tbl_lot SET Qty = $qtysum WHERE LotId = $lotid"; 
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
    }$updateMsg = "Record update successfully...";
    header("refresh:1;main.php");
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
                <a href="main.php" class="navbar-brand">Home Page</a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">

                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                ><?php echo $_SESSION['StaffName'] ?>
                                </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <form method="POSt" action="Staffedit.php">
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
                    <input type="text" name="txt_StaffName" class="form-control" value="<?php echo $staff["StaffName"]; ?>" readonly>
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
            <label class="col-sm-3 control-label">Approval Name</label>
                <div class="col-sm-1">
                    <select name="AppName">       
                        <?php 
                            $sql = 'SELECT * FROM tbl_staff WHERE DepartId = 1';
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
        $sql = "SELECT * FROM tbl_withdrawdetail WHERE WithId = $withid";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) {
        $data[] = $row;  
        }
        foreach($data as $key => $withdetailid){

            $MedId = $withdetailid["MedId"];
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
            <label for="Medicine Name" class="col-sm-3 control-label"></label>
                <div class="col-sm-7">
                <div> <?php echo '<img style = "width:325px;height:325px"  src="upload/'. $med["MedPath"]; ?>"> </div> 
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
            <label for="Medicine pack" class="col-sm-3 control-label">Category</label>
            <div class="col-sm-7">
                <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["MedCate"]; ?>" readonly>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="row">
            <label for="Medicine pack" class="col-sm-3 control-label">Volumn</label>
            <div class="col-sm-7">
                <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["MedVolumn"]; ?>" readonly>
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <div class="row">
            <label for="Medicine pack" class="col-sm-3 control-label">Unit</label>
            <div class="col-sm-7">
                <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["MedUnit"]; ?>" readonly>
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
                
</form>

<script src="js/slim.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>

