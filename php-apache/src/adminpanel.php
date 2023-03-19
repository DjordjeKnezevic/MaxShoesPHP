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
                                    shoe):</label><strong class="required">Required!</strong>
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

                <!-- <div class="col-md-4 p-3 d-flex flex-column align-items-center border">
                    <h3>Update</h3>
                    <form action="shoemanager.php" method="post" class="p-2 m-0">
                        <div class="form-group">
                            <label for="dropdown1">Dropdown 1:</label>
                            <select class="form-control" id="dropdown1">
                                <option>Option 1</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dropdown2">Dropdown 2:</label>
                            <select class="form-control" id="dropdown2">
                                <option>Option A</option>
                                <option>Option B</option>
                                <option>Option C</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="number1">Number 1:</label>
                            <input type="number" class="form-control" id="number1">
                        </div>
                        <div class="form-group">
                            <label for="number2">Number 2:</label>
                            <input type="number" class="form-control" id="number2">
                        </div>
                        <div class="form-group">
                            <label for="number3">Number 3:</label>
                            <input type="number" class="form-control" id="number3">
                        </div>
                        <div class="form-group">
                            <label for="textInput">Text input:</label>
                            <input type="text" class="form-control" id="textInput">
                        </div>
                        <div class="form-group">
                            <label for="inputFile">File input:</label>
                            <input type="file" class="form-control-file" id="inputFile">
                        </div>
                        <input type="submit" name="updateShoe" value="Update Shoe"
                            class="btn btn-primary form-control my-1">
                    </form>
                </div>
                <div class="col-md-4 p-3 d-flex flex-column align-items-center border">
                    <h3>Delete</h3>
                    <form action="shoemanager.php" method="post" class="p-2 m-0">
                        <div class="form-group">
                            <label for="dropdown1">Dropdown 1:</label>
                            <select class="form-control" id="dropdown1">
                                <option>Option 1</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dropdown2">Dropdown 2:</label>
                            <select class="form-control" id="dropdown2">
                                <option>Option A</option>
                                <option>Option B</option>
                                <option>Option C</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="number1">Number 1:</label>
                            <input type="number" class="form-control" id="number1">
                        </div>
                        <div class="form-group">
                            <label for="number2">Number 2:</label>
                            <input type="number" class="form-control" id="number2">
                        </div>
                        <div class="form-group">
                            <label for="number3">Number 3:</label>
                            <input type="number" class="form-control" id="number3">
                        </div>
                        <div class="form-group">
                            <label for="textInput">Text input:</label>
                            <input type="text" class="form-control" id="textInput">
                        </div>
                        <div class="form-group">
                            <label for="inputFile">File input:</label>
                            <input type="file" class="form-control-file" id="inputFile">
                        </div>
                        <input type="submit" name="deleteShoe" value="Delete Shoe"
                            class="btn btn-primary form-control my-1">
                    </form>
                </div> -->
            </div>
        </div>
    </main>
    <?php
    include("../includes/footer.php");
    ?>
</body>

</html>