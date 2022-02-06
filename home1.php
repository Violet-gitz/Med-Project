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
        .row {
            margin-top: 25%;
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
        p {
            font-size: 20px;
            margin-top: 10px;
        }
    </style>

</head>


<body>
   
<div class="container">
  <div class="row">
    <div class="col">
        <a href="Staffshow.php">
            <img src="./Pictures/profile.png">
            <p>ข้อมูลผู้ใช้</p>

        </a>
    </div>

    <div class="col">
        <a href="Dealershow.php">
            <img src="./Pictures/drug-dealer.png">
            <p>ข้อมูลตัวแทนจำหน่าย</p>
        </a>
    </div>

    <div class="col">
        <a href="Departmentshow.php">
            <img src="./Pictures/department.png">
            <p>ข้อมูลแผนก</p>
        </a>
    </div>

   

  </div>  
<body>
        
    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>

</body>
</html>