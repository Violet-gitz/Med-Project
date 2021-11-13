<?php
        include('connect.php');
        session_start();
      
        $MedId = $_REQUEST['testMedId'];
        $act = $_REQUEST['act'];
        $Quantity = $_REQUEST['quantity'];
        $LotId = $_REQUEST['valueid'];
        if($act=='add' && !empty($MedId) && !empty($LotId))
        {
            if(isset($_SESSION['withdraw'][$LotId]))
            { 
                $_SESSION['withdraw'][$LotId][2]+=(int)$Quantity;   
            }
            else
            {
                $_SESSION['withdraw'][$LotId][0]=$LotId;   
                $_SESSION['withdraw'][$LotId][1]=(int)$MedId;   
                $_SESSION['withdraw'][$LotId][2]=(int)$Quantity;  
            }
        }
     
        else if($act=='remove' && !empty($MedId) && !empty($LotId))
        {
            unset($_SESSION['withdraw'][$LotId]);
        }
     
        /*if($act=='update')
        {
            $price_array = $_POST['MedPrice'];
            foreach($price_array as $MedId=>$MedPrice)
            {
                $_SESSION['cart'][$MedId]=$MedPrice;
            }
        }*/

        // print_r($_SESSION['withdraw']);
        // echo '<pre>';
      
    if (isset($_REQUEST['btn_withdraw'])) {
        $i = 0;   
        $Lotid = $_REQUEST['LotId'];
        $sql ="SELECT * FROM tbl_receiveddetail WHERE $Lotid = LotId";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) {
            $data[] = $row;   
        }
        foreach($data as $key => $Lot){

        
            $idmed = $Lot["MedId"];
            $sql ="SELECT * FROM tbl_med WHERE $idmed = MedId";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                }
                foreach($data as $key => $med){}
        

            }
        $StaffId = $_REQUEST['selstaff'];
        date_default_timezone_set("Asia/Bangkok");
        $WithDate = date("Y-m-d h:i:sa");
        
        
         if (empty($StaffId)) {
            $errorMsg = "Please Enter StaffId";
        }  else {
                if (!isset($errorMsg)) {
                    
                    $sql = "INSERT INTO tbl_withdraw(StaffId, WithDate) VALUES ('$StaffId', '$WithDate')";
                    if ($conn->query($sql) === TRUE) { 
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                            $query = "SELECT WithId FROM tbl_withdraw ORDER BY WithId  DESC LIMIT 1";
                            $result = mysqli_query($conn, $query); 
                            $row = mysqli_fetch_array($result);
                            $WithId  = $row["WithId"];

                            foreach($_SESSION['withdraw'] as $value)
                        {
                            $sql = 'SELECT * FROM tbl_receiveddetail WHERE LotId ='.$value[0].' and MedId = '.$value[1];
                            $result = $conn->query($sql);
                            $data = array();
                            
                            while($row = $result->fetch_assoc()) 
                            {
                                $data[] = $row;  
                            }
                            foreach($data as $key => $Rec)
                            {       
                                $Quantity = $value[2];   
                                $MedId = $Rec["MedId"];
                                $LotId = $Rec["LotId"];
                                $Mfd = $Rec["Mfd"];
                                $Exd = $Rec["Exd"];
                                
                                $sql = "INSERT INTO tbl_withdrawdetail(WithId, MedId, LotId, Qty, Mfd, Exd) VALUES ('$WithId', '$MedId', '$LotId', '$Quantity', '$Mfd', '$Exd')";
                            
                                // echo $MedId;
                                // echo $sql;
                            
                                if ($conn->query($sql) === TRUE) { unset($_SESSION['withdraw']);
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }
                                    $qty += $value[2];
                                  
                                    
                                $sql = "UPDATE tbl_withdraw SET Qtysum = $qty WHERE WithId = $WithId"; 
                                if ($conn->query($sql) === TRUE) { 
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }  

                                $sql = "SELECT * FROM tbl_med WHERE MedId = $MedId";
                                $result = $conn->query($sql);
                                $data = array();
                                
                                while($row = $result->fetch_assoc()) 
                                {
                                    $data[] = $row;  
                                }
                                foreach($data as $key => $Med)
                                {
                                    $MedTotal = $Med["MedTotal"];
                                    $Medsum = $MedTotal - $Quantity;
                                    $sql = "UPDATE tbl_med SET MedTotal = $Medsum WHERE MedId = $MedId"; 
                                    if ($conn->query($sql) === TRUE) { 
                                    } else {
                                        echo "Error updating record: " . $conn->error;
                                    }
                                }

                                $sql = "SELECT * FROM tbl_lot WHERE LotId = $Lotid";
                                $result = $conn->query($sql);
                                $data = array();
                                
                                while($row = $result->fetch_assoc()) 
                                {
                                    $data[] = $row;  
                                }
                                foreach($data as $key => $Lot)
                                {
                                    $Lotqty = $Lot["Qty"];
                                    $sum = $Lotqty - $Quantity;
                                    $sql = "UPDATE tbl_lot SET Qty = $sum WHERE LotId = $LotId"; 
                                    if ($conn->query($sql) === TRUE) { 
                                    } else {
                                        echo "Error updating record: " . $conn->error;
                                    }
                                }

                               
                            }
                        // header("refresh:1;main.php");
                 
                }     
        }
    }}

?>
     
     <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
        <?php
            include('slidebar.php');
        ?>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
            <h1 class="navbar-brand">Withdraw Cart</h1>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link"><?php echo $_SESSION['StaffName'] ?></a>                
                        </li>  
                        
                        <li class="nav-item">
                            <td><a href="index.php?logout='1'" class ="btn btn-warning">Logout</a></td>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    
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

    <form name="frmcart" method="post">
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
    if(!empty($_SESSION['withdraw']))
    {
    //    echo count($_SESSION['withdraw']);
        
        foreach($_SESSION['withdraw'] as $value)
        // echo "lot".$value[0] . "MedId" .$value[1] . "qty" . $value[2] . "<br>";
        {
            $sql = 'SELECT* FROM tbl_Med WHERE MedId='.$value[1];
		    $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
            $data[] = $row;  
            }
            echo $row;
            foreach($data as $key => $Med){
            echo "<tr>";
         
            echo "<td width='334'>" . $Med["MedName"] . "</td>";
            echo "<td width='57' align='right'>";  
            // echo "<input type='number'name=".$Med["MedId"]."value=".$value[2]." size='2'/></td>";
            echo "<input type ='number' name='".$Med["MedId"]."' value='".$value[2]."'></td>"; 
            
            echo "<td width='46' align='center'><a href='Withdrawcart.php?testMedId=".$value[1]."&act=remove&quantity=0&valueid=".$value[0]."'>Remove</a></td>";
            echo "</tr>";
            }
            echo "<tr>";
        }
    }
            echo "</tr>";
    ?>
    <tr>
   
    </tr>
    </table>
                    <div class="container">
                        <label class="col-sm-3 control-label">Staff</label>
                            <select name="selstaff">       
                                <?php 
                                    $sql = 'SELECT * FROM tbl_staff';
                                    $result = $conn->query($sql);
                                    $data = array();
                                    while($row = $result->fetch_assoc()) {
                                        $data[] = $row;        
                                    }
                                    foreach($data as $key => $dealer){                  
                                ?>
                                    <option value ="<?php echo $dealer["StaffId"];?>"><?php echo $dealer["StaffName"];?></option>
                                <?php } ?>      
                            </select>
                            <div class="col-sm-9">
                                <input type="submit" name = "btn_withdraw"class = "btn btn-info" value = "Withdraw">
                                <input type ="hidden" name = "LotId" value = "<?php echo $LotId;?>">
                            </div>
                        
                    </div>           
    </form>


    <form action = "Lot.php" method="post">
        <input type="submit" name="btn_lotcallback" class="btn btn-success" value="listorder">
        
    </from>

    </body>
</html>