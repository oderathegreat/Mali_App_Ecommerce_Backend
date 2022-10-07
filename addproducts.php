<?php

require 'config/config.php';
header("Content-type: application/json");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

$data = json_decode(file_get_contents("php://input"), true); // collect input parameters and convert into readable format

$prod_name=$_POST['name'];
$prod_price=$_POST['price'];
$prod_category=$_POST['category'];


$fileName  =  $_FILES['sendimage']['name'];

//   var_dump($fileName,$prod_price,$prod_name,$prod_category);
//   die();

$tempPath  =  $_FILES['sendimage']['tmp_name'];
$fileSize  =  $_FILES['sendimage']['size'];

if(empty($fileName))
{
    $errorMSG = json_encode(array("message" => "please select image", "status" => false));
    echo $errorMSG;
}

 else {

     $upload_path = 'uploads/';
     $fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension
     // valid image extensions
     $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');

     // allow valid image file formats
     if(in_array($fileExt, $valid_extensions))
     {
         //check file not exist our upload folder path
         if(!file_exists($upload_path . $fileName))
         {

             if($fileSize < 5000000){
                 move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path
             } else {
                 $errorMSG = json_encode(array("message" => "sorry file too large", "status" => false));
                 echo $errorMSG;

             }

         } else {

             $errorMSG = json_encode(array("message" => "sorry file already exists check upload folder", "status" => false));
             echo $errorMSG;
         }
     }
      else {
          $errorMSG = json_encode(array("message" => "sorry only JPEGS PNGS GIF Allowed", "status" => false));
          echo $errorMSG;

      }

 }

 if (!isset($errorMSG)) {

     //continue to perform the insertion
     $insertQuery="INSERT INTO items (name, price, category, photo) VALUES('$prod_name','$prod_price','$prod_category','$fileName')";
     $result=mysqli_query($conn,$insertQuery);

     if($result){

         $response['ok']="200";
         $response['message']="New Product Created!";

         echo json_encode(array( "status"=>$response));
     }
     else
     {
         $response['error']="400";
         $response['message']="Failed! to Create Product";
     }

 }


