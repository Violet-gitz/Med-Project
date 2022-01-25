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

        
        $sql = "DELETE FROM tbl_dealer where DealerId = '".$id."'";
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
        foreach($data as $key => $staff){      

        }


    $sql = "SELECT *FROM tbl_dealer";
    $result = $conn->query($sql);
    $data = array();
    while($row = $result->fetch_assoc()) 
    {
    $data[] = $row;   
    }
    foreach($data as $key => $deal)
    {
        $dealername = $deal["DealerName"];
        $MfdDate = $deal["ContractStart"];
        $ExpDate = $deal["ContractEnd"];
        $datemfd=date_create($MfdDate);
        $dateexp=date_create($ExpDate);
        $diff=date_diff($datemfd,$dateexp);
        if($diff->format('%R%a')<=400)
        {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            date_default_timezone_set("Asia/Bangkok");
            $sToken = "5QZMmRQRyNbvtvPsg0utZxUal4y02ag6Ec1Eqhrz1ch";
                
            $sMessage = $dealername. "Contract Expire in " . $diff->format('%R%a') . " Day !!!";
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
            window.location.href="Dealershow.php?delete="+id;

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
                </div>

                <div id="navbar1" class="collapse navbar-collapse" style='justify-content: end;'>
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">
                                
                            <li class="nav-item">
                                    <td><a href="Dealeradd.php" class ="btn btn-success">เพิ่มตัวแทนจำหน่าย</a></td>
                                </li>

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
    <h2>ตารางข้อมูลตัวแทนจำหน่าย</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัสตัวแทนจำหน่าย</th>
                    <th>ชื่อตัวแทนจำหน่าย</th>
                    <th style="width:15%">ที่อยู่ตัวแทนจำหน่าย</th>
                    <th>เบอร์โทรศัพท์ตัวแทนจำหน่าย</th>
                    <th style="width:13%">วันเริ่มต้นสัญญา</th>
                    <th style="width:13%">วันสิ้นสุดสัญญา</th>
                    <th style="width:15%">แก้ไขข้อมูล</th>
                    <th style="width:10%">ลบข้อมูล</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                    //$select_stmt = ;
                    // $result = mysqli_query($conn, "SELECT * FROM tbl_staff");
                    

                    // $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        // echo $row;
                        $sql = 'SELECT * FROM tbl_dealer';
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $dealer){               
                ?>

                    <tr>
                        <td><?php echo $dealer["DealerId"]; ?></td>
                        <td><?php echo $dealer["DealerName"]; ?></td>
                        <td><?php echo $dealer["DealerAddress"]; ?></td> 
                        <td><?php echo $dealer["DealerPhone"]; ?></td> 
                        <td><?php echo $dealer["ContractStart"]; ?></td> 
                        <td><?php echo $dealer["ContractEnd"]; ?></td> 
                        <td><a href="Dealeredit.php?update_id=<?php echo $dealer["DealerId"];?>" class="btn btn-warning">แก้ไขข้อมูล</a></td>
                        <form action = "Dealershow.php" method = "POST">
                            <input type ="hidden" name = "delete" value = "<?php echo $dealer["DealerId"]; ?>">
                            <td><button class ="btn btn-danger" type = "submit" name = "delete" onclick ="deleteFunction(`<?php echo $dealer['DealerId']; ?>`)">ลบ</button></td>
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