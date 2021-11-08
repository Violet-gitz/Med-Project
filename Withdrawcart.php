<?php
        include('connect.php');
        session_start();
      
       
        $MedId = $_REQUEST['testMedId'];
        $act = $_REQUEST['act'];
        $Quantity = $_REQUEST['quantity'];
        $LotId = $_REQUEST['valueid'];
        if($act=='add' && !empty($MedId))
        {
            if(isset($_SESSION['withdraw'.$LotId][$MedId]))
            {
                $_SESSION['withdraw'.$LotId][$MedId]+=(int)$Quantity;    
            }
            else
            {
                $_SESSION['withdraw'.$LotId][$MedId]=(int)$Quantity;  
            }
        }
     
        else if($act=='remove' && !empty($MedId))
        {
            unset($_SESSION['withdraw'.$LotId][$MedId]);
        }
     
        /*if($act=='update')
        {
            $price_array = $_POST['MedPrice'];
            foreach($price_array as $MedId=>$MedPrice)
            {
                $_SESSION['cart'][$MedId]=$MedPrice;
            }
        }*/
        print_r($_SESSION['cart'.$LotId]);
        echo '<pre>';

      
    if (isset($_REQUEST['btn_withdraw'])) {
        $i = 0;   
        $Lotid = $_REQUEST['txt_LotId'];
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
                
                    $sql = "SELECT* FROM tbl_receiveddetail WHERE LotId=$Lotid";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                    $data[] = $row;  
                    }
                    foreach($data as $key => $Rec){

                    $query = "SELECT WithId FROM tbl_withdraw ORDER BY WithId  DESC LIMIT 1";
                    $result = mysqli_query($conn, $query); 
                    $row = mysqli_fetch_array($result);
                    $WithId  = $row["WithId"];

                        $MedId = $_REQUEST["MedId".$i];
                        $LotId = $Rec["LotId"];
                        $QTY = $_REQUEST["qty".$i];
                        $Mfd = $Rec["Mfd"];
                        $Exd = $Rec["Exd"];
                        
                        $sql = "INSERT INTO tbl_withdrawdetail(WithId, MedId, LotId, Qty, Mfd, Exd) VALUES ('$WithId', '$MedId', '$LotId', '$QTY', '$Mfd', '$Exd')";
                        $i++;
                       
                        if ($conn->query($sql) === TRUE) { 
                        } else {
                            echo "Error updating record: " . $conn->error;
                        }
                        // header("refresh:1;main.php");
                    }
                }     
        }
    }

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
    if(!empty($_SESSION['withdraw'.$LotId]))
    {
        foreach($_SESSION['withdraw'.$LotId] as $MedId=>$Quantity)
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
            echo "<input type='text' name= $Med[MedId]; value='$Quantity' disabled size='2'/></td>";
            echo "<td width='46' align='center'><a href='Withdrawcart.php?testMedId=$MedId&act=remove&quantity=0&valueid=$LotId'>Remove</a></td>";
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
                            <select name="selDealer">       
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
                            </div>
                        
                    </div>           
    </form>


    <form action = "Withdrawcart1.php" method="post">
        <input type="submit" name="btn_lotcallback" class="btn btn-success" value="listorder">
        <input type ="hidden" name = "lotcallback" value = "<?php echo $LotId;?>">
    </from>

    </body>
</html>