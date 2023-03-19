<?php
session_start();

if (
    !isset($_SESSION['loggedUser']) || $_SESSION['loggedUser']->type != 'admin' ||
    !(isset($_POST['insertShoe']) || isset($_POST['updateShoe']) || isset($_POST['deleteShoe']))
) {
    http_response_code(403);
    echo "Error: Access denied.";
    exit;
}

include("../includes/env.php");
include("../includes/connect.php");

if (
    isset($_POST['insertShoe'])
) {
    $errArr = [];
    if (!isset($_POST['category-insert']) || $_POST['category-insert'] == 0) {
        array_push($errArr, "You must choose a category");
    } else {
        $category = $_POST['category-insert'];
    }
    if (!isset($_POST['brand-insert']) || $_POST['brand-insert'] == 0) {
        array_push($errArr, "You must choose a brand");
    } else {
        $brand = $_POST['brand-insert'];
    }
    if (!isset($_POST['model-insert']) || strlen($_POST['model-insert']) < 3 || strlen($_POST['model-insert']) > 50) {
        array_push($errArr, "Model must be between 3 and 50 characters long");
    } else {
        $model = $_POST['model-insert'];
    }
    if (!isset($_POST['price-insert']) || $_POST['price-insert'] < 10 || $_POST['price-insert'] > 999) {
        array_push($errArr, "Shoe price must be between 10 and 999 dollars");
    } else {
        $price = $_POST['price-insert'];
    }
    if (isset($_POST['discount-insert']) && $_POST['discount-insert'] != null) {
        if ($_POST['discount-insert'] < 0.01 || $_POST['discount-insert'] > 0.99) {
            array_push($errArr, "Discount must be between 0.01 and 0.99 multiplier ");
        } else {
            $discount = $_POST['discount-insert'];
        }
    }
    if (isset($_POST['discount-insert-date']) && $_POST['discount-insert-date'] != null) {
        $discountDate = $_POST['discount-insert-date'];
        $date = strtotime($dateStr);
        $now = time();
        if ($date < $now) {
            array_push($errArr, "Discount end date can't be in the past ");
        } else {
        }
    }
    if (isset($_POST['shipping-insert']) && $_POST['shipping-insert'] != null) {
        if ($_POST['shipping-insert'] < 0 || $_POST['shipping-insert'] > 999) {
            array_push($errArr, "Shipping price can't be less than 0 and more than 999 dollars");
        } else {
            $shipping = $_POST['shipping-insert'];
        }
    }
    if (!isset($_FILES['file-insert']) || $_FILES['file-insert']['error'] != 0) {
        array_push($errArr, "Error upload image file");
    } else {
        $file = $_FILES['file-insert'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $file_ext = strtolower(end(explode(".", $fileName)));
        $extensions = array("jpeg", "jpg", "png");
        if (in_array($file_ext, $extensions) === false) {
            array_push($errArr, "Extension not allowed, please choose a JPEG or PNG file.");
        } else if ($file_size > 2097152) {
            array_push($errArr, 'File size must be less than 2 MB');
        }
        // } else {
        //     try {
        //         $query = "SELECT src FROM slika WHERE id = (SELECT MAX(id) FROM slika)";
        //         $slikaIme = $conn->query($query)->fetch()->src;
        //         $baseName = explode(".", $slikaIme)[0];
        //         echo $baseName . "<br/>";
        //         $fileNewName = substr($baseName, strlen($baseName) - 6, 4);
        //         $num = (int) substr($baseName, strlen($baseName) - 2, 2);
        //         $num++;
        //         $fileNewName .= "$num" . "." . $file_ext;
        //         $targetPath = "Assets/img/shoes/" . $fileNewName;
        //         move_uploaded_file($fileTmpName, $targetPath);
        //         echo $fileNewName;
        //         $query = "INSERT INTO `slika`(`src`, `alt`) VALUES ('$targetPath','nova slika')";
        //         $conn->query($query);
        //         http_response_code(500);
        //     } catch (PDOException $e) {
        //         echo $e->getMessage();
        //     }
        // }
    }
    if (count($errArr) > 0) {
        $errorStr = implode(",", $errArr);
        header("Location: " . $_SERVER["HTTP_REFERER"] . "?errors=" . $errorStr);
        exit;
    } else {
        echo "Kategorija: " . $category . "<br/>";
        echo "Brend: " . $brand . "<br/>";
        echo "Model: " . $model . "<br/>";
        echo "Cena: " . $price . "<br/>";
        if ($discount)
            echo "Popust: " . $discount . "<br/>";
        if ($discountDate)
            echo "Datum isteka popusta: " . $discountDate . "<br/>";
        if ($shipping)
            echo "Postarina: " . $shipping . "<br/>";

    }
}






// $query = "SELECT src FROM slika WHERE id = (SELECT MAX(id) FROM slika)";
// $rez = $conn->query($query)->fetch();
// $string = substr($rez->src, strlen($rez->src) - 10, 4);
// $num = (int) substr($rez->src, strlen($rez->src) - 6, 2);
// $num++;
// $string .= "$num";
// var_dump($string);


?>