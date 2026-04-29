<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../classes/Officer.php';

if (!isset($_SESSION['officer_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

try {
    if (!isset($_FILES['profilePicture']) || $_FILES['profilePicture']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('No file uploaded or an upload error occurred.');
    }

    $file = $_FILES['profilePicture'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    
    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception('Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.');
    }

    // Ensure uploads directory exists
    $uploadDir = __DIR__ . '/../uploads/profiles/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Delete old profile picture file if one exists
    $oldPicture = $_SESSION['profile_picture'] ?? null;
    if ($oldPicture) {
        $oldPath = $uploadDir . $oldPicture;
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = 'user_' . $_SESSION['officer_id'] . '_' . time() . '.' . $extension;
    $destination = $uploadDir . $newFileName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new Exception('Failed to save uploaded file.');
    }

    $officerModel = new Officer();
    $officerModel->updateProfilePicture($_SESSION['officer_id'], $newFileName);

    // Update session so header avatar reflects immediately
    $_SESSION['profile_picture'] = $newFileName;

    echo json_encode(['success' => true, 'fileName' => $newFileName, 'message' => 'Profile picture updated successfully']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
