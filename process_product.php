<?php 

session_start();

include("includes/db.php");
require("functions/function.php");

?>

<?php 

if(isset($_POST['add_id'])){
        
    //$ip_add = getRealIpUser();

    $user_id = getuserid();
    
    $p_id = $_POST['add_id'];
    
    //$store_id = $_POST['store_id'];

    $get_stock = "select * from products where product_id='$p_id'";

    $run_stock = mysqli_query($con,$get_stock);

    $row_stock = mysqli_fetch_array($run_stock);

    $stock = $row_stock['product_stock'];

    $p_name = $row_stock['product_title'];
    
    $check_product = "select * from cart where user_id='$user_id' AND p_id='$p_id'";
    
    $run_check = mysqli_query($con,$check_product);

    $row_check = mysqli_fetch_array($run_check);

    $p_qty = $row_check['qty'];

    if($p_qty>=$stock){

        echo "alert('Your Requested stock is not available');";

    }else{

            if(mysqli_num_rows($run_check)>0){
                
                $update_qty= "update cart set qty=qty+1 where p_id='$p_id' AND user_id='$user_id'";

                $run_update_qty = mysqli_query($con,$update_qty);
            
        }else{
            
                $query = "insert into cart (p_id,user_id,qty,exp_date) values ('$p_id','$user_id','1',NOW())";
                
                $run_query = mysqli_query($con,$query);
                
            
        }
        echo "location.reload(false);";

    }
    
}

if(isset($_POST['del_id'])){

    //$ip_add = getRealIpUser();

    $user_id = getuserid();

    $p_id = $_POST['del_id'];

    //$store_id = $_GET['store_id'];

    $check_cart = "select * from cart where user_id='$user_id' AND p_id='$p_id'";
    
    $run_check = mysqli_query($con,$check_cart);

    $row_check = mysqli_fetch_array($run_check);

    $qty = $row_check['qty'];

    if($qty>1){

        $update_qty= "update cart set qty=qty-1 where p_id='$p_id' AND user_id='$user_id'";

        $run_update_qty = mysqli_query($con,$update_qty);

        echo "done";

    }else{

        $delete_qty= "delete from cart where p_id='$p_id' AND user_id='$user_id'";

        $run_delete_qty = mysqli_query($db,$delete_qty);

        //echo "<script>window.open('shop?store_id=$store_id','_self')</script>";

    }
}

if(isset($_POST['fmr_code_input'])){
    $fmr_code = strtoupper($_POST['fmr_code_input']);

    $get_check_fmr = "select * from fmr_users where fmr_unique_code='$fmr_code'";
    $run_check_fmr = mysqli_query($con,$get_check_fmr);
    $check_fmr = mysqli_num_rows($run_check_fmr);

    if($check_fmr===1){
        echo 1;
    }else{
        echo 2;
    }
}

if(isset($_POST['c_contact'])){

   $c_contact = $_POST['c_contact'];

   $get_contact = "select * from customers where customer_contact='$c_contact'";
   $run_contact = mysqli_query($con,$get_contact);
   $count = mysqli_num_rows($run_contact);

   if($count<1){
        echo 1;
   }else{
       echo 2;
   }
}

?>