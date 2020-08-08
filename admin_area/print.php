<?php 

include("includes/db.php");


if(isset($_GET['print'])){

    $invoice_id = $_GET['print'];

    $get_orders = "select * from customer_orders where invoice_no='$invoice_id'";

    $run_orders = mysqli_query($con,$get_orders);

    //$order_count = mysqli_num_rows($run_orders);

    $row_orders = mysqli_fetch_array($run_orders);

    $c_id = $row_orders['customer_id'];

    $date = $row_orders['order_date'];

    $add_id = $row_orders['add_id'];

    $del_date = $row_orders['del_date'];

    $get_total = "SELECT sum(due_amount) AS total FROM customer_orders WHERE invoice_no='$invoice_id' and product_status='Deliver'";

    $run_total = mysqli_query($con,$get_total);

    $row_total = mysqli_fetch_array($run_total);

    $total = $row_total['total'];

    $get_customer = "select * from customers where customer_id='$c_id'";

    $run_customer = mysqli_query($con,$get_customer);

    $row_customer = mysqli_fetch_array($run_customer);

    $c_name = $row_customer['customer_name'];

    $c_contact = $row_customer['customer_contact'];

    $get_add = "select * from customer_address where add_id='$add_id'";

    $run_add = mysqli_query($con,$get_add);

    $row_add = mysqli_fetch_array($run_add);

    $customer_address = $row_add['customer_address'];

    $customer_phase = $row_add['customer_phase'];

    $customer_landmark = $row_add['customer_landmark'];

    $customer_city = $row_add['customer_city'];

    $get_min = "select * from admins";

    $run_min = mysqli_query($con,$get_min);

    $row_min = mysqli_fetch_array($run_min);

    $min_price = $row_min['min_order'];

    $del_charges = $row_min['del_charges'];

    $get_txn = "select * from paytm where ORDERID='$invoice_id'";

    $run_txn = mysqli_query($con,$get_txn);

    $row_txn = mysqli_fetch_array($run_txn);

    $txn_status = $row_txn['STATUS'];


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Courgette' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" >
	<title>Bill</title>
	<style>
		@media print{
			.table,thead{
				border:2px solid #000;
			}
		}
	</style>
	<script>
        window.onload = function () {
            window.print();
        }

        window.onafterprint = function(){
            window.close();
        }
    </script>
</head>
<body>
	<div class="container-fluid px-4">
		<div class="row py-1">
			<div class="col-2 px-0">
				<img src="admin_images/dashlogo.png" alt="" class="img-fluid border-3">
			</div>
			<div class="col-10">
				<h5 class="mb-0"><strong>Delivery Statement (Ordered On : <?php echo date("d/M/Y", strtotime($date)); ?> )</strong></h5>
				<h5 class="mb-0"><strong>Name :</strong> <?php echo $c_name; ?> / <strong>Mobile :</strong> +91 <?php echo $c_contact; ?> / <strong>Address :</strong><?php echo $customer_address; ?>, <?php echo $customer_landmark; ?>, <?php echo $customer_phase; ?>, <?php echo $customer_city; ?>. </h5>
			</div>
		</div>
		<table class="table table-bordered mt-2 head">
		<thead>
		<tr>
		<th  style="border:3px solid #000;">Order ID</th><th style="border:3px solid #000;"><?php echo $invoice_id; ?></th>
		<th style="border:3px solid #000;">Amount Payable</th><th style="border:3px solid #000;">Rs.<?php echo $total; ?></th>
		<th style="border:3px solid #000;">Payment Mode</th><th style="border:3px solid #000;"><?php if($txn_status==='TXN_SUCCESS'){echo "PREPAID";}else{echo "POSTPAID";} ?></th>
		<th style="border:3px solid #000;">Delivery Slot</th><th style="border:3px solid #000;"><?php echo date("d/M/Y", strtotime($del_date)); ?></th>
		</tr>
		</thead>
		</table>
		<table class="table table-bordered mt-2">
		    <thead class="text-center">
			   <th colspan="5">Delivered Items</th>
			</thead>
			<thead class="text-center">
				<th style="width:5%;">Sl.No</th>
				<th style="width:60%;">ITEM</th>
				<th style="width:5%;">QUANTITY</th>
				<th style="width:15%;">SAVING</th>
				<th style="width:15%;">TOTAL</th>
			</thead>
			<tbody>
			<?php

				$get_pro_id = "select * from customer_orders where invoice_no='$invoice_id'";

				$run_pro_id = mysqli_query($con,$get_pro_id);

				$counter = 0;

				while($row_pro_id = mysqli_fetch_array($run_pro_id)){
					
				$pro_id = $row_pro_id['pro_id'];

				$qty = $row_pro_id['qty'];

				$product_status = $row_pro_id['product_status'];

				$get_pro = "select * from products where product_id='$pro_id'";

				$run_pro = mysqli_query($con,$get_pro);

				while($row_pro = mysqli_fetch_array($run_pro)){

					$total =0;

					$pro_title = $row_pro['product_title'];

					$pro_desc = $row_pro['product_desc'];

					$pro_price = $row_pro['product_price'];

					$mrp = $row_pro['price_display'];

					$discount = ($mrp-$pro_price)*$qty;

					$sub_total = $row_pro['product_price']*$qty;
					
					$total += $sub_total;

					$counter = ++$counter;

					if($product_status==='Deliver'){

						echo "

						<tr>
						<td class='text-center'>$counter</td>
						<td>$pro_title $pro_desc</td>
						<td class='text-center'>$qty</td>
						<td class='text-center'>$discount.00</td>
						<td class='text-center'>$sub_total.00</td>
						</tr>
						";	

					}else {

						echo "

						<tr>
						<td class='text-center'>$counter</td>
						<td>$pro_title $pro_desc</td>
						<td class='text-center'>$qty</td>
						<td class='text-center' colspan='2'><strong>Undelivered</strong></td>
						</tr>
						";	

					}

					}

				}
				?>		
			</tbody>
			<tbody>
				<tr style="border-top:3px solid #000;">
				    <th colspan="4" class="text-right">GRAND TOTAL :</th>
					<th class="text-center">Rs. <?php echo $total; ?>.00</th>	
				</tr>
			</tbody>
		</table>
		<div class="row">
			<div class="col-12">
				<h5 style="font-size:1rem;font-family:Courgette;">Note :</h5>
				<h5 style="font-size:1rem;font-family:Courgette;">For tax invoice: https://www.wernear.in/customer/order_view?invoice_no=772077224553</h5>
				<h5 style="font-size:1rem;font-family:Courgette;">For online payments refunds will be given online only not cash refunds will be given.</h5>
			</div>
			<div class="col-12">
				<hr class="mb-0" style="border-top:1px solid #999;height:10px;">
				<h5 style="font-size:1rem;font-family:Raleway;text-align:center;">WERNEAR TECHNOLOGIES, Dombivali East, 421204. GSTN:27AADFW3376J1ZR</h5>
			</div>
		</div>
	</div>
</body>
</html>



