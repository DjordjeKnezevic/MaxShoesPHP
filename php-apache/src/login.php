<?php

session_start();
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' || !isset($_POST['trazeniKorisnik'])) {
    http_response_code(403);
    echo "Error: Access denied.";
    exit;
}

include("../includes/env.php");
include("../includes/connect.php");
header('Content-Type: application/json');

$trazeniKorisnik = $_POST["trazeniKorisnik"];
$usernameEmail = $trazeniKorisnik['loginUsernameEmail'];
$password = $trazeniKorisnik['loginPassword'];

try {
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = :usernameEmail OR username = :usernameEmail");
    $stmt->bindParam(':usernameEmail', $usernameEmail);
    $stmt->execute();
    if ($stmt->rowCount() < 1) {
        http_response_code(400);
        echo json_encode("This user does not exist");
        exit;
    } else {
        $user = $stmt->fetch();
        $hasedPass = sha1($PHP_SHA1_STRING . $password);
        if ($user->password != $hasedPass) {
            http_response_code(400);
            echo json_encode("Incorrect password, try again");
            exit;
        }
        if ($user->verified != 1) {
            http_response_code(400);
            echo json_encode("Please verify your account before attempting to log in. Check your registered email");
            exit;
        }

        $_SESSION["loggedUser"] = $user;
        http_response_code(200);
        echo json_encode("success");
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode($e->getMessage());
    exit;
}

?>