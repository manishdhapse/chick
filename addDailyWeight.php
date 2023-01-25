<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId === '1') { 
$allvendor = $vendor->selectAllVendorData();
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
   $userid = $_POST['ven_id'];
  $getUinfo = $vendor->getVendorInfoById($userid);

  
  $_POST['vendor_name'] =$getUinfo->name;
  $userAdd = $weight->addNewWeightByAdmin($_POST);
      $URL="daily_weight_list.php";
     echo "<script>location.href='$URL'</script>";
}

if (isset($userAdd)) {
  echo $userAdd;
}


if (isset($_GET['id'])) {
  $userid = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);

    $getUinfo = $weight->getWeightInfoById($userid);
    
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $weight->updateWeightByIdInfo($userid, $_POST);

}
if (isset($updateUser)) {
  echo $updateUser;
}
 ?>

 <div class="card ">
   <div class="card-header">
          <h3 class='text-center'>Add Daily Weight</h3>
        </div>
        <div class="cad-body">



            <div>

            <form class="" action="" method="post">
                <div class="form-group pt-3">
                  <label for="name">Vendor name</label>
                  <select id="inputState" class="form-control" name="ven_id">
                    <option >Choose...</option>
                  <?php 
                   foreach ($allvendor as $key => $value) {                    
                     ?>
                    

        
        <option  <?php if(@$getUinfo->ven_id == @$value->id){ echo "selected='selected'"; }?> value="<?php  echo $value->id; ?>"><?php  echo $value->name; ?></option>

        <?php
                   }

                  ?>
      </select>


                </div>
                <div class="form-group">
                  <label for="username"> Date</label>
                  <input type="date" name="pr_date"  class="form-control" value="<?php echo @$getUinfo->pr_date; ?>">
                </div>
                                <div class="form-group">
                  <label for="mobile">Weight</label>
                  <input type="text" id="weight" name="weight"  class="form-control" value="<?php echo @$getUinfo->weight; ?>">
                </div>
                <div class="form-group">
                  <label for="mobile">Rate</label>
                  <input type="text" id="rate" name="rate"  class="form-control" value="<?php echo @$getUinfo->rate; ?>">
                </div>
                <div class="form-group">
                  <label for="mobile">Total Price</label>
                  <input type="text" id="price" name="price"  class="form-control" value="<?php echo @$getUinfo->price; ?>" readonly>
                </div>
                    <div class="form-group">
                  <label for="mobile">Remark</label>
                  <input type="text" name="remark"  class="form-control" value="<?php echo @$getUinfo->remark; ?>">
                </div>
                
                <div class="form-group">
                  <?php  if (isset($_GET['id'])) {?>
                    <button type="submit" name="update" class="btn btn-success">Update Vendor</button>
                  <?php }else { ?>
                  <button type="submit" name="add" class="btn btn-success">Add Weight</button>
                <?php } ?>
                </div>


            </form>
          </div>


        </div>
      </div>

<?php
}else{

  header('Location:index.php');



}
 ?>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
  $('#weight, #rate').change(function(){
    var rate = parseFloat($('#rate').val()) || 0;
    var weight = parseFloat($('#weight').val()) || 0;

    $('#price').val(rate * weight);    
});
</script>
  <?php
  include 'inc/footer.php';

  ?>
