<?php
session_start();
if (!isset($_SESSION["loggedUser"])) {
    header("Location: /index.php?msg=profile-unavailable");
}
include("../includes/env.php");
include("../includes/connect.php");

$query = "SELECT * FROM brend";
$brendovi = $conn->query($query)->fetchAll();

$user = $_SESSION["loggedUser"];
$userId = $user->id;
$query = "SELECT * FROM anketa WHERE user_id = $userId";
$rez = $conn->query($query);
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
    <main id="profile-main" class="container-fluid d-flex row">
        <?php
        include("../includes/modal.php");
        ?>
        <div class="d-flex flex-column col-md-8" id="profile-drzac">

            <?php

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
                        <div class='mb-3 rounded p-1'><h2 class='text-decoration-underline'>Estimated delivery time:</h2><h4>" . $porudzbina->procenjen_datum_dostave . "</h4></div>
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
                echo "</div></div>";
            }
            ?>
        </div>
        <div class="col-md-4 p-2 d-flex flex-column justify-content-center align-items-center" id="anketa">
            <div class="p-4" id="anketa-drzac">
                <h5>Which brand of shoes do you like the most?</h5>
                <form action="" class="">
                    <div class="form-group p-2 mt-1" id="anketa-izbori">
                        <?php
                        if ($rez->rowCount() > 0) {
                            $idGlasanogBrenda = $rez->fetch()->brend_id;
                            $query = "SELECT brend.id,COUNT(anketa.brend_id) as broj_glasova FROM `brend` LEFT OUTER JOIN `anketa`
                            ON brend.id = anketa.brend_id
                            GROUP BY brend.id;";
                            $brojGlasovaPoBrendu = $conn->query($query)->fetchAll();
                            foreach ($brendovi as $key => $brend) {
                                $brojGlasova = $brojGlasovaPoBrendu[$key]->broj_glasova;
                                if ($idGlasanogBrenda == $brend->id) {
                                    echo "<div class='form-check p-2 border-bottom my-1'>
                                    <input class='form-check-input mx-0' type='radio' name='izbor' id='$brend->id' checked disabled>
                                    <label class='form-check-label mx-2' for='$brend->id'>$brend->naziv</label>
                                    <p class='d-inline-block m-0'>($brojGlasova votes) <i>Your vote</i></p>
                                    </div>";
                                } else {
                                    echo "<div class='form-check p-2 border-bottom my-1'>
                                    <input class='form-check-input mx-0' type='radio' name='izbor' id='$brend->id' disabled>
                                    <label class='form-check-label mx-2' for='$brend->id'>$brend->naziv</label>
                                    <p class='d-inline-block m-0'>($brojGlasova votes)</p>
                                    </div>";
                                }
                            }
                            echo "</div><input type='button' name='submitVote' value='Vote' class='btn btn-primary form-control my-2'
                            id='submitVote' disabled></form><div class='alert alert-success d-flex align-items-center mt-2' role='alert'
                            id='anketa-success'>
                            <svg xmlns='http://www.w3.org/2000/svg'
                                class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16'
                                role='img' aria-label='Warning:' width='15px' height='15px'>
                                <path
                                    d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z' />
                            </svg>
                            <div>
                                Thank you for your vote
                            </div>
                        </div>";
                        } else {
                            foreach ($brendovi as $brend) {
                                echo "<div class='form-check p-2 border-bottom my-1'>
                            <input class='form-check-input mx-0' type='radio' name='izbor' id='$brend->id'>
                            <label class='form-check-label mx-2' for='$brend->id'>$brend->naziv</label>
                        </div>";
                            }
                            echo "</div><input type='button' name='submitVote' value='Vote' class='btn btn-primary form-control my-2'
                            id='submitVote'></form><span class='hide alert alert-danger d-inline-block w-100 p-2 mt-1' id='anketa-error'>You must select an
                                option in order to vote</span><div class='alert alert-success d-flex align-items-center mt-2 hide' role='alert'
                                id='anketa-success'>
                                <svg xmlns='http://www.w3.org/2000/svg'
                                    class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16'
                                    role='img' aria-label='Warning:' width='15px' height='15px'>
                                    <path
                                        d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z' />
                                </svg>
                                <div>
                                    Thank you for your vote
                                </div>
                            </div>";
                        }
                        ?>
                    </div>
            </div>
    </main>
    <?php
    include("../includes/footer.php");
    ?>
</body>

</html>