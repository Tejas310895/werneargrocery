<?php

include ("../includes/db.php");

if(isset($_GET['payment_link'])){

    $invoice_no = $_GET['payment_link'];

    $get_order_det = "select * from customer_orders where invoice_no='$invoice_no'";
    $run_order_det = mysqli_query($con,$get_order_det);
    $row_order_det = mysqli_fetch_array($run_order_det);

    $customer_id = $row_order_det['customer_id'];

    $get_customer = "select * from customers where customer_id='$customer_id'";
    $run_customer = mysqli_query($con,$get_customer);
    $row_customer = mysqli_fetch_array($run_customer);

    $customer_name = $row_customer['customer_name'];
    $customer_contact = $row_customer['customer_contact'];
    $customer_email = $row_customer['customer_email'];

    $get_order_total = "select sum(due_amount) as order_total from customer_orders where invoice_no='$invoice_no' and product_status='Deliver'";
    $run_order_total = mysqli_query($con,$get_order_total);
    $row_order_total = mysqli_fetch_array($run_order_total);

    $order_total = $row_order_total['order_total'];

    $get_charge_total = "select sum(del_charges) as charge_total from order_charges where invoice_id='$invoice_no'";
    $run_charge_total = mysqli_query($con,$get_charge_total);
    $row_charge_total = mysqli_fetch_array($run_charge_total);

    $charge_total = $row_charge_total['charge_total'];

    $get_cust_dis = "select sum(discount_amount) as cust_dis from customer_discounts where invoice_no='$invoice_no'";
    $run_cust_dis = mysqli_query($con,$get_cust_dis);
    $row_cust_dis = mysqli_fetch_array($run_cust_dis);

    $cust_dis = $row_cust_dis['cust_dis'];

    $order_amount = ($order_total+$charge_total)-$cust_dis;


/*
* import checksum generation utility
* You can get this utility from https://developer.paytm.com/docs/checksum/
*/
require_once("paytmchecksum/PaytmChecksum.php");

$paytmParams = array();

$customerContact = array(
    "customerName" => $customer_name,
    "customerEmail" => $customer_email,
    "customerMobile" => $customer_contact,
);

$paytmParams["body"] = array(
    "mid"                => "UAjOdK93391343818433",
    "linkType"           => "FIXED",
    "linkDescription"    => "Order Payment ".$invoice_no,
    "linkName"           => "WERNEAR",
    "amount"             => $order_amount,
    // "statusCallbackUrl"  => "http://localhost/wrngroceries/admin_area",
    "maxPaymentsAllowed" => 1,
    "sendSms"            => true,
    "sendEmail"            => true,
    "customerContact"    => $customerContact,
    // "expiryDate"         => true,
    "invoiceId"          => $invoice_no,
);

/*
* Generate checksum by parameters we have in body
* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
*/
$checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "mXbkaNeIvRyzRX29");

$paytmParams["head"] = array(
    "tokenType"	      => "AES",
    "signature"	      => $checksum
);

$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

/* for Staging */
// $url = "https://securegw-stage.paytm.in/link/create";

/* for Production */
$url = "https://securegw.paytm.in/link/create";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
$response = curl_exec($ch);
print_r ($response);
$result = json_decode($response, true);

// echo $result['body']['resultInfo']['resultStatus']."</br>";
// echo $result['body']['shortUrl'];

// if($result['body']['resultInfo']['resultStatus']==="SUCCESS"){
//     echo "<script>alert('Link sent to customer')</script>";
//     echo "<script>window.open('../index.php?view_orders','_self')</script>";
// }else{
//     echo "<script>alert('Sending link failed')</script>";
//     echo "<script>window.open('../index.php?view_orders','_self')</script>";
// }
}
?>
