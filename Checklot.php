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

    if (isset($_REQUEST['checklot'])) {
                    
        $medid = $_REQUEST['checklot'];

        $sql = "SELECT * FROM tbl_lot WHERE MedId = $medid";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) {
            $data[] = $row;   
        }
        foreach($data as $key => $lot){
            $MfdDate = $lot["Mfd"];
            $ExpDate = $lot["Exd"];
            $datemfd=date_create($MfdDate);
            $dateexp=date_create($ExpDate);
            $diff=date_diff($datemfd,$dateexp);
            // echo $diff->format('%R%a');

            $checkqty = $lot["Qty"];
            $LotId = $lot["LotId"];
            $LotStatus = $lot["LotStatus"];
            $status = "Not Available";

            if($checkqty == '0' and $LotStatus != 'Claim')
            {
                $sql = "UPDATE tbl_lot SET LotStatus = 'Not Available' WHERE LotId = $LotId"; 
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

    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
                <div style='margin-right: 15px'>
                    <?php
                    include('slidebar.php');   
                    ?>
                </div>
                <div> 
                  <a href="main.php" class="navbar-brand">Home Page</a>
                </div>

                <div id="navbar1" class="collapse navbar-collapse" style='justify-content: end;'>
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">
                                
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                ><?php echo $_SESSION['StaffName'] ?>
                                </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <form method="POST" action="Staffedit.php">
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
   
<div class="container-sm">
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Lot Id</th>
                <th>Medicine</th>
                <th>Pictures</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Expire</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php 
                $medid = $_REQUEST['checklot'];
                $sql = "SELECT * FROM tbl_lot WHERE MedId = $medid";
                $result = $conn->query($sql);
                $data = array();
                  while($row = $result->fetch_assoc()) {
                      $data[] = $row;   
                  }
                  foreach($data as $key => $lot){
                      $MfdDate = $lot["Mfd"];
                      $ExpDate = $lot["Exd"];
                      $datemfd=date_create($MfdDate);
                      $dateexp=date_create($ExpDate);
                      $diff=date_diff($datemfd,$dateexp);
                      // echo $diff->format('%R%a');

                      $checkqty = $lot["Qty"];
                      $LotId = $lot["LotId"];
                      $LotStatus = $lot["LotStatus"];
                      $status = "Not Available";
                      // if ($checkqty == '0' and $LotStatus == 'Claim') 
                      // {
                      //     $sql = "UPDATE tbl_lot SET LotStatus = 'Claim' WHERE LotId = $LotId"; 
                      //     if ($conn->query($sql) === TRUE) { 
                      //     } else {
                      //         echo "Error updating record: " . $conn->error;
                      //     }
                      // }
                      if($checkqty == '0' and $LotStatus != 'Claim')
                      {
                          $sql = "UPDATE tbl_lot SET LotStatus = 'Not Available' WHERE LotId = $LotId"; 
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
                    <td><?php echo $diff->format('%R%a'); ?></td>
                    <td>
                        <div class="dropdown">
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
                                    <a class="dropdown-item" href="Claim.php?Claim=<?php echo $lot["LotId"]; ?>">Claim</a>
                                    <input type ="hidden" name ='Claim' value ="<?php echo $lot["LotId"]; ?>">
                                </form>
                            </div>
                        </div>
                    </td>

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