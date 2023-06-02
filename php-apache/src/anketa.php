<?php
session_start();
if (
    !isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' ||
    !isset($_POST['submitVote']) || !isset($_SESSION["loggedUser"]) || !isset($_POST["idGlas"])
) {
    http_response_code(403);
    echo "Error: Access denied.";
    exit;
}

header('Content-Type: application/json');
include("../includes/env.php");
include("../includes/connect.php");

$userId = $_SESSION["loggedUser"]->id;
$idGlas = $_POST["idGlas"];

$query = "SELECT * FROM anketa WHERE user_id = $userId";
$rez = $conn->query($query);
if($rez->rowCount() > 0) {
    http_response_code(400);
    echo json_encode("You have already voted");
    exit;
}

try {
    $query = "INSERT INTO `anketa`(`user_id`, `brend_id`) VALUES (:userId,:idGlas)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':idGlas', $idGlas);
    $stmt->execute();

    $query2 = "SELECT brend.id,COUNT(anketa.brend_id) as broj_glasova FROM `brend` LEFT OUTER JOIN `anketa`
    ON brend.id = anketa.brend_id
    GROUP BY brend.id;";
    $rez = $conn->query($query2)->fetchAll();

    http_response_code(201);
    echo json_encode($rez);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode($e->getMessage());
}


?>