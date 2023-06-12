<?php

function log_visit()
{
    $user_ip = $_SERVER['REMOTE_ADDR'];
    $query_string = $_SERVER['QUERY_STRING'];
    parse_str($query_string, $query_params);
    $page = isset($query_params['page']) ? $query_params['page'] : 'index';
    $time = date("F j, Y, g:i a");
    $username = $_SESSION['loggedUser']->username ?? "anonymous";
    $log_entry = "$user_ip::$username::$page::$time" . PHP_EOL;
    file_put_contents('data/log.txt', $log_entry, FILE_APPEND);
}

function uploadAndRescaleImage($uploaded_file, $slikaIme, $file_ext)
{
    $image_info = getimagesize($uploaded_file);

    $width = $image_info[0];
    $height = $image_info[1];

    $image = $file_ext === 'png' ? imagecreatefrompng($uploaded_file) : imagecreatefromjpeg($uploaded_file);
    $resized_width = 300;
    $resized_height = 200;
    $resized_image = imagecreatetruecolor($resized_width, $resized_height);
    imagecopyresampled($resized_image, $image, 0, 0, 0, 0, $resized_width, $resized_height, $width, $height);

    $baseName = explode(".", $slikaIme)[0];
    $fileNewName = substr($baseName, strlen($baseName) - 6, 4);
    $num = (int) substr($baseName, strlen($baseName) - 2, 2);
    $num++;
    $fileNewName .= "$num" . "." . $file_ext;
    $original_folder = "../Assets/img/shoes/";
    $resized_folder = "../Assets/img/resized_shoes/";

    move_uploaded_file($uploaded_file, $original_folder . $fileNewName);


    $file_ext == 'png' ? imagepng($resized_image, $resized_folder . $fileNewName) : imagejpeg($resized_image, $resized_folder . $fileNewName);

    imagedestroy($image);
    imagedestroy($resized_image);
    return $resized_folder . $fileNewName;
}
