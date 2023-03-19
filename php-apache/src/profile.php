<?php
session_start();
if (!isset($_SESSION["loggedUser"])) {
    header("Location: /index.php?msg=profile-unavailable");
}
include("../includes/env.php");
include("../includes/connect.php");

?>

<!DOCTYPE html>
<html lang="en">

<?php
include("../includes/head.php")
    ?>

<body>
    <?php
    include("../includes/navbar.php");
    ?>
    <main id="profile-main">
        <?php
        include("../includes/modal.php");
        ?>
        <div class="container d-flex flex-column" id="profile-drzac">

            <?php
            $user = $_SESSION["loggedUser"];

            $userId = $user->id;
            $query = "SELECT * FROM porudzbina p INNER JOIN porudzbina_patika pp ON p.id = pp.porudzbina_id WHERE p.user_id = $userId;";
            $porudzbine = $conn->query($query)->fetchAll();

            $porudzbinaId = 0;
            $brojac = 0;
            if (count($porudzbine) == 0) {
                echo "<div class='d-flex flex-column my-3 w-50' id='nema-kupovine'><h1>You haven't made any purchases</h1>
                <a class='btn btn-primary my-2' href='/products.php'>Go to our shop</a>
                </div>";
            } else {
                foreach (array_reverse($porudzbine) as $porudzbina) {
                    $porucenaPatika = BASEQUERY;
                    if ($porudzbina->id != $porudzbinaId) {
                        if ($brojac != 0) {
                            $brojac = 0;
                            echo "</div></div><p class ='hide'>" . $porudzbina->id . "</p>";
                        }
                        echo "<div class='row my-3 kupovina'><div class='col-md-3 d-flex flex-column porudzbina-informacije'>
                        <div class='mb-2 p-1 rounded'><h2 class='text-decoration-underline'>Time of purchase:</h2><h4>" . $porudzbina->datum_porudzbine . "</h4></div>
                        <div class='mb-2 p-1 rounded'><h2 class='text-decoration-underline'>Total price:</h2><h4>$" . $porudzbina->ukupna_cena . "</h4></div>
                        <div class='mb-2 rounded p-1'><h2 class='text-decoration-underline'>Estimated delivery time:</h2><h4>" . $porudzbina->procenjen_datum_dostave . "</h4></div>
                        </div><div class='col-md-9'>";
                        $porudzbinaId = $porudzbina->id;
                    }
                    $patikaId = $porudzbina->patika_id;
                    $porucenaPatika .= "WHERE p.id = $patikaId";
                    $patika = $conn->query($porucenaPatika)->fetch();

                    if ($patika->kategorija_naziv == 'Men')
                        $bgColor = 'dark-blue-bg text-white';
                    if ($patika->kategorija_naziv == 'Women')
                        $bgColor = 'pink-bg text-dark';
                    if ($patika->kategorija_naziv == 'Kids')
                        $bgColor = 'lgreen-bg text-dark';
                    echo "
                    <div class='row border stavka my-2 d-flex'>
                    <div class='col-md-5 d-flex flex-column border-bottom p-2'>
                    <hgroup>
                    <h3 class='text-decoration-underline'>" . $patika->brend_naziv . " " . $patika->patika_model . "</h3>
                    <i class='$bgColor p-2 my-1 d-inline-block rounded'>" . $patika->kategorija_naziv . "</i>
                    </hgroup>
                    </div>
                    <div class='col-md-3 d-flex flex-column border-bottom p-2'>
                    <h3 class='text-decoration-underline'>Price:</h3>";
                    if ($patika->popust != null) {
                        echo "<hgroup><h5 class='text-decoration-line-through d-inline text-danger fst-italic'>$" . $patika->bazna_cena .
                            "</h5><h5 class='d-inline text-success fw-bold mx-2'>$" . number_format($patika->snizena_cena, 2) . "</h5></hgroup>";
                    } else {
                        echo "<h5>$" . $patika->bazna_cena . "</h5>";
                    }
                    echo "<p>+$";
                    if ($patika->cena_postarine != null) {
                        echo $patika->cena_postarine;
                    } else {
                        echo "0.00";
                    }
                    echo " shipping</p></div>
                    <div class='col-md-4 d-flex border-bottom'><img class='img-fluid p-2' src='$patika->slika_src' alt='$patika->slika_alt'>
                    </div>
                    </div>
                    ";
                    $brojac = 1;
                }
            }
            ?>

        </div>
    </main>
    <?php
    include("../includes/footer.php");
    ?>
</body>

</html>