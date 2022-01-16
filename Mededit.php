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


    if (isset($_REQUEST['edit_id'])) {
        try {
            $id = $_REQUEST['edit_id'];
            $sql ="SELECT * FROM tbl_med WHERE $id = MedId";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $med){}
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $MedName = $_REQUEST['txt_MedName'];
        $MedDes = $_REQUEST['txt_MedDes'];
        $CateId = $_REQUEST['dropdownlist-MedCate'];
        $VolumnId = $_REQUEST['dropdownlist-MedVolumn'];
        $UnitId = $_REQUEST['dropdownlist-MedUnit'];
        $MedPack = $_REQUEST['txt_MedPack'];
        $MedPrice = $_REQUEST['txt_MedPrice'];
        $MedLow = $_REQUEST['txt_Medlow'];
        $MedTotal = $_REQUEST['txt_MedTotal'];
        $MedIndi = $_REQUEST['txt_MedIndi'];
        $MedPoint = $_REQUEST['txt_MedPoint'];
        $TypeId = $_REQUEST['txt_Medtype'];
        $MedExp = $_REQUEST['txt_MedExp'];
        
        if (empty($MedName)) {
            $errorMsg = "Please enter Medicine Name";
        }else if (empty($MedDes)) {
            $errorMsg = "Please Enter Medicine Description";
        } else if (empty($CateId)) {
            $errorMsg = "Please Enter Medicine Catetory";
        } else if (empty($VolumnId)) {
            $errorMsg = "Please Enter Medicine Volumn";
        } else if (empty($UnitId)) {
            $errorMsg = "Please Enter Medicine Unit";
        }else if (empty($MedPack)) {
            $errorMsg = "Please Enter Medicine Pack";
        }else if (empty($MedPrice)) {
            $errorMsg = "Please Enter Medicine Price";
        }else if (empty($MedIndi)) {
            $errorMsg = "Please Enter Medicine Indication";
        }else if (empty($MedPoint)) {
            $errorMsg = "Please Enter Point of Order";
        }else if (empty($MedExp)) {
            $errorMsg = "Please Enter Medicine Exp";
        }else if (empty($TypeId)) {
            $errorMsg = "Please Enter Medicine Type";
        }  else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE tbl_med SET MedName = :1name, CateId = :2name, VolumnId = :3name, UnitId = :4name, MedPack = :5name, MedPrice = :6name, MedTotal = :7name,  MedPoint = :8name, MedDes = :9name, MedLow = :10name, TypeId = :11name, MedIndi = :12name, MedExp = :13name WHERE MedId = :MedId");
                    $update_stmt->bindParam(':1name', $MedName);
                    $update_stmt->bindParam(':2name', $CateId);
                    $update_stmt->bindParam(':3name', $VolumnId);
                    $update_stmt->bindParam(':4name', $UnitId);
                    $update_stmt->bindParam(':5name', $MedPack);
                    $update_stmt->bindParam(':6name', $MedPrice);
                    $update_stmt->bindParam(':7name', $MedTotal);
                    $update_stmt->bindParam(':8name', $MedPoint); 
                    $update_stmt->bindParam(':9name', $MedDes); 
                    $update_stmt->bindParam(':10name', $MedLow);
                    $update_stmt->bindParam(':11name', $TypeId);
                    $update_stmt->bindParam(':12name', $MedIndi);
                    $update_stmt->bindParam(':13name', $MedExp);    
                    $update_stmt->bindParam(':MedId', $id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "Record update successfully...";
                        header("refresh:1;Medshow.php");
                    }
                }
            } catch(PDOException $e) {
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

    
    
        <form method="post" class="form-horizontal mt-5">
            <div class="container">
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicinename" class="col-sm-3 control-label">Medicine Name</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedName" class="form-control" value="<?php echo $med["MedName"]?>"></td>
                            </div>
                    </div>
                </div>
              
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicinedes" class="col-sm-3 control-label">Description</label></td>
                            <div class="col-sm-7">
                                <td><textarea id="w3review" name="txt_MedDes" rows="4" cols="50"><?php echo $med["MedDes"]?></textarea></td>
                            </div>
                    </div>
                </div>
              
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicinedes" class="col-sm-3 control-label">Indication</label></td>
                            <div class="col-sm-7">
                                <td><textarea id="w3review" name="txt_MedIndi" rows="4" cols="50"><?php echo $med["MedIndi"]?></textarea></td>
                            </div>
                    </div>
                </div>
              
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicineprcie" class="col-sm-3 control-label">Price per Pack</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedPrice" class="form-control" value="<?php echo $med["MedPrice"]?>"></td>
                            </div>
                    </div>
                </div>
              
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicinepack" class="col-sm-3 control-label">Unit per Pack</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["MedPack"]?>"></td>
                            </div>
                    </div>
                </div>
               
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicinelow" class="col-sm-3 control-label">Minimum purchase</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_Medlow" class="form-control" value="<?php echo $med["MedLow"]?>"></td>
                            </div>
                    </div>
                </div>
             
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicineprcie" class="col-sm-3 control-label">Reorder Point</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedPoint" class="form-control" value="<?php echo $med["MedPoint"]?>"></td>
                            </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="Medicineprcie" class="col-sm-3 control-label">Medicine Exp</label></td>
                            <div class="col-sm-7">
                                <td><input type="number" name="txt_MedExp" class="form-control" value="<?php echo $med["MedExp"]; ?>"></td>
                            </div>
                        </div>
                </div>
              
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="MedTotal" class="col-sm-3 control-label">Medicine Total</label></td>
                            <div class="col-sm-7">
                                <td><input type="number" name="txt_MedTotal" class="form-control" value="<?php echo $med["MedTotal"]; ?>"></td>
                            </div>
                        </div>
                </div>

                        <div class="form-group text-center">
                            <div class="row">
                                <td><label class="col-sm-3 control-label">Medicine Type</label></td>
                                    <div class="col-sm-1">
                                        <td><select name="txt_Medtype">       
                                            <?php 
                                                $sql = 'SELECT * FROM tbl_type';
                                                $result = $conn->query($sql);
                                                $data = array();
                                                while($row = $result->fetch_assoc()) 
                                                    {
                                                        $data[] = $row;   
                                                    }
                                                    foreach($data as $key => $type){                  
                                            ?>
                                                <option value ="<?php echo $type["TypeId"];?>"><?php echo $type["TypeName"];?></option>
                                            <?php } ?>      
                                        </select><br></td>
                                    </div>
                            </div>
                        </div>
                    
                        <div class="form-group text-center">
                            <div class="row">
                                <td><label class="col-sm-3 control-label">Category</label></td>
                                    <div class="col-sm-1">
                                        <td><select name="dropdownlist-MedCate">       
                                            <?php 
                                                $sql = 'SELECT * FROM tbl_cate';
                                                $result = $conn->query($sql);
                                                $data = array();
                                                while($row = $result->fetch_assoc()) 
                                                    {
                                                        $data[] = $row;   
                                                    }
                                                    foreach($data as $key => $cate){                  
                                            ?>
                                                <option value ="<?php echo $cate["CateId"];?>"><?php echo $cate["CateName"];?></option>
                                            <?php } ?>      
                                        </select><br></td>
                                    </div>
                            </div>
                        </div>
                    
                        <div class="form-group text-center">
                            <div class="row">
                                <td><label class="col-sm-3 control-label">Volumn</label></td>
                                    <div class="col-sm-1">
                                        <td><select name="dropdownlist-MedVolumn">       
                                            <?php 
                                                $sql = 'SELECT * FROM tbl_volumn';
                                                $result = $conn->query($sql);
                                                $data = array();
                                                while($row = $result->fetch_assoc()) 
                                                    {
                                                        $data[] = $row;   
                                                    }
                                                    foreach($data as $key => $vol){                  
                                            ?>
                                                <option value ="<?php echo $vol["VolumnId"];?>"><?php echo $vol["VolumnName"];?></option>
                                            <?php } ?>      
                                        </select><br></td>
                                    </div>
                            </div>
                        </div>
                  
                        <div class="form-group text-center">
                            <div class="row">
                                <td><label class="col-sm-3 control-label">Unit</label></td>
                                    <div class="col-sm-1">
                                        <td><select name="dropdownlist-MedUnit">       
                                            <?php 
                                                $sql = 'SELECT * FROM tbl_unit';
                                                $result = $conn->query($sql);
                                                $data = array();
                                                while($row = $result->fetch_assoc()) 
                                                    {
                                                        $data[] = $row;   
                                                    }
                                                    foreach($data as $key => $unit){                  
                                            ?>
                                                <option value ="<?php echo $unit["UnitId"];?>"><?php echo $unit["UnitName"];?></option>
                                            <?php } ?>      
                                        </select><br></td>
                                    </div>
                            </div>
                        </div>

     

            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="Medshow.php" class="btn btn-danger">Back</a>
                </div>
            </div>


        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>