<?php 


if(isset($_POST['c_id'])){

    $customer_id = $_POST['c_id'];

    $add_id = $_POST['add_id'];

    $date = $_POST['date'];

    date_default_timezone_set('Asia/Kolkata');

    $today = date("Y-m-d H:i:s");

}

$get_contact = "select * from customers where customer_id='$customer_id'";

$run_contact = mysqli_query($con,$get_contact);

$row_contact = mysqli_fetch_array($run_contact);

$c_contact = $row_contact['customer_contact'];

$get_unique = "SELECT * from customer_orders order by order_id DESC LIMIT 1";

$run_unique = mysqli_query($con,$get_unique);

$row_unique = mysqli_fetch_array($run_unique);

$unique_num = $row_unique['order_id'];

$ip_add = getRealIpUser();

$user_id = getuserid();

$status = "Order Placed";

$invoice_no = $unique_num.mt_rand();

$select_cart = "select * from cart where ip_add='$ip_add' AND user_id='$user_id'";

$run_cart = mysqli_query($con,$select_cart);

while($row_cart = mysqli_fetch_array($run_cart)){

    $pro_id = $row_cart['p_id'];

    $pro_qty = $row_cart['qty'];

    $get_products = "select * from products where product_id='$pro_id'";

    $run_products = mysqli_query($con,$get_products);

    while($row_products = mysqli_fetch_array($run_products)){

        $sub_total = $row_products['product_price']*$pro_qty;
        $vendor_sub_total = $row_products['venor_price']*$pro_qty;

        $client_id = $row_products['client_id'];

        $ord_pro_hsn = $row_products['product_hsn'];
        $ord_pro_cgst = $row_products['product_cgst'];
        $ord_pro_sgst = $row_products['product_sgst'];
        $ord_pro_igst = $row_products['product_igst'];
        $ord_pro_cess = $row_products['product_cess'];

        $insert_customer_order = "insert into customer_orders (customer_id,
                                                               add_id,
                                                               pro_id,
                                                               due_amount,
                                                               vendor_due_amount,
                                                               invoice_no,
                                                               qty,
                                                               order_date,
                                                               del_date,
                                                               order_status,
                                                               product_status,
                                                               client_id,
                                                               ord_pro_hsn,
                                                               ord_pro_cgst,
                                                               ord_pro_sgst,
                                                               ord_pro_igst,
                                                               ord_pro_cess) 
                                                        values ('$customer_id',
                                                                '$add_id',
                                                                '$pro_id',
                                                                '$sub_total',
                                                                '$vendor_sub_total',
                                                                '$invoice_no',
                                                                '$pro_qty',
                                                                '$today',
                                                                '$today',
                                                                '$status',
                                                                'Deliver',
                                                                '$client_id',
                                                                '$ord_pro_hsn',
                                                                '$ord_pro_cgst',
                                                                '$ord_pro_sgst',
                                                                '$ord_pro_igst',
                                                                '$ord_pro_cess')";

        $run_customer_order = mysqli_query($con,$insert_customer_order);

        $update_stock = "UPDATE products SET product_stock=product_stock-'$pro_qty' WHERE product_id='$pro_id'";

        $run_update_stock = mysqli_query($con,$update_stock);

        $delete_cart = "delete from cart where ip_add='$ip_add' AND user_id='$user_id'";

        $run_delete = mysqli_query($con,$delete_cart);


    }

}

if($run_customer_order){

    $get_dis_total = "select sum(due_amount) as dis_total from customer_orders WHERE invoice_no='$invoice_no'";
    $run_dis_total = mysqli_query($con,$get_dis_total);
    $row_dis_total = mysqli_fetch_array($run_dis_total);

    $dis_total = $row_dis_total['dis_total'];

    $get_user_order_count = "SELECT customer_id,invoice_no FROM customer_orders WHERE customer_id='$customer_id' GROUP BY customer_id,invoice_no";
    $run_user_orders_count = mysqli_query($con,$get_user_order_count);
    $user_orders_count = mysqli_num_rows($run_user_orders_count);

    if($user_orders_count==1 && $dis_total>300){
     $insert_discount = "insert into customer_discounts (invoice_no,discount_type,discount_amount,discount_date) values ('$invoice_no','First Order Discount','25','$today')";
     $run_insert_discount = mysqli_query($con,$insert_discount);
    }
    
}

if($run_customer_order){
    
    $get_del_total = "select sum(due_amount) as del_total from customer_orders WHERE invoice_no='$invoice_no'";
    $run_del_total = mysqli_query($con,$get_del_total);
    $row_del_total = mysqli_fetch_array($run_del_total);

    $del_total = $row_del_total['del_total'];

    $get_del_charges = "select * from admins";
    $run_del_charges = mysqli_query($con,$get_del_charges);
    $row_del_charges = mysqli_fetch_array($run_del_charges);

    $del_charges = $row_del_charges['del_charges'];

    if($del_total<300){
        $insert_del_charges = "insert into order_charges (invoice_id,del_charges,updated_date) values ('$invoice_no','$del_charges','$today')";
        $run_insert_del_charges = mysqli_query($con,$insert_del_charges);
    }
}

if($run_customer_order){

    $insert_call = "insert into cron_call (invoice_no,cron_call_status,updated_date) values ('$invoice_no','false','$today')";
    $run_insert_call = mysqli_query($con,$insert_call);     
}

if($run_customer_order){

    $invoice_no = $invoice_no;

    // $text = "Thank%20You,%20Your%20Order%20is%20Placed%20Successfully,%20click%20here%20to%20View%20Details%20:-%20http://www.wernear.in/customer/order_view?invoice_no=$invoice_no";

    // //echo $url = "https://smsapi.engineeringtgr.com/send/?Mobile=9636286923&Password=DEZIRE&Message=".$m."&To=".$tel."&Key=parasnovxRI8SYDOwf5lbzkZc6LC0h"; 
    // $url = "http://api.bulksmsplans.com/api/SendSMS?api_id=API31873059460&api_password=W3cy615F&sms_type=T&encoding=T&sender_id=VRNEAR&phonenumber=91$c_contact&textmessage=$text";
    // // Initialize a CURL session. 
    // $ch = curl_init();  
    
    // // Return Page contents. 
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    
    // //grab URL and pass it to the variable. 
    // curl_setopt($ch, CURLOPT_URL, $url); 
    
    // $result = curl_exec($ch);

    include('paytm/TxnTest.php');

}else{

    echo "<script>alert('Order Failed')</script>";

    echo "<script>window.history.go(-2)</script>";

}

?>

