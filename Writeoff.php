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

    if (isset($_REQUEST['Write'])) {
        
            $id = $_REQUEST['Write'];
            $sql = 'SELECT * FROM tbl_lot WHERE LotId ='.$id;

            $result = $conn->query($sql);
            
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $Lot)

            {
                $idmed = $Lot["MedId"];
                $sql ="SELECT * FROM tbl_med WHERE $idmed = MedId";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $med){}
            }

        }

    if (isset($_REQUEST['btn_write'])) {

        $idlot = $_REQUEST['txt_Lot'];
        $sql = "SELECT* FROM tbl_lot WHERE LotId = $idlot";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) 
        {
            $data[] = $row;   
        }
        foreach($data as $key => $Lot)           

        {
            $idmed = $Lot["MedId"];
            $sql ="SELECT * FROM tbl_med WHERE $idmed = MedId";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                }
                foreach($data as $key => $med){}
        }
        
        date_default_timezone_set("Asia/Bangkok");
        $WriteDate = date("Y-m-d h:i:sa");
        $StaffId = $_REQUEST['selstaff'];
        $Qty = $_REQUEST['txt_Total'];
        
        $Total = $med["MedTotal"];
        $Medqty = $Lot["Qty"];
        
        
        $result = $Total-$Qty;

        $Totalrec = $Lot["Qty"];
        $sum = $Totalrec-$Qty;
        
        $lotstatus = "Writeoff";
        
        if (empty($StaffId)) {
            $errorMsg = "Please Enter StaffId";
        }  else {
            try {
                if (!isset($errorMsg)) {
                    
                    $insert_stmt = $db->prepare("INSERT INTO tbl_writeoff(LotId, MedId, StaffId, Qty, WriteDate ) VALUES (:1name, :2name, :3name, :4name, :5name)");
                    
                    $insert_stmt->bindParam(':1name', $idlot);
                    $insert_stmt->bindParam(':2name', $idmed);
                    $insert_stmt->bindParam(':3name', $StaffId);
                    $insert_stmt->bindParam(':4name', $Qty);
                    $insert_stmt->bindParam(':5name', $WriteDate);

                    $sql = "UPDATE tbl_med set MedTotal = '$result' WHERE $idmed=MedId";
                    if ($conn->query($sql) === TRUE) {
                        
                    } else {
                      echo "Error updating record: " . $conn->error;
                    }

                    // $sql = "UPDATE tbl_lot set Qty = '$sum' WHERE $idlot =LotId";
                    // if ($conn->query($sql) === TRUE) {
                        
                    // } else {
                    //   echo "Error updating record: " . $conn->error;
                    // }

                    $sql = "UPDATE tbl_lot set LotStatus = '$lotstatus' WHERE $idlot =LotId";
                    if ($conn->query($sql) === TRUE) {     
                    } else {
                      echo "Error updating record: " . $conn->error;
                    }

                    
                    if ($insert_stmt->execute()) {
                        $insertMsg = "Insert Successfully...";
                        header("refresh:1;main.php");
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
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


            <div>
                <div> <?php echo '<img style = "width:325px;height:325px"  src="upload/'. $med["MedPath"]; ?>"> </div> 
            </div>

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
                        <input type="text" name="txt_Total" class="form-control" value="<?php echo $Lot["Qty"]; ?>" readonly>
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
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_write" class="btn btn-success" value="Writeoff">
                    <a href="Lot.php" class="btn btn-danger">Back</a>
                </div>
            </div>

            

        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>