
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
 
       
                    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
                <a href="Mainuser.php" class="navbar-brand">Home Page</a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        ><?php echo $_SESSION['StaffName'] ?>
                        </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <form method="POSt" action="useredit.php">
                                    <a class="dropdown-item" href="useredit.php?update_id=<?php echo $staff["StaffId"];?>">Edit</a>
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
            include('slidebaruser.php');   
    ?>

   
        <div class="container">
            <div class="row">
                    <div class="col-md-4 ms-auto">
                        <form action="" method="post">
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
                    <th>Quantity</th>
                    <th>Withdraw</th>

                   
                </tr>
            </thead>

            <tbody>
                <?php 
                    
                        $sql = 'SELECT * FROM tbl_med';
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $Med){               
                ?>

                    <tr>
                        <form action = "cartuser.php" method="post">
                        <td><?php echo '<img src="upload/'.$Med['MedPath'].'" height = "80" widht = "80"/>';?></td>
                        <td><?php echo $Med["MedName"]; ?></td>
                        <td><?php echo $Med["MedDes"]; ?></td>
                        <td><?php echo $Med["MedTotal"]; ?></td>
                        <td><input type="number" name="quantity" min="1" max="<?php echo $Med["MedTotal"]; ?>" value= "1"></td>
                        <td><input type="submit" class = "btn btn-info" value = "Add to cart"></td>
                        <input type ="hidden" name = "testMedId" value = "<?php echo $Med["MedId"]; ?>">
                        <input type ="hidden" name = "act" value = "add">
                        </form>
                    </tr>

                    <?php } ?>
                
            </tbody>
        </table>
    </div>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>