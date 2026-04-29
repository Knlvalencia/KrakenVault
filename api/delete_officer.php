<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../classes/Database.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || !isset($data['id'])) {
        throw new Exception('Invalid ID');
    }

    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("DELETE FROM Officers WHERE OfficerID = :id");
    $stmt->execute(['id' => $data['id']]);

    echo json_encode(['success' => true, 'message' => 'Officer deleted successfully']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
