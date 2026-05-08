<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function redirect($url) {
    header("Location: " . $url);
    exit;
}

function setFlashMessage($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlashMessage() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

function uploadFile($file, $targetDir, $allowedTypes = [], $maxSize = 104857600) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Erreur lors de l\'upload'];
    }

    if ($file['size'] > $maxSize) {
        return ['success' => false, 'error' => 'Fichier trop volumineux (max 100MB)'];
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!empty($allowedTypes) && !in_array($mimeType, $allowedTypes)) {
        return ['success' => false, 'error' => 'Type de fichier non autorisé'];
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = uniqid() . '_' . time() . '.' . $extension;
    $targetPath = $targetDir . $newName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return ['success' => false, 'error' => 'Échec du déplacement du fichier'];
    }

    return ['success' => true, 'filename' => $newName];
}

function formatDate($date, $format = 'd/m/Y') {
    if (empty($date)) return '';
    return date($format, strtotime($date));
}

function getStatusBadgeClass($status) {
    $status = strtolower($status);
    if (strpos($status, 'actif') !== false || strpos($status, 'en cours') !== false) return 'badge-success';
    if (strpos($status, 'termine') !== false || strpos($status, 'terminé') !== false) return 'badge-secondary';
    if (strpos($status, 'attente') !== false) return 'badge-warning';
    return 'badge-info';
}

?>
