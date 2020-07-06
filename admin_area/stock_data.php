<?php 

    include("includes/db.php");

?>

<?php 

if(isset($_POST['view'])){

    $from = $_POST['start'];

    $to = $_POST['end'];

    $a = 'Order Placed';

    $b = ' Delivered';

    $order_status = $a.$b;

    $counter = 0;

    $get_bstock = "SELECT distinct pro_id from customer_orders where order_status in ('Order Placed' , 'Delivered') and order_date between '$from' and '$to'";

    $run_bstock = mysqli_query($con,$get_bstock);
                        
    while($row_bstock = mysqli_fetch_array($run_bstock)){

    $pro_id = $row_bstock['pro_id'];

    $get_qtysum = "SELECT SUM(qty) AS bulk_qty FROM customer_orders where pro_id='$pro_id' and order_status in ('Order Placed' , 'Delivered') and order_date between '$from' and '$to'";

    $run_qtysum = mysqli_query($con,$get_qtysum);

    $row_qtysum = mysqli_fetch_array($run_qtysum);

    $bulk_qty = $row_qtysum['bulk_qty'];
    
    $get_prodet = "select * from products where product_id='$pro_id'";

    $run_prodet = mysqli_query($con,$get_prodet);

    $row_prodet = mysqli_fetch_array($run_prodet);

    $pro_title = $row_prodet['product_title'];

    $pro_desc = $row_prodet['product_desc'];

    $counter = $counter+1;

    echo "
    <tr>
        <td class='text-center'> $counter </td>
        <td>$pro_title</td>
        <td>$pro_desc</td>
        <td>$bulk_qty</td>
    </tr>
    ";

}

}

?>
