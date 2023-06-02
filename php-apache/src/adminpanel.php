<?php
session_start();

if (!isset($_SESSION['loggedUser']) || $_SESSION['loggedUser']->type != 'admin') {
    http_response_code(403);
    echo "Error: Access denied.";
    exit;
}

include("../includes/env.php");
include("../includes/connect.php");

$queryKategorija = "SELECT * FROM kategorija";
$kategorije = $conn->query($queryKategorija)->fetchAll();

$queryBrend = "SELECT * FROM brend";
$brendovi = $conn->query($queryBrend)->fetchAll();

$queryShoes = "SELECT 
p.id AS id, 
p.model AS model, 
b.naziv AS brend
FROM patika p
INNER JOIN brend b ON b.id = p.brend_id
ORDER BY b.naziv, p.model";
$queryShoes = $conn->query($queryShoes)->fetchAll();

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
    <main id="admin-main" class="d-flex justify-content-center">
        <?php
        include("../includes/modal.php");

        if (isset($_GET["errors"])) {
            $errorStr = $_GET["errors"];
            $errors = explode(",", $errorStr);

            echo "<div class='modal modalErrMsg' id='error-modal' aria-hidden='true' aria-labelledby='exampleModalToggleLabel4' tabindex='-1'>
<div class='modal-dialog modal-dialog-centered d-flex justify-content-center'>
    <div class='modal-content'>
        <div class='modal-header'>
            <h1 class='modal-title fs-5' id='exampleModalToggleLabel4'>Error</h1>
            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close' id='closeErrModal'></button>
        </div>
        <div class='modal-body'><ul>";
            foreach ($errors as $error) {
                echo "<li>" . $error . "</li>";
            }
            echo "</ul></div>
    </div>
</div>
</div>";
        }
        if (isset($_GET["successMsg"])) {
            echo "<div class='modal modalSuccMsg' id='success-modal' aria-hidden='true' aria-labelledby='success-modal-header' tabindex='-1'>
                <div class='modal-dialog modal-dialog-centered'>
                    <div class='modal-content'>
                        <div class='modal-header bg-success'>
                            <h1 class='modal-title m-3' id='success-modal-header'>Success!</h1>
                            <button type='button' class='btn-close mx-2' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body alert alert-success'>";
            echo $_GET["successMsg"];
            echo "</div>
                    </div>
                </div>
            </div>";
        }


        ?>
        <div class="d-flex flex-column justify-content-center align-items-center" id="admin-drzac">
            <h1 class="my-3">Shoe Editor</h1>
            <div class="d-flex justify-content-center" id="shoe-editor">
                <div class="col-md-4 p-3 d-flex flex-column align-items-center border">
                    <h3>Insert</h3>
                    <h5>Insert a shoe</h5>
                    <form action="shoemanager.php" method="post" class="p-2 m-0" enctype="multipart/form-data">
                        <div class="form-group my-2">
                            <div class="d-flex justify-content-between"><label
                                    for="category-insert">Category:</label><strong class="required">Required!</strong>
                            </div>
                            <select class="form-control my-1" name="category-insert" id="category-insert">
                                <option value="0">Choose a category</option>
                                <?php
                                foreach ($kategorije as $kategorija) {
                                    echo "<option value='" . $kategorija->id . "'>" . $kategorija->naziv . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group my-2">
                            <div class="d-flex justify-content-between"><label for="brend-insert">Brand:</label><strong
                                    class="required">Required!</strong>
                            </div>
                            <select class="form-control my-1" name="brand-insert" id="brand-insert">
                                <option value="0">Choose a brand</option>
                                <?php
                                foreach ($brendovi as $brend) {
                                    echo "<option value='" . $brend->id . "'>" . $brend->naziv . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group my-2">
                            <div class="d-flex justify-content-between"><label for="model-insert">Model name (format
                                    varchar(50)):</label><strong class="required">Required!</strong>
                            </div>
                            <input type="text" placeholder="Between 3 and 50 characters" name="model-insert"
                                class="form-control my-1" id="model-insert">
                        </div>
                        <div class="form-group my-2">
                            <div class="d-flex justify-content-between"><label for="price-insert">Shoe price (format
                                    Decimal(6,2)):</label><strong class="required">Required!</strong>
                            </div>
                            <input type="number" placeholder="Between 10 and 999 dollars" name="price-insert"
                                class="form-control my-1" id="price-insert">
                        </div>
                        <div class="form-group my-2 border p-2">
                            <label for="discount-insert">Discount (format Decimal(3,2), leave blank for no
                                discounts):</label>
                            <input type="number" step="0.01" placeholder="Example: 0.70 if you want 30% discount"
                                name="discount-insert" class="form-control my-1" id="">
                            <label for="discount-insert-start-date">Discount start date (leave blank for current
                                timestamp):</label>
                            <input type="datetime-local" name="discount-insert-start-date"
                                id="discount-insert-start-date">
                            <label for="discount-insert-end-date">Discount end date (leave blank for no date):</label>
                            <input type="datetime-local" name="discount-insert-end-date" id="discount-insert-end-date">
                        </div>
                        <div class="form-group my-2">
                            <label for="shipping-insert">Shipping price (format Decimal(3,2), leave blank for free
                                shipping):</label>
                            <input type="number" placeholder="Between 10 and 999 dollars" name="shipping-insert"
                                class="form-control my-1" id="shipping-insert">
                        </div>
                        <div class="form-group my-2">
                            <div class="d-flex justify-content-between"><label for="file-insert">Image (1 file per
                                    shoe, supported formats JPG, PNG, JPEG):</label><strong
                                    class="required">Required!</strong>
                            </div>
                            <input type="file" name="file-insert" class="form-control-file my-1" id="file-insert">
                        </div>
                        <input type="submit" name="insertShoe" value="Insert Shoe" id="insertShoe"
                            class="btn btn-primary form-control my-1">
                        <div class="hide alert alert-info mt-3 d-flex justify-content-between align-items-center processing"
                            id="insertProcess">
                            <p class="d-inline-block">Proccessing request...</p>
                            <img src="Assets/img/loading.gif" alt="loading-img" class="img-fluid mx-2 loading-img">
                        </div>
                    </form>
                </div>

                <div class="col-md-4 p-3 d-flex flex-column align-items-center border">
                    <h3>Update</h3>
                    <h5>Choose a shoe to update</h5>
                    <div class="form-group my-2">
                        <div class="d-flex justify-content-between"><label for="shoeid-update">Shoe:</label><strong
                                class="required">Required!</strong>
                        </div>
                        <select class="form-control my-1" name="shoeid-update" id="shoeid-update">
                            <option value="0">Choose a shoe</option>
                            <?php
                            foreach ($queryShoes as $shoes) {
                                echo "<option value='" . $shoes->id . "'>" . $shoes->brend . " " . $shoes->model . " ( Shoe id: " . $shoes->id . " )</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div id="shoe-update-display" class="container d-flex flex-column my-2 p-0">
                    </div>
                    <h5 class="mt-2">Choose what to update</h5>
                    <div class="form-group p-2 mt-1 mb-3 border-bottom" id="update-filters">
                        <div class="form-check p-2">
                            <input type="checkbox" class="form-check-input" id="category-chb-update">
                            <label class="form-check-label" for="category-chb-update">Category</label>
                        </div>
                        <div class="form-check p-2">
                            <input type="checkbox" class="form-check-input" id="brand-chb-update">
                            <label class="form-check-label" for="brand-chb-update">Brand</label>
                        </div>
                        <div class="form-check p-2">
                            <input type="checkbox" class="form-check-input" id="model-chb-update">
                            <label class="form-check-label" for="model-chb-update">Model</label>
                        </div>
                        <div class="form-check p-2">
                            <input type="checkbox" class="form-check-input" id="price-chb-update">
                            <label class="form-check-label" for="price-chb-update">Shoe price</label>
                        </div>
                        <div class="form-check p-2">
                            <input type="checkbox" class="form-check-input" id="disc-chb-update">
                            <label class="form-check-label" for="disc-chb-update">Discount</label>
                        </div>
                        <div class="form-check p-2">
                            <input type="checkbox" class="form-check-input" id="shipping-chb-update">
                            <label class="form-check-label" for="shipping-chb-update">Shipping price</label>
                        </div>
                        <div class="form-check p-2">
                            <input type="checkbox" class="form-check-input" id="img-chb-update">
                            <label class="form-check-label" for="img-chb-update">Image</label>
                        </div>
                    </div>
                    <form action="shoemanager.php" method="post" class="p-2 m-0" enctype="multipart/form-data"
                        id="update-form">
                        <input type="text" name="id-update" id="id-selected" class="hide">
                        <input type="submit" name="updateShoe" value="Update Shoe" id="updateShoe"
                            class="btn btn-primary form-control my-1">
                        <div class="hide alert alert-info mt-3 d-flex justify-content-between align-items-center processing"
                            id="updateProcess">
                            <p class="d-inline-block">Proccessing request...</p>
                            <img src="Assets/img/loading.gif" alt="loading-img" class="img-fluid mx-2 loading-img">
                        </div>
                    </form>
                </div>
                <div class="col-md-4 p-3 d-flex flex-column align-items-center border">
                    <h3>Delete</h3>
                    <h5>Choose a shoe to delete</h5>
                    <div class="form-group my-2">
                        <div class="d-flex justify-content-between"><label for="shoeid-delete">Shoe:</label><strong
                                class="required">Required!</strong>
                        </div>
                        <select class="form-control my-1" name="shoeid-delete" id="shoeid-delete">
                            <option value="0">Choose a shoe</option>
                            <?php
                            foreach ($queryShoes as $shoes) {
                                echo "<option value='" . $shoes->id . "'>" . $shoes->brend . " " . $shoes->model . " ( Shoe id: " . $shoes->id . " )</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div id="shoe-delete-display" class="container d-flex flex-column p-0">
                    </div>
                    <form action="shoemanager.php" method="post" class="p-2 m-0 w-100">
                    <input type="text" name="id-delete" id="id-selected-delete" class="hide">
                        <input type="submit" name="deleteShoe" value="Delete Shoe"
                            class="btn btn-primary form-control my-2" id="deleteShoe">
                        <div class="hide alert alert-info d-flex justify-content-between align-items-center processing mt-2"
                            id="deleteProcess">
                            <p class="d-inline-block">Proccessing request...</p>
                            <img src="Assets/img/loading.gif" alt="loading-img" class="img-fluid mx-2 loading-img">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php
    include("../includes/footer.php");
    ?>
</body>

</html>