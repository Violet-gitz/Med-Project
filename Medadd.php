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

    if (isset($_REQUEST['btn_insert'])) {
        
        $MedName = $_REQUEST['txt_MedName'];
        $MedCate = $_REQUEST['dropdownlist-MedCate'];
        $MedVolumn = $_REQUEST['dropdownlist-MedVolumn'];
        $MedUnit = $_REQUEST['dropdownlist-MedUnit'];
        $MedPack = $_REQUEST['txt_MedPack'];
        $MedPrice = $_REQUEST['txt_MedPrice'];
        $MedTotal = 0;
        $MedStatus = "Out of stock";
     
        $dir = "upload/";
        $fileImage = $dir . basename($_FILES["file"]["name"]);

        if(move_uploaded_file($_FILES["file"]["tmp_name"], $fileImage)){  
        }
        $MedPath = basename($_FILES["file"]["name"]);
        
         if (empty($MedName)) {
            $errorMsg = "Please enter Medicine Name";
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
                    
                    $insert_stmt = $db->prepare("INSERT INTO tbl_med(MedName, MedCate, MedVolumn, MedUnit, MedPack, MedPrice, MedTotal, MedStatus, MedPath ) VALUES (:1name, :2name, :3name, :4name, :5name, :6name, :7name, :8name, :9name)");
                    
                    $insert_stmt->bindParam(':1name', $MedName);
                    $insert_stmt->bindParam(':2name', $MedCate);
                    $insert_stmt->bindParam(':3name', $MedVolumn);
                    $insert_stmt->bindParam(':4name', $MedUnit);
                    $insert_stmt->bindParam(':5name', $MedPack);
                    $insert_stmt->bindParam(':6name', $MedPrice);
                    $insert_stmt->bindParam(':7name', $MedTotal);
                    $insert_stmt->bindParam(':8name', $MedStatus);
                    $insert_stmt->bindParam(':9name', $MedPath);  

                    if ($insert_stmt->execute()) {
                        $insertMsg = "Insert Successfully...";
                        header("refresh:1;Medshow.php");
                    }
                }
            } catch (PDOException $e) {
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
            <h1 class="navbar-brand">Medicine Add+</h1>
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
         if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>


        <form method="post" class="form-horizontal mt-5" enctype="multipart/form-data">

            
            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicinename" class="col-sm-3 control-label">Medicine Name</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedName" class="form-control" placeholder="Enter Medicine Name...">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicineprcie" class="col-sm-3 control-label">Medicine Price</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedPrice" class="form-control" placeholder="Enter Medicine Price...">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicinepack" class="col-sm-3 control-label">Medicine Pack</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedPack" class="form-control" placeholder="Enter Medicine Pack...">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                <label for="Category" class="col-sm-3 control-label">Category</label>
                    <div class="col-sm-1">
                        <select name = "dropdownlist-MedCate">
                            <option value="Select">Select</option> 
                            <option value="Vitamins">Vitamins</option>
                            <option value="Antipyretics">Antipyretics</option>
                            <option value="Antibiotics">Antibiotics</option>
                            <option value="Mood stabilizers">Mood stabilizers</option>
                            

                        </select><br><br>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                <label for="Volumn" class="col-sm-3 control-label">Volumn</label>
                    <div class="col-sm-1">
                        <select name = "dropdownlist-MedVolumn">

                            <option value="Select">Select</option> 
                            <option value="100 CC">100 CC</option>
                            <option value="500 CC">500 CC</option>
                            <option value="1000 CC">1000 CC</option>
                            <option value="250 MG">250 MG</option>
                            <option value="500 MG">500 MG</option>
                            <option value="1000 MG">1000 MG</option>
                            

                        </select><br><br>
                    </div>
                </div>
            </div>

             <div class="form-group text-center">
                <div class="row">
                <label for="Unit" class="col-sm-3 control-label">Unit</label>
                    <div class="col-sm-1">
                        <select name = "dropdownlist-MedUnit">
                        
                            <option value="Select">Select</option> 
                            <option value="Capsule">Pill</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Capsule">Capsule</option>  
                        
                        </select><br><br>
                    </div>
                </div>
            </div>


            <div class="form-group text-center">
                <div class="row">
                
                    <div class="col-sm-3 control-label">
                        Select image to upload<br>
                        
                        <input type="file" name="file">
                        
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_insert" class="btn btn-success" value="Insert">
                    <a href="Medshow.php" class="btn btn-danger">Back</a>
                </div>
            </div>


        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>