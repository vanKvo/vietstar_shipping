<!DOCTYPE html>
<html>
<head>
	<!-- js -->			
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('a[rel*=facebox]').facebox({
      loadingImage : 'src/loading.gif',
      closeImage   : 'src/closelabel.png'
    })
  })
</script>
<title>
POS
</title>
<?php
	require_once('auth.php');
?>
       
		<link href="vendors/uniform.default.css" rel="stylesheet" media="screen">
  <link href="css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
  
  <link rel="stylesheet" href="css/font-awesome.min.css">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

	<!-- combosearch box-->	
	
	  <script src="vendors/jquery-1.7.2.min.js"></script>
    <script src="vendors/bootstrap.js"></script>

	
	
<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<!--sa poip up-->




 <script language="javascript" type="text/javascript">
/* Visit http://www.yaldex.com/ for full source code
and get more free JavaScript, CSS and DHTML scripts! */
<!-- Begin
var timerID = null;
var timerRunning = false;
function stopclock (){
if(timerRunning)
clearTimeout(timerID);
timerRunning = false;
}
function showtime () {
var now = new Date();
var hours = now.getHours();
var minutes = now.getMinutes();
var seconds = now.getSeconds()
var timeValue = "" + ((hours >12) ? hours -12 :hours)
if (timeValue == "0") timeValue = 12;
timeValue += ((minutes < 10) ? ":0" : ":") + minutes
timeValue += ((seconds < 10) ? ":0" : ":") + seconds
timeValue += (hours >= 12) ? " P.M." : " A.M."
document.clock.face.value = timeValue;
timerID = setTimeout("showtime()",1000);
timerRunning = true;
}
function startclock() {
stopclock();
showtime();
}
window.onload=startclock;
// End -->
</SCRIPT>	

</head>
<?php
function createRandomPassword() {
	$chars = "003232303232023232023456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass = '' ;
	while ($i <= 7) {

		$num = rand() % 33;

		$tmp = substr($chars, $num, 1);

		$pass = $pass . $tmp;

		$i++;

	}
	return $pass;
}
$finalcode='RS-'.createRandomPassword();
?>
<body>
<?php include('navfixed.php');?>
	<?php
$position=$_SESSION['SESS_LAST_NAME'];
if($position=='cashier') {
?>
<!--<a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>">Cash</a>-->
<a href="sales.php?pmt_method=cash&invoice=<?php echo $finalcode ?>">Cash</a>

<a href="../index.php">Logout</a>
<?php
}
if($position=='admin') {
?>
	
<div class="container-fluid">
      <div class="row-fluid">
	<div class="span2">
          <div class="well sidebar-nav">
              <ul class="nav nav-list">
              <li><a href="index.php"><i class="icon-dashboard icon-2x"></i> Dashboard </a></li> 
			<li class="active"><a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><i class="icon-shopping-cart icon-2x"></i> Sales</a>  </li>             
			<li><a href="products.php"><i class="icon-list-alt icon-2x"></i> Products</a>                                     </li>
			<li><a href="customer.php"><i class="icon-group icon-2x"></i> Customers</a>                                    </li>
			<li><a href="supplier.php"><i class="icon-group icon-2x"></i> Suppliers</a>                                    </li>
			<li><a href="salesreport.php?d1=0&d2=0"><i class="icon-bar-chart icon-2x"></i> Sales Report</a>                </li>
			<br><br><br><br><br><br>
			<li>
			 <div class="hero-unit-clock">
		
			<form name="clock">
			<font color="white">Time: <br></font>&nbsp;<input style="width:150px;" type="text" class="trans" name="face" value="" disabled>
			</form>
			  </div>
			</li>
				
				</ul>    
<?php } ?>				
          </div><!--/.well -->
        </div><!--/span-->
	<div class="span10">
		<div class="contentheader">
			<i class="icon-money"></i> Sales
			</div>
			<ul class="breadcrumb">
			<a href="index.php"><li>Dashboard</li></a> /
			<li class="active">Sales</li>
			</ul>
<div style="margin-top: -19px; margin-bottom: 21px;">
<a  href="index.php"><button class="btn btn-default btn-large" style="float: none;"><i class="icon icon-circle-arrow-left icon-large"></i> Back</button></a>
</div>
													
<form action="incoming.php" method="post" >								
	<input type="hidden" name="pmt_method" value="<?php echo $_GET['pmt_method']; ?>" />
	<input type="hidden" name="invoice" value="<?php echo $_GET['invoice']; ?>" />
	<select name="product_id" style="width:650px; "class="chzn-select" required>
	<option></option>
		<?php
		include('../connect.php');
		$result = $db->prepare("SELECT * FROM products");
			$result->bindParam(':invoice_id', $res);
			$result->execute();
			for($i=0; $row = $result->fetch(); $i++){
		?>
			<option value="<?php echo $row['product_id'];?>"><?php echo $row['product_code']; ?> | <?php echo $row['product_name']; ?> | Qty Onhand: <?php echo $row['qty_onhand']; ?></option>
		<?php
					}
		?>
	</select>
	<input type="number" name="qty_picked" value="1" min="1" placeholder="Qty" autocomplete="off" style="width: 68px; height:30px; padding-top:6px; padding-bottom: 4px; margin-right: 4px; font-size:15px;" required>
	<input type="hidden" name="discount" value="" autocomplete="off" style="width: 68px; height:30px; padding-top:6px; padding-bottom: 4px; margin-right: 4px; font-size:15px;" />
	<input type="hidden" name="date" value="<?php echo date("m/d/y"); ?>" />
	<button type="submit" class="btn btn-info" style="width: 123px; height:35px; margin-top:-5px;"><i class="icon-plus-sign icon-large"></i> Add</button>
</form>
<table class="table table-bordered" id="resultTable" data-responsive="table">
	<thead>
		<tr>
			<th> Product Code </th>
			<th> Product Name </th>
			<th> Category / Description </th>
			<th> Unit Price </th>
			<th> Qty </th>
			<th> Amount </th>
			<th> Profit </th>
			<th> Action </th>
		</tr>
	</thead>
	<tbody>
		
			<?php
				$id=$_GET['invoice'];
				include('../connect.php');
				$query = "SELECT * FROM sales_order so JOIN products p 
				ON so.product_id = p.product_id
				WHERE invoice = :invoice_id";
				$result = $db->prepare($query);
				$result->bindParam(':invoice_id', $id);
				$result->execute();
				for($i=1; $row = $result->fetch(); $i++){
					?>
					<tr class="record">
					<td hidden><?php echo $row['product_id']; ?></td>
					<td><?php echo $row['product_code']; ?></td>
					<td><?php echo $row['product_name']; ?></td>
					<td><?php echo $row['product_category']; ?></td>
					<td>
					<?php
					$ppp=$row['unit_price'];
					echo formatMoney($ppp, true);
					?>
					</td>
					<td><?php echo $row['qty_picked']; ?></td>
					<td>
					<?php
					$sales_order_amount=$row['sales_order_amount'];
					echo formatMoney($sales_order_amount, true);
					?>
					</td>
					<td>
					<?php
					$profit=$row['sales_order_profit'];
					echo formatMoney($profit, true);
					?>
					</td>
					<td width="90"><a href="delete.php?sales_order_id=<?php echo $row['sales_order_id']; ?>&invoice=<?php echo $_GET['invoice']; ?>&pmt_method=<?php echo $_GET['pmt_method']; ?>&qty_picked=<?php echo $row['qty_picked'];?>&product_id=<?php echo $row['product_id'];?>"><button class="btn btn-mini btn-warning"><i class="icon icon-remove"></i> Cancel </button></a></td>
					</tr>
			<?php
				}
			?>
			<tr>
			<th> </th>
			<th>  </th>
			<th>  </th>
			<th>  </th>
			<th>  </th>
			<td> Total Amount: </td>
		 <td> Total Profit: </td>
			<th>  </th>
		</tr>
			<tr>
				<th colspan="5"><strong style="font-size: 12px; color: #222222;">Total:</strong></th>
				<td colspan="1"><strong style="font-size: 12px; color: #222222;">
				<?php
				function formatMoney($number, $fractional=false) {
					if ($fractional) {
						$number = sprintf('%.2f', $number);
					}
					while (true) {
						$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
						if ($replaced != $number) {
							$number = $replaced;
						} else {
							break;
						}
					}
					return $number;
				}
				$invoice=$_GET['invoice'];
				$resultas = $db->prepare("SELECT sum(sales_order_amount) FROM sales_order WHERE invoice= :a");
				$resultas->bindParam(':a', $invoice);
				$resultas->execute();
				for($i=0; $rowas = $resultas->fetch(); $i++){
				$total_amount=$rowas['sum(sales_order_amount)'];
				echo formatMoney($total_amount, true);
				}
				?>
				</strong></td>
				<td colspan="1"><strong style="font-size: 12px; color: #222222;">
			<?php 
				$resulta = $db->prepare("SELECT sum(sales_order_profit) FROM sales_order WHERE invoice= :b");
				$resulta->bindParam(':b', $invoice);
				$resulta->execute();
				for($i=0; $qwe = $resulta->fetch(); $i++){
				$total_profit=$qwe['sum(sales_order_profit)'];
				echo formatMoney($total_profit, true);
				} 
			?>
				</td>
				<th></th>
			</tr>
		
	</tbody>
</table><br>
<a rel="facebox" href="checkout.php?payment_method=<?php echo $_GET['pmt_method']?>&invoice=<?php echo $_GET['invoice']?>&total_amount=<?php echo $total_amount ?>&total_profit=<?php echo $total_profit ?>&cashier=<?php echo $_SESSION['SESS_FIRST_NAME']?>"><button class="btn btn-success btn-large btn-block"><i class="icon icon-save icon-large"></i> SAVE</button></a>
<div class="clearfix"></div>
</div>
</div>
</div>
</body>
<?php include('footer.php');?>
</html>