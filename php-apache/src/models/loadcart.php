<?php

if (isset($_SESSION['loggedUser'])) {
    $user = $_SESSION["loggedUser"];
    $selectCart = "SELECT k.id, k.user_id, kp.patika_id, k.ukupna_cena 
    FROM korpa k LEFT OUTER JOIN korpa_patika kp ON k.id = kp.korpa_id WHERE k.user_id = $user->id";
    $result = $conn->query($selectCart);
    if ($result->rowCount() < 1) {
        $insertCart = "INSERT INTO korpa(`user_id`, `ukupna_cena`) VALUES ($user->id, 0)";
        $conn->query($insertCart);
        $newResult = $conn->query($selectCart);
        $_SESSION["cart"] = $newResult->fetch();
    } else {
        $korpa = $result->fetchAll();
        $_SESSION['cart'] = $korpa;
        $brojStavkiUKorpi = count($korpa);
        if ($brojStavkiUKorpi > 0 && $korpa[0]->patika_id != null) {
            echo "<div id='brojac' class='text-dark'>$brojStavkiUKorpi</div>";
        } else {
            echo "<div id='brojac' class='text-dark hide'></div>";
        }
    }
}


?>