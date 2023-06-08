<?php

header('Content-Type: application/json');
$fileContent = file_get_contents("../data/log.txt");
$pages = ['products', 'index', 'cart', 'profile'];

$pageCounts = [];
foreach ($pages as $page) {
    $pageCounts[$page] = substr_count($fileContent, "::" . $page . "::");
}

$totalVisits = array_sum($pageCounts);
$pagePercentages = [];
foreach ($pageCounts as $page => $count) {
    $pagePercentages[$page] = round($count / $totalVisits, 3);
}

echo json_encode($pagePercentages);
