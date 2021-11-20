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

        <script>
            function showResult(str) {
            if (str == "") {
                document.getElementById("livesearch").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("livesearch").innerHTML = this.responseText;
                }
                };
                xmlhttp.open("GET","main.php?q="+str,true);
                xmlhttp.send();
            }
            }
        </script>
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
            include('slidebar.php');
        ?>

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