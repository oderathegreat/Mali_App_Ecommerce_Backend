<?php

require_once 'config/config.php';
require_once  'jwtauth.php';

header("Content-type: application/json");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

$bearer_token = get_bearer_token();




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




$checkUser="SELECT * FROM users WHERE email='$email'";

$result=mysqli_query($conn,$checkUser);

if(mysqli_num_rows($result)>0){

    $data = json_decode(file_get_contents("php://input", true));

    $checkUserquery="SELECT id, username, email FROM users WHERE email='$email' and password='$password'";
    $resultant=mysqli_query($conn,$checkUserquery);

    if(mysqli_num_rows($resultant)>0){

        while($row=$resultant->fetch_assoc())


            $response=$row;


            $response['true']="200";
            $response['message']="login success";


        $headers = array('alg'=>'HS256','typ'=>'JWT');
        $payload = array('username'=>$username, 'exp'=>(time() + 60));

        $jwt = generate_jwt($headers, $payload);

        echo json_encode(array('token' => $jwt, "user"=>$response));
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





























?>