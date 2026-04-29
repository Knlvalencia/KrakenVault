<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../classes/DocumentArchive.php';
require_once __DIR__ . '/../components/check_auth.php'; // Ensure user is logged in

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    $id = $_POST['id'] ?? null;

    if (!$id) {
        throw new Exception('Missing document ID.');
    }

    $docModel = new DocumentArchive();
    $success = $docModel->deleteDocument($id);

    if ($success) {
        require_once __DIR__ . '/../classes/AuditLog.php';
        $audit = new AuditLog();
        $audit->logActivity($_SESSION['officer_id'], "Deleted document ID: " . $id);
        
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to delete document from database.');
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
