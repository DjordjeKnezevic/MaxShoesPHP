<?php
session_start();
include("../config/env.php");
include("../config/connect.php");
include("../config/functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<?php
include("./views/fixed/head.php")
?>

<body>
    <?php
    include("./views/fixed/navbar.php");

    switch ($_GET["page"]) {
        case "products":
            include("views/products.php");
            break;
        case "cart":
            include("views/cart.php");
            break;
        case "profile":
            include("views/profile.php");
            break;
        case "adminpanel":
            include("views/adminpanel.php");
            break;
        default:
            include("views/mainpage.php");
            break;
    }

    include("./views/fixed/footer.php");
    ?>

</body>

</html>