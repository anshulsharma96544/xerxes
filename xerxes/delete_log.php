<?php
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
$del_ids = filter_input(INPUT_POST, 'del_ids');

if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_SESSION['admin_type']!='super'){
        $_SESSION['failure'] = "You don't have permission to perform this action";
        header('location: list_log.php');
        exit;

    }
    $log_id = $del_id;
    $db->where('id', $log_id);
    $status = $db->delete('logs');

    if ($status)
    {
        $_SESSION['info'] = "Log message deleted successfully!";
        header('location: list_log.php');
        exit;
    }
    else
    {
        $_SESSION['failure'] = "Unable to delete log message";
        header('location: list_log.php');
        exit;

    }
}
if ($del_ids && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $status = false;
    if($_SESSION['admin_type']!='super'){
        $_SESSION['failure'] = "You don't have permission to perform this action";
        header('location: list_log.php');
        exit;

    }
    foreach (explode(":", $del_ids) as $del_id) {
        $db->where('id', $del_id);
        $status = $db->delete('logs');
    }

    if ($status)
    {
        $_SESSION['info'] = "Log message deleted successfully!";
        header('location: list_log.php');
        exit;
    }
    else
    {
        $_SESSION['failure'] = "Unable to delete log message";
        header('location: list_log.php');
        exit;

    }
}