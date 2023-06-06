<?php

if (
    !isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest' ||
    !isset($_POST['getShoes'])
) {
    http_response_code(403);
    echo "Error: Access denied.";
    exit;
}

header('Content-Type: application/json');
include("../../config/env.php");
include("../../config/connect.php");

$query = BASEQUERY;

if (
    isset($_POST['Category']) || isset($_POST['Brand']) || isset($_POST['FreeShipping']) || isset($_POST['Keyword'])
    || isset($_POST['OnDiscount']) || isset($_POST['donjaCena']) || isset($_POST['gornjaCena']) || isset($_POST['Model']) || isset($_POST['ids'])
) {
    $filterQuery = "WHERE ";
    if (isset($_POST['Category'])) {
        $category = $_POST['Category'];
        $filterQuery .= "k.naziv = '$category' AND ";
    }
    if (isset($_POST['Brand'])) {
        $brand = $_POST['Brand'];
        $filterQuery .= "b.naziv = '$brand' AND ";
    }
    if (isset($_POST['Model'])) {
        $model = $_POST['Model'];
        $filterQuery .= "p.model = '$model' AND ";
    }
    if (isset($_POST['FreeShipping'])) {
        $filterQuery .= "cp.vrednost IS NULL AND ";
    }
    if (isset($_POST['OnDiscount'])) {
        $filterQuery .= "pop.procenat IS NOT NULL AND ";
    }
    if (isset($_POST['Keyword'])) {
        $keyword = strtolower($_POST['Keyword']);
        $filterQuery .= "CONCAT(b.naziv,' ',p.model) LIKE '%$keyword%' AND ";
    }
    if (isset($_POST['donjaCena']) && isset($_POST['gornjaCena'])) {
        $donjaCena = $_POST['donjaCena'];
        $gornjaCena = $_POST['gornjaCena'];
        $filterQuery .= "IFNULL((c.vrednost * pop.procenat), c.vrednost) <= $gornjaCena AND 
        IFNULL((c.vrednost * pop.procenat), c.vrednost) >= $donjaCena AND ";
    }
    if (isset($_POST['ids'])) {
        $ids = implode(",", $_POST['ids']);
        $filterQuery .= "p.id IN ($ids) AND ";
    }
    $filterQuery = substr($filterQuery, 0, strlen($filterQuery) - 4);
    $query .= $filterQuery;
}
if (isset($_POST['SortBy'])) {
    $sort = $_POST['SortBy'];
    $filterQuery = "ORDER BY ";
    switch ($sort) {
        case "Price Ascending":
            $filterQuery .= "snizena_cena";
            break;
        case "Price Descending":
            $filterQuery .= "snizena_cena DESC";
            break;
        case "Name Ascending":
            $filterQuery .= "b.naziv, p.model";
            break;
        case "Name Descending":
            $filterQuery .= "b.naziv DESC, p.model DESC";
            break;
    }
    $query .= $filterQuery;
}

try {
    $rez = $conn->query($query)->fetchAll();
    http_response_code(200);
    echo (json_encode($rez));
} catch (PDOException $e) {
    http_response_code(500);
    echo $e->getMessage();
}

?>