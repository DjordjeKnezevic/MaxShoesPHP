<?php

$query = "SELECT * FROM ikonica LEFT OUTER JOIN path ON ikonica.id = path.ikonica_id";
$rez = $conn->query($query)->fetchAll();

?>

<footer class="dark-blue-bg" id="footer">
    <section>
        <?php
        for ($i = 0; $i < 3; $i++) {
            echo "<a href='" . $rez[$i]->link . "'class='text-light nav-link'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='35' height='35' fill='currentColor'
                                class='" . $rez[$i]->klasa . "' viewBox='0 0 16 16'>";
            $path = $i == 2 ? "<path d='" . $rez[$i]->vrednost . "'/><path d='" . $rez[$i + 1]->vrednost . "'/>" : "<path d='" . $rez[$i]->vrednost . "'/>";
            echo $path . "</svg></a>";
        }
        ?>
    </section>
    <section>
        <?php
        for ($i = 4; $i < 7; $i++) {
            echo "<article>
                <svg xmlns='http://www.w3.org/2000/svg' width='35' height='35' fill='currentColor'
                    class='" . $rez[$i]->klasa . " text-light' viewBox='0 0 16 16'>";
            $path = $i == 6 ? "<path d='" . $rez[$i]->vrednost . "'/><path d='" . $rez[$i + 1]->vrednost . "'/>" : "<path d='" . $rez[$i]->vrednost . "'/>";
            echo $path . "</svg>
                <p class='text-light'>" . $rez[$i]->label . "</p>
            </article>";
        }
        ?>
    </section>
    <section>
        <?php
        for ($i = 8; $i < 11; $i++) {
            if ($i != 10) {
                echo "<a href='" . $rez[$i]->link . "' class='nav-link'>
                <h5 class='text-light'>" . $rez[$i]->label . "</h5>
            </a>";
            } else {
                echo "<a href='sitemap.xml' class='text-light'>
                <svg xmlns='http://www.w3.org/2000/svg' width='35' height='35' fill='currentColor'
                    class='" . $rez[$i]->klasa . "' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd'
                        d='" . $rez[$i]->vrednost . "' />
                </svg>
            </a>";
            }
        }
        ?>
    </section>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
<script type="text/javascript" src="Assets/js/script.js"></script>