<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");
include("../includes/db.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if($isValidChecksum == "TRUE") {
	//echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
			$CURRENCY = $_POST['CURRENCY'];
			$GATEWAYNAME = $_POST['GATEWAYNAME'];
			$RESPMSG = $_POST['RESPMSG'];
			// $BANKNAME = $_POST['BANKNAME'];
			$PAYMENTMODE = $_POST['PAYMENTMODE'];
			$MID = $_POST['MID'];
			$RESPCODE = $_POST['RESPCODE'];
			$TXNID = $_POST['TXNID'];
			$TXNAMOUNT = $_POST['TXNAMOUNT'];
			$ORDERID = $_POST['ORDERID'];
			$STATUS = $_POST['STATUS'];
			$BANKTXNID = $_POST['BANKTXNID'];
			$TXNDATE = $_POST['TXNDATE'];
			$CHECKSUMHASH = $_POST['CHECKSUMHASH'];

			$insert_customer_order = "insert into paytm (CURRENCY,GATEWAYNAME,RESPMSG,BANKNAME,PAYMENTMODE,MID,RESPCODE,TXNID,TXNAMOUNT,ORDERID,STATUS,BANKTXNID,TXNDATE,CHECKSUMHASH) 
			values ('$CURRENCY','$GATEWAYNAME','$RESPMSG','null','$PAYMENTMODE','$MID','$RESPCODE','$TXNID','$TXNAMOUNT','$ORDERID','$STATUS','$BANKTXNID','$TXNDATE','$CHECKSUMHASH')";

				$get_customer = "select * from customer_orders where invoice_no='$ORDERID'";

				$run_customer = mysqli_query($con,$get_customer);

				$row_customer = mysqli_fetch_array($run_customer);

				$customer_id = $row_customer['customer_id'];

				$get_contact = "select * from customers where customer_id='$customer_id'";

				$run_contact = mysqli_query($con,$get_contact);

				$row_contact = mysqli_fetch_array($run_contact);

				$c_contact = $row_contact['customer_contact'];

				if($run_insert = mysqli_query($con,$insert_customer_order)){

				//$text = "Thank%20You,%20Your%20Order%20is%20Placed%20Successfully,%20click%20here%20to%20View%20Details%20:-%20http://www.wernear.in/customer/order_view?invoice_no=$invoice_no";

				$text1d = "Thank%20You,%20Your%20Order%20is%20Placed%20Successfully,%0APayment%20Successful%20of%20-%20$TXNAMOUNT%20Call%209019196792%20For%20Support";
				$text2d = "Prepaid%20Order%20Received-https://www.wernear.in/admin_area/print.php?print=$ORDERID";
				//echo $url = "https://smsapi.engineeringtgr.com/send/?Mobile=9636286923&Password=DEZIRE&Message=".$m."&To=".$tel."&Key=parasnovxRI8SYDOwf5lbzkZc6LC0h"; 
				// $url1d = "http://api.bulksmsplans.com/api/SendSMS?api_id=APIMerR2yHK34854&api_password=wernear_11&sms_type=T&encoding=T&sender_id=VRNEAR&phonenumber=91$c_contact&textmessage=$text1d";
				// $url2d = "http://api.bulksmsplans.com/api/SendSMS?api_id=APIMerR2yHK34854&api_password=wernear_11&sms_type=T&encoding=T&sender_id=VRNEAR&phonenumber=919867765397&textmessage=$text2d";
				$url1d = "http://www.bulksmsplans.com/api/send_sms_multi?api_id=APIMerR2yHK34854&api_password=wernear_11&sms_type=Transactional&sms_encoding=text&sender=VRNEAR&message=$text1d&number=+91$c_contact";
				$url2d = "http://www.bulksmsplans.com/api/send_sms_multi?api_id=APIMerR2yHK34854&api_password=wernear_11&sms_type=Transactional&sms_encoding=text&sender=VRNEAR&message=$text2d&number=+919867765397";
							
				// create both cURL resources
				$ch1 = curl_init();
				$ch2 = curl_init();

				// set URL and other appropriate options
				curl_setopt($ch1, CURLOPT_URL, $url1d);
				curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch2, CURLOPT_URL, $url2d);
				curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);

				//create the multiple cURL handle
				$mh = curl_multi_init();

				//add the two handles
				curl_multi_add_handle($mh,$ch1);
				curl_multi_add_handle($mh,$ch2);

				//execute the multi handle
				do {
					$status = curl_multi_exec($mh, $active);
					if ($active) {
						curl_multi_select($mh);
					}
				} while ($active && $status == CURLM_OK);

				//close the handles
				curl_multi_remove_handle($mh, $ch1);
				curl_multi_remove_handle($mh, $ch2);
				curl_multi_close($mh);
		
				echo "<script>alert('Payment Successfull')</script>";

				echo "<script>window.open('../customer/pay_success','_self')</script>";
			}
	}
		//Process your transaction here as success transaction.
		//Verify amount & order id received from Payment gateway with your application's order id and amount.

	else {

		$ORDERID = $_POST['ORDERID'];

		$get_customer = "select * from customer_orders where invoice_no='$ORDERID'";

		$run_customer = mysqli_query($con,$get_customer);

		$row_customer = mysqli_fetch_array($run_customer);

		$customer_id = $row_customer['customer_id'];

		$get_contact = "select * from customers where customer_id='$customer_id'";

		$run_contact = mysqli_query($con,$get_contact);

		$row_contact = mysqli_fetch_array($run_contact);

		$c_contact = $row_contact['customer_contact'];


		$text1f = "Thank%20You,%20Your%20Order%20is%20Placed%20Successfully,%0APayment%20Failed%20no%20worries%20pay%20on%20delivery%20Call%209019196792%20For%20Support";
		$text2f = "Payment%20Failed%20Order%20Received-https://www.wernear.in/admin_area/print.php?print=$ORDERID";
        //echo $url = "https://smsapi.engineeringtgr.com/send/?Mobile=9636286923&Password=DEZIRE&Message=".$m."&To=".$tel."&Key=parasnovxRI8SYDOwf5lbzkZc6LC0h"; 
        // $url1f = "http://api.bulksmsplans.com/api/SendSMS?api_id=APIMerR2yHK34854&api_password=wernear_11&sms_type=T&encoding=T&sender_id=VRNEAR&phonenumber=91$c_contact&textmessage=$text1f";
		// $url2f = "http://api.bulksmsplans.com/api/SendSMS?api_id=APIMerR2yHK34854&api_password=wernear_11&sms_type=T&encoding=T&sender_id=VRNEAR&phonenumber=919867765397&textmessage=$text2f";
		$url1f = "http://www.bulksmsplans.com/api/send_sms_multi?api_id=APIMerR2yHK34854&api_password=wernear_11&sms_type=Transactional&sms_encoding=text&sender=VRNEAR&message=$text1f&number=+91$c_contact";
		$url2f = "http://www.bulksmsplans.com/api/send_sms_multi?api_id=APIMerR2yHK34854&api_password=wernear_11&sms_type=Transactional&sms_encoding=text&sender=VRNEAR&message=$text2f&number=+919867765397";
	
        // create both cURL resources
        $ch1 = curl_init();
        $ch2 = curl_init();

        // set URL and other appropriate options
        curl_setopt($ch1, CURLOPT_URL, $url1f);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_URL, $url2f);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);

        //create the multiple cURL handle
        $mh = curl_multi_init();

        //add the two handles
        curl_multi_add_handle($mh,$ch1);
        curl_multi_add_handle($mh,$ch2);

        //execute the multi handle
        do {
            $status = curl_multi_exec($mh, $active);
            if ($active) {
                curl_multi_select($mh);
            }
        } while ($active && $status == CURLM_OK);

        //close the handles
        curl_multi_remove_handle($mh, $ch1);
        curl_multi_remove_handle($mh, $ch2);
        curl_multi_close($mh);

		echo "<script>alert('Payment Failed')</script>";

		echo "<script>window.open('../customer/pay_failed','_self')</script>";
	}

	// if (isset($_POST) && count($_POST)>0 )
	// { 
	// 	foreach($_POST as $paramName => $paramValue) {
	// 			echo "<br/>" . $paramName . " = " . $paramValue;
	// 	}
	// }
	

}
else {

	$ORDERID = $_POST['ORDERID'];

	$get_customer = "select * from customer_orders where invoice_no='$ORDERID'";

	$run_customer = mysqli_query($con,$get_customer);

	$row_customer = mysqli_fetch_array($run_customer);

	$customer_id = $row_customer['customer_id'];

	$get_contact = "select * from customers where customer_id='$customer_id'";

	$run_contact = mysqli_query($con,$get_contact);

	$row_contact = mysqli_fetch_array($run_contact);

	$c_contact = $row_contact['customer_contact'];


	$text1n = "Thank%20You,%20Your%20Order%20is%20Placed%20Successfully,%0APayment%20Failed%20no%20worries%20pay%20on%20delivery%20Call%209019196792%20For%20Support";
	$text2n = "Payment%20Failed%20Order%20Received-https://www.wernear.in/admin_area/print.php?print=$ORDERID";
	//echo $url = "https://smsapi.engineeringtgr.com/send/?Mobile=9636286923&Password=DEZIRE&Message=".$m."&To=".$tel."&Key=parasnovxRI8SYDOwf5lbzkZc6LC0h"; 
	// $url1n = "http://api.bulksmsplans.com/api/SendSMS?api_id=APIMerR2yHK34854&api_password=wernear_11&sms_type=T&encoding=T&sender_id=VRNEAR&phonenumber=91$c_contact&textmessage=$text1n";
	// $url2n = "http://api.bulksmsplans.com/api/SendSMS?api_id=APIMerR2yHK34854&api_password=wernear_11&sms_type=T&encoding=T&sender_id=VRNEAR&phonenumber=919867765397&textmessage=$text2n";
	$url1n = "http://www.bulksmsplans.com/api/send_sms_multi?api_id=APIMerR2yHK34854&api_password=wernear_11&sms_type=Transactional&sms_encoding=text&sender=VRNEAR&message=$text1n&number=+91$c_contact";
	$url2n = "http://www.bulksmsplans.com/api/send_sms_multi?api_id=APIMerR2yHK34854&api_password=wernear_11&sms_type=Transactional&sms_encoding=text&sender=VRNEAR&message=$text2n&number=+919867765397";
	// create both cURL resources
	$ch1 = curl_init();
	$ch2 = curl_init();

	// set URL and other appropriate options
	curl_setopt($ch1, CURLOPT_URL, $url1n);
	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch2, CURLOPT_URL, $url2n);
	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);

	//create the multiple cURL handle
	$mh = curl_multi_init();

	//add the two handles
	curl_multi_add_handle($mh,$ch1);
	curl_multi_add_handle($mh,$ch2);

	//execute the multi handle
	do {
		$status = curl_multi_exec($mh, $active);
		if ($active) {
			curl_multi_select($mh);
		}
	} while ($active && $status == CURLM_OK);

	//close the handles
	curl_multi_remove_handle($mh, $ch1);
	curl_multi_remove_handle($mh, $ch2);
	curl_multi_close($mh);

	echo "<script>alert('Payment failed')</script>";

		echo "<script>window.open('../customer/pay_failed')</script>";
	//Process transaction as suspicious.
}

?>