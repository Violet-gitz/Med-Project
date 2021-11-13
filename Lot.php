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

<div class="container-sm">
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Lot Id</th>
                <th>Medicine</th>
                <th>Pictures</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Action</th>
                <th>backup </th>
                <th>Claim</th> 
            </tr>
        </thead>

        <tbody>
            <?php 
                    $sql = "SELECT tbl_lot.LotId,tbl_lot.Qty,tbl_lot.LotStatus,tbl_receiveddetail.RecId,tbl_receiveddetail.MedId,tbl_receiveddetail.Mfd,tbl_receiveddetail.Exd 
                    FROM tbl_lot
                    INNER JOIN tbl_receiveddetail ON tbl_lot.LotId = tbl_receiveddetail.LotId";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $lot){

                        $checkqty = $lot["Qty"];
                        $LotId = $lot["LotId"];
                        $status = "Not Available"; 
                        if($checkqty == '0')
                        {
                            $sql = "UPDATE tbl_lot SET LotStatus = '$status' WHERE LotId = $LotId"; 
                            // echo $sql;
                            if ($conn->query($sql) === TRUE) { 
                            } else {
                                echo "Error updating record: " . $conn->error;
                            }
                        }

                    $MedId = $lot["MedId"];
                    $sql = "SELECT* FROM tbl_med WHERE MedId = $MedId";
                    $result = $conn->query($sql);
                    $data = array();
                        while($row = $result->fetch_assoc()) 
                        {
                            $data[] = $row;  
                        }
                        foreach($data as $key => $Med){
                        
                      
            ?>

                <tr>
                    <td><?php echo $lot["LotId"]; ?></td>
                    <td><?php echo $Med["MedName"]; ?></td>
                    <td><?php echo '<img style = "width:100px;height:100px"  src="upload/'. $Med["MedPath"]; ?>"></td>
                    <td><?php echo $lot["Qty"]; ?></td>
                    <td><?php echo $lot["LotStatus"]; ?></td>

                    <td>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="Withdraw.php?withdraw=<?php echo $lot["LotId"]; ?>">Wtihdraw</a>

                                <form method="POST" action="Writeoff.php">
                                    <a class="dropdown-item" href="Writeoff.php?Write=<?php echo $lot["LotId"]; ?>">Writeoff</a>
                                    <input type ="hidden" name ='Write' value ="<?php echo $lot["LotId"]; ?>">
                                </form>

                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </td>
                    
                    <!-- <td>
                        <form method="POST" action="Withdraw.php">
                            <button type="submit" value = "<?php echo $lot["LotId"]; ?>" name = "withdraw" class = "btn btn-success"
                                <?php 
                                    $Qty = $lot["Qty"];
                                    if ($Qty<=0)
                                    {
                                        $LotId = $lot["LotId"];
                                        $status = "Not Available"; 
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
                    </td> -->

                    <!-- <td>
                        <form method = "POST" action ="Writeoff.php">
                            <button type = "submit" value ="<?php echo $lot["LotId"]; ?>" name = "Write" class = "btn btn-success"
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
                    </td> -->

                    <!-- <td>
                        <form method = "POST" action = "Claim.php">
                            <button type ="submit" value = "<?php echo $lot["LotId"]; ?>" name = "Claim" class = "btn btn-warning"
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
                    </td> -->

                </tr>

                <?php } } ?>
            
            
        </tbody>
    </table>
</div>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>

  
</body>
</html>