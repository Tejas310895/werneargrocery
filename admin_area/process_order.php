<?php 

include("includes/db.php");

if(isset($_GET['update_order'])){

  $update_order = $_GET['update_order'];

  $status = $_GET['status'];

  $update_status_del = "UPDATE customer_orders SET order_status='$status' WHERE invoice_no='$update_order'";

  $run_status_del = mysqli_query($con,$update_status_del);


    echo "<script>alert('Status Updated')</script>";

    echo "<script>window.open('index.php?view_orders','_self')</script>";


}

if(isset($_GET['cancel_order'])){

    $update_order = $_GET['cancel_order'];

    $get_id = "select * from customer_orders where invoice_no='$update_order'";

    $run_id = mysqli_query($con,$get_id);

    $row_id = mysqli_fetch_array($run_id);

    $c_id = $row_id['customer_id'];

    $get_contact = "select * from customers where customer_id='$c_id'";

    $run_contact = mysqli_query($con,$get_contact);

    $row_contact = mysqli_fetch_array($run_contact);

    $c_contact = $row_contact['customer_contact'];
  
    $update_status_del = "UPDATE customer_orders SET order_status='Cancelled',product_status='Undeliver' WHERE invoice_no='$update_order'";
  
    $run_status_del = mysqli_query($con,$update_status_del);
  
  
      echo "<script>alert('Order Cancelled')</script>";
  
      echo "<script>window.open('index.php?view_orders','_self')</script>";

      $text = "Your%20Order%20with%20Order%20Id%20$update_order%20is%20been%20Cancelled%20Call%209867765397%20For%20Support";

      //echo $url = "https://smsapi.engineeringtgr.com/send/?Mobile=9636286923&Password=DEZIRE&Message=".$m."&To=".$tel."&Key=parasnovxRI8SYDOwf5lbzkZc6LC0h"; 
     $url = "http://api.bulksmsplans.com/api/SendSMS?api_id=API31873059460&api_password=W3cy615F&sms_type=T&encoding=T&sender_id=VRNEAR&phonenumber=91$c_contact&textmessage=$text";
     // Initialize a CURL session. 
     $ch = curl_init();  
     
     // Return Page contents. 
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
     
     //grab URL and pass it to the variable. 
     curl_setopt($ch, CURLOPT_URL, $url); 
     
     $result = curl_exec($ch);   
  
  }

  if(isset($_GET['update_stock'])){

    $pro_id = $_GET['update_stock'];

    $stock = $_POST['stock'];
  
    $update_stock = "UPDATE products SET product_stock='$stock' WHERE product_id='$pro_id'";
  
    $run_update_stock = mysqli_query($con,$update_stock);
  
  
      echo "<script>alert('Stock Updated')</script>";
  
      echo "<script>window.open('index.php?view_products','_self')</script>";
  
  
  }

  if(isset($_POST['add_city'])){

    $city_name = $_POST['city_name'];
  
    $insert_city = "insert into city (city_name) values ('$city_name')";
  
    $run_insert_city = mysqli_query($con,$insert_city);
  
  
      echo "<script>alert('City Added')</script>";
  
      echo "<script>window.open('index.php?view_area','_self')</script>";
  
  
  }

  if(isset($_POST['add_area'])){

    $city_id = $_POST['city_id'];

    $area_name = $_POST['area_name'];
  
    $insert_area = "insert into area (area_name,city_id) values ('$area_name','$city_id')";
  
    $run_insert_area = mysqli_query($con,$insert_area);
  
  
      echo "<script>alert('Area Added')</script>";
  
      echo "<script>window.open('index.php?view_area','_self')</script>";
  
  
  }

  if(isset($_POST['add_landmark'])){

    $area_id = $_POST['area_id'];

    $landmark_name = $_POST['landmark_name'];
  
    $insert_landmark = "insert into landmark (landmark_name,area_id) values ('$landmark_name','$area_id')";
  
    $run_insert_landmark = mysqli_query($con,$insert_landmark);
  
  
      echo "<script>alert('Landmark Added')</script>";
  
      echo "<script>window.open('index.php?view_area','_self')</script>";
  
  
  }

  if(isset($_GET['update_pos'])){

    $pro_id = $_GET['update_pos'];

    $position = $_POST['position'];

    $check_count = "SELECT * FROM products where store_id=(SELECT store_id FROM products WHERE product_id='$pro_id')";

    $run_check_count = mysqli_query($con,$check_count);

    $count = mysqli_num_rows($run_check_count);

    // $row_check_count = mysqli_fetch_array($run_check_count);

    // $store_id = $row_check_count['store_id'];


    if($position<=$count){

      $update_position = "UPDATE products SET product_position='$position' WHERE product_id='$pro_id'";

      $run_update_position = mysqli_query($con,$update_position);
  
      echo "<script>alert('Position Updated')</script>";
  
      echo "<script>window.open('index.php?view_products','_self')</script>";

    }else{

      echo "<script>alert('Products less then position number')</script>";
  
      echo "<script>window.open('index.php?view_products','_self')</script>";
    }

  
  
  }


  if(isset($_GET['Y'])){

    $pro_id = $_GET['Y'];

    $update_visibility = "UPDATE products SET product_visibility='Y' WHERE product_id='$pro_id'";
  
    $run_update_visibility = mysqli_query($con,$update_visibility);
  
  
      echo "<script>alert('Product Visible')</script>";
  
      echo "<script>window.open('index.php?view_products','_self')</script>";
  
  
  }

  if(isset($_GET['N'])){

    $pro_id = $_GET['N'];

    $update_visibility = "UPDATE products SET product_visibility='N' WHERE product_id='$pro_id'";
  
    $run_update_visibility = mysqli_query($con,$update_visibility);
  
  
      echo "<script>alert('Product Visible')</script>";
  
      echo "<script>window.open('index.php?view_products','_self')</script>";
  
  
  }

  if(isset($_GET['undeliver_order'])){

    $invoice_id = $_GET['undeliver_order'];

    $pro_id = $_GET['undelpro_id'];

    $update_undel = "update customer_orders set product_status='Undeliver' where invoice_no='$invoice_id' and pro_id='$pro_id'";

    $run_update_undel = mysqli_query($con,$update_undel);

    if($run_update_undel){
  
      echo "<script>alert('Order Updated')</script>";
  
      echo "<script>window.open('index.php?confirm_order=$invoice_id','_self')</script>";

    }else{

      echo "<script>alert('Try Again')</script>";
  
      echo "<script>window.open('index.php?confirm_order=$invoice_id','_self')</script>";


    }
  
  
  }

  if(isset($_GET['deliver_order'])){

    $invoice_id = $_GET['deliver_order'];

    $pro_id = $_GET['delpro_id'];

    $update_del = "update customer_orders set product_status='Deliver' where invoice_no='$invoice_id' and pro_id='$pro_id'";

    $run_update_del = mysqli_query($con,$update_del);

    if($run_update_del){
  
      echo "<script>alert('Order Updated')</script>";
  
      echo "<script>window.open('index.php?confirm_order=$invoice_id','_self')</script>";

    }else{

      echo "<script>alert('Try Again')</script>";
  
      echo "<script>window.open('index.php?confirm_order=$invoice_id','_self')</script>";


    }
  
  
  }


?>