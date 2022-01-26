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

    if (isset($_REQUEST['Cancel_id'])) 
        {
            $withid = $_REQUEST['Cancel_id'];
    
            $sql = "UPDATE tbl_withdraw SET WithStatus = 'Cancel' WHERE WithId = $withid";
            if ($conn->query($sql) === TRUE) {     
            } else {
              echo "Error updating record: " . $conn->error;
            }
            
            $sql = "SELECT * FROM tbl_withdraw WHERE WithId = '$withid'";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) 
                {
                    $data[] = $row;  
                }
                foreach($data as $key => $withdraw)
                {      

                    $withdrawId = $withdraw["WithId"];
                    $sql = "SELECT * FROM tbl_withdrawdetail WHERE WithId = '$withid'";
                    $result = $conn->query($sql);
                    $data = array();
                        while($row = $result->fetch_assoc()) 
                        {
                            $data[] = $row;  
                        }
                        foreach($data as $key => $withdrawdetail)
                        {   
                            $lotid = $withdrawdetail["LotId"];
                            $sql = "SELECT * FROM tbl_lot WHERE LotId = '$lotid'";
                            $result = $conn->query($sql);
                            $data = array();
                                while($row = $result->fetch_assoc()) 
                                {
                                    $data[] = $row;  
                                }
                                foreach($data as $key => $lot)
                                {
                                    $withqty = $withdrawdetail["Qty"];
                                    $Reserve = $lot["Reserve"];
                                    $sum = $Reserve - $withqty;

                                    $sql = "UPDATE tbl_lot SET Reserve = '$sum' WHERE LotId = $lotid";
                                    if ($conn->query($sql) === TRUE) {     
                                    } else {
                                      echo "Error updating record: " . $conn->error;
                                    }

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
                    include('slidebaruser.php');   
                    ?>
                </div>
                <div> 
                  <a href="Mainuser.php" class="navbar-brand">หนัาหลัก</a>
                </div>

                <!-- <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button> -->
                <div id="navbar1" class="collapse navbar-collapse" style='justify-content: end;'>
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">

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

<div class="container">
  <div class="row">
        <div class="col-md-4 ms-auto">
            <form action="usersearch.php" method="post">
                <input type="text" name="textsearch" placeholder = "ค้นหา">
                <input type="submit" name="submit" value="ค้นหา">
            </form>
        </div>
  </div>
</div><br>

<div class="container">
 
    <table class="table table-striped">
         <div style='margin-bottom: 15px;'>
         <h2>รายการขออนุมัติ</h2>
            </div>
            <thead >
            <tr>
                <th>รหัสการเบิก</th>
                <th>ชื่อพนักงาน</th>
                <th>จำนวน</th>
                <th>สถานะ</th>
                <th>วันที่เบิก</th>
                <th>รายงาน</th>
     
               
            </tr>
        </thead>
        <tbody>
            <?php 
                    $sql = "SELECT * FROM tbl_withdraw";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $with){

                        $staffid = $with["StaffId"];
                        $sql = "SELECT * FROM tbl_staff WHERE StaffId = $staffid";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $staff){
                            $withstatus = $with["WithStatus"];
                      
            ?>

                <tr>
                    <td><?php echo $with["WithId"]; ?></td>
                    <td><?php echo $staff["StaffName"]; ?></td>
                    <td><?php echo $with["Qtysum"]; ?></td>
                    <td><?php echo $with["WithStatus"]; ?></td>
                    <td><?php echo $with["WithDate"]; ?></td>
                    <?php
                        if ($withstatus == "Approved")
                        {
                            echo '<td>
                                    <form method = "POST" action = "userreport.php">
                                        <button type = "submit" value = "'.$with["WithId"].'" name = "Report" class="btn btn-primary">รายงาน</button>
                                        <input type ="hidden" name = "valueid" value = '.$with["WithId"].'">
                                    </form>
                                </td>';
                        }
                    ?>

                <?php } } ?>
            
            
        </tbody>
    </table>
    </div>

                   
 

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>

  
</body>
</html>