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
                  <a href="main.php" class="navbar-brand">หน้าหลัก</a>
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

    <style>
        .container {
            margin: 0 auto;
            min-width: 920px;
        }
        .col {
            text-align : center;
        }
        img {
            width: 200px;   
            height: 200px;
        }
        h4 {
            margin-top: 20px;
        }
    </style>


</head>


<body>
   
<div class="container">
  <div class="row" style = "margin-top : 25%;">
    <div class="col">
        <a href="home1.php">
            <img src="./Pictures/people.png" alt="HTML tutorial">
            <h4 style = "text-align:center;">จัดการข้อมูลพื้นฐาน</h4>
        </a>
    </div>

    <div class="col">
        <a href="Orders.php">
            <img src="./Pictures/shopping-cart.png" alt="HTML tutorial">
            <h4 style = "text-align:center;">สั่งซื้อ</h4>
        </a>
    </div>

    <div class="col">
        <a href="home3.php">
            <img src="./Pictures/pills.png" alt="HTML tutorial">
            <h4 style = "text-align:center;">จัดการข้อมูลยา</h4>
        </a>
    </div>

     <div class="col">
        <a href="home2.php">
            <img src="./Pictures/package.png" alt="HTML tutorial">
            <h4 style = "text-align:center;">จัดการข้อมูล</h4>
        </a>
    </div>

  </div>  
<body>
        
    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>

</body>
</html>