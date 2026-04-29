<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../classes/Committee.php';

if (!isset($_SESSION['officer_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['id'])) {
        throw new Exception('Invalid input data. ID is required.');
    }

    $committeeModel = new Committee();
    $success = $committeeModel->deleteCommittee($data['id']);
    
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Committee member deleted successfully']);
    } else {
        throw new Exception('Failed to delete committee member from database.');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
