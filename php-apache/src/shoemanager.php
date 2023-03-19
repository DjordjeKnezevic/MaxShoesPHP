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

if (isset($_POST['insertShoe'])) {
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
        if (isset($_POST['discount-insert-start-date']) && $_POST['discount-insert-start-date'] != null) {
            $discountStartDate = $_POST['discount-insert-start-date'];
            $tmpDate = new DateTime($discountStartDate);
            $discountStartDateInsert = $tmpDate->format('Y-m-d H:i:s');
            $dateStart = strtotime($discountStartDate);
            $now = time();
            if ($dateStart < $now) {
                array_push($errArr, "Discount start date can't be in the past ");
            }
        }
        if (isset($_POST['discount-insert-end-date']) && $_POST['discount-insert-end-date'] != null) {
            $discountEndDate = $_POST['discount-insert-end-date'];
            $tmpDate = new DateTime($discountEndDate);
            $discountEndDateInsert = $tmpDate->format('Y-m-d H:i:s');
            $dateEnd = strtotime($discountEndDate);
            $now = time();
            if ($dateEnd < $now) {
                array_push($errArr, "Discount end date can't be in the past ");
            }
        }
        if (
            isset($_POST['discount-insert-start-date']) && $_POST['discount-insert-start-date'] != null &&
            isset($_POST['discount-insert-end-date']) && $_POST['discount-insert-end-date'] != null
        ) {
            if ($dateEnd < $dateStart) {
                array_push($errArr, "Discount end date can't be before the start date");
            }
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
        array_push($errArr, "Error uploading image file");
    } else {
        $file = $_FILES['file-insert'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileNameSubstr = explode(".", $fileName);
        $file_ext = strtolower(end($fileNameSubstr));
        $extensions = array("jpeg", "jpg", "png");
        if (in_array($file_ext, $extensions) === false) {
            array_push($errArr, "Extension not allowed, please choose a JPG, JPEG or PNG file.");
        } else if ($file_size > 2097152) {
            array_push($errArr, 'File size must be less than 2 MB');
        }
    }
    if (count($errArr) > 0) {
        $errorStr = "?errors=" . implode(",", $errArr);
        $referrer = $_SERVER['HTTP_REFERER'];
        $path = parse_url($referrer, PHP_URL_PATH);
        $filename = basename($path);
        $relativePath = "/" . $filename;
        header("Location: " . $relativePath . $errorStr);
    } else {
        // echo "Kategorija: " . $category . "<br/>";
        // echo "Brend: " . $brand . "<br/>";
        // echo "Model: " . $model . "<br/>";
        // echo "Cena: " . $price . "<br/>";
        // if ($discount)
        //     echo "Popust: " . $discount . "<br/>";
        // if ($discountDate)
        //     echo "Datum isteka popusta: " . $discountDate . "<br/>";
        // if ($shipping)
        //     echo "Postarina: " . $shipping . "<br/>";

        $conn->beginTransaction();
        try {
            $query = "SELECT src FROM slika WHERE id = (SELECT MAX(id) FROM slika)";
            $slikaIme = $conn->query($query)->fetch()->src;
            $baseName = explode(".", $slikaIme)[0];
            $fileNewName = substr($baseName, strlen($baseName) - 6, 4);
            $num = (int) substr($baseName, strlen($baseName) - 2, 2);
            $num++;
            $fileNewName .= "$num" . "." . $file_ext;
            $targetPath = "Assets/img/shoes/" . $fileNewName;
            move_uploaded_file($fileTmpName, $targetPath);

            $alt = $brand . " " . $model;
            $insertIntoSlika = "INSERT INTO `slika`(`src`, `alt`) VALUES (:src,:alt)";
            $stmt = $conn->prepare($insertIntoSlika);
            $stmt->bindParam(':src', $targetPath);
            $stmt->bindParam(':alt', $alt);
            $stmt->execute();

            $imgId = $conn->lastInsertId();
            $insertIntoPatika = "INSERT INTO `patika`(`brend_id`, `model`, `kategorija_id`, `slika_id`) VALUES (:brand,:model,:category,:img)";
            $stmt = $conn->prepare($insertIntoPatika);
            $stmt->bindParam(':brand', $brand);
            $stmt->bindParam(':model', $model);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':img', $imgId);
            $stmt->execute();

            $patikaId = $conn->lastInsertId();
            $insertIntoCena = "INSERT INTO `cena`(`patika_id`, `vrednost`) VALUES (:patikaId, :vrednost)";
            $stmt = $conn->prepare($insertIntoCena);
            $stmt->bindParam(':patikaId', $patikaId);
            $stmt->bindParam(':vrednost', $price);
            $stmt->execute();

            if (isset($discount)) {
                if (isset($discountStartDate) && isset($discountEndDate)) {
                    $insertIntoPopust = "INSERT INTO `popust`(`patika_id`, `procenat`, `datum_pocetka`, `datum_kraja`) VALUES (:patikaId, :procenat, :datumPocetka, :datumKraja)";
                    $stmt = $conn->prepare($insertIntoPopust);
                    $stmt->bindParam(':datumPocetka', $discountStartDateInsert);
                    $stmt->bindParam(':datumKraja', $discountEndDateInsert);
                } else if (isset($discountStartDate) && !isset($discountEndDate)) {
                    $insertIntoPopust = "INSERT INTO `popust`(`patika_id`, `procenat`, `datum_pocetka`) VALUES (:patikaId, :procenat, :datumPocetka)";
                    $stmt = $conn->prepare($insertIntoPopust);
                    $stmt->bindParam(':datumPocetka', $discountStartDateInsert);
                } else if (!isset($discountStartDate) && isset($discountEndDate)) {
                    $insertIntoPopust = "INSERT INTO `popust`(`patika_id`, `procenat`, `datum_kraja`) VALUES (:patikaId, :procenat, :datumKraja)";
                    $stmt = $conn->prepare($insertIntoPopust);
                    $stmt->bindParam(':datumKraja', $discountEndDateInsert);
                } else {
                    $insertIntoPopust = "INSERT INTO `popust`(`patika_id`, `procenat`) VALUES (:patikaId, :procenat)";
                    $stmt = $conn->prepare($insertIntoPopust);
                }
                $stmt->bindParam(':patikaId', $patikaId);
                $stmt->bindParam(':procenat', $discount);
                $stmt->execute();
            }

            if (isset($shipping)) {
                $insertIntoCenaPostarine = "INSERT INTO `cena_postarine`(`patika_id`, `vrednost`) VALUES (:patikaId, :vrednost)";
                $stmt = $conn->prepare($insertIntoCenaPostarine);
                $stmt->bindParam(':patikaId', $patikaId);
                $stmt->bindParam(':vrednost', $shipping);
                $stmt->execute();
            }
            $conn->commit();
            $referrer = $_SERVER['HTTP_REFERER'];
            $path = parse_url($referrer, PHP_URL_PATH);
            $filename = basename($path);
            $relativePath = "/" . $filename;
            header("Location: " . $relativePath . "?successMsg=Successfully inserted new shoe");
            // http_response_code(201);
        } catch (PDOException $e) {
            $conn->rollBack();
            http_response_code(500);
            echo $e->getMessage();
        }
    }
}



?>