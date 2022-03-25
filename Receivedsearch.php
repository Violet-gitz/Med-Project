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

    if (isset($_GET['delete_id'])) {
        $id = $_GET['delete_id'];


        $sql = "DELETE FROM tbl_med where MedId = '".$id."'";
        if($conn->query($sql) == TRUE){
          echo "<script type='text/javascript'>alert('ลบข้อมูลสำเร็จ');</script>";
        }else{
          echo "<script type='text/javascript'>alert('ลบข้อมูลไม่สำเร็จ');</script>";
        }
      
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
                  <a href="main.php" class="navbar-brand">หน้าหลัก</a>
                  
                  <a herf="main.php"><i class="fa fa-bell" data-toggle="modal" data-target="#centralModalLg" style ="font-size: 36px; color: 
                        <?php
                        if(count($med) > 0)
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
                            if(count($med) > 0)
                                {
                                    echo "<sup>".count($med)."</sup>";
                                }
                        ?>
                        </i>
                    </a>                
                </div>

                <div id="navbar1" class="collapse navbar-collapse" style='justify-content: end;'>
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">
                    
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
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
                <form action="Receivedsearch.php" method="post">
                    <input type="text" name="textsearch" placeholder = "ค้นหา">
                    <input type="submit" name="submit" value="ค้นหา">
                </form>
            </div>
    </div>
    <form method = "POST" action = "Exportreceived.php" style='display: flex;justify-content: end;'>
        <select name="Year" class='mr-2'>
            <option value="2022-">2022</option>
            <option value="2023-">2023</option>
            <option value="2024-">2024</option>
            <option value="2025-">2025</option>
        </select> 
        <select name="Month" class='mr-2' >
            <option value="01">มกราคม</option>
            <option value="02">กุมภาพันธ์</option>
            <option value="03">มีนาคม</option>
            <option value="04">เมษายน</option>
            <option value="05">พฤษภาคม</option>
            <option value="06">มิถุนายน</option>
            <option value="07">กรกฎาคม</option>
            <option value="08">สิงหาคม</option>
            <option value="09">กันยายน</option>
            <option value="10">ตุลาคม</option>
            <option value="11">พฤศจิกายน</option>
            <option value="12">ธันวาคม</option>
        </select>
        <button type = "submit" value = "<?php echo $with["WithId"]; ?>" name = "Report" class="btn btn-primary mr-2">รายงาน</button>
    </form>
 
    <table class="table table-striped">
         <div style='margin-bottom: 15px;'>
         <h2>รายการรับ</h2>
            </div>
        <thead>
            <tr>
                    <th>รหัสการรับ</th>
                    <th>รายการสั่งซื้อ</th>
                    <th>ราคา</th>
                    <th>สถานะการสั่งซื้อ</th>
                    <th>วันที่</th>
                    <th>ชื่อพนักงาน</th>
                    <th>ชื่อคนส่งของ</th>
                    <th>แก้ไข</th>
                    <th>รายงาน</th>
                
            </tr>
        </thead>

        <tbody>
            <?php 
                    $sql = "SELECT tbl_received.RecId,tbl_received.RecDate,tbl_received.RecDeli,tbl_order.OrderId,tbl_order.OrderStatus,tbl_order.OrderPrice,tbl_order.OrderTotal,tbl_staff.StaffName 
                    FROM tbl_received
                    INNER JOIN tbl_order ON tbl_received.OrderId = tbl_order.OrderId
                    INNER JOIN tbl_staff ON tbl_received.StaffId = tbl_staff.StaffId 
                    WHERE RecId LIKE '%{$search}%' OR RecDate LIKE '%{$search}%' OR OrderStatus LIKE '%{$search}%'";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $rec){

                        // $OrderStatus = $order["OrderStatus"];
            ?>

                <tr>
                    <td><?php echo $rec["RecId"]; ?></td>
                    <td><?php echo $rec["OrderId"]; ?></td>
                    <td><?php echo $rec["OrderPrice"];?></td>
                    <td><?php echo $rec["OrderStatus"];?></td>
                    <td><?php echo $rec["RecDate"]; ?></td>
                    <td><?php echo $rec["StaffName"]; ?></td>
                    <td><?php echo $rec["RecDeli"]; ?></td>
                    <td>
                        <form method = "POST" action = "Receivededit.php">
                            <button type = "submit" value = "<?php echo $rec["RecId"]; ?>" name = "Edit" class = "btn btn-warning"
                                <?php
                                    // if($OrderStatus == "Received")
                                    // {
                                    //     $buttonStatus = "Disabled";
                                    //     echo $buttonStatus;
                                    // }
                                    // else if($OrderStatus == "Cancel")
                                    // {
                                    //     $buttonStatus = "Disabled";
                                    //     echo $buttonStatus;
                                    // }
                                ?>
                                >แก้ไข
                            </button>
                        </form>
                    </td>

                    <td>
                        <form method = "POST" action = "Reportreceived.php">
                            <button type = "submit" value = "<?php echo $rec["RecId"]; ?>" name = "Report" class="btn btn-primary">รายงาน</button>
                            <input type ="hidden" name = "valueid" value = "<?php echo $rec["RecId"];?>">
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