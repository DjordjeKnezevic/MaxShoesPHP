<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' || !isset($_POST['novKorisnik'])) {
    http_response_code(403);
    echo "Error: Access denied.";
    exit;
}

include("../../config/env.php");
include("../../config/connect.php");
header('Content-Type: application/json');

$newUser = $_POST['novKorisnik'];

$username = $newUser['username'];
$password = $newUser['password'];
$firstName = $newUser['firstName'];
$lastName = $newUser['lastName'];
$email = $newUser['email'];
$address = $newUser['address'];
$agreedToTOS = $newUser['agreedToTOS'];

if ($agreedToTOS != "true") {
    http_response_code(400);
    echo json_encode("You must agree to terms of services in order to register");
    exit;
}

$reUsername = [
    "/^[\w\d!@#\$%\^&\*\._]{5,20}$/",
    "/^[A-Z][\w\d!@#\$%\^&\*\._]{4,19}$/"
];
$porukaUsername = [
    'Username must be between 5 and 20 characters long and must not contain spaces',
    'Username must start with a capital letter'
];
$rePassword = [
    "/^[\w\d!@#\$%\^&\*\._]{8,20}$/",
    "/^([\w!@#$%^&*._]+[\d]+)|([\d]+[\w!@#\$%\^&\*\._]+)$/",
    "/^([\w\d]+[!@#\$%\^&\*\._]+)|([!@#\$%\^&\*\._]+[\w\d]+)$/",
    "/^[A-Z][\w\d!@#\$%\^&\*\._]{7,19}$/"
];
$porukaPassword = [
    'Password must be between 8 and 20 characters long and must not contain spaces',
    'Password must contain at least 1 number',
    'Password must contain at least 1 of the characters: "!@#$%^&*._"',
    'Password must start with a capital letter'
];
$reFirstLastName = [
    "/^[\w\dŽĐŠĆČćđčžš]{3,30}$/",
    "/^[A-Z][\w\dŽĐŠĆČćđčžšшђжћчЂШЖЋЧ]{2,29}$/"
];
$porukaFirstLastName = [
    'Name (First and Last) must be between 3 and 20 characters long and must not contain spaces',
    'Name (First and Last) must start with a capital letter'
];
$reEmail = "/^[a-z\d\._]{3,29}@[a-z]{3,10}(\.[a-z]{2,5}){1,4}$/";
$porukaEmail = 'Invalid email format (Email must contain "@" and end with a domain name (Ex. ".com")))';
$reAddress = [
    "/^(([A-Z][\w\d\.\-]+)|([\d]+\.?))(\s{1}[\w\d\.\-\/]+)+$/",
    "/^(([A-Z][\w\d\.\-]+)|([\d]+\.?))(\s{1}[\w\d\/\.\-]+){0,7}$/",
    "/^(([A-Z][\w\d\.\-]+)|([\d]+\.?))(\s{1}[\w\d\/\.\-]+){0,7}\s(([\d]{1,3}((\/(([\d]{1,2}[\w]?)|([\w]{1,2}))|([\w])))?)|((BB)|(bb)))$/"
];
$porukaAddress = [
    'Address must start with either a capital letter, or a number',
    'Address must have a maximum of 8 words',
    'Address must include a number (Ex. 2, 6/a, 30/4b, BB)'
];
for ($i = 0; $i < count($reUsername); $i++) {
    if (!preg_match($reUsername[$i], $username)) {
        http_response_code(400);
        echo json_encode($porukaUsername[$i]);
        exit;
    }
}
for ($i = 0; $i < count($rePassword); $i++) {
    if (!preg_match($rePassword[$i], $password)) {
        http_response_code(400);
        echo json_encode($porukaPassword[$i]);
        exit;
    }
}
for ($i = 0; $i < count($reFirstLastName); $i++) {
    if (!preg_match($reFirstLastName[$i], $firstName)) {
        http_response_code(400);
        echo json_encode($porukaFirstLastName[$i]);
        exit;
    }
}
for ($i = 0; $i < count($reFirstLastName); $i++) {
    if (!preg_match($reFirstLastName[$i], $lastName)) {
        http_response_code(400);
        echo json_encode($porukaFirstLastName[$i]);
        exit;
    }
}
if (!preg_match($reEmail, $email)) {
    http_response_code(400);
    echo json_encode($porukaEmail);
    exit;
}
for ($i = 0; $i < count($reAddress); $i++) {
    if (!preg_match($reAddress[$i], $address)) {
        http_response_code(400);
        echo json_encode($porukaAddress[$i]);
        exit;
    }
}

try {
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode("User with this email already exists");
        exit;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode($e->getMessage());
    exit;
}
try {
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode("User '$username' already exists");
        exit;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode($e->getMessage());
    exit;
}

$randomNumber = mt_rand(100000000000000, 999999999999999);
$hashedPass = sha1($PHP_SHA1_STRING . $password);

try {
    $stmt = $conn->prepare("INSERT INTO `user`(`username`, `password`, `first_name`, `last_name`, `email`, `address`, `random_number`) 
    VALUES (:username,:password,:firstName,:lastName,:email,:address,:randomNumber)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPass);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':randomNumber', $randomNumber);
    $stmt->execute();
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode($e->getMessage());
    exit;
}

$PHPMAIL_DESTINATION = 'https://distortive-hello.000webhostapp.com/models/confirm.php'; // env fajl
$mailBody = "<a href='$PHPMAIL_DESTINATION?num=$randomNumber'>Click to confirm your mail</a>";

use League\OAuth2\Client\Provider\Google;

require('../dependencies/autoload.php');
require('../dependencies/league/oauth2-google/src/Provider/Google.php');
$provider = new Google([
    'clientId' => $PHPMAILER_CLIENTID,
    'clientSecret' => $PHPMAILER_CLIENTSECRET,
]);
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com'; //gmail SMTP server
$mail->SMTPAuth = true;
$mail->Host = 'smtp.gmail.com'; //gmail SMTP server
$mail->Username = $PHPMAIL_SENDER; //email
$mail->Password = $PHPMAIL_PASSWORD; //16 character obtained from app password created
$mail->Port = 465; //SMTP port
$mail->SMTPSecure = "ssl";

$mail->setFrom($PHPMAIL_SENDER, 'Auto mail sender');
$mail->addAddress($email);

$mail->isHTML(true);
$mail->Subject = "Confirmation mail";
$mail->Body = $mailBody;

// Send mail   
try {
    $mail->send();
    http_response_code(201);
    echo json_encode("confirm");
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode($mail->ErrorInfo);
}

$mail->smtpClose();
