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
