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
        $MedDes = $_REQUEST['txt_MedDes'];
        $MedCate = $_REQUEST['dropdownlist-MedCate'];
        $MedVolumn = $_REQUEST['dropdownlist-MedVolumn'];
        $MedUnit = $_REQUEST['dropdownlist-MedUnit'];
        $MedPack = $_REQUEST['txt_MedPack'];
        $MedPrice = $_REQUEST['txt_MedPrice'];
        $MedLow = $_REQUEST['txt_Medlow'];
        $MedTotal = 0;
        $MedStatus = "Out of stock";
     
        $dir = "upload/";
        $fileImage = $dir . basename($_FILES["file"]["name"]);

        if(move_uploaded_file($_FILES["file"]["tmp_name"], $fileImage)){  
        }
        $MedPath = basename($_FILES["file"]["name"]);
        
        if (empty($MedName)) {
            $errorMsg = "Please enter Medicine Name";
        }else if (empty($MedDes)) {
            $errorMsg = "Please Enter Medicine Description";
        }else if (empty($MedCate)) {
            $errorMsg = "Please Enter Medicine Catetory";
        }else if (empty($MedVolumn)) {
            $errorMsg = "Please Enter Medicine Volumn";
        }else if (empty($MedUnit)) {
            $errorMsg = "Please Enter Medicine Unit";
        }else if (empty($MedPack)) {
            $errorMsg = "Please Enter Medicine Pack";
        }else if (empty($MedPrice)) {
            $errorMsg = "Please Enter Medicine Price";
        }else if (empty($MedLow)) {
            $errorMsg = "Please Enter Medicine Minimum purchase";
        }else if (empty($MedStatus)) {
            $errorMsg = "Please Enter Medicine Status";
        }else {

            $query = "SELECT * FROM tbl_med WHERE MedName = '$MedName'  LIMIT 1";
            $result = mysqli_query($conn, $query); 
            $row = mysqli_fetch_array($result);
        if ($row["MedName"] === $MedName) {
            $errorMsg =  "Medicine already exists";
        }
        else {
        $sql = "INSERT INTO tbl_med(MedName , MedCate , MedVolumn , MedUnit , MedPack , MedPrice , MedLow , MedDes , MedStatus , MedTotal , MedPath ) VALUES ('$MedName', '$MedCate','$MedVolumn', '$MedUnit', '$MedPack', '$MedPrice', '$MedLow', '$MedDes', '$MedStatus', '$MedTotal', '$MedPath')";
        if ($conn->query($sql) === TRUE){
            $insertMsg = "Insert Successfully...";
            header("refresh:1;Medshow.php");
        }

            else {echo "Error updating record: " . $conn->error;}
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
         if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>


        <form method="post" class="form-horizontal mt-5" enctype="multipart/form-data">
            <table class="table table-sm">
                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicinename" class="col-sm-3 control-label">Medicine Name</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedName" class="form-control" placeholder="Enter Medicine Name..."></td>
                            </div>
                        </div>
                    </div>
                </tr>

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicinedes" class="col-sm-3 control-label">Description</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedDes" class="form-control" placeholder="Enter Medicine Description..."></td>
                            </div>
                        </div>
                    </div>
                </tr>

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicineprcie" class="col-sm-3 control-label">Price per Pack</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedPrice" class="form-control" placeholder="Enter Medicine Price..."></td>
                            </div>
                        </div>
                    </div>
                </tr>

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicinepack" class="col-sm-3 control-label">Unit per Pack</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedPack" class="form-control" placeholder="Enter Medicine Pack..."></td>
                            </div>
                        </div>
                    </div>
                </tr>

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicinelow" class="col-sm-3 control-label">Minimum purchase</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_Medlow" class="form-control" placeholder="Enter Medicine Minimum purchase..."></td>
                            </div>
                        </div>
                    </div>
                </tr>

                </tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Category" class="col-sm-3 control-label">Category</label></td>
                            <div class="col-sm-1">
                                <td><select name = "dropdownlist-MedCate">
                                    <option value="Select">Select</option> 
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
                                    <option value="Select">Select</option> 
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
                            <td><label for="Unit" class="col-sm-3 control-label">Unit</label></td>
                            <div class="col-sm-1">
                                <td><select name = "dropdownlist-MedUnit">
                                    <option value="Select">Select</option> 
                                    <option value="Capsule">Pill</option>
                                    <option value="Tablet">Tablet</option>
                                    <option value="Capsule">Capsule</option>  
                                </select><br><br></td>
                            </div>
                        </div>
                    </div>
                </tr>

                </tr>
                    <div class="form-group text-center">
                        <div class="row">
                        
                            <td><div class="col-sm-3 control-label">
                                Select image to upload<br></td>
                                
                                <td><input type="file" name="file"></td>
                                
                            </div>
                        </div>
                    </div>
                </tr>
         </table>

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