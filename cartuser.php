
<?php
        include('connect.php');
        error_reporting(0);
        session_start();
        // echo '<pre>';
        // print_r($_SESSION);
        // echo '<pre>';
        $MedId = !empty($MedId) ? 0 : $_REQUEST['testMedId'];
        $act = !empty($act) ? 0 : $_REQUEST['act'];
        $Quantity = !empty($Quantity) ? 0 : $_REQUEST['quantity'];
    
        if($act=='add' && !empty($MedId))
        {
            if(isset($_SESSION['usercart'][$MedId]))
            {
                $_SESSION['usercart'][$MedId]+=(int)$Quantity;    
            }
            else
            {
                $_SESSION['usercart'][$MedId]=(int)$Quantity;  
            }
        }
     
        else if($act=='remove' && !empty($MedId))
        {
            unset($_SESSION['usercart'][$MedId]);
        }
     
        /*if($act=='update')
        {
            $price_array = $_POST['MedPrice'];
            foreach($price_array as $MedId=>$MedPrice)
            {
                $_SESSION['cart'][$MedId]=$MedPrice;
            }
        }*/

        $staff =  $_SESSION['StaffName'];
        $sql = "SELECT* FROM tbl_staff WHERE StaffName = '$staff'";
        $result = $conn->query($sql);
        $data = array();
            while($row = $result->fetch_assoc()) 
            {
                $data[] = $row;  
            }
            foreach($data as $key => $staff){      
                $StaffId = $staff["StaffId"];
            }

        
        if (isset($_REQUEST['btn-Order'])) 
        {   

            $WithStatus = "Pending approval";
            date_default_timezone_set("Asia/Bangkok");
            $WithDate = date("Y-m-d h:i:sa");

            $sql = "INSERT INTO tbl_withdraw(StaffId, WithDate, WithStatus) VALUES ('$StaffId', '$WithDate', '$WithStatus')";
            if ($conn->query($sql) === TRUE) { 
            } else {
            echo "Error updating record: " . $conn->error;
            }

            if(!empty($_SESSION['usercart']))
                {
                    // unset($_SESSION['test']);
                    foreach($_SESSION['usercart'] as $MedId=>$Quantity)
                    {
                        $test = 0;
                        // echo $Quantity. "<br>";
                        $sql = "SELECT * FROM tbl_lot WHERE MedId ='$MedId' AND LotStatus != 'Claim' AND LotStatus != 'Writeoff' AND LotStatus != 'Not Available' AND LotStatus != 'Reserve'";
                        $result = $conn->query($sql);
                        $data = array();
                                
                        while($row = $result->fetch_assoc()) 
                        {
                            $data[] = $row;  
                        }
                            foreach($data as $key => $lot)
                            {      
                                $MfdDate = $lot["Mfd"];
                                $ExpDate = $lot["Exd"];
                                $datemfd=date_create($MfdDate);
                                $dateexp=date_create($ExpDate);
                                $diff=date_diff($datemfd,$dateexp);
                                    
                                // echo $lot["LotId"] . $diff->format('%R%a') . "qty ".$lot["Qty"]. "<br>";
                            
                                $lotid = $lot["LotId"];
                                $qtylot = $lot["Qty"];
                                $Reserve = $lot["Reserve"];
                                $qty = $qtylot - $Reserve;
                                if($test < $Quantity)
                                {
                                    if($qty > ($Quantity-$test))
                                    {
                                        $_SESSION['test'][$lotid][0]=$lotid;   
                                        $_SESSION['test'][$lotid][1]=(int)$qty;   //จำนวนทั้งหมดของ lot
                                        $_SESSION['test'][$lotid][2]=(int)$qty - ($Quantity - $test); //จำนวนคงเหลือ 
                                        $_SESSION['test'][$lotid][3]=(int)$Quantity - $test; //จำนวนที่ตัด ****
                                        $test += ($Quantity - $test);
                                    }
                                    else if($qty <= ($Quantity-$test))
                                    {
                                        $_SESSION['test'][$lotid][0]=$lotid;   
                                        $_SESSION['test'][$lotid][1]=(int)$qty;   
                                        $_SESSION['test'][$lotid][2]=(int)$qty; 
                                        $_SESSION['test'][$lotid][3]=(int)$qty; 
                                        $test += $qty;
                                    }
                                }  

                            }

                    }
                }unset($_SESSION['usercart']);header("refresh:1;Mainuser.php"); 
        }

            if(!empty($_SESSION['test']))
            {   
                $sum = 0;
                foreach($_SESSION['test'] as $value)
                    {
                        $idlot = $value[0]; 
                        $Qty = $value[3];
                        $sql = 'SELECT * FROM tbl_lot WHERE LotId ='.$idlot.'';
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) 
                        {
                            $data[] = $row;  
                        }
                        foreach($data as $key => $lot)
                        {
                        $query = "SELECT WithId FROM tbl_withdraw ORDER BY WithId DESC LIMIT 1";
                        $result = $conn->query($query); 
                        $row = mysqli_fetch_array($result);
                        $WithId  = $row["WithId"];

                        $MfdDate = $lot["Mfd"];
                        $ExpDate = $lot["Exd"];
                        {
                            $sql = "INSERT INTO tbl_withdrawdetail(WithId, MedId, LotId, Qty, Mfd, Exd) VALUES ('$WithId', '$MedId', '$idlot', '$Qty', '$MfdDate', '$ExpDate')";
                            // echo $sql;
                            if ($conn->query($sql) === TRUE) { 
                            } else {
                            echo "Error updating record: " . $conn->error;
                            }
                            $sum = $sum + $value[3];
                            $sumReserve = $Reserve + $Qty;

                            $sql = "UPDATE tbl_lot SET Reserve = $sumReserve WHERE LotId = $idlot"; 
                            if ($conn->query($sql) === TRUE) { 
                            } else {
                            echo "Error updating record: " . $conn->error;
                            }

                            $sql = "UPDATE tbl_withdraw SET Qtysum = $sum WHERE WithId = $WithId"; 
                            if ($conn->query($sql) === TRUE) { 
                            } else {
                            echo "Error updating record: " . $conn->error;
                            }
                        }
                        }
                    }unset($_SESSION['test']);
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
                  <a href="Mainuser.php" class="navbar-brand">Home Page</a>
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
                                            <a class="dropdown-item" href="edituser.php?update_id=<?php echo $staff["StaffId"];?>">Edit</a>
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
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    
    <?php 
         if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>

  
    <form name="frmcart" method="post" action = "usertest.php">
      <table width="600" border="0" align="center" class="square">
        <tr>
          <td colspan="5" bgcolor="#CCCCCC">
          <b>Cart</span></td>
        </tr>
        <tr>
          <td bgcolor="#EAEAEA">Order</td>
          <td align="center" bgcolor="#EAEAEA">Quantity</td>
          <td align="center" bgcolor="#EAEAEA">Remove</td>
        </tr>
    <?php
    $total=0;
    if(!empty($_SESSION['usercart']))
    {
        foreach($_SESSION['usercart'] as $MedId=>$Quantity)
        {
            $sql = "SELECT* FROM tbl_Med WHERE MedId=$MedId";
		    $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
            $data[] = $row;  
            }
            foreach($data as $key => $Med){

            echo "<tr>";
            echo "<td width='334'>" . $Med["MedName"] . "</td>";
            echo "<td width='57' align='right'>";  
            echo "<input type='text' name= $Med[MedId]; value='$Quantity' disabled size='5'/></td>";
 
            
            echo "<td width='46' align='center'><a href='cartuser.php?testMedId=$MedId&act=remove&quantity=0'>Remove</a></td>";
            echo "</tr>";
            }
            echo "<tr>";
            //echo "<td colspan='3' bgcolor='#CEE7FF' align='center'><b>ราคารวม</b></td>";
          
            //echo "<td align='left' bgcolor='#CEE7FF'></td>";
        }
    }
           
            //echo "<td align='right' bgcolor='#CEE7FF'>"."<b>".number_format($total,2)."</b>"."</td>";
            echo "</tr>";
    ?>
    <tr>
    
    </table>
   

                        <div class="form-group text-center">
                            <div class="col-md-12 mt-3">
                                <input type="submit" name = "Order"class = "btn btn-info" value = "Order">
                                <input type ="hidden" name = "StaffId" value = "<?php echo $staff["StaffId"];?>">
                                <a href="Mainuser.php" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                  
    </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    </body>
    </html>
