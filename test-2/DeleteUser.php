<?php
include 'Database.php';
class DeleteUser {
    public $con;
    public function __construct() {
        $this->con =  Database::connectDB(); 
    }
    function delete(){
    $sql = "DELETE FROM users WHERE id='$_GET[deleteid]'";
    $result = $this->con->query($sql);
    if($result === TRUE){
    header('location:index.php');
    }
    }
}

$deleteuser = new DeleteUser;
$deleteuser->delete();
