<?php 
    include('connect.php');
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

    if (isset($_REQUEST['btn_insert'])) {
        
        $MedName = $_REQUEST['txt_MedName'];
        $MedDes = $_REQUEST['txt_MedDes'];
        $MedIndi = $_REQUEST['txt_MedIndi'];
        $MedCate = $_REQUEST['dropdownlist-MedCate'];
        $MedVolumn = $_REQUEST['dropdownlist-MedVolumn'];
        $MedUnit = $_REQUEST['dropdownlist-MedUnit'];
        $MedPack = $_REQUEST['txt_MedPack'];
        $MedPrice = $_REQUEST['txt_MedPrice'];
        $MedLow = $_REQUEST['txt_Medlow'];
        $MedPoint = $_REQUEST['txt_MedPoint'];
        $MedType = $_REQUEST['txt_Medtype'];
        $MedExp = $_REQUEST['txt_MedExp'];
        $MedTotal = 0;
        
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
        }else if (empty($MedIndi)) {
            $errorMsg = "Please Enter Medicine Indication";
        }else if (empty($MedPoint)) {
            $errorMsg = "Please Enter Point of Order";
        }else if (empty($MedType)) {
            $errorMsg = "Please Enter Medicine Type";
        }else if (empty($MedExp)) {
            $errorMsg = "Please Enter Medicine Exp";
        }else {
            $query = "SELECT * FROM tbl_med WHERE MedName = '$MedName'  LIMIT 1";
            $result = mysqli_query($conn, $query); 
            $row = mysqli_fetch_array($result);
        if($row["MedName"] === $MedName) {
            $errorMsg =  "Medicine already exists";
        }
        else {
        $sql = "INSERT INTO tbl_med(MedName , CateId , VolumnId , UnitId , MedPack , MedPrice , MedLow , MedDes , MedPoint , MedTotal , MedPath , MedIndi , TypeId , MedExp) VALUES ('$MedName', '$MedCate','$MedVolumn', '$MedUnit', '$MedPack', '$MedPrice', '$MedLow', '$MedDes', '$MedPoint', '$MedTotal', '$MedPath' , '$MedIndi' , '$MedType' , '$MedExp')";
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
         if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>


        <form method="post" class="form-horizontal mt-5" enctype="multipart/form-data">
                <div class="container">
                    
                        <div class="form-group text-center">
                            <div class="row">
                                <td><label for="Medicinename" class="col-sm-3 control-label">Medicine Name</label></td>
                                <div class="col-sm-7">
                                    <td><input type="text" name="txt_MedName" class="form-control" placeholder="Enter Medicine Name..."></td>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group text-center">
                            <div class="row">
                                <td><label for="Medicinedes" class="col-sm-3 control-label">Description</label></td>
                                <div class="col-sm-7">
                                <td><textarea id="w3review" name="txt_MedDes" rows="4" cols="50" placeholder="Enter Medicine Description..."></textarea></td>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group text-center">
                            <div class="row">
                                <td><label for="Medicinedes" class="col-sm-3 control-label">Indication</label></td>
                                <div class="col-sm-7">
                                <td><textarea id="w3review" name="txt_MedIndi" rows="4" cols="50" placeholder="Enter Medicine Indication..."></textarea></td>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group text-center">
                            <div class="row">
                                <td><label for="Medicineprcie" class="col-sm-3 control-label">Price per Pack</label></td>
                                <div class="col-sm-7">
                                    <td><input type="number" name="txt_MedPrice" class="form-control" placeholder="Enter Medicine Price..."></td>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group text-center">
                            <div class="row">
                                <td><label for="Medicinepack" class="col-sm-3 control-label">Unit per Pack</label></td>
                                <div class="col-sm-7">
                                    <td><input type="number" name="txt_MedPack" class="form-control" placeholder="Enter Medicine Pack..."></td>
                                </div>
                            </div>
                        </div>
                   
                        <div class="form-group text-center">
                            <div class="row">
                                <td><label for="Medicinelow" class="col-sm-3 control-label">Minimum purchase</label></td>
                                <div class="col-sm-7">
                                    <td><input type="number" name="txt_Medlow" class="form-control" placeholder="Enter Medicine Minimum purchase..."></td>
                                </div>
                            </div>
                        </div>
                   
                        <div class="form-group text-center">
                            <div class="row">
                                <td><label for="Medicineprcie" class="col-sm-3 control-label">Reorder Point</label></td>
                                <div class="col-sm-7">
                                    <td><input type="number" name="txt_MedPoint" class="form-control" placeholder="Enter Medicine Point"></td>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <div class="row">
                                <td><label for="Medicineprcie" class="col-sm-3 control-label">Medicine Exp</label></td>
                                <div class="col-sm-7">
                                    <td><input type="number" name="txt_MedExp" class="form-control" placeholder="Enter Medicine Exp"></td>
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
                            <div class="row">
                            
                                <td><div class="col-sm-3 control-label">
                                    Select image to upload<br></td>
                                    
                                    <td><input type="file" name="file"></td>
                                    
                                </div>
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