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
        $MedPack = $_REQUEST['txt_MedPack'];
        $MedPrice = $_REQUEST['txt_MedPrice'];
        $MedLow = $_REQUEST['txt_Medlow'];
        $MedTotal = $_REQUEST['txt_MedTotal'];
        $MedIndi = $_REQUEST['txt_MedIndi'];
        $MedPoint = $_REQUEST['txt_MedPoint'];
        $MedType = $_REQUEST['txt_Medtype'];
    
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
        }else if (empty($MedIndi)) {
            $errorMsg = "Please Enter Medicine Indication";
        }else if (empty($MedPoint)) {
            $errorMsg = "Please Enter Point of Order";
        }else if (empty($MedType)) {
            $errorMsg = "Please Enter Medicine Type";
        }  else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE tbl_med SET MedName = :1name, MedCate = :2name, MedVolumn = :3name, MedUnit = :4name, MedPack = :5name, MedPrice = :6name, MedTotal = :7name,  MedPoint = :8name, MedDes = :9name, MedLow = :10name, MedType = :11name, MedIndi = :12name WHERE MedId = :MedId");
                    $update_stmt->bindParam(':1name', $MedName);
                    $update_stmt->bindParam(':2name', $MedCate);
                    $update_stmt->bindParam(':3name', $MedVolumn);
                    $update_stmt->bindParam(':4name', $MedUnit);
                    $update_stmt->bindParam(':5name', $MedPack);
                    $update_stmt->bindParam(':6name', $MedPrice);
                    $update_stmt->bindParam(':7name', $MedTotal);
                    $update_stmt->bindParam(':8name', $MedPoint); 
                    $update_stmt->bindParam(':9name', $MedDes); 
                    $update_stmt->bindParam(':10name', $MedLow);
                    $update_stmt->bindParam(':11name', $MedType);
                    $update_stmt->bindParam(':12name', $MedIndi);  
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

    
    
        <form method="post" class="form-horizontal mt-5">
        <table class="table table-sm">
                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicinename" class="col-sm-3 control-label">Medicine Name</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedName" class="form-control" value="<?php echo $med["MedName"]?>"></td>
                            </div>
                        </div>
                    </div>
                </tr>

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicinedes" class="col-sm-3 control-label">Description</label></td>
                            <div class="col-sm-7">
                            <td><textarea id="w3review" name="txt_MedDes" rows="4" cols="50"><?php echo $med["MedDes"]?></textarea></td>
                            </div>
                        </div>
                    </div>
                </tr>

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicinedes" class="col-sm-3 control-label">Indication</label></td>
                            <div class="col-sm-7">
                            <td><textarea id="w3review" name="txt_MedIndi" rows="4" cols="50"><?php echo $med["MedIndi"]?></textarea></td>
                            </div>
                        </div>
                    </div>
                </tr>

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicinelow" class="col-sm-3 control-label">Medicine Type</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_Medtype" class="form-control" value="<?php echo $med["MedType"]?>"></td>
                            </div>
                        </div>
                    </div>
                </tr>

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicineprcie" class="col-sm-3 control-label">Price per Pack</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedPrice" class="form-control" value="<?php echo $med["MedPrice"]?>"></td>
                            </div>
                        </div>
                    </div>
                </tr>

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicinepack" class="col-sm-3 control-label">Unit per Pack</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["MedPack"]?>"></td>
                            </div>
                        </div>
                    </div>
                </tr>

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicinelow" class="col-sm-3 control-label">Minimum purchase</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_Medlow" class="form-control" value="<?php echo $med["MedLow"]?>"></td>
                            </div>
                        </div>
                    </div>
                </tr>

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicineprcie" class="col-sm-3 control-label">Reorder Point</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedPoint" class="form-control" value="<?php echo $med["MedPoint"]?>"></td>
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
                            <td><label for="Category" class="col-sm-3 control-label">Category</label></td>
                            <div class="col-sm-1">
                                <td><select name = "dropdownlist-MedCate">
                                    <option value="<?php echo $med["MedCate"]; ?>"><?php echo $med["MedCate"]; ?></option> 
                                    <option value="Vitamins">Vitamins</option>
                                    <option value="Antipyretics">Antipyretics</option>
                                    <option value="Antibiotics">Antibiotics</option>
                                    <option value="Mood stabilizers">Mood stabilizers</option>
                                </select><br><br></td>
                            </div>
                        </div>
                    </div>
                </tr>

                
                
                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Volumn" class="col-sm-3 control-label">Volumn per unit</label></td>
                            <div class="col-sm-1">
                                <td><select name = "dropdownlist-MedVolumn">
                                    <option value="<?php echo $med["MedVolumn"]; ?>"><?php echo $med["MedVolumn"]; ?></option> 
                                    <option value="100 CC">100 CC</option>
                                    <option value="500 CC">500 CC</option>
                                    <option value="1000 CC">1000 CC</option>
                                    <option value="250 MG">250 MG</option>
                                    <option value="300 MG">300 MG</option>
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
                            <td><label for="Unit" class="col-sm-3 control-label">Unit</label></td>
                            <div class="col-sm-1">
                                <td><select name = "dropdownlist-MedUnit">
                                    <option value="<?php echo $med["MedUnit"]; ?>"><?php echo $med["MedUnit"]; ?></option> 
                                    <option value="Capsule">Pill</option>
                                    <option value="Tablet">Tablet</option>
                                    <option value="Capsule">Capsule</option>  
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