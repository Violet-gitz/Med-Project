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
                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link"><?php echo $_SESSION['StaffName'] ?></a>                
                        </li>  
                            &nbsp;&nbsp;
                        <li class="nav-item">
                            <td><a href="index.php?logout='1'" class ="btn btn-warning">Logout</a></td>
                        </li>

                    </ul>
                </div>
            </div>
        </nav> 
  

</head>


<body>

    <?php
            include('slidebar.php');
            
    ?>


        
        

        <script>
            function display_ct6() 
            {
                var x = new Date()
                var ampm = x.getHours( ) >= 12 ? ' PM' : ' AM';
                hours = x.getHours( ) % 12;
                hours = hours ? hours : 12;
                var x1=x.getMonth() + 1+ "/" + x.getDate() + "/" + x.getFullYear(); 
                x1 = x1 + " - " +  hours + ":" +  x.getMinutes() + ":" +  x.getSeconds() + ":" + ampm;
                document.getElementById('ct6').innerHTML = x1;
                display_c6();
                }
                function display_c6(){
                var refresh=1000; // Refresh rate in milli seconds
                mytime=setTimeout('display_ct6()',refresh)
            }
            display_c6()
        </script>


<body>


<span id='ct6'></span>

<div class="container-sm">
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Lot Id</th>
                <th>Medicine Name</th>
                <th>Manufactured Date</th>
                <th>Expiration Date</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Received Name</th>
                <th>Time left</th>
                <th>Withdraw</th>
                <th>Write off </th>
                <th>Claim</th> 
            </tr>
        </thead>

        <tbody>
            <?php 
                
                    $sql = "SELECT tbl_lot.LotId,tbl_lot.LotStatus,tbl_received.MedId,tbl_received.MfdDate,tbl_received.ExpDate,tbl_lot.Qty,tbl_lot.LotStatus,tbl_received.RecName,tbl_received.RecTime,tbl_received.RecDeli
                    FROM tbl_lot
                    INNER JOIN tbl_received ON tbl_lot.RecId = tbl_received.RecId";

                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                        
                    }
                    foreach($data as $key => $Lot){ 
                        
                        $MedId = $Lot["MedId"];
                        $sql = "SELECT * FROM tbl_med WHERE $MedId = MedId";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $Med){ 


                        $StaffId = $Lot["RecName"];
                        $sql = "SELECT * FROM tbl_staff WHERE $StaffId = StaffId";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $Staff){ 

                            
                            $buttonStatus;
                            $Qty = $Lot["Qty"];
                            $LotStatus = $Lot["LotStatus"];                            
                            
            ?>

                <tr>
                    <td><?php echo $Lot["LotId"]; ?></td>
                    <td><?php echo $Med["MedName"]; ?></td>
                    <td><?php echo $Lot["MfdDate"]; ?></td>
                    <td><?php echo $Lot["ExpDate"]; ?></td>
                    <td><?php echo $Lot["Qty"]; ?></td>
                    <td><?php echo $Lot["LotStatus"]; ?></td>
                    <td><?php echo $Staff["StaffName"]; ?></td>
                    <td>
                        <?php 
                        
                            $date = date("Y-m-d");
                            $expired = $Lot["ExpDate"];
                            $date1=date_create($expired);
                            $date2=date_create($date);
                            $diff=date_diff($date2,$date1);
                            echo $diff->format('%R%a days');
                        ?>
                    </td>

                    <td>
                        <form method="POST" action="Withdraw.php">
                            <button type="submit" value = "<?php echo $Lot["LotId"]; ?>" name = "draw" class = "btn btn-success"
                                <?php 
                                    if ($Qty<=0)
                                    {
                                        $buttonStatus = "disabled";
                                        echo $buttonStatus;
                                    }
                                    else if ($LotStatus == "Writeoff")
                                    {
                                        $buttonStatus = "disabled";
                                        echo $buttonStatus;
                                    }
                                ?> 
                            >Withdraw</button>    
                        </form>
                    </td>

                    <td>
                        <form method = "POST" action ="Writeoff.php">
                            <button type = "submit" value ="<?php echo $Lot["LotId"]; ?>" name = "Write" class = "btn btn-success"
                                <?php
                                    if ($LotStatus == "Writeoff")
                                    {
                                        $buttonStatus = "disabled";
                                        echo $buttonStatus;
                                    }
                                    else if ($Qty<=0)
                                    {
                                        $buttonStatus = "disabled";
                                        echo $buttonStatus;
                                    }
                                ?>
                            >Write-off</button>
                        </form>
                    </td>

                    <td>
                        <form method = "POST" action = "Claim.php">
                            <button type ="submit" value = "<?php echo $Lot["LotId"]; ?>" name = "Claim" class = "btn btn-warning"
                                <?php
                                    if ($Qty<=0)
                                    {
                                        $buttonStatus = "disabled";
                                        echo $buttonStatus;
                                    }
                                    else if ($LotStatus == "Claim")
                                    {
                                        $buttonStatus = "disable";
                                        echo $buttonStatus;
                                    }
                                ?>
                            >Claim</button>
                        </form>
                    </td>

                </tr>

                <?php } } } ?>
            
            
        </tbody>
    </table>
</div>


  
</body>
</html>