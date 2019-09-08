<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once('../config/Database.php');
include_once('../objects/Product.php');

$database = new Database;
$pdo = $database->getConnection();
$product = new Product($pdo);

$data = json_decode(file_get_contents("php://input"));

$product->id = $data->id;

if ($product->delete()) {
    http_response_code(200);

    echo json_encode([
        "message" => "The product was deleted."
    ]);
} else {
    http_response_code(503);

    echo json_encode([
        "message" => "Unable to delete the product."
    ]);
}
