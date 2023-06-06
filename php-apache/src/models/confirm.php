<?php

session_start();


if (isset($_GET["num"])) {
    include("../../config/env.php");
    include("../../config/connect.php");
    $num = $_GET["num"];

    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE random_number = :randomNum AND verified = 0");
        $stmt->bindParam(':randomNum', $num);
        $stmt->execute();
        if ($stmt->rowCount() < 1) {
            http_response_code(403);
            echo "Error: acess denied";
            exit;
        } else {
            $user = $stmt->fetch();
            $query = "UPDATE user SET verified = 1 WHERE username = '$user->username'";
            try {
                $conn->query($query);
                $_SESSION["loggedUser"] = $user;
                http_response_code(200);
                header("Location: /");
            } catch (PDOException $e) {
                http_response_code(500);
                echo $e->getMessage();
                exit;
            }
        }
    } catch (PDOException $e) {
        http_response_code(403);
        echo "Error: acess denied";
        exit;
    }
} else {
    http_response_code(403);
    echo "Error: acess denied";
    exit;
}


?>