<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();
	
	// Graph Type
	$top = $_GET['b'];
	if($top == 1)
	{ $gpt = "bar"; }
	else if($top == 2)
	{ $gpt = "line"; }
	else
	{ $gpt = "pie"; }
		
     if (!$link) {
         # code...
        echo "Problem in database connection! Contact administrator!" . mysqli_error();
     }else{
             $sql = $conn->prepare("SELECT * FROM tr_sales_graph ORDER BY od_date");
             $sql->execute();
             $chart_data="";
             while ($sql_data = $sql->fetch()) { 
     
                $productname[]  = $sql_data['date_name'];
                $sales[] = $sql_data['total_sales'];
            }
     
     
     }
	 
	 $customer = $_GET['c'];
	 
	 $cst = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$customer'");
	 $cst->execute();
	 $cst_data = $cst->fetch();
	 $custname = $cst_data['client_name'];
	 
	 $rty = $_GET['l'];
	 if($rty == 1){ $leg = "Sales"; }else{ $leg = "Quantity"; }
	 
     
    ?>
    <!DOCTYPE html>
    <html lang="en"> 
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Graphical <?php echo $leg; ?> Report</title>
			<link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>images/favicon.ico">
        </head>
        <body>
            <div style="width:60%;hieght:20%;text-align:center">
			<table style="margin:auto;">
			<tr>
				<td><img src="<?php echo WEB_ROOT; ?>images/logo/header_logo.png" /></td>
				<td>&nbsp; &nbsp;</td>
				<td>
					<h2 class="page-header" >Graphical <?php echo $leg; ?> Report - <?php echo $custname; ?></h2>					
				</td>
			</tr>
			<table>               
                <canvas id="chartjs_bar"></canvas> 
            </div>    
        </body>
      <script src="jquery.js"></script>
      <script src="Chart.min.js"></script>
    <script type="text/javascript">
          var ctx = document.getElementById("chartjs_bar").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: '<?php echo $gpt; ?>',
                        data: {
                            labels:<?php echo json_encode($productname); ?>,
                            datasets: [{
                                backgroundColor: [
                                   "#5969ff",
                                    "#ff407b",
                                    "#25d5f2",
                                    "#ffc750",
                                    "#2ec551",
                                    "#7040fa",
                                    "#ff004e"
                                ],
                                data:<?php echo json_encode($sales); ?>,
                            }]
                        },
                        options: {
                               legend: {
                            display: false,
                            position: 'bottom',
     
                            labels: {
                                fontColor: '#71748d',
                                fontFamily: 'Circular Std Book',
                                fontSize: 14,
                            }
                        },
     
     
                    }
                    });
        </script>
    </html>