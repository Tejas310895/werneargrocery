
<?php 
    
    if(!isset($_SESSION['admin_email'])){
        
        echo "<script>window.open('login.php','_self')</script>";
        
    }else{

?>

<div class="row">
           <div class="col-lg-6 col-md-6">
           <h2 class="card-title">PAYMENT DETAILS</h2>
           </div>
           <div class="col-lg-6 col-md-6">
                <a href="index.php?raise_notes" class="btn btn-primary pull-right">Raise CR/DR</a>
            </div>
       </div>

<div class="row">
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead class="text-center">
        <tr>
            <th>DATE</th>
            <th>CLIENT NAME</th>
            <th>AMOUNT</th>
            <th>TYPE</th>
            <th>COMMENT</th>
        </tr>
    </thead>
    <tbody class="text-center" style="font-size:12px;">
            <?php
            
            $get_ledger = "select * from client_ledger order by updated_date DESC";

            $run_ledger = mysqli_query($con,$get_ledger);

            while($row_ledger=mysqli_fetch_array($run_ledger)){

                $client_id = $row_ledger['client_id'];
                $amount = $row_ledger['amount'];
                $amt_type = $row_ledger['amt_type'];
                $ledger_comment = $row_ledger['ledger_comment'];
                $updated_date = $row_ledger['updated_date'];

                $get_client = "select * from clients where client_id='$client_id'";
                $run_client = mysqli_query($con,$get_client);
                $row_client = mysqli_fetch_array($run_client);

                $client_name = $row_client['client_name'];
            
            ?>
        <tr>
            <td><?php echo date('d/M/Y(h:i a)',strtotime($updated_date)); ?></td>
            <td><?php echo $client_name; ?></td>
            <td><?php echo $amount; ?></td>
            <td><?php echo $amt_type; ?></td>
            <td><?php echo $ledger_comment; ?></td>
        </tr>
            <?php } ?>
    </tbody>
</table>
</div>

<script src='https://code.jquery.com/jquery-1.12.4.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.js'></script>
<script src='https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js' defer></script>
<script src='https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.js' defer></script>
<script src='https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.js' defer></script>
<script src='https://cdn.datatables.net/buttons/1.5.1/js/buttons.bootstrap.js' defer></script>
<script src='https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.js' defer></script>
<script  src='js/datatable.js'></script>

<?php } ?>