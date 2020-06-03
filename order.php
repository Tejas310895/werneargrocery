<?php 

    include("includes/db.php");
    include("functions/function.php");

?>

<?php 

if(isset($_POST['c_id'])){

    $customer_id = $_POST['c_id'];

    $add_id = $_POST['add_id'];

    $date = $_POST['date'];

}

$ip_add = getRealIpUser();

$status = "Order Placed";

$invoice_no = mt_rand();

$select_cart = "select * from cart where ip_add='$ip_add'";

$run_cart = mysqli_query($con,$select_cart);

while($row_cart = mysqli_fetch_array($run_cart)){

    $pro_id = $row_cart['p_id'];

    $pro_qty = $row_cart['qty'];

    $get_products = "select * from products where product_id='$pro_id'";

    $run_products = mysqli_query($con,$get_products);

    while($row_products = mysqli_fetch_array($run_products)){

        $sub_total = $row_products['product_price']*$pro_qty;

        $insert_customer_order = "insert into customer_orders (customer_id,add_id,pro_id,due_amount,invoice_no,qty,order_date,del_date,order_status) 
        values ('$customer_id','$add_id',' $pro_id','$sub_total','$invoice_no','$pro_qty',NOW(),'$date','$status')";

        $run_customer_order = mysqli_query($con,$insert_customer_order);

        $delete_cart = "delete from cart where ip_add='$ip_add'";

        $run_delete = mysqli_query($con,$delete_cart);


        echo "<script>alert('your orders has been submitted, thanks')</script>";

        echo "<script>window.open('customer/my_account','_self')</script>";




    }

}

?>