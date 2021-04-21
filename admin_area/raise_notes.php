<?php 

    if(!isset($_SESSION['admin_email'])){
        
        echo "<script>window.open('login.php','_self')</script>";
        
    }else{

?>    
   <div class="row"><!-- row Begin -->
    
    <div class="col-lg-6 col-md-6">
        <h2 class="card-title">INSERT STAFF</h2>
    </div>
    <div class="col-lg-6 col-md-6">
        <a href="index.php?ledger_notes" class="btn btn-primary pull-right">Back</a>
    </div>
 
</div><!-- row Finish -->

<form method="post">
    <div class="row">
        <div class="col-lg-6 my-3">
            <div class="form-group">
                <label for="exampleFormControlSelect1">Client Name</label>
                <select class="form-control" name="client_id" id="exampleFormControlSelect1">
                <option selected disabled>Select Client</option>
                <?php 
                
                $get_client = "select * from clients";
                $run_client = mysqli_query($con,$get_client);
                while($row_client = mysqli_fetch_array($run_client)){

                    echo "<option value=".$row_client['client_id'].">".$row_client['client_name']."</option>";
                    
                }
                
                ?>
                </select>
            </div>
        </div>
        <div class="col-lg-6 my-3">
            <div class="form-group">
                <label for="exampleFormControlSelect1">Note type</label>
                <select class="form-control" name="amt_type" id="exampleFormControlSelect1">
                <option selected disabled>Select Note</option>
                <option value="debit">DEBIT</option>
                <option value="credit">CREDIT</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6 my-3">
        <label> Amount </label>
        <input type="text" class="form-control" name="amount" placeholder="Enter Products Type">
        </div>
        <div class="col-lg-6 my-3">
        <label> Comment </label>
        <input type="text" class="form-control" name="ledger_comment" placeholder="Enter Products Type">
        </div>
        <div class="col-lg-12 my-3">
        <button type="submit" name="insert" class="btn btn-primary btn-lg btn-block">Add Staff</button>
        </div>
    </div>
</form>



<?php 

if(isset($_POST['insert'])){
    
    $client_id = $_POST['client_id'];
    $amt_type = $_POST['amt_type'];
    $amount = $_POST['amount'];
    $ledger_comment = $_POST['ledger_comment'];

    date_default_timezone_set('Asia/Kolkata');

    $today = date("Y-m-d H:i:s");
    
    $insert_ledger = "insert into client_ledger (client_id,
                                                amount,
                                                amt_type,
                                                ledger_comment,
                                                updated_date) 
                                    values ('$client_id',
                                             '$amount',
                                             '$amt_type',
                                             '$ledger_comment',
                                             '$today')";
    
    $run_ledger = mysqli_query($con,$insert_ledger);
    
    if($run_ledger){
        
        echo "<script>alert('Ledger Updated sucessfully')</script>";
        echo "<script>window.open('index.php?ledger_notes','_self')</script>";       
    }

}

?>


<?php } ?>