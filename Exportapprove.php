<?php
    include('Connect.php'); 
    if (isset($_REQUEST['Report'])) 
    {
        require_once __DIR__ . '/vendor/autoload.php';
        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        
        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [
                __DIR__ . '/tmp',
            ]),
            'fontdata' => $fontData + [
                'sarabun' => [
                    'R' => 'TH Krub.ttf',
                    'I' => 'TH Krub Italic.ttf',
                    'B' => 'TH Krub Bold.ttf',
                    'BI'=> 'TH Krub Bold Italic.ttf'
                ]
            ],
            'default_font' => 'TH Krub'
        ]);
        ob_start();   
        $Year = $_REQUEST["Year"];
        $Month = $_REQUEST["Month"];
        $date=$Year.$Month;
       
        $sql = "SELECT * FROM tbl_withdraw WHERE WithDate LIKE '%{$date}%'";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) 
        {
            $data[] = $row;  
        }
        foreach($data as $key => $with)
            // $sum = 0;
            $qty = $with["Qtysum"];
            echo $qty;
            $sum =+ $qty;
        {      
            $staffid = $with["StaffId"];
            $sql = "SELECT * FROM tbl_staff WHERE StaffId = '$staffid'";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) 
            {
                $data[] = $row;  
            }
            foreach($data as $key => $staff){}    
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase order</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
    </head>

<style>
body{margin-top:20px;
    color: #2e323c;
    background: #f5f6fa;
    position: relative;
    height: 100%;
    font-family: 'Sarabun', sans-serif;
}
.invoice-container {
    padding: 1rem;
}
.invoice-container .invoice-header .invoice-logo {
    margin: 0.8rem 0 0 0;
    display: inline-block;
    font-size: 1.6rem;
    font-weight: 700;
    color: #2e323c;
}
.invoice-container .invoice-header .invoice-logo img {
    max-width: 130px;
}
.invoice-container .invoice-header address {
    font-size: 1.3rem;
    color: #9fa8b9;
    margin: 0;
}
.invoice-container .invoice-details {
    margin: 1rem 0 0 0;
    padding: 1rem;
    line-height: 180%;
    background: #f5f6fa;
}
.invoice-container .invoice-details .invoice-num {
    text-align: right;
    font-size: 1.3rem;
}
.invoice-container .invoice-body {
    padding: 1rem 0 0 0;
}
.invoice-container .invoice-footer {
    text-align: center;
    font-size: 1.7rem;
    margin: 5px 0 0 0;
}

.invoice-status {
    text-align: center;
    padding: 1rem;
    background: #ffffff;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    margin-bottom: 1rem;
}
.invoice-status h2.status {
    margin: 0 0 0.8rem 0;
}
.invoice-status h5.status-title {
    margin: 0 0 0.8rem 0;
    color: #9fa8b9;
}
.invoice-status p.status-type {
    margin: 0.5rem 0 0 0;
    padding: 0;
    line-height: 150%;
}
.invoice-status i {
    font-size: 1.5rem;
    margin: 0 0 1rem 0;
    display: inline-block;
    padding: 1rem;
    background: #f5f6fa;
    -webkit-border-radius: 50px;
    -moz-border-radius: 50px;
    border-radius: 50px;
}
.invoice-status .badge {
    text-transform: uppercase;
}

@media (max-width: 767px) {
    .invoice-container {
        padding: 1rem;
    }
}


.custom-table {
    border: 1px solid #e0e3ec;
}
.custom-table thead {
    background: #007ae1;
}
.custom-table thead th {
    border: 0;
    color: #ffffff;
}
.custom-table > tbody tr:hover {
    background: #fafafa;
}
.custom-table > tbody tr:nth-of-type(even) {
    background-color: #ffffff;
}
.custom-table > tbody td {
    border: 1px solid #e6e9f0;
}


.card {
    background: #ffffff;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border: 0;
    margin-bottom: 1rem;
}

.text-success {
    color: #00bb42 !important;
}

.text-muted {
    color: #9fa8b9 !important;
}

.custom-actions-btns {
    margin: auto;
    display: flex;
    justify-content: flex-end;
}

.custom-actions-btns .btn {
    margin: .3rem 0 .3rem .3rem;
}

.container {
    width: 786px;
}
</style>

<body>


<div class="container">
<div class="row gutters">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-body p-0">
					<div class="invoice-container">
						<div class="invoice-header">
							<!-- Row start -->
							
							<!-- Row end -->
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                    Monthly report<br>
                                    
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6">
									<address class="text-right">
                                        M38 Petchkasem Rd, Bang Wa <br>
										SPhasi Charoen, Bangkok 10160.<br>
										02 867 8088
									</address>
								</div>
							</div>
							<!-- Row end -->
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
									<div class="invoice-details">
										<address>
                                            <div>Writdraw <?php echo $date;?></div>
										</address>
									</div>
								</div>
							<!-- Row end -->
						</div>
						<div class="invoice-body">
							<!-- Row start -->
							<div class="row gutters">
                            <table class="table table-bordered">
                                <thead>
                                </thead>
                                    <tr>
                                        <th>WithId</th>
                                        <th>StaffId</th>
                                        <th>WithDate</th>
                                        <th>Status</th>
                                        <th>Quantity</th>
                                    </tr>

                                <tbody>
                                    
                                    <?php 
                                        $sql = "SELECT * FROM tbl_withdraw WHERE WithDate LIKE '%{$date}%'";
                                        $result = $conn->query($sql);
                                        $data = array();
                                        while($row = $result->fetch_assoc()) {
                                            $data[] = $row;   
                                        }
                                        foreach($data as $key => $with){

                                            $staffid = $with["StaffId"];
                                            $sql = "SELECT * FROM tbl_staff WHERE StaffId = $staffid";
                                            $result = $conn->query($sql);
                                            $data = array();
                                            while($row = $result->fetch_assoc()) {
                                                $data[] = $row;   
                                            }
                                            foreach($data as $key => $staff){
                                            $withstatus = $with["WithStatus"];
                                            
                                    ?>
                                        <tr>
                                            <td><?php echo "#".$with["WithId"]; ?></td>
                                            <td><?php echo $staff["StaffName"]; ?></td>
                                            <td><?php echo $with["WithDate"]; ?></td>
                                            <td><?php echo $with["WithStatus"]; ?></td>
                                            <td><?php echo $with["Qtysum"]; ?></td>
                                        </tr>
                                        <?php } } ?>
                                        <tr>
                                            <td colspan = "4">ToTal</td>
                                            <td><?php echo $sum; ?></td>
                                            
                                        </tr>
                                    
                                </tbody>
                            </table>
                            </div>
							<!-- Row end -->
						</div>
						<div class="invoice-footer">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    
</div>
    </div>

<?php
    $html=ob_get_contents();
    $mpdf->WriteHTML($html);
    $mpdf->Output("report/Export-Writdraw.pdf");
    ob_end_flush();
?>
</body>
</html>