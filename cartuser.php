<?php
        include('connect.php');
        session_start();
        echo '<pre>';
        print_r($_SESSION);
        echo '<pre>';
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
        
        if (isset($_REQUEST['btn-Order'])) 
        {   
            if(!empty($_SESSION['usercart']))
                {
                    foreach($_SESSION['usercart'] as $MedId=>$Quantity)
                    {
                        // echo $MedId;
                        // echo $Quantity;
                        $sql = "SELECT * FROM tbl_lot WHERE MedId ='$MedId'";
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
                                    
                                    echo $lot["LotId"] . $diff->format('%R%a') . "<br>";

                                }

                    }
                }
            //     $idmed = $_REQUEST['testMedId'];
            //     echo $idmed;
            //     $sql ="SELECT * FROM tbl_med WHERE MedId = $idmed";
            //     echo $sql;
            //     $result = $conn->query($sql);
            //     $data = array();
            //         while($row = $result->fetch_assoc()) {
            //             $data[] = $row;   
            //         }
            //         foreach($data as $key => $med){}
            

            // $StaffId = $_REQUEST['selstaff'];
            // date_default_timezone_set("Asia/Bangkok");
            // $WithDate = date("Y-m-d h:i:sa");
            // $WithStatus = "Pending approval";
            
            // if (empty($StaffId)) {
            //     $errorMsg = "Please Enter StaffId";
            // }  else 
            //     {
            //         if (!isset($errorMsg))
            //         {
            //             $sql = "INSERT INTO tbl_withdraw(StaffId, WithDate, WithStatus) VALUES ('$StaffId', '$WithDate', '$WithStatus')";
            //             if ($conn->query($sql) === TRUE) { 
            //             } else {
            //                 echo "Error updating record: " . $conn->error;
            //             }
            //                     $query = "SELECT WithId FROM tbl_withdraw ORDER BY WithId  DESC LIMIT 1";
            //                     $result = mysqli_query($conn, $query); 
            //                     $row = mysqli_fetch_array($result);
            //                     $WithId  = $row["WithId"];

                        //         foreach($_SESSION['withdraw'] as $value)
                        //         {
                        //         $sql = 'SELECT * FROM tbl_lot WHERE LotId ='.$value[0].' and MedId = '.$value[1];

                        //         $result = $conn->query($sql);
                        //         $data = array();
                                
                        //         while($row = $result->fetch_assoc()) 
                        //         {
                        //             $data[] = $row;  
                        //         }
                        //         foreach($data as $key => $lot)
                        //         {       
                        //             $Quantity = $value[2];   
                        //             $MedId = $lot["MedId"];
                        //             $LotId = $lot["LotId"];
                        //             $Mfd = $lot["Mfd"];
                        //             $Exd = $lot["Exd"];
                                    
                        //             $sql = "INSERT INTO tbl_withdrawdetail(WithId, MedId, LotId, Qty, Mfd, Exd) VALUES ('$WithId', '$MedId', '$LotId', '$Quantity', '$Mfd', '$Exd')";
                                
                        //             if ($conn->query($sql) === TRUE) { unset($_SESSION['withdraw']);
                        //             } else {
                        //                 echo "Error updating record: " . $conn->error;
                        //             }
                        //                 $qty += $value[2];
                                    
                                        
                        //             $sql = "UPDATE tbl_withdraw SET Qtysum = $qty WHERE WithId = $WithId"; 
                        //             if ($conn->query($sql) === TRUE) { 
                        //             } else {
                        //                 echo "Error updating record: " . $conn->error;
                        //             }  
                        //         }
                            
                        // }     
                //     }
                // } $insertMsg = "Insert Successfully...";
                // header("refresh:1;main.php");   
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
                <a href="main.php" class="navbar-brand">Home Page</a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">

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
            include('slidebaruser.php');
        ?>
    
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

  
    <form name="frmcart" method="post" >
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
    <td><a href="Mainuser.php">Medicine</a></td>
    </tr>
    </table>
                    <div class="container">
                        <label class="col-sm-3 control-label">Dealer</label>
                            <select name="selDealer">       
                                <?php 
                                    $sql = 'SELECT * FROM tbl_dealer';
                                    $result = $conn->query($sql);
                                    $data = array();
                                    while($row = $result->fetch_assoc()) {
                                        $data[] = $row;        
                                    }
                                    foreach($data as $key => $dealer){                  
                                ?>
                                    <option value ="<?php echo $dealer["DealerId"];?>"><?php echo $dealer["DealerName"];?></option>
                                <?php } ?>      
                            </select>
                            <div class="col-sm-9">
                                <input type="submit" name = "btn-Order"class = "btn btn-info" value = "Order">
                            </div>
                        
                    </div>           
    </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    </body>
    </html>