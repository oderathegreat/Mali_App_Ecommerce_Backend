<?php

require 'config/config.php';
header("Content-type: application/json");

$username=$_POST['username'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$password=$_POST['password'];

$messages=[];
if (empty($username) || strlen($username)<5){
    $messages["username"] ="Invalid username";
}
if (empty($email) ){
    $messages["email"] ="Invalid Email";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) ){
    $messages["email"] ="Invalid Email";
}

if (empty($phone)){
    $messages["phone"] ="Empty phone";
}



if (empty($password)){
    $messages["password"] ="Empty Password Field";
}

$password = md5($password);

if (!empty($messages)){
    echo  json_encode($messages);
    exit;
}
//check if encrypted password is empty


$checkUser="SELECT * from users WHERE email='$email' and phone='$phone'";
$checkQuery=mysqli_query($conn,$checkUser);


if(mysqli_num_rows($checkQuery)>0){

    $response['error']="403";
    $response['message']="User exist with $email and $phone exists" ;
}
else
{
    $insertQuery="INSERT INTO users (username,phone,email,password) VALUES('$username','$phone','$email','$password')";
    $result=mysqli_query($conn,$insertQuery);

    if($result){

        //$response['error']="200";
        $response['message']="New User Created!";
    }
    else
    {
        $response['error']="400";
        $response['message']="Failed! to Create User";
    }



}


echo json_encode($response);
