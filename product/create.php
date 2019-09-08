<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('../config/Database.php');
include_once('../objects/Product.php');

$database = new Database();
$pdo = $database->getConnection();
$product = new Product($pdo);

//posted data
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->price) && !empty($data->description) && !empty($data->cat_id)) {
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->cat_id = $data->cat_id;
    $product->created = date('Y-m-d H:i:s');

    if ($product->create()) {
        http_response_code(201);

        echo json_encode([
            "message" => "The product was added."
        ]);
    } else {
        http_response_code(503);

        echo json_encode([
            "message" => "Unable to add the product."
        ]);
    }
} else {
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
