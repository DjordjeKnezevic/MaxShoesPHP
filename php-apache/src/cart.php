<?php
session_start();
if (!isset($_SESSION["loggedUser"])) {
    header("Location: /index.php?msg=cart-unavailable");
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

    <main id="korpa-main" class="d-flex flex-column justify-content-center align-items-center">

        <?php
        include("../includes/modal.php");
        ?>

        <div class="w-75 border border-dark container d-flex flex-column align-items-center" id="korpa-drzac">
        </div>
        <div class="row my-2 d-flex flex-row justify-content-around align-items-center w-75" id="korpa-info">
            <button type="button" class="btn btn-danger w-25" id="clear">Clear cart</button>
            <h2 class="d-inline-block w-50 h-100 text-center text-decoration-underline" id="total">Total: $
            </h2>
            <button type="button" class="btn btn-primary w-25" id="purchase">Purchase</button>

        </div>
    </main>
    <?php
    include("../includes/footer.php");
    ?>
</body>

</html>