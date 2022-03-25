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
  <div class="row" style = "margin-top : 70px;">

    <div class="col">
        <a href="CheckOrder.php">
            <img src="./Pictures/cargo.png" alt="HTML tutorial" style="width:180px;height:180px;">
            <p>ข้อมูลการซื้อ</p>
        </a>
    </div>

    <div class="col">
        <a href="CheckReceived.php">
            <img src="./Pictures/parcel.png" alt="HTML tutorial" style="width:180px;height:180px;">
            <p>ข้อมูลการรับยา</p>
        </a>
    </div>

    <div class="col">
        <a href="Approve.php">
            <img src="./Pictures/approved.png" alt="HTML tutorial" style="width:180px;height:180px;">
            <p>ข้อมูลการอนุมัติ</p>
        </a>
    </div>

    <div class="col">
        <a href="CheckClaim.php">
            <img src="./Pictures/error.png" alt="HTML tutorial" style="width:180px;height:180px;">
            <p>ข้อมูลการเคลม</p>
        </a>
    </div>

    <div class="col">
        <a href="ClaimReceived.php">
            <img src="./Pictures/delivery.png" alt="HTML tutorial" style="width:180px;height:180px;">
            <p>ข้อมูลการรับเคลม</p>
        </a>
    </div>
    
    <div class="col">
        <a href="Writeoffshow.php">
            <img src="./Pictures/littering.png" alt="HTML tutorial" style="width:180px;height:180px;">
            <p>ข้อมูลการตัดจำหน่าย</p>
        </a>
    </div>

   

  </div>  
<body>
        
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