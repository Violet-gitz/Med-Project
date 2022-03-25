<?php 
    include('Connect.php'); 

    $sql = "SELECT * FROM tbl_med";
    $result = $conn->query($sql);
    $data = array();
        while($row = $result->fetch_assoc()) 
        {
            $data[] = $row;  
        }
        foreach($data as $key => $med)
        {   
            $MedPoint = $med["MedPoint"];  
            $MedTotal = $med["MedTotal"];  
            if($MedTotal <= $MedPoint)
            {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                date_default_timezone_set("Asia/Bangkok");
                $sToken = "tpIhKWBEGejBDvkVnlUeGlnf6VvtJPgc6ud5xsV0Ob2";

                $medname = $med["MedName"];
            
                $sMessage = $medname ." ตำกว่าจุดสั่งซื้อ !";
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
                    else 
                    { 
                        $result_ = json_decode($result, true); 
                            // echo "status : ".$result_['status']; echo "message : ". $result_['message'];
                    } 
                        curl_close( $chOne );
            }
            
            $sql = "SELECT * FROM tbl_lot";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) 
            {
            $data[] = $row;   
            }
            foreach($data as $key => $lot)
            {

            $mednotidate = $med["MedNoti"];
            date_default_timezone_set("Asia/Bangkok");
            $datenow = date("d")."-".date("m")."-".(date("Y")+543);
            $ExpDate = $lot["Exd"];
            $datenow=date_create($datenow);
            $dateexp=date_create($ExpDate);
            $diff=date_diff($datenow,$dateexp);
            if($diff->format('%R%a') <= $mednotidate)
            {
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                date_default_timezone_set("Asia/Bangkok");
                $sToken = "tpIhKWBEGejBDvkVnlUeGlnf6VvtJPgc6ud5xsV0Ob2";
        
                $lot = $lot["LotId"];
                $medname = $med["MedName"];
                $sMessage = $medname ." ล็อคที่ #". $lot." กำลังจะหมดอายุภายในอีก  ".$diff->format('%R%a'). " วัน ! ";
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
                    else 
                    { 
                        $result_ = json_decode($result, true); 
                            // echo "status : ".$result_['status']; echo "message : ". $result_['message'];
                    } 
                        curl_close( $chOne );
            }
        }

    }

?>