<?php log_visit(); ?>
<main id="second-page" class="d-flex flex-column">
    <section id="frame">
        <nav class=" navbar navbar-expand-lg dark-blue-bg">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h3 id="filter-tekst" class="text-light">Filters</h3>
                <div class="offcanvas offcanvas-end dark-blue-bg" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title text-light" id="offcanvasDarkNavbarLabel">Filters</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form class="d-flex" id="filter">
                            <ul class="navbar-nav flex-grow-1 pe-3">
                                <li class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false">
                                        Category
                                    </a>
                                    <ul class="dropdown-menu padajuci-meni" id="kategorije-opcije">
                                        <?php
                                        $query = "SELECT naziv FROM kategorija";
                                        $rez = $conn->query($query)->fetchAll();
                                        foreach ($rez as $row) {
                                            echo "<li class='dropdown-item text-light'>$row->naziv</li>";
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false">
                                        Brand
                                    </a>
                                    <ul class="dropdown-menu padajuci-meni" id="brendovi">
                                        <?php
                                        $query = "SELECT naziv FROM brend";
                                        $rez = $conn->query($query)->fetchAll();
                                        foreach ($rez as $row) {
                                            echo "<li class='dropdown-item text-light'>$row->naziv</li>";
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false">
                                        Price
                                    </a>
                                    <ul class="dropdown-menu padajuci-meni container" id="dropdown-cena">
                                        <li class="dropdown-item">
                                            <p id="amount" class="text-light"></p>
                                            <div id="slider-range" data-price-min="0" data-price-max="300">
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false">
                                        Sort by
                                    </a>
                                    <ul class="dropdown-menu padajuci-meni" id="sortiraj-po">
                                        <?php
                                        $query = "SELECT naziv FROM sortiranje";
                                        $rez = $conn->query($query)->fetchAll();
                                        foreach ($rez as $row) {
                                            echo "<li class='dropdown-item text-light'>$row->naziv</li>";
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false">
                                        Other filters
                                    </a>
                                    <ul class="dropdown-menu padajuci-meni text-white" id="ostali-filtri">
                                        <li class="d-flex flex-row justify-content-center dropdown-item"><input type="checkbox" name="" id="on-discount" class="form-check-input me-2 my-0" data-name="On Discount"><label for="on-discount" class="form-check-label text-white">On
                                                Discount</label></li>
                                        <li class="d-flex flex-row justify-content-center dropdown-item"><input type="checkbox" name="" id="free-shipping" class="form-check-input me-2 my-0" data-name="Free shipping"><label for="free-shipping" class="form-check-label text-white">Free
                                                shipping</label></li>
                                        <li class="d-flex flex-column justify-content-center dropdown-item">
                                            <label for="text-input" class="form-label text-light">Search by
                                                keyword:</label>
                                            <input type="text" class="form-control" id="text-input" placeholder="Enter text">
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <button type="button" class="btn" id="apply-filters">Apply filters</button>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <section id="filter-display" class="container-sm">
            <buttton class="btn dark-blue-bg text-light ms-3 filter-dugme hide ukloni-dugme" id="ukloni-filtre">
                Clear filters
            </buttton>
        </section>
        <section id="patike-display" class="container">
        </section>
    </section>
    <div id="pagination" class="mt-2 d-flex justify-content-between container">
        <button class="btn dark-blue-bg text-white" id="prev">Page 1</button>
        <button class="btn dark-blue-bg text-white" id="next">Page 2</button>
    </div>

    <div class="alert alert-success d-flex align-items-center" role="alert" id="uspesno-dodato" style="opacity: 0;">
        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:" width="15px" height="15px">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </svg>
        <div>
            Successfully added to cart
        </div>
    </div>
    <div class="alert alert-success d-flex align-items-center" role="alert" id="uspesno-skinuto" style="opacity: 0;">
        <svg xmlns="http://www.w3.org/2000/svg" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:" width="15px" height="15px">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </svg>
        <div>
            Successfully removed from cart
        </div>
    </div>
    <div class="alert alert-danger d-flex align-items-center" role="alert" id="ajax-error">
    </div>
</main>