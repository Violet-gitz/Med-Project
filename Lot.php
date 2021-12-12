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

        /*if (isset($_GET['delete'])) {
            $id = $_GET['delete'];


        // Delete an original record from db
        //$sql = 'DELETE FROM tbl_Staff WHERE StaffId' =.$id);


        $sql = "DELETE FROM tbl_lot WHERE LotId = '".$id."'";
        if($conn->query($sql) == TRUE){
            echo "<script type='text/javascript'>alert('ลบข้อมูลสำเร็จ');</script>";
        }else{
            echo "<script type='text/javascript'>alert('ลบข้อมูลไม่สำเร็จ');</script>";
        }
      
    }*/

    $sql = "SELECT *FROM tbl_lot";
    $result = $conn->query($sql);
    $data = array();
    while($row = $result->fetch_assoc()) 
    {
    $data[] = $row;   
    }
    foreach($data as $key => $lot)
    {
        $MedId = $lot["MedId"];
        $sql = "SELECT* FROM tbl_med WHERE MedId = $MedId";
        $result = $conn->query($sql);
        $data = array();
            while($row = $result->fetch_assoc()) 
            {
                $data[] = $row;  
            }
            foreach($data as $key => $Med)
            {
                $MfdDate = $lot["Mfd"];
                $ExpDate = $lot["Exd"];
                $datemfd=date_create($MfdDate);
                $dateexp=date_create($ExpDate);
                $diff=date_diff($datemfd,$dateexp);
                if($diff->format('%R%a')<=150)
                {
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                    date_default_timezone_set("Asia/Bangkok");
                    $sToken = "5QZMmRQRyNbvtvPsg0utZxUal4y02ag6Ec1Eqhrz1ch";
            
                    $lot = $lot["LotId"];
                    $medname = $Med["MedName"];
                
                    $sMessage = $medname ." Lot #". $lot." Expiry tracking alert "."in ".$diff->format('%R%a'). " day ! " . "link http://localhost/project/Lot.php";
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

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11.2.0/dist/sweetalert2.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   
  
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
                <a href="main.php" class="navbar-brand">Home Page</a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">

                                <li class="nav-item">
                                    <td><a href="Withdrawcart.php" class ="btn btn-info">Cart</a></td>
                                </li>

                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                ><?php echo $_SESSION['StaffName'] ?>
                                </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <form method="POSt" action="Staffedit.php">
                                            <a class="dropdown-item" href="Staffedit.php?update_id=<?php echo $staff["StaffId"];?>">Edit</a>
                                            <input type="hidden" name ='update_id' value ="<?php echo $staff["StaffId"]; ?>">
                                        </from>

                                        <form method="POST" action="index.php">
                                            <a class="dropdown-item" href="index.php?logout='1'">Logout</a>
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
    <?php
            include('slidebar.php');           
    ?>


<div class="container">
  <div class="row">
        <div class="col-md-4 ms-auto">
            <form action="LotSearch.php" method="post">
                <input type="text" name="search" placeholder = "search">
                <input type="submit" name="submit" value="Search">
            </form>
        </div>
  </div>
</div><br>

<div class="container-sm">
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Lot Id</th>
                <th>Medicine</th>
                <th>Pictures</th>
                <th>Quantity</th>
                <th>Reserve</th>
                <th>Status</th>
                <th>Expire</th>
                <th>Detail</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php 
                    $sql = "SELECT tbl_lot.LotId,tbl_lot.MedId,tbl_lot.RecClaimid,tbl_lot.Qty,tbl_lot.Reserve,tbl_lot.Mfd,tbl_lot.Exd,tbl_lot.LotStatus,tbl_med.MedId,tbl_med.MedName,tbl_med.MedPath
                    FROM tbl_lot
                    INNER JOIN tbl_med ON tbl_lot.MedId = tbl_med.MedId";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $lot){
                        $checkqty = $lot["Qty"];
                        $LotId = $lot["LotId"];
                        $LotStatus = $lot["LotStatus"];
                        $status = "Not Available";
                        $checkclaim = $lot["RecClaimid"];
                        $Reserve = $lot["Reserve"];
                        $checkreserve = $checkqty - $Reserve;
                        
                        if($checkqty == '0' and $LotStatus != 'Claim')
                        {
                            $sql = "UPDATE tbl_lot SET LotStatus = 'Not Available' WHERE LotId = $LotId"; 
                            if ($conn->query($sql) === TRUE) { 
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }
                        }
                        else if ($checkreserve == '0' and $LotStatus != 'Claim') 
                        {
                            $sql = "UPDATE tbl_lot SET LotStatus = 'Reserve' WHERE LotId = $LotId"; 
                            if ($conn->query($sql) === TRUE) { 
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }
                        }
                            $MfdDate = $lot["Mfd"];
                            $ExpDate = $lot["Exd"];
                            $datemfd=date_create($MfdDate);
                            $dateexp=date_create($ExpDate);
                            $diff=date_diff($datemfd,$dateexp);
            ?>

                <tr>
                    <td><?php echo $lot["LotId"]; ?></td>
                    <td><?php echo $lot["MedName"]; ?></td>
                    <td><?php echo '<img style = "width:100px;height:100px"  src="upload/'. $lot["MedPath"]; ?>"></td>
                    <td><?php echo $lot["Qty"]; ?></td>
                    <td><?php echo $lot["Reserve"]; ?></td>
                    <td><?php echo $lot["LotStatus"]; ?></td>
                    <td><?php echo $diff->format('%R%a');?></td>
                    <td>            
                        <form method="POSt" action="lotdetail.php">
                            <button type = "submit" value = "<?php echo $lot["LotId"]; ?>" name = "detail" class="btn btn-danger">Detail</button>
                            <input type="hidden" name ='Detail' value ="<?php echo $lot["LotId"]; ?>">
                        </from>
                    </td>
                    <td><div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            <?php 
                                    $Qty = $lot["Qty"];
                                    if ($Qty<=0)
                                    {
                                        $LotId = $lot["LotId"];
                                        $buttonStatus = "disabled";
                                        echo $buttonStatus;
                                    }
                                    else if ($LotStatus == "Writeoff")
                                    {
                                        $buttonStatus = "disabled";
                                        echo $buttonStatus;
                                    }
                                    else if ($LotStatus == "Claim")
                                    {
                                        $buttonStatus = "disabled";
                                        echo $buttonStatus;
                                    }
                                ?> 
                                >Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <form method="POSt" action="Withdraw.php">
                                    <a class="dropdown-item" href="Withdraw.php?withdraw=<?php echo $lot["LotId"]; ?>">Wtihdraw</a>
                                    <input type="hidden" name ='withdraw' value ="<?php echo $lot["LotId"]; ?>">
                                </from>

                                <form method="POST" action="Writeoff.php">
                                    <a class="dropdown-item" href="Writeoff.php?Write=<?php echo $lot["LotId"]; ?>">Writeoff</a>
                                    <input type ="hidden" name ='Write' value ="<?php echo $lot["LotId"]; ?>">
                                </form>

                                <form method="POST" action="Claim.php">
                                    <?php
                                        if(is_null($checkclaim) && $Reserve == '0')
                                        {
                                    ?>
                                    <a class="dropdown-item" href="Claim.php?Claim=<?php echo $lot["LotId"]; ?>">Claim</a>
                                    <input type ="hidden" name ='Claim' value ="<?php echo $lot["LotId"]; ?>">
                                    <?php } ?>
                                </form>
 
                            </div>
                        </div>

                    </td>
                    
                </tr>

                <?php }?>
            
            
        </tbody>
    </table>
 
</div>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>

  
</body>
</html>

