
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


     if (isset($_GET['logout'])) {
            session_destroy();
            unset($_SESSION['StaffUsername']);
            header('location: login.php');
        }


        if (isset($_REQUEST['submit'])) {
            $search = $_REQUEST['textsearch'];
           
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

            $sql = "SELECT * FROM tbl_med";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) 
                {
                    $data[] = $row;  
                }
                foreach($data as $key => $med)
                {   
                    $MedPoint = $med["MedPoint"];  
                    $MedTotal = $med["MedTotal"];  
                    if($MedTotal <= $MedPoint)
                    {
                        ini_set('display_errors', 1);
                        ini_set('display_startup_errors', 1);
                        error_reporting(E_ALL);
                        date_default_timezone_set("Asia/Bangkok");
                        $sToken = "5QZMmRQRyNbvtvPsg0utZxUal4y02ag6Ec1Eqhrz1ch";
        
                        $medname = $med["MedName"];
                    
                        $sMessage = $medname ." was reached reorder point !";
                        $chOne = curl_init(); 
                        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
                        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
                        curl_setopt( $chOne, CURLOPT_POST, 1); 
                        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
                        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
                        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
                        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                        $result = curl_exec( $chOne ); 
                        //Result error 
                            if(curl_error($chOne)) 
                            { 
                                echo 'error:' . curl_error($chOne);
                            } 
                            else 
                            { 
                                $result_ = json_decode($result, true); 
                                    // echo "status : ".$result_['status']; echo "message : ". $result_['message'];
                            } 
                                curl_close( $chOne );
                    }
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
                    include('slidebaruser.php');   
                    ?>
                </div>
                <div> 
                  <a href="Mainuser.php" class="navbar-brand">หน้าหลัก</a>
                </div>

                <!-- <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button> -->
                <div id="navbar1" class="collapse navbar-collapse" style='justify-content: end;'>
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">

                                <li class="nav-item" style='margin-right: 15px;'>
                                    <td><a href="cartuser.php" class ="btn btn-success">ตะกร้าสินค้า</a></td>
                                </li>

                                <button class="btn btn-info  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                ><?php echo $_SESSION['StaffName'] ?>
                                </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <form method="POST" action="edituser.php">
                                            <a class="dropdown-item" href="edituser.php?update_id=<?php echo $staff["StaffId"];?>">แก้ไขข้อมูลส่วนตัว</a>
                                            <input type="hidden" name ='update_id' value ="<?php echo $staff["StaffId"]; ?>">
                                        </from>

                                        <form method="POST" action="index.php">
                                            <a class="dropdown-item" href="index.php?logout='1'">ออกจากระบบ</a>
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

    <div class="container-sm">
    <div class="row mb-5">
            <div class="col-md-4 ms-auto " style="text-align: end;">
                <form action="Mainusersearch.php" method="post">
                    <input type="text" name="textsearch" placeholder = "ค้นหา">
                    <input type="submit" name="submit" value="ค้นหา">
                </form>
            </div>
    </div>
    
    <center><strong><h2>รายการยา</h2></strong></center>
    <div class="container-sm">
    
        <table class="table table-striped" style="width:1500px; margin-left:-200px ; margin-top: 4rem;">
            <thead>
                <tr>
                    <th>รูป</th>
                    <th style="width:20%">ชื่อยา</th>
                    <th>ประเภท</th>
                    <th>หมวดหมู่</th>
                    <th>ปริมาณ</th>
                    <th>หน่วยหนับ</th>
                    <th>จำนวนคงเหลือ</th>
                    <th>จำนวน</th>
                    <th>เบิก</th>
                </tr>
            </thead>

            <tbody>
                <?php       
                        $sumReserve = 0;             
                        $sql = "SELECT tbl_med.MedId,tbl_med.TypeId,tbl_med.CateId,tbl_med.VolumnId,tbl_med.UnitId,tbl_med.MedName,tbl_med.MedPack,tbl_med.MedPrice,tbl_med.MedDes,tbl_med.MedIndi,tbl_med.MedLow,tbl_med.MedTotal,tbl_med.MedPoint,tbl_med.MedPath,tbl_type.TypeName,tbl_cate.CateName,tbl_volumn.VolumnName,tbl_unit.UnitName
                        FROM tbl_med
                        INNER JOIN tbl_type ON tbl_type.TypeId = tbl_med.TypeId
                        INNER JOIN tbl_cate ON tbl_cate.CateId = tbl_med.CateId
                        INNER JOIN tbl_volumn ON tbl_volumn.VolumnId = tbl_med.VolumnId
                        INNER JOIN tbl_unit ON tbl_unit.UnitId = tbl_med.UnitId
                        WHERE MedName LIKE '%{$search}%' OR TypeName LIKE '%{$search}%' OR CateName LIKE '%{$search}%' OR VolumnName LIKE '%{$search}%' OR UnitName LIKE '%{$search}%'";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $Med){
                            
                            $medtotal = $Med["MedTotal"];
                            $medid = $Med["MedId"];

                            $sql = "SELECT * FROM tbl_lot WHERE MedId = '$medid'";
                            $result = $conn->query($sql);
                            $data = array();
                            while($row = $result->fetch_assoc()) {
                                $data[] = $row;   
                            }
                            foreach($data as $key => $lot)
                            {
                                $Reserve = $lot["Reserve"];
                                $sumReserve = $sumReserve + $Reserve;
                                $sum = $medtotal - $sumReserve;
                            }
                ?>

                    <tr>
                    <form action = "cartuser.php" method="post">
                        <td><?php echo '<img src="upload/'.$Med['MedPath'].'" height = "80" widht = "80"/>';?></td>
                        <td><?php echo $Med["MedName"]; ?></td>
                        <td><?php echo $Med["TypeName"]; ?></td>
                        <td><?php echo $Med["CateName"]; ?></td>
                        <td><?php echo $Med["VolumnName"]; ?></td>
                        <td><?php echo $Med["UnitName"]; ?></td>
                        <td><?php echo $sum; ?></td>
                        <td><input type="number" name="quantity" min="1" max="<?php echo $sum; ?>" value= "1"></td>
                        <td><input type="submit" class = "btn btn-info" value = "เพิ่มสินค้าลงตะกร้า"></td>
                        <input type ="hidden" name = "testMedId" value = "<?php echo $Med["MedId"]; ?>">
                        <input type ="hidden" name = "act" value = "add">
                        </form>
                    </tr>

                    <?php } ?>
                
            </tbody>
        </table>
    </div>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>