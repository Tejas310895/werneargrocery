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

    $order_date = $row_orders['order_date'];

    $get_total = "SELECT sum(due_amount) AS total FROM customer_orders WHERE invoice_no='$invoice_id'";

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


}

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../styles/bootstrap.min.css" >
    <link rel="stylesheet" href="../styles/bootstrap.css" >
    <script>
        window.onload = function () {
            window.print();
        }

        window.onafterprint = function(){
            document.location.href = "index.php?view_orders";
        }
    </script>
    <style>

    @media print {
         *{width: 100mm;}

            td.table{
                width:20%;
            }

         }


 </style>
</head>

<body>

<div class="container">
<div class="row">
    <div class="col-12">
        <img src="admin_images/black.png" alt="" class="border-0 d-block mx-auto pt-4" width="50%">
        <p class="text-center">We Deliver Happiness</p>
        <br>
        <h4>Order Date : <?php echo $order_date; ?></h4>
        <h4>Name : <?php echo $c_name; ?></h4>
        <h4>Mobile No. : <?php echo $c_contact; ?></h4>
        <h4>Address : <?php echo $customer_address.', '.$customer_phase.', '.$customer_landmark.', '.$customer_city.'.'; ?></h4>
    </div>
    <div class="col-12">
        <table class="table" style="font-weight:bold;font-size:1.2rem;">
            <thead>
                <tr>
                    <th>ITEMS</th>
                    <th>QTY</th>
                    <th>SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
            <?php
                                          
            $get_pro_id = "select * from customer_orders where invoice_no='$invoice_id'";

            $run_pro_id = mysqli_query($con,$get_pro_id);

            $counter = 0;

            while($row_pro_id = mysqli_fetch_array($run_pro_id)){

            $pro_id = $row_pro_id['pro_id'];

            $qty = $row_pro_id['qty'];

            $get_pro = "select * from products where product_id='$pro_id'";

            $run_pro = mysqli_query($con,$get_pro);

            $row_pro = mysqli_fetch_array($run_pro);

            $pro_title = $row_pro['product_title'];

            $pro_price = $row_pro['product_price'];

            $pro_desc = $row_pro['product_desc'];
            
            $sub_total = $pro_price * $qty;

            $get_min = "select * from admins";

            $run_min = mysqli_query($con,$get_min);

            $row_min = mysqli_fetch_array($run_min);

            $min_price = $row_min['min_order'];

            $del_charges = $row_min['del_charges'];

            ?>
                <tr>
                    <td><?php echo $pro_title; ?> <br> <?php echo $pro_desc; ?> </td>
                    <td ><?php echo  $qty; ?> </td>  
                    <td>₹ <?php echo $sub_total; ?></td>
                </tr>
         <?php } ?>
                <tr>
                    <td colspan="2" class="text-left">Item Total </td>
                    <td>: ₹ <?php echo $total; ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-left">Delivery Changes </td>
                    <td>: ₹ <?php echo $del_charges; ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center"><h4 class="mb-0">   Grand Total : ₹ <?php echo $total+$del_charges; ?></h4><p style="font-size:0.7rem;">(inc of all taxes)</p></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-12">
        <h5 class="text-center">Thank You</h5>
        <h6 class="text-center">Order Again : www.wernear.in</h6>
    </div>
</div>
</div>

</body>
</html>



