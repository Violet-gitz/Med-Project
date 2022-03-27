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

    if (isset($_REQUEST['Cancelclaim'])) 
    {
        $cliamid = $_REQUEST['Cancelclaim'];

        $sql = "UPDATE tbl_claim SET ClaimStatus  = 'ยกเลิก' WHERE ClaimId = $cliamid";
        if ($conn->query($sql) === TRUE) {     
        } else {
        echo "Error updating record: " . $conn->error;
        }
    
        $sql = "SELECT * FROM tbl_claim WHERE ClaimId = '$cliamid'";
        $result = $conn->query($sql);
        $data = array();
            while($row = $result->fetch_assoc()) 
            {
                $data[] = $row;  
            }
            foreach($data as $key => $claim)
            {   
                $lotid = $claim["LotId"];    
                $claimqty = $claim["Qty"];

                 
                $sql = "UPDATE tbl_lot SET LotStatus = 'สามารถใช้งานได้' , Qty = $claimqty WHERE LotId = $lotid";
                if ($conn->query($sql) === TRUE) {     
                } else {
                echo "Error updating record: " . $conn->error;
                }

                $medid = $claim["MedId"];
                $sql = "SELECT * FROM tbl_med WHERE MedId = '$medid'";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) 
                    {
                        $data[] = $row;  
                    }
                    foreach($data as $key => $med)
                    {
                        $medqty = $med["MedTotal"];
                        $claimqty = $claim["Qty"];
                        $sum = $medqty + $claimqty;
                       
                        $sql = "UPDATE tbl_med SET MedTotal = '$sum' WHERE MedId = $medid";
                        if ($conn->query($sql) === TRUE) {     
                        } else {
                        echo "Error updating record: " . $conn->error;
                }
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
        foreach($data as $key => $staff)
        {      

        }

    $sql = "SELECT * FROM tbl_med WHERE MedTotal <= MedPoint";
    $result1 = $conn->query($sql);
    $med = array();
    while($row = $result1->fetch_assoc()) 
        {
            $med[] = $row;  
        }

        $sql = "SELECT * FROM tbl_lot WHERE LotStatus != 'เคลม' AND LotStatus != 'ตัดจำหน่าย' AND LotStatus != 'ไม่สามารถใช้งานได้'";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) 
        {
        $data[] = $row;   
        }
        $Alert = 0;
        foreach($data as $key => $lot)
        {
            $Medid = $lot["MedId"];
            $sql = "SELECT * FROM tbl_med WHERE $Medid = MedId";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) 
            {
            $data[] = $row;   
            }
            foreach($data as $key => $Med)
            {

                $mednotidate = $Med["MedNoti"];
                date_default_timezone_set("Asia/Bangkok");
                $datenow = date("d")."-".date("m")."-".(date("Y")+543);
                $ExpDate = $lot["Exd"];
                $datenow=date_create($datenow);
                $dateexp=date_create($ExpDate);
                $diff=date_diff($datenow,$dateexp);
                if($diff->format('%R%a') <= $mednotidate)
                {
                $Alert++;
                }
            }   
        }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <title>Document</title>

    <script>
      function CancelFunction(id) {
      event.preventDefault(); // prevent form submit
      var form = document.forms["myForm"]; // storing the form
      swal({
             title: "Are you sure?",
             text: "คุณต้องการยกเลิกข้อมูลนี้ใช่ไหม",
             icon: "warning",
             buttons: true,
             dangerMode: true,
           })
          .then((isConfirm) => {

        if (isConfirm) {
            window.location.href="CheckClaim.php?Cancelclaim="+id;

        } else {
            swal("ยกเลิกสำเร็จ");
        }
    });

    }
    </script>

    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
                <div style='margin-right: 15px'>
                    <?php
                    include('slidebar.php');   
                    ?>
                </div>
                <div> 
                  <a href="main.php" class="navbar-brand">หน้าหลัก</a>
                  
                  <a herf="main.php"><i class="fa fa-bell" data-toggle="modal" data-target="#centralModalLg" style ="font-size: 36px; color: 
                        <?php
                        if((count($med)+$Alert) > 0)
                            {
                                echo "red";
                            }
                        else 
                            {
                                echo "white";
                            }
                        ?> 
                        ; margin-left: 22em;" aria-hidden="true">  
                        <?php
                            if((count($med)+$Alert) > 0)
                                {
                                    echo "<sup>".(count($med)+$Alert)."</sup>";
                                }
                        
                        ?>
                        </i>
                    </a>                
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
                                            <a class="dropdown-item" href="Staffedit.php?update_id=<?php echo $staff["StaffId"];?>">แก้ไขข้อมูลส่วนตัว</a>
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

<div class="container">

<div class="container-sm">
    <div class="row mb-5">
            <div class="col-md-4 ms-auto " style="text-align: end;">
                <form action="ClaimSearch.php" method="post">
                    <input type="text" name="textsearch" placeholder = "ค้นหา">
                    <input type="submit" name="submit" value="ค้นหา">
                </form>
            </div>
    </div>
    <form method = "POST" action = "Exportclaim.php" style='display: flex;justify-content: end;'>
        <select name="Year" class='mr-2'>
            <option value="2565">2565</option>
            <option value="2566">2566</option>
            <option value="2567">2567</option>
            <option value="2568">2568</option>
        </select> 
        <select name="Month" class='mr-2' >
            <option value="01-">มกราคม</option>
            <option value="02-">กุมภาพันธ์</option>
            <option value="03-">มีนาคม</option>
            <option value="04-">เมษายน</option>
            <option value="05-">พฤษภาคม</option>
            <option value="06-">มิถุนายน</option>
            <option value="07-">กรกฎาคม</option>
            <option value="08-">สิงหาคม</option>
            <option value="09-">กันยายน</option>
            <option value="10-">ตุลาคม</option>
            <option value="11-">พฤศจิกายน</option>
            <option value="12-">ธันวาคม</option>
        </select>
        <button type = "submit" value = "<?php echo $with["WithId"]; ?>" name = "Report" class="btn btn-primary mr-2">รายงาน</button>
    </form>
 
    <table class="table table-striped">
         <div style='margin-bottom: 15px;'>
            <h2>ตารางการส่งเคลม</h2>
            </div>
            <thead>
            <tr>
                <th>รหัสการเคลม</th>
                <th>วันที่เคลม</th>
                <th>สถานะ</th>
                <th>ล็อตที่</th> 
                <th>จำนวน</th>
                <th>ชื่อตัวแทนจำหน่าย</th>
                <th>ที่อยู่ตัวแทนจำหน่าย</th>
                <th>รับ</th>
                <th>รายงาน</th>
                <th>ยกเลิก</th>
                
            </tr>
        </thead>
        

        <tbody>
            <?php 
                    $sql = "SELECT tbl_claim.ClaimId,tbl_claim.LotId,tbl_claim.StaffId,tbl_claim.DealerId,tbl_claim.MedId,tbl_claim.Qty,tbl_claim.Reason,tbl_claim.ClaimDate,tbl_claim.ClaimStatus,tbl_dealer.DealerName,tbl_dealer.DealerAddress,tbl_staff.StaffName
                    FROM tbl_claim
                    INNER JOIN tbl_dealer ON tbl_dealer.DealerId = tbl_claim.DealerId
                    INNER JOIN tbl_lot ON tbl_lot.LotId = tbl_claim.LotId
                    INNER JOIN tbl_med ON tbl_med.MedId = tbl_claim.MedId
                    INNER JOIN tbl_staff ON tbl_staff.StaffId = tbl_claim.StaffId";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $claim){
                     
                        $ClaimStatus = $claim["ClaimStatus"];                   
            ?>

                <tr>
                    <td><?php echo $claim["ClaimId"]; ?></td>
                    <td><?php echo $claim["ClaimDate"]; ?></td>
                    <td><?php echo $claim["ClaimStatus"]; ?></td>
                    <td><?php echo $claim["LotId"]; ?></td>
                    <td><?php echo $claim["Qty"]; ?></td>
                    <td><?php echo $claim["DealerName"]; ?></td>
                    <td><?php echo $claim["DealerAddress"]; ?></td>
                    <td>
                        <form method = "POST" action = "ReceivdClaim.php">
                            <button type = "submit" value = "<?php echo $claim["ClaimId"]; ?>" name = "Claim_id" class = "btn btn-success"
                                <?php
                                    if($ClaimStatus == "รับสำเร็จ")
                                    {
                                        $buttonStatus = "Disabled";
                                        echo $buttonStatus;
                                    }
                                    else if($ClaimStatus == "ยกเลิก")
                                    {
                                        $buttonStatus = "Disabled";
                                        echo $buttonStatus;
                                    }
                                ?>
                                >รับ
                            </button>
                        </form>
                    </td>

                    <td>
                        <form method = "POST" action = "Reportclaim.php">
                            <button type = "submit" value = "<?php echo $claim["ClaimId"]; ?>" name = "Report" class="btn btn-primary">รายงาน</button>
                            <input type ="hidden" name = "valueid" value = "<?php echo $claim["ClaimId"];?>">
                        </form>
                    </td>

                    <td>
                        <form method = "POST" action = "CheckClaim.php">
                            <button type = "submit" value = "<?php echo $claim["ClaimId"]; ?>" name = "Cancelclaim" class="btn btn-danger" onclick ="CancelFunction(`<?php echo $claim['ClaimId']; ?>`)"
                                <?php
                                    if($ClaimStatus == "สามารถใช้งานได้")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                        else if($ClaimStatus == "รับสำเร็จ")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                        else if($ClaimStatus == "ยกเลิก")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                ?>
                                    >ยกเลิก
                            </button>
                        </form>
                    </td> 
                </tr>

                <?php 
            }?>

                

            
        </tbody>
    </table>
</div>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    
    <div class="modal fade" id="centralModalLg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <!--Content-->
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header">
            <h4 class="modal-title w-100" id="myModalLabel">รายการแจ้งเตือน</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!--Body-->
          <?php
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
                        echo $med['MedName']." : ต่ำกว่าจุดสั่งซื้อ<br>";
                    }
                }

                $sql = "SELECT * FROM tbl_lot WHERE LotStatus != 'เคลม' AND LotStatus != 'ตัดจำหน่าย' AND LotStatus != 'ไม่สามารถใช้งานได้'";
                $result = $conn->query($sql);
                $data = array();
                while($row = $result->fetch_assoc()) 
                {
                $data[] = $row;   
                }

                    foreach($data as $key => $lot)
                    {
                        $Medid = $lot["MedId"];
                        $sql = "SELECT * FROM tbl_med WHERE $Medid = MedId";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) 
                        {
                        $data[] = $row;   
                        }
                        foreach($data as $key => $Med)
                        {
        
                        $mednotidate = $Med["MedNoti"];
                        date_default_timezone_set("Asia/Bangkok");
                        $datenow = date("d")."-".date("m")."-".(date("Y")+543);
                        $ExpDate = $lot["Exd"];
                        $lot = $lot["LotId"];
                        $medname = $Med["MedName"];
                        $datenow=date_create($datenow);
                        $dateexp=date_create($ExpDate);
                        $diff=date_diff($datenow,$dateexp);
                        if($diff->format('%R%a') <= $mednotidate)
                        {
                        
                            echo $medname ." : ล็อคที่  ". $lot." กำลังจะหมดอายุภายในอีก  ".$diff->format("%a"). " วัน  <br>";
                        }
                    }
                }
            ?>
   
          <!--Footer-->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

          </div>
        </div>
        <!--/.Content-->
      </div>
    </div>
    
</body>
</html>