<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Vendor
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
        return date('Y-m-d H:i:s', $strtime);
    }
     // Select All User Method
    public function selectAllVendorData()
    {
        $sql  = "SELECT * FROM tbl_vendor ORDER BY id DESC";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    // Delete User by Id Method
    public function deleteUserById($remove)
    {
        $sql  = "DELETE FROM tbl_vendor WHERE id = :id ";
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
        $sql = "UPDATE tbl_vendor SET

       isActive=:isActive
       WHERE id = :id";
        
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue(':isActive', 1);
        $stmt->bindValue(':id', $deactive);
        $result = $stmt->execute();
        if ($result) {
            echo "<script>location.href='vendor.php';</script>";
            Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> User account Diactivated Successfully !</div>');
            
        } else {
            echo "<script>location.href='vendor.php';</script>";
            Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not Diactivated !</div>');
            
            return $msg;
        }
    }
    
    
    // User Deactivated By Admin
    public function userActiveByAdmin($active)
    {
        $sql = "UPDATE tbl_vendor SET
       isActive=:isActive
       WHERE id = :id";
        
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue(':isActive', 0);
        $stmt->bindValue(':id', $active);
        $result = $stmt->execute();
        if ($result) {
            echo "<script>location.href='vendor.php';</script>";
            Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> User account activated Successfully !</div>');
        } else {
            echo "<script>location.href='vendor.php';</script>";
            Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not activated !</div>');
        }
    }

    // Check Exist Email Address Method
    public function checkExistEmail($email)
    {
        $sql  = "SELECT email from  tbl_vendor WHERE email = :email";
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
    public function addNewVendorByAdmin($data){
    $name = $data['name'];
    $address = $data['address'];    
    $mobile = $data['mobile'];
    
    if ($name == "" || $mobile == "" || $address == "") {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Input fields must not be Empty !</div>';
    return $msg;
    }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Enter only Number Characters for Mobile number field !</div>';
    return $msg;
    
    }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Enter only Number Characters for Mobile number field !</div>';
    return $msg;
    
    }else{
    
    $sql = "INSERT INTO tbl_vendor(name, address, mobile) VALUES(:name, :address, :mobile)";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':address', $address);    
    $stmt->bindValue(':mobile', $mobile);      
    $result = $stmt->execute();
    if ($result) {
    $msg = '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success !</strong> Wow, you have Registered Successfully !</div>';
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
    public function updateVendorByIdInfo($userid, $data)
    {
        $name    = $data['name'];
        $address = $data['address'];        
        $mobile  = $data['mobile'];
        
        
        
        if ($name == "" || $address == "" || $mobile == "") {
            $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Error !</strong> Input Fields must not be Empty !</div>';
            return $msg;
        } elseif (filter_var($mobile, FILTER_SANITIZE_NUMBER_INT) == FALSE) {
            $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Enter only Number Characters for Mobile number field !</div>';
            return $msg;
            
            
        } else {
            
          
          $this->db_mysql->connect();
          //$this->db_mysql->update('tbl_vendor',array('name'=>"$name",'email'=>"$email" , 'mobile' = "$mobile"),'id="$userid"'); // Table name, column names and values, WHERE conditions
          $this->db_mysql->update('tbl_vendor',array('name'=>"$name",'address'=>"$address",'mobile'=>"$mobile"),'id='.$userid); // Table name, column names and values, WHERE conditions
$result = $this->db_mysql->getResult();

            if ($result) {
                echo "<script>location.href='vendor.php';</script>";
                Session::set('msg', '<div class="alert alert-success alert-dismissible mt-3" id="flash-msg">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success !</strong> Wow, Your Information updated Successfully !</div>');
                
                
                
            } else {
                echo "<script>location.href='vendor.php';</script>";
                Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error !</strong> Data not inserted !</div>');
                
                
            }
            
            
        }
        }     
    
    // Get Single User Information By Id Method
    public function getVendorInfoById($userid)
    {
        $sql  = "SELECT * FROM tbl_vendor WHERE id = :id LIMIT 1";
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