<?php

$query = "SELECT * FROM navigacija LEFT OUTER JOIN slika on navigacija.slika_id = slika.id";
$navigacija = $conn->query($query)->fetchAll();

?>

<nav class="navbar navbar-expand-lg dark-blue-bg navbar-meni">
    <div class="container-fluid">
        <div class="col navbar-brand">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvasLg"
                aria-controls="navbarOffcanvasLg">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="col navbar-brand">
                <a href="/">
                    <h1 class=" text-light" id="logo-ime"><span class="lgreen">M</span>ax <span
                            class="lgreen">S</span>hoes</h1>
                </a>
                <a href="/"><img src="Assets/img/logo.jpg" alt="logo" class="ms-4"></a>
            </div>
        </div>
        <div class="col">
            <div class="offcanvas offcanvas-start" tabindex="-1" id="navbarOffcanvasLg"
                aria-labelledby="navbarOffcanvasLgLabel">
                <ul class="navbar-nav">

                    <?php
                    foreach ($navigacija as $row) {
                        echo "<li class='nav-item'><a class='nav-link text-light' href='$row->link'>$row->naziv</a></li>";
                    }
                    ?>

                </ul>
            </div>
        </div>
        <div class="col icons">
            <a class="text-light" id="glavna-korpa" href=<?php
            if (isset($_SESSION["loggedUser"]))
                echo "cart.php";
            else
                echo "#account-modal" . " data-bs-toggle='modal'"; ?>><svg xmlns="http://www.w3.org/2000/svg" width="35"
                    height="35" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                    <path
                        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </svg>
                <?php

                include("../includes/loadcart.php");

                ?>
            </a>

            <?php

            if (isset($_SESSION["loggedUser"])):

                ?>

                <div class="dropdown text-white mx-3" id="my-profile">
                    <a class="dropdown-toggle nav-link" href="#" role="button" aria-expanded="false" id="profile-ddtoggle">
                        <?php
                        echo $_SESSION["loggedUser"]->username;
                        if ($_SESSION["loggedUser"]->type == "admin") {
                            echo "(Admin)";
                        }
                        ?>
                    </a>
                    <ul class="dropdown-menu lgreen-bg">
                        <li><a class="dropdown-item" href="profile.php">My profile</a></li>
                        <?php if ($_SESSION["loggedUser"]->type == "admin") {
                            echo "<li><a class='dropdown-item' href='adminpanel.php'>Go to admin panel</a></li>";
                        } ?>
                        <li><a class="dropdown-item" href="#" id="logout">Logout</a></li>
                    </ul>
                </div>


                <?php
            else:
                ?>

                <a class="text-light" id="profile" data-bs-toggle="modal" href="#account-modal" role="button"><svg
                        xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor"
                        class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>
                </a>

                <?php
            endif;
            ?>
        </div>
    </div>
</nav>
<?php

if (isset($_SESSION["loggedUser"])) {
    $korpa = $_SESSION['cart'];
    echo "<div class='hide' id='isLoggedIn'>";
    foreach ($korpa as $row) {
        echo "<p class='shoe-data'>" . $row->patika_id . "</p>";
    }
    echo "</div>";
}

?>