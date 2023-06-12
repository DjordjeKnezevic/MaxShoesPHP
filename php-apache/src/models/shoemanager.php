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

include("../../config/env.php");
include("../../config/connect.php");
include("../../config/functions.php");

function getParsedUrl()
{
    $referrer = $_SERVER['HTTP_REFERER'];
    $path = parse_url($referrer, PHP_URL_PATH);
    $filename = basename($path);
    $relativePath = "/" . $filename;
    return $relativePath;
}

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
        $fileNameSubstr = explode(".", $fileName);
        $file_ext = strtolower(end($fileNameSubstr));
        $extensions = array("jpeg", "jpg", "png");
        if (in_array($file_ext, $extensions) === false) {
            array_push($errArr, "Extension not allowed, please choose a JPG, JPEG or PNG file.");
        } else if ($fileSize > 2097152) {
            array_push($errArr, 'File size must be less than 2 MB');
        }
    }
    if (count($errArr) > 0) {
        $errorStr = "?errors=" . implode(",", $errArr);
        $relativePath = getParsedUrl();
        header("Location: " . $relativePath . $errorStr);
    } else {
        $conn->beginTransaction();
        try {
            $query = "SELECT src FROM slika WHERE id = (SELECT MAX(id) FROM slika)";
            $slikaIme = $conn->query($query)->fetch()->src;
            $targetPath = uploadAndRescaleImage($fileTmpName, $slikaIme, $file_ext);

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
            $relativePath = getParsedUrl();
            header("Location: " . $relativePath . "?page=adminpanel&successMsg=Successfully inserted new shoe");
        } catch (PDOException $e) {
            $conn->rollBack();
            http_response_code(500);
            echo $e->getMessage();
        }
    }
}

if (isset($_POST['updateShoe'])) {
    if (!isset($_POST['id-update']) || $_POST['id-update'] == null || $_POST['id-update'] == 0) {
        $errorStr = "?errors=You must select a shoe to update";
        $relativePath = getParsedUrl();
        header("Location: " . $relativePath . $errorStr);
        exit;
    } else {
        $idUpdate = $_POST['id-update'];
        $errArr = [];
        if (
            !isset($_POST['category-update']) && !isset($_POST['brand-update']) && !isset($_POST['model-update']) && !isset($_POST['price-update']) &&
            !isset($_POST['discount-update']) && !isset($_POST['shipping-update']) && !isset($_FILES['file-update'])
        ) {
            $errorStr = "?errors=You must select something to update";
            $relativePath = getParsedUrl();
            header("Location: " . $relativePath . $errorStr);
            exit;
        }
        if (isset($_POST['category-update'])) {
            if ($_POST['category-update'] == 0) {
                array_push($errArr, "You must choose a category");
            } else {
                $category = $_POST['category-update'];
            }
        }
        if (isset($_POST['brand-update'])) {
            if ($_POST['brand-update'] == 0) {
                array_push($errArr, "You must choose a brand");
            } else {
                $brand = $_POST['brand-update'];
            }
        }
        if (isset($_POST['model-update'])) {
            if (strlen($_POST['model-update']) < 3 || strlen($_POST['model-update']) > 50) {
                array_push($errArr, "Model must be between 3 and 50 characters long");
            } else {
                $model = $_POST['model-update'];
            }
        }
        if (isset($_POST['price-update'])) {
            if ($_POST['price-update'] < 10 || $_POST['price-update'] > 999) {
                array_push($errArr, "Shoe price must be between 10 and 999 dollars");
            } else {
                $price = $_POST['price-update'];
            }
        }
        if (isset($_POST['discount-update'])) {
            if (($_POST['discount-update'] < 0.01 || $_POST['discount-update'] > 0.99) && $_POST['discount-update'] != null) {
                array_push($errArr, "Discount must be between 0.01 and 0.99 multiplier");
            } else {
                $discount = $_POST['discount-update'];
            }
        }
        if (isset($_POST['shipping-update'])) {
            if (($_POST['shipping-update'] < 0 || $_POST['shipping-update'] > 999) && $_POST['shipping-update'] != null) {
                array_push($errArr, "Shipping price can't be less than 0 or more than 999 dollars");
            } else {
                $shipping = $_POST['shipping-update'];
            }
        }
        if (isset($_FILES['file-update'])) {
            if ($_FILES['file-update']['error'] != 0) {
                array_push($errArr, "Error uploading image file");
            } else {
                $file = $_FILES['file-update'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileNameSubstr = explode(".", $fileName);
                $file_ext = strtolower(end($fileNameSubstr));
                $extensions = array("jpeg", "jpg", "png");
                if (in_array($file_ext, $extensions) === false) {
                    array_push($errArr, "Extension not allowed, please choose a JPG, JPEG or PNG file.");
                } else if ($fileSize > 2097152) {
                    array_push($errArr, 'File size must be less than 2 MB');
                }
            }
        }
        if (count($errArr) > 0) {
            $errorStr = "?errors=" . implode(",", $errArr);
            $relativePath = getParsedUrl();
            header("Location: " . $relativePath . $errorStr);
        } else {
            $conn->beginTransaction();
            try {
                if (isset($category)) {
                    $updatePatika = "UPDATE `patika` SET `kategorija_id`=:category WHERE id = :idUpdate";
                    $stmt = $conn->prepare($updatePatika);
                    $stmt->bindParam(':category', $category);
                    $stmt->bindParam(':idUpdate', $idUpdate);
                    $stmt->execute();
                }
                if (isset($brand)) {
                    $updatePatika = "UPDATE `patika` SET `brend_id`=:brand WHERE id = :idUpdate";
                    $stmt = $conn->prepare($updatePatika);
                    $stmt->bindParam(':brand', $brand);
                    $stmt->bindParam(':idUpdate', $idUpdate);
                    $stmt->execute();
                }
                if (isset($model)) {
                    $updatePatika = "UPDATE `patika` SET `model`=:model WHERE id = :idUpdate";
                    $stmt = $conn->prepare($updatePatika);
                    $stmt->bindParam(':model', $model);
                    $stmt->bindParam(':idUpdate', $idUpdate);
                    $stmt->execute();
                }
                if (isset($file)) {
                    $query = "SELECT src FROM slika WHERE id = (SELECT MAX(id) FROM slika)";
                    $slikaIme = $conn->query($query)->fetch()->src;
                    $targetPath = uploadAndRescaleImage($fileTmpName, $slikaIme, $file_ext);

                    $alt = $fileNewName;
                    $insertIntoSlika = "INSERT INTO `slika`(`src`, `alt`) VALUES (:src,:alt)";
                    $stmt = $conn->prepare($insertIntoSlika);
                    $stmt->bindParam(':src', $targetPath);
                    $stmt->bindParam(':alt', $alt);
                    $stmt->execute();
                    $imgId = $conn->lastInsertId();

                    $updatePatika = "UPDATE `patika` SET `slika_id`=:slikaId WHERE id = :idUpdate";
                    $stmt = $conn->prepare($updatePatika);
                    $stmt->bindParam(':slikaId', $imgId);
                    $stmt->bindParam(':idUpdate', $idUpdate);
                    $stmt->execute();
                }

                if (isset($price)) {
                    $datumKraja = date('Y-m-d H:i:s');
                    $updatePreviousPrice = "UPDATE `cena` SET `datum_kraja`= :datumKraja WHERE patika_id = :idUpdate";
                    $stmt = $conn->prepare($updatePreviousPrice);
                    $stmt->bindParam(':idUpdate', $idUpdate);
                    $stmt->bindParam(':datumKraja', $datumKraja);
                    $stmt->execute();

                    $updateCurrentPrice = "INSERT INTO `cena`(`patika_id`, `vrednost`) VALUES (:idUpdate, :vrednost)";
                    $stmt = $conn->prepare($updateCurrentPrice);
                    $stmt->bindParam(':vrednost', $price);
                    $stmt->bindParam(':idUpdate', $idUpdate);
                    $stmt->execute();
                }
                if (isset($discount)) {
                    $selectPreviousDiscount = "SELECT * FROM `popust` WHERE patika_id = :idUpdate";
                    $stmt = $conn->prepare($selectPreviousDiscount);
                    $stmt->bindParam(':idUpdate', $idUpdate);
                    $stmt->execute();
                    if ($stmt->rowCount() > 0) {
                        $datumKraja = date('Y-m-d H:i:s');
                        $updatePreviousDiscount = "UPDATE `popust` SET `datum_kraja`= :datumKraja WHERE patika_id = :idUpdate";
                        $stmt = $conn->prepare($updatePreviousDiscount);
                        $stmt->bindParam(':idUpdate', $idUpdate);
                        $stmt->bindParam(':datumKraja', $datumKraja);
                        $stmt->execute();
                    }
                    if ($discount != null) {
                        $updateCurrentDiscount = "INSERT INTO `popust`(`patika_id`, `procenat`) VALUES (:idUpdate, :procenat)";
                        $stmt = $conn->prepare($updateCurrentDiscount);
                        $stmt->bindParam(':procenat', $discount);
                        $stmt->bindParam(':idUpdate', $idUpdate);
                        $stmt->execute();
                    }
                }
                if (isset($shipping)) {
                    $datumKraja = date('Y-m-d H:i:s');
                    $updatePreviousShippingPrice = "UPDATE `cena_postarine` SET `datum_kraja`= :datumKraja WHERE patika_id = :idUpdate";
                    $stmt = $conn->prepare($updatePreviousShippingPrice);
                    $stmt->bindParam(':idUpdate', $idUpdate);
                    $stmt->bindParam(':datumKraja', $datumKraja);
                    $stmt->execute();

                    $updateCurrentShippingPrice = "INSERT INTO `cena_postarine`(`patika_id`, `vrednost`) VALUES (:idUpdate, :vrednost)";
                    $stmt = $conn->prepare($updateCurrentShippingPrice);
                    $stmt->bindParam(':vrednost', $shipping);
                    $stmt->bindParam(':idUpdate', $idUpdate);
                    $stmt->execute();
                }
                $conn->commit();
                $relativePath = getParsedUrl();
                header("Location: " . $relativePath . "?page=adminpanel&successMsg=Successfully updated a shoe");
            } catch (PDOException $e) {
                $conn->rollBack();
                http_response_code(500);
                echo $e->getMessage();
            }
        }
    }
}

if (isset($_POST['deleteShoe'])) {
    if (!isset($_POST['id-delete']) || $_POST['id-delete'] == null || $_POST['id-delete'] == 0) {
        $errorStr = "?errors=You must select a shoe to delete";
        $relativePath = getParsedUrl();
        header("Location: " . $relativePath . $errorStr);
        exit;
    } else {
        try {
            $idDelete = $_POST['id-delete'];
            $deleteQuery = "DELETE FROM patika WHERE id=:idDelete";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bindParam(':idDelete', $idDelete);
            $stmt->execute();
            $relativePath = getParsedUrl();
            header("Location: " . $relativePath . "?page=adminpanel&successMsg=Successfully deleted shoe with an id of $idDelete");
        } catch (PDOException $e) {
            $conn->rollBack();
            http_response_code(500);
            echo $e->getMessage();
        }
    }
}
