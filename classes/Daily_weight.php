<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Daily_weight
{ 
    
    // Db Property
    private $db;
    private $db_mysql;
    
    // Db __construct Method
    public function __construct()
    {
        $this->db = new Database();
        $this->db_mysql = new Database_Mysql();


    }
    
    // Date formate Method
    public function formatDate($date)
    {
        date_default_timezone_set('Asia/Dhaka');
        $strtime = strtotime($date);
        return date('Y-m-d', $strtime);
    }
     // Select All User Method
    public function selectAllWeightData()
    {
        $sql  = "SELECT * FROM tbl_daily_wt ORDER BY id DESC";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    // Delete User by Id Method
    public function deleteUserById($remove)
    {
        $sql  = "DELETE FROM tbl_daily_wt WHERE id = :id ";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue(':id', $remove);
        $result = $stmt->execute();
        if ($result) {
            $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> User account Deleted Successfully !</div>';
            return $msg;
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not Deleted !</div>';
            return $msg;
        }
    }
    
    // User Deactivated By Admin
    public function userDeactiveByAdmin($deactive)
    {
        $sql = "UPDATE tbl_daily_wt SET

       isActive=:isActive
       WHERE id = :id";
        
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue(':isActive', 1);
        $stmt->bindValue(':id', $deactive);
        $result = $stmt->execute();
        if ($result) {
            echo "<script>location.href='daily_weight_list.php';</script>";
            Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> User account Diactivated Successfully !</div>');
            
        } else {
            echo "<script>location.href='daily_weight_list.php';</script>";
            Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not Diactivated !</div>');
            
            return $msg;
        }
    }
    
    
    // User Deactivated By Admin
    public function userActiveByAdmin($active)
    {
        $sql = "UPDATE tbl_daily_wt SET
       isActive=:isActive
       WHERE id = :id";
        
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue(':isActive', 0);
        $stmt->bindValue(':id', $active);
        $result = $stmt->execute();
        if ($result) {
            echo "<script>location.href='daily_weight_list.php';</script>";
            Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> User account activated Successfully !</div>');
        } else {
            echo "<script>location.href='daily_weight_list.php';</script>";
            Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not activated !</div>');
        }
    }

    // Check Exist Email Address Method
    public function checkExistEmail($email)
    {
        $sql  = "SELECT email from  tbl_daily_wt WHERE email = :email";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
        // Add New User By Admin
    public function addNewWeightByAdmin($data){
    $ven_id = $data['ven_id'];
    $pr_date = $data['pr_date'];
    $vendor_name = $data['vendor_name'];
    $weight = $data['weight'];
    $price = $data['price'];
    $remark = $data['remark'];
    $rate = $data['rate'];

    if ($ven_id == "" || $pr_date == "" || $weight == "" || $price == "") {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Input fields must not be Empty !</div>';
    return $msg;
    }else{
     $date =$this->formatDate($pr_date);
    $sql = "INSERT INTO tbl_daily_wt(ven_id,vendor_name, pr_date, weight,rate,price,remark) VALUES(:ven_id,:vendor_name, :pr_date, :weight,:rate,:price,:remark )";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':ven_id', $ven_id);
    $stmt->bindValue(':vendor_name', $vendor_name);
    $stmt->bindValue(':pr_date', $date);    
    $stmt->bindValue(':weight', $weight);
    $stmt->bindValue(':rate', $rate);
    $stmt->bindValue(':price', $price);
    $stmt->bindValue(':remark', $remark);                        
    $result = $stmt->execute();
    if ($result) {
    $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> Wow, you have added Weight Successfully !</div>';
    return $msg;
    }else{
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Something went Wrong !</div>';
    return $msg;
    }
    }
    
    }
    
      //
    //   Get Single User Information By Id Method
    public function updateWeightByIdInfo($userid, $data)
    {
        $name    = $data['name'];
        $address = $data['address'];        
        $mobile  = $data['mobile'];
        
        
        
        if ($name == "" || $address == "" || $mobile == "") {
            $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Input Fields must not be Empty !</div>';
            return $msg;
        } else {
            
          
          $this->db_mysql->connect();        
          $this->db_mysql->update('tbl_daily_wt',array('name'=>"$name",'address'=>"$address",'mobile'=>"$mobile"),'id='.$userid); // Table name, column names and values, WHERE conditions
         $result = $this->db_mysql->getResult();

            if ($result) {
                echo "<script>location.href='daily_weight_list.php';</script>";
                Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Wow, Your Information updated Successfully !</div>');
                
                
                
            } else {
                echo "<script>location.href='daily_weight_list.php';</script>";
                Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not inserted !</div>');
                
                
            }
            
            
        }
        }     
    
    // Get Single User Information By Id Method
    public function getWeightInfoById($userid)
    {
        $sql  = "SELECT * FROM tbl_daily_wt WHERE id = :id LIMIT 1";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue(':id', $userid);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        if ($result) {
            return $result;
        } else {
            return false;
        }
        
        
    }
    

}
/*
class Vendor
{
    
    
    
    
    
    
    

        
        
    }
    
    
    
    
    
    
    
}





$vendor = new Vendor();
echo "here";
print_r($vendor);
die;
*/