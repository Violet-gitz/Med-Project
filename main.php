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

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
                <a href="main.php" class="navbar-brand">Home Page</a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <div class="dropdown">
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
                    </div>
                </div>
            </div>
        </nav> 

        <!-- <script>
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
        </script> -->


    
</head>


<body>

    <?php
            include('slidebar.php');   
            
            
            echo '
            <script type="text/javascript">
        
            $(document).ready(function(){
        
            swal({
                position: "top-end",
                type: "success",
                title: "Your work has been saved",
                showConfirmButton: false,
                timer: 1500
            })
            });
        
        </script>
        ';
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

  
      

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>

</body>
</html>