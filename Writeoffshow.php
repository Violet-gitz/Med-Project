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

    if (isset($_GET['Cancelwriteoff'])) 
    {
        $write = $_GET['Cancelwriteoff'];
    
        $sql = "SELECT * FROM tbl_writeoff WHERE WriteId = '$write'";
        $result = $conn->query($sql);
        $data = array();
            while($row = $result->fetch_assoc()) 
            {
                $data[] = $row;  
            }
            foreach($data as $key => $writeoff)
            { 
                $lotid = $writeoff["LotId"];     
                $sql = "UPDATE tbl_lot SET LotStatus = 'Available' WHERE LotId = $lotid";
                if ($conn->query($sql) === TRUE) {     
                } else {
                echo "Error updating record: " . $conn->error;
                }

                $medid = $writeoff["MedId"];
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
                        $writeqty = $writeoff["Qty"];
                        $sum = $medqty + $writeqty;
                        $sql = "UPDATE tbl_med SET MedTotal = '$sum' WHERE MedId = $medid";
                        if ($conn->query($sql) === TRUE) {     
                        } else {
                        echo "Error updating record: " . $conn->error;
                }
                    }
            }
    }

    // if (isset($_REQUEST['Report'])) 
    // {
    //     require_once __DIR__ . '/vendor/autoload.php';
    //     $mpdf = new \Mpdf\Mpdf();

    //     $orderid = $_REQUEST["valueid"];
       
    //     $mpdf->WriteHTML
    //     (
    //        "Test" . $orderid

    //             );
    //     // Output a PDF file directly to the browser
    //     $mpdf->Output();
    // }

    $staff =  $_SESSION['StaffName'];
    $sql = "SELECT * FROM tbl_staff WHERE StaffName = '$staff'";
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
            window.location.href="Writeoffshow.php?Cancelwriteoff="+id;

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
                <form action="Writesearch.php" method="post">
                    <input type="text" name="textsearch" placeholder = "ค้นหา">
                    <input type="submit" name="submit" value="ค้นหา">
                </form>
            </div>
    </div>
    <form method = "POST" action = "Exportwriteoff.php" style='display: flex;justify-content: end;'>
        <select name="Year" class='mr-2'>
            <option value="2021-">2021</option>
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
         <h2>รายการตัดจำหน่าย<h2>
                </div>
            <thead>
            <tr>
                    <th>รายการตัดจำหน่าย</th>
                    <th>ล็อต</th>
                    <th>ชื่อยา</th>
                    <th>จำนวน</th>
                    <th>วันที่</th> 
                    <th>ชื่อพนักงาน</th>
                    <th>รายงาน</th>   
                    <th>ยกเลิก</th>
                    
                    
                </tr>
    </thead>

            <tbody>
                <?php 
                        $sql = "SELECT tbl_writeoff.WriteId,tbl_writeoff.LotId,tbl_writeoff.Qty,tbl_writeoff.WriteDate,tbl_lot.LotStatus,tbl_med.MedName,tbl_staff.StaffName 
                        FROM tbl_writeoff
                        INNER JOIN tbl_staff ON tbl_writeoff.StaffId = tbl_staff.StaffId
                        INNER JOIN tbl_lot ON tbl_writeoff.LotId = tbl_lot.LotId
                        INNER JOIN tbl_med ON tbl_writeoff.MedId = tbl_med.MedId;";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $write){
                            $Status = $write["LotStatus"];
       
                ?>

                    <tr>
                        <td><?php echo $write["WriteId"]; ?></td>
                        <td><?php echo $write["LotId"]; ?></td>
                        <td><?php echo $write["MedName"]; ?></td>
                        <td><?php echo $write["Qty"]; ?></td>
                        <td><?php echo $write["WriteDate"]; ?></td>
                        <td><?php echo $write["StaffName"]; ?></td>
                        <td>
                            <form method = "POST" action = "Reportwriteoff.php">
                                <button type = "submit" value = "<?php echo $write["WriteId"]; ?>" name = "Report" class="btn btn-primary"
                                <?php
                                    if($Status == "Available")
                                    {
                                        $buttonStatus = "Disabled";
                                        echo $buttonStatus;
                                    }
                                ?>
                                    >รายงาน</button>
                                <input type ="hidden" name = "valueid" value = "<?php echo $write["WriteId"];?>">
                            </form>
                        </td>
                        
                        <td>
                            <form method = "POST" action = "Writeoffshow.php">
                                <button type = "submit" value = "<?php echo $write["WriteId"]; ?>" name = "Cancelwriteoff" class="btn btn-danger" onclick ="CancelFunction(`<?php echo $write['WriteId']; ?>`)"
                                    <?php
                                        if($Status == "Available")
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
  
    
</body>
</html>