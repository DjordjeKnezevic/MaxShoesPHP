<?php

session_start();

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' || !isset($_SESSION["loggedUser"])) {
    http_response_code(403);
    echo "Error: Access denied.";
    exit;
}

unset($_SESSION["loggedUser"]);
unset($_SESSION["cart"]);
http_response_code(200);

?>