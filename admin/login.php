<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Auto-login for presentation
session_start();
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_name'] = 'Administrateur';
$_SESSION['admin_email'] = 'admin@iutfv.cm';

redirect('dashboard.php');

function redirect($url) {
    header("Location: " . $url);
    exit;
}
?>
