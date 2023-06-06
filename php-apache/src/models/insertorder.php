<?php

session_start();

if (
    !isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' ||
    !(isset($_POST['makeAnOrder']))
) {
    http_response_code(403);
    echo "Error: Access denied.";
    exit;
}

include("../../config/env.php");
include("../../config/connect.php");
header('Content-Type: application/json');

$korpa = $_SESSION["cart"];

$conn->beginTransaction();

$current_timestamp = time();
$delivery_timestamp = strtotime('+2 months', $current_timestamp);
$delivery_date = date('Y-m-d', $delivery_timestamp);

try {
    $stmt = $conn->prepare("INSERT INTO `porudzbina` (user_id, ukupna_cena, procenjen_datum_dostave) 
    VALUES (:user_id, :ukupna_cena, :procenjen_datum_dostave)");
    $stmt->bindParam(':user_id', $korpa[0]->user_id);
    $stmt->bindParam(':procenjen_datum_dostave', $delivery_date);
    $stmt->bindParam(':ukupna_cena', $korpa[0]->ukupna_cena);
    $stmt->execute();

    $order_id = $conn->lastInsertId();

    foreach ($korpa as $stavka) {
        $stmt = $conn->prepare("INSERT INTO porudzbina_patika (porudzbina_id, patika_id) VALUES (:porudzbina_id, :patika_id)");
        $stmt->bindParam(':porudzbina_id', $order_id);
        $stmt->bindParam(':patika_id', $stavka->patika_id);
        $stmt->execute();
    }
    $conn->commit();
    http_response_code(201);
    echo json_encode("Successfully made an order");
} catch (PDOException $e) {
    $conn->rollBack();
    http_response_code(500);
    echo json_encode($e->getMessage());
}


?>