<?php 
    
    if(!isset($_SESSION['admin_email'])){
        
        echo "<script>window.open('login.php','_self')</script>";
        
    }else{

?>

<div class="row">
           <div class="col-lg-6 col-md-6">
           <h2 class="card-title">INSERT SLIDE</h2>
           </div>
           <div class="col-lg-6 col-md-6">
            <a href="index.php?view_slides" class="btn btn-primary pull-right">Back</a>
           </div>
       </div>
                <form action="" class="form-horizontal" method="post" enctype="multipart/form-data" ><!-- form-horizontal begin -->
                <div class="row mt-5"><!-- row 2 begin -->
                    <div class="col-lg-6">
                        <div class="form-group"><!-- form-group begin -->
                            
                                <input name="slide_name" type="text" placeholder="Slide Name" class="form-control">
                            
                        
                        </div><!-- form-group finish -->
                    </div>
                    <div class="col-lg-6">
                            <div class="form-group">
                                <!-- <label>Choose Slide Image</label> -->
                                <input type="text" name="slide_image" class="form-control" placeholder="Slide image link" required>
                            </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                                <!-- <label class="custom-file-label"  for="inputGroupFile01">Choose Slide Image</label> -->
                                <input type="text" name="slide_url" class="form-control" placeholder="Slide url" required>
                            </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                          <select class="form-control" name="image_type">
                            <option value="head_slide">head_slide</option>
                            <option value="promo_images">promo_images</option>
                            <option value="foot_slide">foot_slide</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-group"><!-- form-group begin -->
                                            
                        <div class="col-lg-12"><!-- col-md-6 begin -->
                        
                            <input value="Submit" name="submit" type="submit" class="form-control btn btn-primary">
                        
                        </div><!-- col-md-6 finish -->
                    
                    </div><!-- form-group finish -->
            </div><!-- row 2 finish -->
    </form><!-- form-horizontal finish -->

<?php  

    if(isset($_POST['submit'])){
        
        $slide_name = $_POST['slide_name'];
        
        $slide_image = $_POST['slide_image'];

        $slide_url = $_POST['slide_url'];

        $image_type = $_POST['image_type'];
        
        //$temp_name = $_FILES['slide_image']['tmp_name'];
        
        $view_slides = "select * from slider";
        
        $view_run_slide = mysqli_query($con,$view_slides);
        
        $count = mysqli_num_rows($view_run_slide);
            
        //move_uploaded_file($temp_name,"slides_images/$slide_image");
        
        $insert_slide = "insert into slider (slide_name,slide_image,slide_url,image_type) values ('$slide_name','$slide_image','$slide_url','$image_type')";
        
        $run_slide = mysqli_query($con,$insert_slide);
        
        echo "<script>alert('Your new slide image has been inserted')</script>";
        
        echo "<script>window.open('index.php?view_slides','_self')</script>";
        
        echo "<script>alert('You have already inserted 4 slides')</script>"; 
            
    }

?>

<?php } ?>