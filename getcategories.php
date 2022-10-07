<?php

require_once 'config/config.php';
$check_prod = $conn->prepare("SELECT distinct username from users");
$check_prod->execute();
    $results = $check_prod->get_result();
        $array_prod = array();

        while ($row = $results->fetch_assoc()) {

           array_push($array_prod, $row);


        }

        echo json_encode($array_prod);
