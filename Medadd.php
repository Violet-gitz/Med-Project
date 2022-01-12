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
        }else {
            $query = "SELECT * FROM tbl_med WHERE MedName = '$MedName'  LIMIT 1";
            $result = mysqli_query($conn, $query); 
            $row = mysqli_fetch_array($result);
        if($row["MedName"] === $MedName) {
            $errorMsg =  "Medicine already exists";
        }
        else {
        $sql = "INSERT INTO tbl_med(MedName , MedCate , MedVolumn , MedUnit , MedPack , MedPrice , MedLow , MedDes , MedPoint , MedTotal , MedPath , MedIndi , MedType) VALUES ('$MedName', '$MedCate','$MedVolumn', '$MedUnit', '$MedPack', '$MedPrice', '$MedLow', '$MedDes', '$MedPoint', '$MedTotal', '$MedPath' , '$MedIndi' , '$MedType')";
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
                            <td><textarea id="w3review" name="txt_MedDes" rows="4" cols="50" placeholder="Enter Medicine Description..."></textarea></td>
                            </div>
                        </div>
                    </div>
                </tr>

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicinedes" class="col-sm-3 control-label">Indication</label></td>
                            <div class="col-sm-7">
                            <td><textarea id="w3review" name="txt_MedIndi" rows="4" cols="50" placeholder="Enter Medicine Indication..."></textarea></td>
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

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Medicineprcie" class="col-sm-3 control-label">Reorder Point</label></td>
                            <div class="col-sm-7">
                                <td><input type="text" name="txt_MedPoint" class="form-control" placeholder="Enter Medicine Point"></td>
                            </div>
                        </div>
                    </div>
                </tr>

                <tr>
                    <div class="form-group text-center">
                        <div class="row">
                            <td><label for="Category" class="col-sm-3 control-label">Medicine Type</label></td>
                            <div class="col-sm-1">
                                <td><select name = "txt_Medtype">
                                    <option value="">Select</option> 
                                    <option value="Internal medicine">Internal medicine</option>
                                    <option value="External medicine">External medicine</option>
                                </select><br><br></td>
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
                                    <option value="">Select</option> 
                                    <option value="Nucleoside Reverse Transcriptase Inhibitors">ยาต้านไวรัสในกลุ่มเอ็นอาร์ทีไอ/ Nucleoside Reverse Transcriptase Inhibitors: NRTI</option>
                                    <option value="Mucolytic">ยาละลายเสมหะ/ Mucolytic</option>
                                    <option value="Retinoids">ยาเรตินอยด์/ Retinoids</option>
                                    <option value="Vermifuge">ยาถ่ายพยาธิ/ Vermifuge</option>
                                    <option value="Intravenous & Other Sterile Solutions">ยาฉีดเข้าหลอดเลือดดำ และสารละลาย Intravenous & Other Sterile Solutions</option>
                                    <option value="Household Remedy">ยาสามัญ/ Household Remedy</option>
                                    <option value="Antiviral Drug">ยาต้านไวรัส/ Antiviral Drug</option>
                                    <option value="Calcium Channel Blocker">ยาแคลเซียมแชนแนลบล็อกเกอร์/ Calcium Channel Blocker</option>
                                    <option value="Penicillin">ยาปฏิชีวนะกลุ่มเพนิซิลลิน/ Penicillin</option>
                                    <option value="Supplementary Food">อาหารเสริม / Supplementary Food</option>
                                    <option value="Erectile Dysfunction Drug">ยารักษาภาวะหย่อนสมรรถภาพทางเพศ/ Erectile Dysfunction Drug</option>
                                    <option value="Angiotensin Receptor Blockers">ยาต้านตัวรับแองจิโอเทนซิน Angiotensin Receptor Blockers: ARB</option>
                                    <option value="Muscle Relaxants">ยาคลายกล้ามเนื้อ / Muscle Relaxants</option>
                                    <option value="Cinnarizine">ยารักษาอาการวิงเวียนศีรษะ/ Cinnarizine</option>
                                    <option value="Laxative">ยาระบาย/ Laxative</option>
                                    <option value="Beta Blockers">ยาเบต้าบล็อกเกอร์/ Beta Blockers</option>
                                    <option value="Cephalosporin">ยาปฏิชีวนะกลุ่มเซฟาโลสปอริน/ Cephalosporin</option>
                                    <option value="NSAIDs">ยาแก้อักเสบที่ไม่ใช่สเตียรอยด์ NSAIDs</option>
                                    <option value="Antihistamine">ยาต้านการทำงานของฮีสตามีน Antihistamine</option>
                                    <option value="Antiplatelet">ยาต้านเกล็ดเลือด ยาขยายหลอดเลือด/ Antiplatelet</option>
                                    <option value="Allopurinol">ยาสำหรับรักษาภาวะกรดยูริคในเลือดสูงและโรคเก๊าท์/ Allopurinol</option>
                                    <option value="H2 Blockers">ยาปิดกั้นตัวรับฮิสตามีนชนิดที่ 2 H2 Blockers</option>
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
                                    <option value="">Select</option> 
                                    <option value="50 Ml MG">50 ML</option>
                                    <option value="100 CC">100 CC</option>
                                    <option value="500 CC">500 CC</option>
                                    <option value="1000 CC">1000 CC</option>
                                    <option value="1 MG">1 MG</option>
                                    <option value="4 MG">4 MG</option>
                                    <option value="5 MG">5 MG</option>
                                    <option value="8 MG">8 MG</option>
                                    <option value="10 MG">10 MG</option>
                                    <option value="12.5 MG">12.5 MG</option>
                                    <option value="24 MG">24 MG</option>
                                    <option value="25 MG">25 MG</option>
                                    <option value="30 MG">30 MG</option>
                                    <option value="40 MG">40 MG</option>
                                    <option value="100 MG">100 MG</option>
                                    <option value="250 MG">250 MG</option>
                                    <option value="300 MG">300 MG</option>
                                    <option value="400 MG">400 MG</option>
                                    <option value="500 MG">500 MG</option>
                                    <option value="600 MG">600 MG</option>
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
                                    <option value="">Select</option> 
                                    <option value="Pill">Pill</option>
                                    <option value="Tablet">Tablet</option>
                                    <option value="Capsule">Capsule</option>  
                                    <option value="Powder">Powder</option> 
                                    <option value="Solution">Solution</option>
                                    <option value="Suppository">Suppository</option>
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