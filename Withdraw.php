
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
            $sql = "SELECT* FROM tbl_lot WHERE LotId=$Lotid";
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

    
    
    
    <div class="container mt-5">

                <?php 
                        $Lot = $Lot["LotId"];
                        $sql = "SELECT* FROM tbl_lot WHERE LotId=$Lot";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $rec)
                        { 
                           
                            $MedId = $rec["MedId"];
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
                            foreach($data as $key => $Med){                  
                ?>
                         
                    <form action = "Withdrawcart.php" method="post">
                        <div class="form-group text-center">
                            <div>
                                <div> <?php echo '<img style = "width:325px;height:325px"  src="upload/'. $Med["MedPath"]; ?>"> </div> 
                            </div>
                        </div>
                            <div>
                                <?php  
                                    $withqty = 0 ;
                                    $WithId = $rec["LotId"];
                                    $sql = "SELECT* FROM tbl_lot WHERE LotId = $Lotid";
                                    $result = $conn->query($sql);
                                    $data = array();
                                    while($row = $result->fetch_assoc()) 
                                    {
                                        $data[] = $row;   
                                    }
                                    foreach($data as $key => $Lot)
                                    $lotReserve = $Lot["Reserve"];
                                    $lotqty = $Lot["Qty"];                                   
                                    $sum = $lotqty - $lotReserve;           
                                ?>
                            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Lot</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_Lot" class="form-control" value="<?php echo $Lot["LotId"]; ?>" readonly>
                    </div>
                </div>
            </div>
        
            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Medicine</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_MedName" class="form-control" value="<?php echo $Med["MedName"]; ?>" readonly>
                    </div>
                </div>
            </div>
            

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Category" class="col-sm-3 control-label">Category</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedCate" class="form-control" value="<?php echo $Med["CateName"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Volumn" class="col-sm-3 control-label">Volumn</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedVolumn" class="form-control" value="<?php echo $Med["VolumnName"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Unit" class="col-sm-3 control-label">Unit</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedUnit" class="form-control" value="<?php echo $Med["UnitName"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine pack" class="col-sm-3 control-label">Unit/Pack</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $Med["MedPack"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">Total/Pack</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Total" class="form-control" value="<?php echo $sum; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">Quantity</label>
                    <div class="col-sm-7">
                    <input type="number" name="quantity" min="1" max="<?php echo $sum; ?>" value= "1"></p>
                    </div>
                </div>
            </div>

                            <div class="form-group text-center">
                                <input type ="hidden" name = "testMedId" value = "<?php echo $Med["MedId"]; ?>">
                                <input type ="hidden" name = "act" value = "add">
                                <input type="submit" class = "btn btn-info" value = "Add to cart"> 
                                <input type ="hidden" name = "valueid" value = "<?php echo $rec["LotId"];?>">
                                <a href="Lot.php" class="btn btn-danger">Back</a>
                            </div>
                            </form>  
                    </div>
                                                  
                    <?php }} ?>

            </div>
            </div>
        </div>
                     
            </form>  
            <script src="js/slim.js"></script>
            <script src="js/popper.js"></script>
            <script src="js/bootstrap.js"></script>
</body>
</html>
