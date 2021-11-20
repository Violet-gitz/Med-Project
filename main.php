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

</head>


<body>

    <?php
            include('slidebar.php');    
    ?>

   

<body>

        <div class="container">
            <div class="row">
                    <div class="col-md-4 ms-auto">
                        <form>
                            <input type="text" size="30" onkeyup="showResult(this.value)">
                            <div id="livesearch"></div>
                        </form>
                    </div>
            </div>
        </div><br>

  
        <?php
            $q = intval($_GET['q']);

            $sql="SELECT * FROM tbl_lot WHERE MedId = '".$q."'";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
            $data[] = $row;   
            }
            foreach($data as $key => $Lot){
                $medid = $Lot["MedId"];
                $sql="SELECT * FROM tbl_med WHERE MedId = '".$q."'";
                $result = $conn->query($sql);
                $data = array();
                while($row = $result->fetch_assoc()) {
                $data[] = $row;   
                }
                foreach($data as $key => $Med){
            echo "<table>";
            echo "<tr>";
            echo "<td>" . $Med['MedName'] . "</td>";

            echo "</tr>";
            }}
            echo "</table>";
            
        ?>

</body>
</html>