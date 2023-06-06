<main id="main-page">
    <?php

    if (isset($_GET["msg"])) {
        if ($_GET["msg"] == "cart-unavailable") echo "<p class='hide' id='cart-unavailable'>Please login or register first before accessing the cart page</p>";
        else if ($_GET["msg"] == "profile-unavailable") echo "<p class='hide' id='profile-unavailable'>Please login or register first before accessing the profile page</p>";
    }
    ?>
    <section id="welcome-screen">
        <?php

        $query = "SELECT * FROM slika WHERE alt LIKE 'bg-%'";
        $rez = $conn->query($query)->fetchAll();
        foreach ($rez as $row) {
            echo "<img src='$row->src' alt='$row->alt'>";
        }
        ?>

    </section>

    <hgroup id="welcome-title">
        <h1>MAX SHOES</h1>
        <h3>MAXIMUM STYLE, MINIMUM EFFORT
            <h3 />
    </hgroup>
    <section class="container" id="Akcije">
        <div id="menjaj-sliku" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php

                $popularnePatike = array(
                    array(
                        'brend' => 'Asics',
                        'model' => 'Lite Show',
                        'link' => 'index.php?page=products&brand=Asics&amp;model=Lite Show',
                        'src' => 'Assets/img/AsicsLiteShow.jpg',
                        'alt' => 'AsicsLiteShow'
                    ),
                    array(
                        'brend' => 'Asics',
                        'model' => 'Metaspeed Sky',
                        'link' => 'index.php?page=products&brand=Asics&amp;model=Metaspeed Sky',
                        'src' => 'Assets/img/AsicsMetaspeedSky.jpg',
                        'alt' => 'AsicsMetaspeedSky'
                    ),
                    array(
                        'brend' => 'Nike',
                        'model' => 'Pegasus Turbo Next Nature',
                        'link' => 'index.php?page=products&brand=Nike&amp;model=Pegasus Turbo Next Nature',
                        'src' => 'Assets/img/NikePegasusTurboNextNature.jpg',
                        'alt' => 'NikePegasusTurboNextNature'
                    )
                );

                $active = true;
                for ($i = 1; $i < count($popularnePatike) + 1; $i++) {
                    $prev = $i - 1;
                    echo "<button type='button' data-bs-target='#menjaj-sliku' 
                        data-bs-slide-to='$prev' aria-label='Slide $i'";
                    if ($active)
                        echo "class='active' aria-current='true'";
                    echo "></button >";
                    $active = false;
                }

                ?>
            </div>
            <div class="carousel-inner">

                <?php

                $active = true;
                foreach ($popularnePatike as $patika) {
                    if ($active)
                        echo "<article class='carousel-item active";
                    else
                        echo "<article class='carousel-item";
                    echo "'><a
                        href='" . $patika['link'] . "'><img
                            src='" . $patika['src'] . "' class='d-block w-100' alt='" . $patika['alt'] . "'></a>
                    <div class='carousel-caption'>
                        <h5>" . $patika['brend'] . "</h5>
                        <p>" . $patika['model'] . "</p>
                    </div>
                </article>
                        ";
                    $active = false;
                }

                $carouselKontrole = ["prev", "next"];
                $carouselKontroleTekst = ["Previous", "Next"];

                for ($i = 0; $i < count($carouselKontrole); $i++) {
                    echo "<button class='carousel-control-$carouselKontrole[$i]' type='button' data-bs-target='#menjaj-sliku'
                            data-bs-slide='$carouselKontrole[$i]'>
                    <span class='carousel-control-$carouselKontrole[$i]-icon' aria-hidden='true'></span>
                            <span class='visually-hidden'>$carouselKontroleTekst[$i]</span>
                        </button>
                        ";
                }
                ?>
            </div>
        </div>
        <a href="/index.php?page=products&brand=Nike&discount=On Discount"><img src="Assets/img/NikeDiscount.jpg" class="img-fluid" alt="NikeDiscount"></a>
    </section>
    <section id="kategorije">
        <hgroup id="kategorije-naslov">
            <h2>CATEGORIES</h2>
            <h5>Best offers and selection for each of the categories</h5>
        </hgroup>
        <div class="container" id="kategorije-kartice">
            <div class="row">
                <?php

                for ($i = 0; $i < 3; $i++) {
                    echo "<a href='" . $navigacija[$i]->link . "' class='nav-link col-md-3'>
                        <div class='hcontainer " . $navigacija[$i]->klasa . "'>
                            <h3>" . $navigacija[$i]->naziv . "</h3>
                        </div>
                        <img src='" . $navigacija[$i]->src . "' alt='" . $navigacija[$i]->alt . "'>
                        </a>";
                }
                ?>
            </div>
        </div>
    </section>
</main>