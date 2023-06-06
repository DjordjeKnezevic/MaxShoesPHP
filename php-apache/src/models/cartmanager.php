<?php

session_start();

if (
    !isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' ||
    !(isset($_POST['shoeToAdd']) || isset($_POST['shoeToRemove']) || isset($_POST['removeAll']))
) {
    http_response_code(403);
    echo "Error: Access denied.";
    exit;
}

include("../../config/env.php");
include("../../config/connect.php");
header('Content-Type: application/json');

$korpa = $_SESSION["cart"];

if (isset($_POST['shoeToAdd'])) {
    $shoeToAdd = $_POST['shoeToAdd'];

    try {
        $stmt = $conn->prepare("INSERT INTO korpa_patika(`korpa_id`, `patika_id`) VALUES (:korpaId,:patikaId)");
        $stmt->bindParam(':korpaId', $korpa[0]->id);
        $stmt->bindParam(':patikaId', $shoeToAdd['patika_id']);
        $stmt->execute();

        $query = "UPDATE korpa
        SET ukupna_cena = ukupna_cena + (
        SELECT IFNULL(IFNULL((c.vrednost * p.procenat), c.vrednost) + cp.vrednost, IFNULL((c.vrednost * p.procenat), c.vrednost)) AS uk_cena
        FROM korpa_patika kp
        INNER JOIN cena c ON c.patika_id = kp.patika_id
        LEFT JOIN cena_postarine cp ON cp.patika_id = kp.patika_id
        LEFT JOIN popust p ON p.patika_id = kp.patika_id
        WHERE kp.patika_id = :patikaId AND kp.korpa_id = :korpaId
        )
        WHERE id = :korpaId;";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':korpaId', $korpa[0]->id);
        $stmt->bindParam(':patikaId', $shoeToAdd['patika_id']);
        $stmt->execute();

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode($e->getMessage());
    }

}

if (isset($_POST['shoeToRemove'])) {
    $shoeToRemove = $_POST['shoeToRemove'];
    try {

        $query = "UPDATE korpa
        SET ukupna_cena = ukupna_cena - (
        SELECT IFNULL(IFNULL((c.vrednost * p.procenat), c.vrednost) + cp.vrednost, IFNULL((c.vrednost * p.procenat), c.vrednost)) AS uk_cena
        FROM korpa_patika kp
        INNER JOIN cena c ON c.patika_id = kp.patika_id
        LEFT JOIN cena_postarine cp ON cp.patika_id = kp.patika_id
        LEFT JOIN popust p ON p.patika_id = kp.patika_id
        WHERE kp.patika_id = :patikaId AND kp.korpa_id = :korpaId
        )
        WHERE id = :korpaId;";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':korpaId', $korpa[0]->id);
        $stmt->bindParam(':patikaId', $shoeToRemove['patika_id']);
        $stmt->execute();

        $stmt = $conn->prepare("DELETE FROM korpa_patika WHERE korpa_id = :korpaId AND patika_id = :patikaId");
        $stmt->bindParam(':korpaId', $korpa[0]->id);
        $stmt->bindParam(':patikaId', $shoeToRemove['patika_id']);
        $stmt->execute();

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode($e->getMessage());
    }

}

if (isset($_POST['removeAll'])) {
    try {
        $korpaId = $korpa[0]->id;
        $query = "UPDATE korpa SET ukupna_cena = 0 WHERE id = $korpaId";
        $conn->query($query);
        $query = "DELETE FROM korpa_patika WHERE korpa_id = $korpaId";
        $conn->query($query);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode($e->getMessage());
    }

}

try {
    $userId = $korpa[0]->user_id;
    $selectCart = "SELECT k.id, k.user_id, kp.patika_id, k.ukupna_cena 
    FROM korpa k LEFT OUTER JOIN korpa_patika kp ON k.id = kp.korpa_id WHERE k.user_id = $userId";
    $_SESSION['cart'] = $conn->query($selectCart)->fetchAll();
    http_response_code(200);
    echo json_encode("Success!");    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode($e->getMessage());
}



?>