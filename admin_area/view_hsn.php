<?php 
    
    if(!isset($_SESSION['admin_email'])){
        
        echo "<script>window.open('login.php','_self')</script>";
        
    }else{

?>

    <div class="row">
           <div class="col-lg-6 col-md-6">
           <h2 class="card-title">TAX HSN CODE LIBRARY</h2>
           </div>
           <div class="col-lg-6 col-md-6">
            <a href="index.php?insert_hsn" class="btn btn-primary pull-right">Add New</a>
           </div>
       </div>
       <div class="row">
       <div class="col-lg-12 col-md-12">
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr class="text-center">
                    <th>Sl.No</th>
                    <th>HSN CODE</th>
                    <th>Description</th> 
                    <th>CGST%</th>
                    <th>SGST%</th>
                    <th>IGST%</th>
                    <th>CESS%</th>
                    <th class="text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php 
                
                    $get_hsn = "select * from taxes";
        
                    $run_hsn = mysqli_query($con,$get_hsn);
                    
                    $counter=0;

                    while($run_hsn_section=mysqli_fetch_array($run_hsn)){
                        
                        $tax_id = $run_hsn_section['tax_id'];

                        $hsn_code = $run_hsn_section['hsn_code'];

                        $cgst = $run_hsn_section['cgst'];

                        $sgst = $run_hsn_section['sgst'];

                        $igst = $run_hsn_section['igst'];

                        $cess = $run_hsn_section['cess'];
                        
                        $tax_for = substr($run_hsn_section['tax_for'],0,100);
                
                ?>
                <tr>
                <td ><?php echo ++$counter; ?></td>
                <td ><?php echo $hsn_code; ?></td>
                <td ><?php echo $tax_for; ?></td>
                <td ><?php echo $cgst; ?></td>
                <td ><?php echo $sgst; ?></td>
                <td ><?php echo $igst; ?></td>
                <td ><?php echo $cess; ?></td>
                <td class="td-actions text-center">
                        <a  href="index.php?edit_hsn=<?php echo $tax_id; ?>" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                            <i class="tim-icons icon-settings"></i>
                        </a>
                        <a href="index.php?delete_hsn=<?php echo $tax_id; ?>" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                            <i class="tim-icons icon-simple-remove"></i>
                        </a>
                    </td>
                    </tr>
                <?php } ?>
            
                </tbody>
        </table>
       </div>
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