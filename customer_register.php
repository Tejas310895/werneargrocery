<?php 

    include("includes/header.php");

?>

<!-- fixed nav -->
    <div class="container-fuild fixed-top">
            <!-- nav -->
                <ul class="nav bg-white cartloc ">
                    <li class="nav-item">
                        <a class="nav-link" href="./">
                            <i style="font-size: 1.8rem;" class="fas fa-arrow-left"></i>
                        </a>
                    </li>
                    <li class="nav-item pt-1">
                        <h5 class="cart_head">Register</h5>
                    </li>
                </ul>
            <!-- nav -->

    <!-- breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb pt-1">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item active" aria-current="page">Register</li>
            </ol>
        </nav>
    <!-- breadcrumb -->

    </div>
<!-- fixed nav -->

<!-- register form -->
    <div class="container">
        <form action="customer_register.php" method="post" enctype="multipart/form-data" class="register_form">
        <div class="form-group ">
            <label>Full Name</label>
            <input type="text" class="form-control" id="name" name="c_name" aria-describedby="emailHelp" placeholder="Enter Name" required>
        </div>
        <div class="form-group">
            <label>Mobile No.</label>
            <input type="text" class="form-control" id="name" name="c_contact" aria-describedby="emailHelp" placeholder="Enter Number" required>
        </div>
        <div class="form-group">
            <label>Email address</label>
            <input type="email" class="form-control" id="email" name="c_email" aria-describedby="emailHelp" placeholder="Enter email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" id="pass" name="c_pass" placeholder="Password" required>
        </div>
        <button type="submit" name="register" class="btn btn-success btn-lg btn-block text-center">Register</button>
        </form>
    </div>
<!-- register form -->

<?php 

include("includes/footer.php");

?>

<?php 

if(isset($_POST['register'])){

    $c_name = $_POST['c_name'];

    $c_contact = $_POST['c_contact'];

    $c_email = $_POST['c_email'];

    $c_pass = $_POST['c_pass'];

    $c_ip = getRealIpUser();

    move_uploaded_file($c_image_tmp,"customer/customer_images/$c_image");

    $insert_customer = "insert into customers (customer_name,customer_contact,customer_email,customer_pass,customer_ip) 
    values ('$c_name','$c_contact','$c_email','$c_pass','$c_ip')";

    $run_customer = mysqli_query($con,$insert_customer);

    $sel_cart = "select * from cart where ip_add='$c_ip'";

    $run_cart = mysqli_query($con,$sel_cart);

    $check_cart = mysqli_num_rows($run_cart);

    if($check_cart>0){

        //if customer register with items in cart//

        $_SESSION['customer_email']=$c_email;

        echo "<script>alert('You have Registered Sucessfully')</script>";

        echo "<script>window.open('checkout.php','_self')</script>";

    }else{

        //if customer register without items in cart//

        $_SESSION['customer_email']=$c_email;

        echo "<script>alert('You have Registered Sucessfully')</script>";

        echo "<script>window.open('index.php','_self')</script>";

    }
    

}

?>