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
        

            if (isset($_REQUEST['submit']))
            {
                $search = $_REQUEST['text'];        
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                date_default_timezone_set("Asia/Bangkok");
                $sToken = "5QZMmRQRyNbvtvPsg0utZxUal4y02ag6Ec1Eqhrz1ch";

                $con = "";
                $con2 = "";
                $con = "สวัสดีค่ะ ";
                $con2  = "มีรายการที่ต้องจัดซื้อ";

                $sMessage = $con."".$con2. $search;


                $chOne = curl_init(); 
                curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
                curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
                curl_setopt( $chOne, CURLOPT_POST, 1); 
                curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
                $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
                curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
                curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec( $chOne ); 
                //Result error 
                if(curl_error($chOne)) 
                { 
                echo 'error:' . curl_error($chOne);
                } 
                else { 
                $result_ = json_decode($result, true); 
                // echo "status : ".$result_['status']; echo "message : ". $result_['message'];
                } 
                curl_close( $chOne );
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

</head>


<body>

    <?php
            include('slidebar.php');   
    ?>

        <div class="container">
            <div class="row">
                    <div class="col-md-4 ms-auto">
                        <form action="main.php" method="post">
                            <input type="text" name="text" placeholder = "Search">
                            <input type="submit" name="submit" value="Search">
                        </form>
                    </div>
            </div>
        </div><br>

   

<body>
        
    
  
      

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>

</body>
</html>