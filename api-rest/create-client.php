<?php
    require_once("../includes/Client.class.php"); 

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET["email"]) && isset($_GET["name"]) && isset($_GET["city"]) && isset($_GET["phone"])){
        $email = $_GET["email"];
        $name = $_GET["name"];
        $city = $_GET["city"];
        $phone = $_GET["phone"];

        Client::create_client($email, $name, $city, $phone);
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array("message" => "Invalid request"));
    }
?>