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

    if (isset($_GET['delete_id'])) {
        $id = $_GET['delete_id'];


        //Delete an original record from db
        //$sql = 'DELETE FROM tbl_Med WHERE MedId' =.$id);
        $sql = "DELETE FROM tbl_med where MedId = '".$id."'";
        if($conn->query($sql) == TRUE){
          echo "<script type='text/javascript'>alert('ลบข้อมูลสำเร็จ');</script>";
        }else{
          echo "<script type='text/javascript'>alert('ลบข้อมูลไม่สำเร็จ');</script>";
        }
      
    }

    if (isset($_REQUEST['submit'])) {
        $search = $_REQUEST['textsearch'];

       
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
                                
                                <button class="btn btn-info  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
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
        <div class="container">
            <div class="row">
                    <div class="col-md-4 ms-auto">
                        <form action="Medsearch.php" method="post">
                            <input type="text" name="textsearch" placeholder = "Search">
                            <input type="submit" name="submit" value="Search">
                        </form>
                    </div>
            </div>
        </div><br>


    <div class="container-sm">
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Total</th>
                    <!-- <th>Edit</th> -->
                    <th>Check Lot</th>
                   
                </tr>
            </thead>

            <tbody>
                <?php 
                        $search = $_REQUEST['textsearch'];
                        $sql = "SELECT * FROM tbl_med WHERE MedId LIKE '%{$search}%' || MedName LIKE '%{$search}%' ";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $Med){               
                ?>

                    <tr>
                        <td><?php echo '<img src="upload/'.$Med['MedPath'].'" height = "80" widht = "80"/>';?></td>
                        <td><?php echo $Med["MedName"]; ?></td>
                        <td><?php echo $Med["MedDes"]; ?></td>
                        <td><?php echo $Med["MedTotal"]; ?></td>
                        <!-- <td><a href="Mededit.php?edit_id=<?php echo $Med["MedId"];?>" class="btn btn-info">Edit</a></td> -->
                        <td><a href="Checklot.php?checklot=<?php echo $Med["MedId"];?>" class="btn btn-info">Check</a></td>
                    </tr>

                    <?php } ?>

            </tbody>
        </table>
    </div>
    
        <?php

            // $q = intval($_GET['q']);

            // $sql="SELECT * FROM tbl_lot WHERE MedId = '".$q."'";
            // $result = $conn->query($sql);
            // $data = array();
            // while($row = $result->fetch_assoc()) {
            // $data[] = $row;   
            // }
            // foreach($data as $key => $Lot){
            //     $medid = $Lot["MedId"];
            //     $sql="SELECT * FROM tbl_med WHERE MedId = '".$q."'";
            //     $result = $conn->query($sql);
            //     $data = array();
            //     while($row = $result->fetch_assoc()) {
            //     $data[] = $row;   
            //     }
            //     foreach($data as $key => $Med){
            // echo "<table>";
            // echo "<tr>";
            // echo "<td>" . $Med['MedName'] . "</td>";

            // echo "</tr>";
            // }}
            // echo "</table>";           
        ?>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>