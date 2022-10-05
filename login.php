<?php

require 'config/config.php';

header("Content-type: application/json");

$email=$_POST['email'];
$password=$_POST['password'];

//check if encrypted password is empty
$password = md5($password);

if (empty($email) ){
    $messages["email"] ="Invalid Email";
}


if (empty($password)) {
    $messages["password"] ="Invalid Password";
}

$password = md5($password);


$checkUser="SELECT * FROM users WHERE email='$email'";

$result=mysqli_query($conn,$checkUser);

if(mysqli_num_rows($result)>0){

    $checkUserquery="SELECT id, username, email FROM users WHERE email='$email' and password='$password'";
    $resultant=mysqli_query($conn,$checkUserquery);

    if(mysqli_num_rows($resultant)>0){

        while($row=$resultant->fetch_assoc())
            $response['user']=$row;
            $response['true']="200";
            $response['message']="login success";
    }
    else{
        $response['user']=(object)[];
        $response['error']="400";
        $response['message']="Wrong credentials";

    }


}
else{

    $response['user']=(object)[];
    $response['error']="400";
    $response['message']="user does not exist";


}

echo json_encode($response);



























?>