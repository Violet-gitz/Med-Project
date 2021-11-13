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
        $MedCate = $_REQUEST['dropdownlist-MedCate'];
        $MedVolumn = $_REQUEST['dropdownlist-MedVolumn'];
        $MedUnit = $_REQUEST['dropdownlist-MedUnit'];
        $MedPack = $_REQUEST['qtyPack'];
        $MedPrice = $_REQUEST['qtyPrice'];
        $MedLow = $_REQUEST['txt_MedLow'];
        $MedTotal = $_REQUEST['txt_MedTotal'];
        $MedStatus = $_REQUEST['dropdownlist-MedStatus'];
    
         if (empty($MedName)) {
            $errorMsg = "Please enter Medicine Name";
        }else if (empty($MedDes)) {
            $errorMsg = "Please Enter Medicine Description";
        } else if (empty($MedCate)) {
            $errorMsg = "Please Enter Medicine Catetory";
        } else if (empty($MedVolumn)) {
            $errorMsg = "Please Enter Medicine Volumn";
        } else if (empty($MedUnit)) {
            $errorMsg = "Please Enter Medicine Unit";
        }else if (empty($MedPack)) {
            $errorMsg = "Please Enter Medicine Pack";
        }else if (empty($MedPrice)) {
            $errorMsg = "Please Enter Medicine Price";
        } else if (empty($MedStatus)) {
            $errorMsg = "Please Enter Medicine Status";
        }  else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE tbl_med SET MedName = :1name, MedCate = :2name, MedVolumn = :3name, MedUnit = :4name, MedPack = :5name, MedPrice = :6name, MedTotal = :7name,  MedStatus = :8name, MedDes = :9name, MedLow = :10name WHERE MedId = :MedId");
                    $update_stmt->bindParam(':1name', $MedName);
                    $update_stmt->bindParam(':2name', $MedCate);
                    $update_stmt->bindParam(':3name', $MedVolumn);
                    $update_stmt->bindParam(':4name', $MedUnit);
                    $update_stmt->bindParam(':5name', $MedPack);
                    $update_stmt->bindParam(':6name', $MedPrice);
                    $update_stmt->bindParam(':7name', $MedTotal);
                    $update_stmt->bindParam(':8name', $MedStatus); 
                    $update_stmt->bindParam(':9name', $MedDes); 
                    $update_stmt->bindParam(':10name', $MedLow); 
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
            <h1 class="navbar-brand">Medicine Edit</h1>
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

    
    
        <form method="post" class="form-horizontal mt-5">
            <table class="table table-sm">
            <tr>
                <div class="form-group text-center">
                    <div class="row">
                        <td><label for="MedicineName" class="col-sm-3 control-label">Medicine Name</label></td>
                        <div class="col-sm-7">
                            <td><input type="text" name="txt_MedName" class="form-control" value="<?php echo $med["MedName"]; ?>"></td>
                        </div>
                    </div>
                </div>
            </tr>

            <tr>
                <div class="form-group text-center">
                    <div class="row">
                    <td><label for="MedicineDes" class="col-sm-3 control-label">Medicine Description</label></td>
                        <div class="col-sm-7">
                        <td><input type="text"  name="txt_MedDes" class="form-control" value="<?php echo $med["MedDes"]?>"></td>
                        </div>
                    </div>
                </div>
            </tr>

            <tr>
                <div class="form-group text-center">
                    <div class="row">
                    <td><label for="Medicineprcie" class="col-sm-3 control-label">Medicine Price/Pack</label></td>
                        <div class="col-sm-1">
                        <td><input type="number" id="quantity" name="qtyPrice" class="form-control" min="1" max="9999" value="<?php echo $med["MedPrice"]?>"></td>
                        </div>
                    </div>
                </div>
            </tr>

            <tr>
                <div class="form-group text-center">
                    <div class="row">
                    <td><label for="Medicinepack" class="col-sm-3 control-label">Medicine Unit/Pack</label></td>
                        <div class="col-sm-1">
                        <td><input type="number" id="quantity" name="qtyPack" class="form-control" min="1" max="9999" value="<?php echo $med["MedPack"]?>"></td>
                        </div>
                    </div>
                </div>
            </tr>

            <tr>
                <div class="form-group text-center">
                    <div class="row">
                    <td><label for="MedTotal" class="col-sm-3 control-label">Minimum purchase</label></td>
                        <div class="col-sm-7">
                        <td><input type="number" name="txt_MedLow" class="form-control" value="<?php echo $med["MedLow"]; ?>"></td>
                        </div>
                    </div>
                </div>
            </tr>

            <tr>
                <div class="form-group text-center">
                    <div class="row">
                    <td><label for="MedTotal" class="col-sm-3 control-label">Medicine Total</label></td>
                        <div class="col-sm-7">
                        <td><input type="number" name="txt_MedTotal" class="form-control" value="<?php echo $med["MedTotal"]; ?>"></td>
                        </div>
                    </div>
                </div>
            </tr>
            
            <tr>
                <div class="form-group text-center">
                    <div class="row">
                    <td><label for="Tel" class="col-sm-3 control-label">Category</label></td>
                        <div class="col-sm-1">
                        <td><select name = "dropdownlist-MedCate">
                                <option value="<?php echo $med["MedCate"]; ?>"><?php echo $med["MedCate"]; ?></option> 
                                <option value="Vitamins">Vitamins</option>
                                <option value="Antipyretics">Antipyretics</option>
                                <option value="Antibiotics">Antibiotics</option>
                                <option value="OMood stabilizers">Mood stabilizers</option>
                                

                            </select><br><br></td>
                        </div>
                    </div>
                </div>
            </tr>

            <tr>
                <div class="form-group text-center">
                    <div class="row">
                    <td><label for="Tel" class="col-sm-3 control-label">Volumn</label></td>
                        <div class="col-sm-1">
                        <td><select name = "dropdownlist-MedVolumn">

                                <option value="<?php echo $med["MedVolumn"]; ?>"><?php echo $med["MedVolumn"]; ?></option> 
                                <option value="100 CC">100 CC</option>
                                <option value="500 CC">500 CC</option>
                                <option value="1000 CC">1000 CC</option>
                                <option value="250 MG">250 MG</option>
                                <option value="500 MG">500 MG</option>
                                <option value="1000 MG">1000 MG</option>
                                

                            </select><br><br></td>
                        </div>
                    </div>
                </div>
            </tr>

            <tr>
                <div class="form-group text-center">
                    <div class="row">
                    <td><label for="Tel" class="col-sm-3 control-label">Unit</label></td>
                        <div class="col-sm-1">
                        <td><select name = "dropdownlist-MedUnit">
                            
                                <option value="<?php echo $med["MedUnit"]; ?>"><?php echo $med["MedUnit"]; ?></option> 
                                <option value="Drops">Drops</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Capsule">Capsule</option>
                            
                            </select><br><br></td>
                        </div>
                    </div>
                </div>
            </tr>


            <tr>
                <div class="form-group text-center">
                    <div class="row">
                    <td><label for="Tel" class="col-sm-3 control-label">Status</label></td>
                        <div class="col-sm-1">
                        <td><select name = "dropdownlist-MedStatus">
                                <option value="<?php echo $med["MedStatus"]; ?>"><?php echo $med["MedStatus"]; ?></option> 
                                <option value="Avialable">Avialable</option>
                                <option value="Not use">Not use</option>
                                <option value="Out of stock">Out of stock</option>
                                <option value="Re stock">Re stock</option>
                                

                            </select><br><br></td>
                        </div>
                    </div>
                </div>
            </tr>

        </table>

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