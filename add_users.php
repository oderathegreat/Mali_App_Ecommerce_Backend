<?php

// get database connection
include_once 'config/config.php';

// instantiate user object
include_once 'objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

// set user property values
$user->username = $_POST['username'];
$user->password = base64_encode($_POST['password']);
$user->email = $_POST['phonenumber'];
$user->email = $_POST['email'];



// create the user
if($user->signup()){
    $user_arr=array(
        "status" => true,
        "message" => "Successfully Created Account!",
        "id" => $user->id,
        "username" => $user->username
    );
}
else{
    $user_arr=array(
        "status" => false,
        "message" => "Username already exists!"
    );
}
print_r(json_encode($user_arr));



























?>