<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId === '1') { ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addUser'])) {
  
  $userAdd = $vendor->addNewVendorByAdmin($_POST);
}

if (isset($userAdd)) {
  echo $userAdd;
}


if (isset($_GET['id'])) {
  $userid = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);

    $getUinfo = $vendor->getVendorInfoById($userid);
    
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $vendor->updateVendorByIdInfo($userid, $_POST);

}
if (isset($updateUser)) {
  echo $updateUser;
}
 ?>
 <div class="card ">
   <div class="card-header">
          <h3 class='text-center'>Add New Vendor</h3>
        </div>
        <div class="cad-body">



            <div>

            <form class="" action="" method="post">
                <div class="form-group pt-3">
                  <label for="name">Vendor name</label>
                  <input type="text" name="name"  class="form-control" value="<?php echo @$getUinfo->name; ?>">
                </div>
                <div class="form-group">
                  <label for="username"> Address</label>
                  <input type="text" name="address"  class="form-control" value="<?php echo @$getUinfo->address; ?>">
                </div>

                <div class="form-group">
                  <label for="mobile">Mobile Number</label>
                  <input type="text" name="mobile"  class="form-control" value="<?php echo @$getUinfo->mobile; ?>">
                </div>

                
                <div class="form-group">
                  <?php  if (isset($_GET['id'])) {?>
                    <button type="submit" name="update" class="btn btn-success">Update Vendor</button>
                  <?php }else { ?>
                  <button type="submit" name="addUser" class="btn btn-success">Add Vendor</button>
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

  <?php
  include 'inc/footer.php';

  ?>
