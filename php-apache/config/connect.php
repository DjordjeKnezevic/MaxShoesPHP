<?php

try {
    $conn = new PDO("mysql:host=$MYSQL_DATABASE_HOST;dbname=$MYSQL_DATABASE_NAME", $MYSQL_USER, $MYSQL_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    // echo "Uspesna konekcija<br/>";
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>