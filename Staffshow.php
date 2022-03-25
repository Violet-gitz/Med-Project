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


    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        $sql = "DELETE FROM tbl_Staff WHERE StaffId = '".$id."'";
        if($conn->query($sql) == TRUE){
            echo "<script type='text/javascript'>alert('ลบข้อมูลสำเร็จ');</script>";
        }else{
            echo "<script type='text/javascript'>alert('ลบข้อมูลไม่สำเร็จ');</script>";
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
      function deleteFunction(id) {
      event.preventDefault(); // prevent form submit
      var form = document.forms["myForm"]; // storing the form
      swal({
             title: "Are you sure?",
             text: "คุณต้องการลบข้อมูลนี้ใช่ไหม",
             icon: "warning",
             buttons: true,
             dangerMode: true,
           })
          .then((isConfirm) => {

        if (isConfirm) {
            window.location.href="Staffshow.php?delete="+id;

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
                        if(count($med) > 0)
                            {
                                echo "red";
                            }
                        else 
                            {
                                echo "white";
                            }
                        ?> 
                        ; margin-left: 20em;" aria-hidden="true">  
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
                                
                                <li class="nav-item">
                                    <a href="Staffadd.php" class ="btn btn-success" style ="width: 100px;">เพิ่มพนักงาน</a>
                                </li>

                                <!-- <a href="Staffadd.php"><button class="btn btn-success" type="button" style ="width: 100px;" >เพิ่มพนักงาน</button></a> -->

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
 
    <div class="container-sm">
    <h2>ตารางข้อมูลพนักงาน</h2>
        <table class="table table-bordered">
            
                <tr>
                    <th>รหัสพนักงาน</th>
                    <th>ชื่อ</th>
                    <th>เบอร์โทร</th>
                    <th>อีเมล</th> 
                    <th>แผนก</th>
                    <th>แก้ไขข้อมูล</th>
                    <th>ลบข้อมูล</th>
                </tr>

            <tbody>
                <?php 
                    //$select_stmt = ;
                    // $result = mysqli_query($conn, "SELECT * FROM tbl_staff");
                    

                    // $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        // echo $row;
                        $sql = 'SELECT * FROM tbl_staff';
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) 
                        {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $staff){

                            $Depart = $staff["DepartId"];
                                $sql ="SELECT * FROM tbl_department WHERE $Depart = DepartId";
                                $result = $conn->query($sql);
                                $data = array();
                                    while($row = $result->fetch_assoc()) 
                                    {
                                        $data[] = $row;   
                                    }
                                    foreach($data as $key => $de){           
                ?>

                    <tr>
                        <td><?php echo $staff["StaffId"]; ?></td>
                        <td><?php echo $staff["StaffName"]; ?></td>
                        <td><?php echo $staff["StaffTel"]; ?></td>
                        <td><?php echo $staff["StaffEmail"]; ?></td>
                        <td><?php echo $de["DepartName"]; ?></td>
                        <td><a href="Staffedit.php?update_id=<?php echo $staff["StaffId"];?>" class="btn btn-warning">แก้ไขข้อมูล</a></td>
                        <form action = "Staffshow.php" method = "POST">
                            <input type ="hidden" name = "delete" value = "<?php echo $staff['StaffId']; ?>">
                            <td><button class ="btn btn-danger" type = "submit" name = "delete" onclick ="deleteFunction(`<?php echo $staff['StaffId']; ?>`)">ลบ</button></td>
                        </form>
                    </tr>

                    <?php } }?>

                    

                
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