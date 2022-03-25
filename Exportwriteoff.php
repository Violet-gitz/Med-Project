<?php
    error_reporting(0);
    include('Connect.php'); 
    if (isset($_REQUEST['Report'])) 
    {
        $Year = $_REQUEST["Year"];
        $Month = $_REQUEST["Month"];
        $date=$Year.$Month;
       
        $sql = "SELECT tbl_writeoff.WriteId,tbl_writeoff.LotId,tbl_writeoff.MedId,tbl_writeoff.Qty,tbl_writeoff.WriteDate,tbl_lot.LotStatus,tbl_med.MedName,tbl_staff.StaffName 
        FROM tbl_writeoff
        INNER JOIN tbl_staff ON tbl_writeoff.StaffId = tbl_staff.StaffId
        INNER JOIN tbl_lot ON tbl_writeoff.LotId = tbl_lot.LotId
        INNER JOIN tbl_med ON tbl_writeoff.MedId = tbl_med.MedId
        WHERE WriteDate LIKE '%{$date}%'";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) 
        {
            $data[] = $row;  
        }
        foreach($data as $key => $write){}
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">

    <script language="javascript" type="text/javascript">
        function printWindow()
        {
        var printReadyEle = document.getElementById("printContent");
        var shtml = '<HTML>\n<HEAD>\n';
        if (document.getElementsByTagName != null)
        {
            var sheadTags = document.getElementsByTagName("head");
            if (sheadTags.length > 0)
                shtml += sheadTags[0].innerHTML;
            }
            shtml += '</HEAD>\n<BODY onload="window.print();">\n';
            if (printReadyEle != null)
            {
            shtml += '<form name = frmform1>';
            shtml += printReadyEle.innerHTML;
            }
            shtml += '\n</form>\n</BODY>\n</HTML>';
            var printWin1 = window.open();
            printWin1.document.open();
            printWin1.document.write(shtml);
            printWin1.document.close();

        }
    </script>
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
    margin: 0;
}
.invoice-container .invoice-details {
    margin: 1rem 0 0 0;
    padding: 1rem;
    line-height: 180%;
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
</style>

<body>
<div class="container">
<div class="row gutters" id="printContent">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-body p-0">
					<div class="invoice-container">
						<div class="invoice-header">
							<div class="row gutters">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
									
                                        <?php 
                                           echo "<h3>รายงานการตัดจำหน่าย<br>ประจำเดือนที่ ".$Month ."-". $Year."</h3>";
                                        ?><br>

								</div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
									<address class="text-right">
                                        38 ถ. เพชรเกษม แขวง บางหว้า <br>
										เขตภาษีเจริญ กรุงเทพมหานคร 10160.<br>
										02 867 8088
									</address>
								</div>
				
							<!-- Row end -->
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
									<div class="invoice-details">
										<address>
										<?php 
                                           date_default_timezone_set("Asia/Bangkok");
                                           $Datereport = date("d")."-".date("m")."-".(date("Y")+543);  
                                           echo "วันที่ออกรายงาน : ". $Datereport;
                                        ?>
										</address>
									</div>
								</div>
								<!-- <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
									<div class="invoice-details">
										<div class="invoice-num">
                                           
										</div>
									</div>													
								</div> -->
							</div>
							<!-- Row end -->
						</div>
						<div class="invoice-body">
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="table-responsive">
										<table class="table custom-table m-0">
											<!-- <thead> -->
												<tr>
													<th width = "220">ชื่อยา</th>
                                                    <th with = "80">ล็อตที่</th>
													<th width = "100">รหัสยา</th>
													<th width = "80">จำนวน</th>
												</tr>
											<!-- </thead> -->
											<tbody>
                                                <?php
                                                    $sum = 0;
                                                    $sql = "SELECT tbl_writeoff.WriteId,tbl_writeoff.LotId,tbl_writeoff.MedId,tbl_writeoff.Qty,tbl_writeoff.WriteDate,tbl_lot.LotStatus,tbl_med.MedName,tbl_staff.StaffName 
                                                    FROM tbl_writeoff
                                                    INNER JOIN tbl_staff ON tbl_writeoff.StaffId = tbl_staff.StaffId
                                                    INNER JOIN tbl_lot ON tbl_writeoff.LotId = tbl_lot.LotId
                                                    INNER JOIN tbl_med ON tbl_writeoff.MedId = tbl_med.MedId
                                                    WHERE WriteDate LIKE '%{$date}%'";
                                                    $result = $conn->query($sql);
                                                    $data = array();
                                                    while($row = $result->fetch_assoc()) 
                                                    {
                                                        $data[] = $row;  
                                                    }
                                                    foreach($data as $key => $write){
                                                $sum = $sum + $write["Qty"];
                                                    $Med = $write["MedId"];
                                                    $sqli ="SELECT * FROM tbl_med WHERE $Med = MedId";
                                                    $result = $conn->query($sqli);
                                                    $data = array();
                                                    while($row = $result->fetch_assoc()) 
                                                    {
                                                    $data[] = $row;   
                                                    }   
                                                        foreach($data as $key => $med){
                                                ?>
												<tr>
													<td width = "220"><?php echo $med["MedName"];?></td>
                                                    <td width = "100"><?php echo "#".$write["LotId"];?></td>
													<td width = "100"><?php echo "#".$med["MedId"];?></td>
													<td width = "80"><?php echo $write["Qty"];?></td>
													
												</tr>
                                                    <?php
                                                            }}
                                                    ?>
											
												<tr>
                                                    <td colspan="1"><h5 class="text-success"><strong>จำนวนรวม</strong></h5></td>	
                                                    <td><h5 class="text-success"><strong></strong></h5></td>	
                                                    <td></td>	
													<td><h5 class="text-success"><strong><?php echo $sum. "<br>";?></strong></h5></td>
												</tr>
											</tbody>
										</table>

                                       
									</div>
								</div>
							</div>
							<!-- Row end -->
						</div>
				
                        <div class="row">
                            <div class="col-md-12 text-right identity">
                          
                            </div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</body>


            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="button" value="พิมพ์" class="btn btn-primary" onclick="window.printWindow()" /> 
                    <a href="Writeoffshow.php" class="btn btn-danger">กลับ</a>
                </div>
            </div>
</html>