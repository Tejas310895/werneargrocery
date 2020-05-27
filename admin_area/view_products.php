<?php

    if(!isset($_SESSION['admin_email'])){

        echo "<script>window.open('login.php','_self')</script>";

    }else{

        ?>

        <div class="row"><!-- row 1 Begins -->
            <div class="col-lg-12"><!-- col-lg-12 Begins -->
                <ol class="breadcrumb"><!-- breadcrumb Begins -->
                    <li class="active">
                    
                        <i class="fa fa-dashboard"></i> Dashboard / View Products
                    
                    </li>
                </ol><!-- breadcrumb ends -->
            </div><!-- col-lg-12 ends -->
        </div><!-- row 1 ends -->

        <div class="row col-lg-12"><!-- row 2 begins -->
            <div class="panel panel-default"><!-- panel panel-default begins -->
                <div class="panel-heading"><!-- panel-heading begins -->
                    <h3 class="panel-title"><!-- panel-title begins -->
                    
                        <i class="fa fa-tags"></i> Veiw Products
                    
                    </h3><!-- panel-title ends -->
                </div><!-- panel-heading ends -->

                    <div class="panel-body"><!-- panel-body begins -->
                        <div class="table-responsive"><!-- table-responsive begins -->
                            <table class="table table-striped table-borderd table-hover"><!-- table table-striped table-borderd table-hover begins -->
                            
                                <thead><!-- thead begins -->
                                    <tr><!-- tr begins -->
                                        <th> Product ID: </th>
                                        <th>Product Title: </th>
                                        <th> Product Image: </th>
                                        <th> Product Price: </th>
                                        <th> Product Sold: </th>
                                        <th> Product Keywords</th>
                                        <th> Product Date: </th>
                                        <th> Product Delete: </th>
                                        <th> Product Edit: </th>
                                    </tr><!-- tr ends -->
                                </thead><!-- thead ends -->

                                <tbody><!-- tbody begins -->
                                
                                    <?php
                                    
                                        $i=0;
                                    
                                        $get_pro = "select * from products";

                                        $run_pro = mysqli_query($con,$get_pro);

                                        while($row_pro=mysqli_fetch_array($run_pro)){

                                            $pro_id = $row_pro['product_id'];

                                            $pro_title = $row_pro['product_title'];

                                            $pro_img1 = $row_pro['product_img1'];

                                            $pro_price = $row_pro['product_price'];

                                            $pro_keywords = $row_pro['product_keywords'];

                                            $pro_date = $row_pro['date'];

                                            $i++;

                                    
                                    ?>

                                    <tr><!-- tr begins -->
                                        <td> <?php echo $i; ?> </td>
                                        <td> <?php echo $pro_title; ?> </td>
                                        <td> <img src="product_images/<?php echo $pro_img1; ?>" width="60" height="60"> </td>
                                        <td> $ <?php echo $pro_price; ?> </td>
                                        <td> 
                                        
                                        <?php 
                                        
                                                $get_sold = "select * from pending_orders where product_id='$pro_id'";

                                                $run_sold = mysqli_query($con,$get_sold);

                                                $count = mysqli_num_rows($run_sold);

                                                echo $count;
                                        
                                        ?> 
                                        
                                        </td>
                                        <td> <?php echo $pro_keywords; ?> </td>
                                        <td> <?php echo $pro_date; ?> </td>
                                        <td> 
                                            <a class="btn btn-danger" href="index.php?delete_product=<?php echo $pro_id; ?>">
                                        
                                                <i class="fa fa-trash-o"></i> Delete
                                        
                                            </a> 
                                        </td>
                                        <td>
                                        
                                            <a class="btn btn-success" href="index.php?edit_product=<?php echo $pro_id; ?>">
                                            
                                                <i class="fa fa-pencil"></i> Edit
                                    
                                            </a> 
                                        
                                        </td>
                                    </tr><!-- tr ends -->

                                    <?php  } ?>
                                
                                </tbody><!-- tbody ends -->
                            
                            </table><!-- table table-striped table-borderd table-hover ends -->
                        </div><!-- table-responsive ends -->
                    </div><!-- panel-body ends -->

            </div><!-- panel panel-default ends -->
        </div><!-- row 2 ends -->

    <?php } ?>